<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *财务模块
 */
class Finance_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'bonus';		
	}
	
	public function order_list($page, $size, $start_time, $end_time, $status, $order_num,$agent_id)
	{
		$data = array();
		$page = ($page - 1)*$size;
		$where = array();
		$map = array();
		$this->db->from('pay_order AS a')->select('a.order_id, a.user_id,a.order_sn, a.pay_money, a.pay_status, a.pay_time, a.add_time,a.agent_id,b.user_id,b.user_name');

		if($start_time)
		{
			$this->db->where('a.pay_time >= ', strtotime($start_time.' 00:00:00'));
			$where['pay_time >='] = strtotime($start_time.' 00:00:00');
		}

		if($end_time)
		{
			$this->db->where('a.pay_time <= ', strtotime($end_time.' 23:59:59'));
			$where['pay_time <='] = strtotime($end_time.' 23:59:59');
		}

		if($status == 1)
		{
			$this->db->where('a.pay_status', '1');			
		}else if($status == 2){
		
			$this->db->where('a.pay_status', '0');
		}

		$where['pay_status'] = 1;

		if($order_num)
		{
			$this->db->like('a.order_sn', $order_num);
			$map['order_sn'] = $order_num;
		}

		if($agent_id)
		{	
			$this->db->like('a.agent_id', $agent_id);
			$map['agent_id'] = $agent_id;
		}

		$this->db->join('user as b','a.user_id=b.user_id');
		$this->db->order_by('a.order_id DESC');
		$data['lists'] = $this->db->limit($size,$page)->get()->result_array();

		$sum = $this->db->from('pay_order')->select_sum('pay_money')->like($map)->where($where)->get()->first_row('array');
		$data['sum'] = $sum['pay_money'];

		if($start_time)
		{
			$this->db->where('pay_time >= ', strtotime($start_time.' 00:00:00'));
		}
		
		if($end_time)
		{
			$this->db->where('pay_time <= ', strtotime($end_time.' 23:59:59'));
		}
		
		if($status == 1)
		{
			$this->db->where('pay_status', '1');
		}
		else if($status == 2)
		{
			$this->db->where('pay_status', '0');
		}

		if($order_num)
		{
			$this->db->like('order_sn', $order_num);
		}

		if($agent_id)
		{
			$this->db->like('agent_id', $agent_id);
		}
		
		$data['count'] = $this->db->count_all_results('pay_order');
		return $data;

	}

	
}



