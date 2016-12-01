<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 会员管理
 */
class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        parent::admin_init();
        $this->load->model('user_model');
        $this->load->language(['user'], 'zh_cn');
    }

    //用户列表
    public function user_list()
    {
        $page = $this->input->get_post('per_page') ? intval($this->input->get_post('per_page')) : 1;
        $size = config_item('page_size');
        $where = [];
        $extend = [];
        $mobile = $this->input->get('mobile');
        $user_name = $this->input->get('user_name');

        if($mobile) {
            $mobile = str_replace(array(' ', '，'), ',', $mobile);
            $mobile = explode(',', $mobile);
            $extend['where_in']['mobile'] = $mobile;
        }

        if($user_name) {
            $user_name = str_replace(array(' ', '，'), ',', $user_name);
            $user_name = explode(',', $user_name);
            $extend['where_in']['user_name'] = $user_name;
        }

        $list = $this->user_model->user_list($where, $page, $size, $extend);
        $data['list'] = $list['lists'];

        $cfg['total_rows'] = $list['count'];
        $cfg['per_page'] = $size;
        $data['pages'] = $this->pages($cfg);
        $this->load->view('user_list_tpl.php', $data);
    }

    //获取会员信息
    public function user_info()
    {
        $data = $this->user_model->get_one(['user_id' => $this->input->get('user_id')]);
        $this->load->view('user_info', $data);
    }

    // 查看副账号
    public function view_child()
    {
        $user_id = $this->input->get('user_id');
        $data['list'] = $this->user_model->view_child($user_id);
        $this->load->view('user_child_tpl', $data);
    }

    // 会员修改
    public function user_edit()
    {
        if ($this->input->post()) {
            $where['user_id'] = $this->input->post('user_id');
            $before = $this->user_model->get_one(['user_id' => $this->input->post('user_id')]);

            if (empty($before)) {
                show_message('链接不存在', $_SERVER['HTTP_REFERER']);
            }

            if ($this->input->post('password') != $this->input->post('pwdconfirm')) {
                show_message(lang('passwords_not_match'), $_SERVER['HTTP_REFERER']);
            }

            if (strlen($this->input->post('password')) > 16) {
                $data['password'] = $this->input->post('password');
            } else {
                $data['password'] = md5(md5($this->input->post('password')) . $before['salt']);
            }

            //为空则不修改
            if (!$this->input->post('password')) {
                $data['password'] = $before['password'];
                show_message(lang('operation_success'), '', '', 'edit');
            } else {
                $this->user_model->edit_one($data, $where);
                $passwordChange = $_SESSION['user_name'] . "修改了会员" . $before['user_name'] . "的密码；";
                $this->admin_log(3, $passwordChange);
                show_message(lang('operation_success'), '', '', 'edit');
            }
        } else {
            $data = $this->user_model->get_one(['user_id' => $this->input->get('user_id')]);
            $this->load->view('user_edit', $data);
        }
    }

    // 提现管理
    public function user_withdrawals()
    {
        $this->load->model('user_withdrawals_model');
        $page = $this->input->get_post('per_page') ? intval($this->input->get_post('per_page')) : 1;
        $size = config_item('page_size');
        $where = [];
        $extend = [];
        $data = $this->user_withdrawals_model->get_list($where, $page, $size, $extend);

        $cfg['total_rows'] = $data['count'];
        $cfg['per_page'] = $size;
        $data['pages'] = $this->pages($cfg);
        $this->load->view('user_withdrawals_tpl.php', $data);
    }

    //审核提现
    public function update_status()
    {
        $this->load->model('user_withdrawals_model');
        $pass = $this->input->get('pass');
        $refuse = $this->input->get('refuse');
        $wl_id = $this->input->get('wl_id');
        $user_id = $this->input->get('user_id');
        $money = $this->input->get('money');
        // 审核通过
        if ($pass == 1) {
            $this->db->trans_begin();
            // 获取before_money
            $user = $this->user_model->get_one(['user_id' => $user_id], 'gold_money');
            // 修改审核状态、审核时间
            $this->user_withdrawals_model->edit_one(['status' => 1, 'confirm_time' => time()], ['wl_id' => $wl_id]);
            // 扣爱心积分
            $this->db
                ->where(['user_id' => $user_id])
                ->set('gold_money', 'gold_money - ' . $money, false)
                ->update('user');
            // 写日志
            $this->load->model('user_log_model');
            $this->user_log_model->user_log($user_id, 4, 1, $user['gold_money'] , ($user['gold_money'] - $money), '爱心积分提现');

            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                show_message(lang('user_withdrawals_pass'));
                return true;
            }

        }

        // 拒绝
        if ($refuse == 1) {
            $this->user_withdrawals_model->edit_one(['status' => 2, 'confirm_time' => time()], ['wl_id' => $wl_id]);
            show_message(lang('user_withdrawals_refuse'));
        }

    }


    //用户日志
    public function user_log()
    {   
        $data = array();
        $page = $this->input->get_post('page') ? intval($this->input->get_post('page')) : 1;
        $size   = config_item('page_size') ? config_item('page_size') :15  ;
        $start_time = $this->input->get('start_time');
        $end_time = $this->input->get('end_time');
        $log_type = $this->input->get('log_type');
        $user_name = $this->input->get('keyword') ? $this->input->get('keyword') : '';
        $user = $this->user_model->get_one(array('user_name'=>$user_name));
        $export = $this->input->get('export');
        $data = $this->user_model->user_log($start_time,$end_time,$page, $size, $log_type, $user['user_id']);
        $where = array();
        if($export){
            set_time_limit(0); 
            ini_set('memory_limit','1024M');
            ini_set('max_execution_time','0');
            $filename = './data/'.date('YmdHis').'.csv';
            if($user['user_id']){
                $where['user_log.user_id = '] = $user['user_id'];
            }

            if($log_type){
                $where['log_type = '] = $log_type;
            }

            if($start_time){
                $where['log_time >= '] = strtotime($start_time.'00:00:00');
            }

            if($end_time){
                $where['log_time <= '] = strtotime($end_time.'23:59:59');
            }

            $count = $data['count'];

            $c = 0;
            $page = ceil($count / 5000);

            $this->config->load('user_log');
            $log_types = $this->config->item('log_type');

            for($i = 0;$i < $page;$i++){

                $arr = $this->db->select('log_id, log_type, user_name, before_money, after_money, log_info, log_time')
                    ->from('user_log')
                    ->join('user','user_log.user_id = user.user_id')
                    ->where($where)
                     ->limit(4999,$c)
                    ->order_by('log_id DESC')
                    ->get()->result_array();

                $c = $c + 5000;
                if(!empty($arr)){
                        $fp = fopen($filename,"a+");
                        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
                        fputcsv($fp,array(
                                    '日志ID',
                                    '日志类型',
                                    '用户名',
                                    '变化前(金额)',
                                    '变化后(金额)',
                                    '日志信息',
                                    '日志时间'
                                    ));
                        foreach ($arr as $k => $v) {
                            $v['log_time'] = date('Y-m-d H:i:s',$v['log_time']);
                            foreach ($log_types as $key => $val) {
                                if($v['log_type'] == $key){
                                    $v['log_type'] = $val;
                                }
                            }
                            
                             fputcsv($fp,array(
                                            $v['log_id'],
                                            $v['log_type']. "\t",
                                            $v['user_name']. "\t",
                                            $v['before_money']. "\t",
                                            $v['after_money']. "\t",
                                            $v['log_info']."\t",
                                            $v['log_time']."\t",
                                            ));
                        }
                    fclose($fp);
                }

                
            }

                if (file_exists($filename)) {
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=".date('YmdHis').'.csv' ) ;
                    echo file_get_contents($filename);
                    @unlink($filename);
                } else {
                    show_message('没有符合条配件的数据', $_SERVER['HTTP_REFERER']);
                }

                 exit;
    
        }
        $cfg['total_rows'] = $data['count'];
        $cfg['per_page']  = $size;
        $data['pages'] = $this->pages($cfg);
        $this->config->load('user_log');
        $data['log_types'] = $this->config->item('log_type');
        $data['log_type'] = $log_type;
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        $this->load->view('user_log_tpl',$data);

    }

}