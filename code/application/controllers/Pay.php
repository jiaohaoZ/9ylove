<?php
/**
 * 充值
 */
class Pay extends Front_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_agent_model');
        $this->load->model('user_model');
        $this->load->model('pay_order_model');
    }

    public function index()
    {
        $data = [];
        $data['agents'] = $this->user_agent_model->getAllAgent();
        $this->view('pay_index_tpl', $data);
    }

    public function flow()
    {
        if($this->input->post()) {
            $money = (int) $this->input->post('money');
            if($money < 50) {
                show_msg('充值必须大于50个');
            }
            $agent_id = $this->input->post('agent_id');
            $agent = $this->user_agent_model->get_one(['agent_id' => $agent_id]);

            if(!$agent) {
                show_msg('代理商不存在');
            }

            $info = $this->user_model->get_one(['user_id' => $agent['user_id']]);

            $data = [
                'info' => $info,
                'money' => $money,
                'agent' => $agent,
            ];

            $this->view('pay_flow_tpl', $data);
        } else {
            redirect(site_url('pay'));
        }

    }

    public function done()
    {
        if($this->input->post()) {
            $money = (int) $this->input->post('money');
            $agent_id = $this->input->post('agent_id');
            if($money < 50) {
                show_msg('充值必须大于50个', site_url('pay'));
            }
            $agent_id = $this->input->post('agent_id');
            $agent = $this->user_agent_model->get_one(['agent_id' => $agent_id]);
            if(!$agent) {
                show_msg('代理商不存在', site_url('pay'));
            }

            $order_sn = get_order_sn();
            $order = [
                'user_id' => $_SESSION['user_id'],
                'order_sn' => $order_sn,
                'pay_money' => $money,
                'agent_id' => $agent_id,
                'add_time' => time(),
            ];

            $this->pay_order_model->add_one($order);
            $order_id = $this->db->insert_id();

            redirect('pay/order_view?order_id=' . $order_id);
        } else {
            redirect(site_url('pay'));
        }
    }

    public function order_view()
    {
        $order_id = $this->input->get('order_id');
        $order = $this->pay_order_model->get_one(['order_id' => $order_id]);
        if(!$order) {
            show_msg('订单不存在', site_url('user_transfer/myWallet'));
        }

        $agent = $this->user_agent_model->get_one(['agent_id' => $order['agent_id']]);

        $info = $this->user_model->get_one(['user_id' => $agent['user_id']]);

        $data = [
            'order' => $order,
            'agent' => $agent,
            'info' => $info,
        ];

        $this->view('order_view_tpl', $data);

    }

    // 充值记录
    public function pay_record()
    {
        $data = $this->pay_order_model->pay_record();
        $this->view('pay_record', $data);
    }

    // 充值记录滚动加载
    public function pay_record_load()
    {
        $page = $this->input->post('page');
        $data = $this->pay_order_model->pay_record($page, 10);
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