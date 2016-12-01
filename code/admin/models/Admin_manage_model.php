<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *权限模块
 */
class Admin_manage_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'admin_user';		
	}
	
   	public function admin_list($page, $size)
   	{
   		$data = array();
   		$data['list'] = $this->db->select('*')->get('admin_user', $size, ($page-1)*$size)->result_array();
   		$data['count'] = $this->db->count_all_results('admin_user');
   		return $data;
   	}
   	
   	public function check_name($where)
   	{
   		$sql = 'SELECT user_id FROM `ci_admin_user` WHERE user_name = ? ';
   		return $this->db->query($sql, $where)->result_array();
   	}
   	   	  	   	
   	public function check_email($where)
   	{
   		$sql = 'SELECT user_id FROM `ci_admin_user` WHERE email = ? ';
   		return $this->db->query($sql, $where)->first_row();
   	}
   	
}



/* End of file admin_manage_model.php */
/* Location: ./application/models/admin_manage_model.php */