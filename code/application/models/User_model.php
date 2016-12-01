<?php

/**
 * 会员Model
 */
class User_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'user';
    }

    //注册账户生成规定数量的副账户
    public function register($data = [])
    {
        //注册生成副账号的数量
        $register_create_num = $this->config->item('register_create_num');
        //主账号数据
        $insert_data = [];
        $insert_data['user_name'] = $data['user_name'];
        $insert_data['mobile'] = $data['mobile'];
        $insert_data['parent_id'] = $data['parent_id'];
        $insert_data['main_id'] = 0;
        $insert_data['is_main'] = 1;
        $password = password($data['password']);
        $insert_data['password'] = $password['password'];
        $insert_data['salt'] = $password['salt'];
        $insert_data['reg_time'] = time();
        $insert_data['last_time'] = time();
        $insert_data['last_ip'] = $this->input->ip_address();
        $insert_data['portrait'] = '/assets/default/images/icon/default_avator.png';
        //设置为待激活状态
        $insert_data['status'] = 1;
        $this->add_one($insert_data);

        $main_id = $parent_id = $this->db->insert_id();

        //插入副账号
        for ($i = 2; $i <= $register_create_num; $i++) {
            $data2 = [
                'user_name' => $insert_data['user_name'] . '-' . $i,
                'mobile' => $insert_data['mobile'],
                'parent_id' => $parent_id,
                'main_id' => $main_id,
                'reg_time' => time(),
            ];
            $this->add_one($data2);
            $parent_id = $this->db->insert_id();

        }

        //设置关系表
        $parent = $this->get_one(['user_id' => $data['parent_id']]);
        $this->load->model('user_relation_model');
        $this->user_relation_model->set_user_relation($parent['main_id'], $main_id);

        return true;
    }

    //向日葵账户
    public function getAccount($page = 1, $size = 5)
    {
        $limit = ($page - 1) * $size;

        //主账户下的副账户
        $user_children = $this->db
            ->select('user_id, user_name, recommend_bonus, market_bonus, market_bonus_total, status')
            ->from('user')
            ->where(['main_id' => $_SESSION['user_id'], 'state' => 0])
            ->order_by('user_id asc')
            ->limit($size, $limit)
            ->get()->result_array();

        if($page == 1) {
            //主账号
            $user[] = $this->get_one(['user_id' => $_SESSION['user_id']], 'user_id, user_name, recommend_bonus, market_bonus, market_bonus_total, status');
            $data = array_merge($user, $user_children);
        } else {
            $data = $user_children;
        }

        foreach ($data as $key => $value) {
            //激活状态，0未激活，1待激活，2已激活
            switch ($value['status']) {
                case 1:
                    $data[$key]['href'] = site_url('home/clickActivations?user_id=') . $value['user_id'];
                    $data[$key]['disabled'] = '';
                    break;
                case 2:
                    $data[$key]['href'] = '###';
                    $data[$key]['disabled'] = 'disabled';
                    break;
                case 0:
                    $data[$key]['href'] = '###';
                    $data[$key]['disabled'] = 'disabled';
                    break;
            }
        }

        $tmp['lists'] = $data;
        return $tmp;
    }

    // 获取未收数量
    public function getNoExchange()
    {
        $account = $this->db
            ->select_sum('recommend_bonus', 'recommend')
            ->select_sum('market_bonus', 'market')
            ->from('user')
            ->where(['main_id' => $_SESSION['user_id']])
            ->or_where(['user_id' => $_SESSION['user_id']])
            ->get()->result_array();

        $cast = $this->db
            ->select_sum('cast_num', 'cast')
            ->select_sum('market_bonus', 'market')
            ->from('user_cast')
            ->where(['user_id' => $_SESSION['user_id']])
            ->get()->result_array();

        $data['account'] = $account[0];
        $data['cast'] = $cast[0];

        return $data;
    }

    //激活账户
    public function accountActivation($user_id)
    {
        $this->load->model('bonus_model');
        //账户激活设置
        $account_bonus_config = config_item('account_bonus_config');

        $this->db->trans_begin();

        //准备激活的账号
        $activeUser = $this->get_one(['user_id' => $user_id], 'user_id, user_name, main_id, parent_id, user_money');

        //扣除激活所需积分、更新状态为已激活
        $this->db
            ->where(['user_id' => $_SESSION['user_id']])
            ->set('user_money', 'user_money - ' . config_item('active_money'), false)
            ->update('user');
        $this->edit_one(['status' => 2], ['user_id' => $activeUser['user_id']]);
        // 扣除向日葵积分日志
        $this->load->model('user_log_model');
        $this->user_log_model->user_log($activeUser['user_id'], 1, 2, $activeUser['user_money'], ($activeUser['user_money'] - config_item('active_money')), '激活用户' . $activeUser['user_name']);

        //将下一个账号设置为待激活状态
        $this->edit_one(['status' => 1], ['parent_id' => $activeUser['user_id'], 'main_id' => $_SESSION['user_id']]);

        //已激活的父级账号推荐奖 + 1 (直推关系)
        $layer = 0;
        if($activeUser['main_id'] == 0) {
            $layer++;
        }

        $next = true;
        $parent_id = $activeUser['parent_id'];
        $bonuse_max = $account_bonus_config['bonus_max'];
        $n = 1;
        while($next) {
            $parent = $this->get_one(['user_id' => $parent_id], 'user_id, main_id, parent_id, recommend_bonus, bonus_total, status');
            if(! $parent) {
                break;
            }
            if($parent['status'] == 2) {
                $recommend_bonus = 1;
                if($recommend_bonus > 0) {
                    $this->db->set('recommend_bonus', 'recommend_bonus + ' . $recommend_bonus, false)
                        ->set('bonus_total', 'bonus_total + ' . $recommend_bonus, false)
                        ->where(['user_id' => $parent['user_id']])
                        ->where('bonus_total <=', $bonuse_max - 1)
                        ->update('user');
                    //插入奖金日志
                    $bonus_log = [
                        'bonus_type' => 1,
                        'bonus_money' => $recommend_bonus,
                        'user_id' => $parent['user_id'],
                        'bonus_time' => time(),
                        'bonus_desc' => $activeUser['user_name'] . '激活',
                    ];
                    $this->bonus_model->add_one($bonus_log);
                }

                $n++;
            }

            $parent_id = $parent['parent_id'];

            if($parent['main_id'] == 0) {
                $layer++;
            }

            if($n == $account_bonus_config['recommend_bonus'] || $layer == 2) {
                $next = false;
            }

        }

        if ($this->db->trans_status() === false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }

    }

    //实名认证
    public function real_img_add($map)
    {
        $arr = $this->db->insert('identity_image',$map);

        return $arr;

    }

    //实名认证图片
    public function get_real_img($where)
    {
        $arr = $this->db->from('user AS a')->join('identity_image AS b','a.user_id = b.user_id','LEFT')
        ->select('a.is_real,a.real_name,a.identity_card,b.*')->where($where)->get()->result_array();

        return $arr[0];

    }


    //银行信息
    public function add_card_info()
    {
        $where1['user_id'] = $_SESSION['user_id'];
        $data['lists1'] = $this->db->from('user')->select('real_name,identity_card')->where($where1)->get()->result_array();
        $where2['status'] = 1;
        $data['lists2'] = $this->db->from('bank')->select('*')->where($where2)->get()->result_array();

        return $data;

    }

    //添加银行卡信息
    public function add_card($map)
    {
        $data = $this->db->insert('user_card',$map);

        return $data;
    }


    public function my_card_packge()
    {   
        $where['user_id'] = $_SESSION['user_id'];
        $rrr = $this->db->from('user')->select('is_real')->where($where)->get()->result_array();
        $data['is_real'] = $rrr[0]['is_real'];


        $qqq= $this->db->from('user_card AS a')->join('bank as b','a.bank_id=b.bank_id')->select('*')->where($where)->get()->result_array();

        foreach ($qqq as $k => $v) {
            $str = trim($v['card_no']);
            $strlen = ceil(strlen($str)/4);
            $strstr = str_split($str,4);
            $stt = '';
            for($i=0;$i<$strlen;$i++){
                $stt .= $strstr[$i].' ';
            }
            $qqq[$k]['card_no'] = $stt;
        }

        $data['lists'] = $qqq;

        return $data;

        
    }

 






    public function del_my_cart($card_id)
    {
        $where['card_id'] = $card_id;
        $res = $this->db->where($where)->delete('user_card');

        return $res;
    }

    // 邀请好友记录
    public function inviteFriendsRecord()
    {
        //主账号的最后一个副账号
        $user = $this->db->from('user')->where(['main_id' => $_SESSION['user_id']])->order_by('user_id desc')->get()->first_row('array');
        return $this->db->select('reg_time, mobile, user_name, qq')->from('user')->where(['parent_id' => $user['user_id']])->get()->result_array();
    }

    //查看推荐号
    public function get_parent_id($where)
    {   
        $arr1 = $this->db->select('parent_id')->from('user')->where($where)->get()->result_array();
        if($arr1){
            $where2['user_id'] = $arr1[0]['parent_id'];
            $arr2 = $this->db->select('user_name')->where($where2)->from('user')->get()->result_array();
            if($arr2){
                return $arr2[0]['user_name'];
            }

        }else{
            return false;
        }
    }

}
