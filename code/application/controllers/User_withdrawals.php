<?php

/**
 * 首页
 */
class User_withdrawals extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_withdrawals_model');
    }

    // 提现
    public function userWithdrawals()
    {
        $this->load->model(['user_model', 'user_card_model']);
        $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'gold_money');
        $data['card'] = $this->user_card_model->getUserCard();
        $data['personal_income_config'] = $this->config->item('personal_income_config');
        $this->view('user_withdrawals', $data);
    }

    // 确定提现
    public function userWithdrawalsConfirm()
    {
        if ($this->input->post()) {
            $this->load->model(['user_model', 'user_card_model']);
            $pay_password = $this->input->post('pay_password');
            $money = $this->input->post('money');
            $insert['money'] = intval($money / 60) * 60; //60的整数倍
            $personal_income_config = $this->config->item('personal_income_config');
            $insert['real_money'] = $insert['money'] - $insert['money'] * $personal_income_config * 0.01;
            $insert['card_id'] = $this->input->post('card_id');
            $insert['user_id'] = $_SESSION['user_id'];
            $insert['add_time'] = time();

            $card = $this->user_card_model->get_one(['card_id' => $insert['card_id']]);
            $insert['card_no'] = $card['card_no'];

            if ($insert['money'] < 60) {
                $result['status'] = 5; //提现金额为60的整数倍
                echo json_encode($result);
                exit;
            }

            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'gold_money, pay_password, pay_salt');

            // 判断余额 > 提现值
            if ($data['gold_money'] < $insert['money']) {
                $result['status'] = 4; //超出期望值
                echo json_encode($result);
                exit;
            }

            // 判断支付密码
            if ($data['pay_password'] != md5(md5($pay_password) . $data['pay_salt'])) {
                $result['status'] = 1; //密码错误
                echo json_encode($result);
                exit;
            }

            // 提现
            $this->user_withdrawals_model->add_one($insert);

            if ($this->db->insert_id()) {
                $result['status'] = 2; // 提现成功
            } else {
                $result['status'] = 0; // 提现失败
            }
            echo json_encode($result);
            exit;
        }
    }


    // 提现记录
    public function withdrawals_record()
    {
        $data = $this->user_withdrawals_model->withdrawals_record();
        $this->view('withdrawals_record', $data);
    }

    // 提现记录滚动加载
    public function withdrawals_record_load()
    {
        $page = $this->input->post('page');
        $data = $this->user_withdrawals_model->withdrawals_record($page, 10);
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