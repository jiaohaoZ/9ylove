<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *权限模块
 */
class Admin_log_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'admin_log';		
	}
   	
	public function admin_log_list($page, $size, $start_time, $end_time, $admin_user, $type)
	{
		$data = array();
		$page = ($page - 1)*$size;
		$this->db->select('user_name, log_type, log_info, log_time, log_ip');
		
		if($start_time)
		{
			$this->db->where('log_time > ', strtotime($start_time.'00:00:00'));
		}
		
		if($end_time)
		{
			$this->db->where('log_time < ', strtotime($end_time.'23:59:59'));
		}
		
		if($admin_user)
		{
			$this->db->where('admin_log.user_id', $admin_user);
		}
		
		if($type)
		{
			$this->db->where('log_type', $type);
		}
		$this->db->join('admin_user', 'admin_user.user_id = admin_log.user_id');
		$data['list'] = $this->db->from($this->_table)->limit($size, $page)
									  ->order_by('log_time DESC')
									  ->get()->result_array();
		
		if($start_time)
		{
			$this->db->where('log_time > ', strtotime($start_time.'00:00:00'));
		}
		
		if($end_time)
		{
			$this->db->where('log_time < ', strtotime($end_time.'23:59:59'));
		}
		
		if($admin_user)
		{
			$this->db->where('user_id', $admin_user);
		}
		
		if($type)
		{
			$this->db->where('log_type', $type);
		}
		
		$data['count'] = $this->db->count_all_results($this->_table);							 
		
		return $data;
	}
}
