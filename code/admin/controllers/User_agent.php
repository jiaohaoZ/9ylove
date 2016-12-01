<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 代理管理
 */
class User_agent extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        parent::admin_init();
        $this->load->model('user_agent_model');
        $this->load->language(['user_agent'], 'zh_cn');
    }

    // 添加修改代理
    public function agent_edit()
    {
        if ($this->input->post()) {
            if($this->input->post('agent_rank') != '-1') {
                $insert = [
                    'user_id' => $this->input->post('user_id'),
                    'agent_rank' => $this->input->post('agent_rank'),
                    'agent_name' => $this->input->post('user_name'),
                    'alipay' => $this->input->post('alipay'),
                    'card_no' => $this->input->post('card_no'),
                    'bank' => $this->input->post('bank'),
                    'card_address' => $this->input->post('card_address'),
                    'status' => 1,
                ];

                $isset = $this->user_agent_model->get_one(['user_id' => $this->input->post('user_id')]);
                if ($isset) {
                    $this->user_agent_model->edit_one($insert, ['agent_id' => $isset['agent_id']]);
                } else {
                    $insert['agent_id'] = '9000' . mt_rand(1000, 9999);
                    $this->user_agent_model->add_one($insert);
                    echo $this->db->last_query();
                }
            }
            show_message(lang('agent_add_success'), $_SERVER['HTTP_REFERER']);
        } else {
            $this->config->load('user_agent');
            $this->load->model('user_model');
            $data = $this->user_model->get_one(['user_id' => $this->input->get('user_id')], 'user_id, user_name, mobile');
            $data['agent_all'] = $this->config->item('agent');
            $data['user_agent'] = $this->user_agent_model->get_one(['user_id' => $this->input->get('user_id')]);
            $this->load->view('user_agent_edit', $data);
        }
    }

}