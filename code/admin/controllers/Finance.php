<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 积分管理
 */

class Finance extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        parent::admin_init();
		$this->load->model(array('user_model','finance_model'));
    }

    /*
	 * 订单列表
	 */
	public function order_list()
	{
		$data = array();
		$page = $this->input->get_post('page') ? intval($this->input->get_post('page')) : 1;
		$size   = config_item('page_size');
		$start_time = $this->input->get('start_time');
		$end_time = $this->input->get('end_time');
		$status = 	$this->input->get('status');
		$order_num = $this->input->get('keyword');
		$agent_id = $this->input->get('agent_id');								
		$data = $this->finance_model->order_list($page, $size, $start_time, $end_time, $status, $order_num,$agent_id);
		$cfg['total_rows'] = $data['count'];
		$cfg['per_page']  = $size;
		$data['pages'] = $this->pages($cfg);
		$data['start_time'] = $start_time;
		$data['end_time'] = $end_time;
		$data['order_num'] = $order_num;
		$data['agent_id'] = $agent_id;
		$this->load->view('order_list_tpl',$data);
	}

    
	/**
	 * 充值管理
	 */
	public function recharge_manage()
	{	
		if($this->input->post()){
			 $data = $this->input->post();
			 	$user = $this->user_model->get_one(array('user_name' => $data['user_name']));
				if(!$user){
					show_message('该会员不存在', $_SERVER['HTTP_REFERER']);
				}elseif($data['money'] <= 0){
					show_message('充值金额必须大于0', $_SERVER['HTTP_REFERER']);
				}elseif ($user['main_id'] != 0) {
					show_message('充值账号只能是主账号', $_SERVER['HTTP_REFERER']);
				}

			$this->db->trans_begin();

			if($data['type'] == 1)
			{
				$this->user_model->edit_one(array('user_money' => $data['money'] + $user['user_money']), array('user_id' => $user['user_id']));
			}

			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
				show_message(lang('system_busy'), $_SERVER['HTTP_REFERER']);
			}else{
				$this->db->trans_commit();			
				
				$type_name = lang('log_types')[$data['type']];
				$this->admin_log(7, $_SESSION['user_name'].'给会员'.$user['user_name'].'充值了'.$data['money'].'的'.$type_name);
				show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
			}

		}else{
			$data['log_types'] = lang('log_types');
			$this->load->view('recharge_money_tpl',$data);
		}
	}
	
	
	
	
}