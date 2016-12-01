<?php

/**
 * 首页
 */
class User_transfer extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_transfer_model');
        $this->load->language('user_transfer', 'zh_cn');
    }

    // 我的钱包
    public function myWallet()
    {
        $this->load->model('user_model');
        $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_money, gold_money, shop_money');
        $this->view('my_wallet', $data);
    }

    // 转账
    public function userTransfer()
    {
        $this->view('user_transfer');
    }

    // 判断转账账号是否存在
    public function isUserIsset()
    {
        if ($this->input->post()) {
            $userInfo = $this->input->post('userInfo');
            // 主账户、已激活
            $userData = $this->db
                ->from('user')
                ->select('user_id')
                ->group_start()
                    ->where(['mobile' => $userInfo])
                    ->or_group_start()
                    ->where(['user_name' => $userInfo])
                    ->group_end()
                    ->or_group_start()
                    ->where(['email' => $userInfo])
                    ->group_end()
                ->group_end()
                ->where(['is_main' => 1])
                ->get()->first_row('array');

            if ($userData) {
                $result['transfer_user_id'] = $userData['user_id'];
                $result['status'] = 1; //存在
            } else {
                $result['status'] = 0; // 不存在
            }
            echo json_encode($result);
            exit;
        }
    }

    // 转账对象详情
    public function userTransferDetail()
    {
        if ($this->input->post()) {
            $this->load->model('user_model');
            $data = $this->user_model->get_one(['user_id' => $this->input->post('transfer_user_id')], 'user_id, user_money, user_name, email, portrait, mobile');
            $data['self'] = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_money');
            $data['transfer_user'] = $this->input->post('transfer_user');
            $this->view('user_transfer_detail', $data);
        }
    }

    // 确认转账
    public function userTransferConfirm()
    {
        //判断支付密码是否正确
        if ($this->input->post()) {
            $pay_password = $this->input->post('pay_password');
            //转出
            $insert_data['money'] = $this->input->post('money');
            $insert_data['money_type'] = 2; //向日葵积分
            $insert_data['transfer_type'] = 1; //转出
            $insert_data['transfer_user'] = $this->input->post('transfer_user');
            $insert_data['transfer_user_id'] = $this->input->post('transfer_user_id');
            $insert_data['transfer_desc'] = $this->input->post('transfer_desc');
            $insert_data['user_id'] = $_SESSION['user_id'];
            $insert_data['add_time'] = time();

            //转入
            $insert['money'] = $this->input->post('money');
            $insert['money_type'] = 2; //向日葵积分
            $insert['transfer_type'] = 2; //转入
            $insert['transfer_user'] = $_SESSION['user_name'];
            $insert['transfer_user_id'] = $_SESSION['user_id'];
            $insert['transfer_desc'] = $this->input->post('transfer_desc');
            $insert['user_id'] = $this->input->post('transfer_user_id');
            $insert['add_time'] = time();

            $transfer_before_money = $this->input->post('transfer_before_money');

            //判断支付密码是否正确
            $this->load->model('user_model');
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_money, pay_password, pay_salt');
            if ($data['pay_password'] != md5(md5($pay_password) . $data['pay_salt'])) {
                $result['status'] = 1; //密码错误
                echo json_encode($result);
                exit;
            }

            // 判断现有的user_money > 转出
            if($data['user_money'] < $insert_data['money']) {
                $result['status'] = 4; //超出期望值
                echo json_encode($result);
                exit;
            }

            // 开始转账
            $this->db->trans_begin();

            // 添加转账记录
            $this->user_transfer_model->add_one($insert_data);
            $this->user_transfer_model->add_one($insert);

            // 转出方扣除user_money
            $this->db
                ->where(['user_id' => $_SESSION['user_id']])
                ->set('user_money', 'user_money - ' . $insert_data['money'], false)
                ->update('user');

            // 收入方添加user_money
            $this->db
                ->where(['user_id' => $insert_data['transfer_user_id']])
                ->set('user_money', 'user_money + ' . $insert_data['money'], false)
                ->update('user');

            // 日志
            $this->load->model('user_log_model');
            // 转出方日志
            $this->user_log_model->user_log($_SESSION['user_id'], 3, 2, $data['user_money'], ($data['user_money'] - $insert_data['money']), '转账扣除'.$insert_data['money'].'个向日葵积分');
            // 收方日志
            $this->user_log_model->user_log($insert_data['transfer_user_id'], 3, 2, $transfer_before_money, ($transfer_before_money + $insert_data['money']), '转账收入'.$insert_data['money'].'个向日葵积分');


            if ($this->db->trans_status() === FALSE) {
                $result['status'] = 0; //购买失败
                $this->db->trans_rollback();
            } else {
                $result['status'] = 2; //购买成功
                $this->db->trans_commit();
            }
            echo json_encode($result);
            exit;
        }
    }

    // 交易记录
    public function transfer_record()
    {
        $data = $this->user_transfer_model->transfer_record();
        $this->view('transfer_record', $data);
    }

    // 交易记录滚动加载
    public function transfer_record_load()
    {
        $page = $this->input->post('page');
        $data = $this->user_transfer_model->transfer_record($page, 10);
        if (!empty($data['lists'])) {
            $data['status'] = 1;
            echo json_encode($data);
            exit;
        } else {
            $data = [
                'lists' => [],
                'status' => 0,
            ];
            echo json_encode($data);exit;
        }
    }
}