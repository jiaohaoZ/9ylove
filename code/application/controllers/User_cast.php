<?php

/**
 * 首页
 */
class User_cast extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_cast_model');

        $this->load->language('account', 'zh_cn');
    }

    //购买倍投账号
    public function castBuy()
    {
        if ($this->input->post()) {
            $data['cast_num'] = $this->input->post('cast_num');
            // 获取最后一个倍投账号
            $last_cast = $this->db
                ->select('cast_name')
                ->from('user_cast')
                ->where(['user_id' => $_SESSION['user_id']])
                ->order_by('cast_id desc')
                ->get()->first_row('array');

            if ($last_cast) {
                $last_cast = explode(':', $last_cast['cast_name']);
                $last_cast[1] = $last_cast[1] + 1;
                // 1-9 前面拼接0
                if (in_array($last_cast[1], range(1, 9))) {
                    $last_cast[1] = '0' . $last_cast[1];
                }
                $data['cast_name'] = $_SESSION['user_name'] . ':' . $last_cast[1];
            } else {
                $data['cast_name'] = $_SESSION['user_name'] . ':' . '01';
            }

            // 倍投账户设置
            $user_cast_config = $this->config->item('user_cast_config');
            $data['reduce_user_money'] = $data['cast_num'] * $user_cast_config['buy_one_cast'];
            $this->view('cast_buy_confirm', $data);
        } else {
            $this->load->model('user_model');
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_money');
            $this->view('cast_buy', $data);
        }
    }

    // 倍投账号购买支付、添加倍投账户
    public function castBuyConfirm()
    {
        //判断支付密码是否正确
        if($this->input->post()) {
            $pay_password = $this->input->post('pay_password');
            $insert_data['cast_num'] = $this->input->post('cast_num');
            $insert_data['cast_name'] = $this->input->post('cast_name');
            $insert_data['user_id'] = $_SESSION['user_id'];
            $insert_data['add_time'] = time();
            $reduce_user_money = $this->input->post('reduce_user_money');

            //判断支付密码是否正确
            $this->load->model('user_model');
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'pay_password, pay_salt, bonus_total');
            if ($data['pay_password'] != md5(md5($pay_password) . $data['pay_salt'])) {
                $return['status'] = 1; //密码错误
                echo json_encode($return);
                exit;
            }

            $this->db->trans_begin();

            // 插入倍投表
            $this->user_cast_model->add_one($insert_data);

            // 扣除user_money
            $this->db
                ->where(['user_id' => $_SESSION['user_id']])
                ->set('user_money', 'user_money - ' . $reduce_user_money, false)
                ->update('user');

            //本人主副已激活账户获得推荐奖
            $account_bonus_config = config_item('account_bonus_config');
            $bonus_max = $account_bonus_config['bonus_max'];
            $result = $this->user_model->get_all(['main_id' => $_SESSION['user_id'], 'status' => 2], 'user_id, bonus_total');
            $user_ids = [];
            foreach ($result as $row)
            {
                $recommend_bonus = $insert_data['cast_num'] * 1;
                if($recommend_bonus + $row['bonus_total'] > $bonus_max) {
                    $recommend_bonus = $bonus_max - ceil($row['bonus_total']);
                }
                $user_ids[$row['user_id']] = $recommend_bonus;
            }

            $recommend_bonus = $insert_data['cast_num'] * 1;
            if($recommend_bonus + $data['bonus_total'] > $bonus_max) {
                $recommend_bonus = $bonus_max - ceil($data['bonus_total']);
            }

            $user_ids[$_SESSION['user_id']] = $recommend_bonus;

            foreach ($user_ids as $key => $value)
            {
                $this->db->set('recommend_bonus', 'recommend_bonus + ' . $value, false)
                    ->set('bonus_total', 'bonus_total + ' . $value, false)
                    ->where('user_id', $key)
                    ->update('user');
            }

            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                $return['status'] = 0;
            }
            else
            {
                $this->db->trans_commit();
                $return['status'] = 2;
            }

            echo json_encode($return);
            exit;
        }
    }

    // ajax判断余额是否不足
    public function isMoneyEnough()
    {
        if ($this->input->post()) {
            $cast_num = $this->input->post('cast_num');
            $this->load->model('user_model');
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_money');
            // 倍投账户设置
            $user_cast_config = $this->config->item('user_cast_config');
            // 余额 < 一个倍投账号费 * 份数
            if ($data['user_money'] < $user_cast_config['buy_one_cast'] * $cast_num) {
                $result['status'] = 1;
            } else {
                $result['status'] = 0;
            }
            echo json_encode($result);
            exit;
        }
    }

}
