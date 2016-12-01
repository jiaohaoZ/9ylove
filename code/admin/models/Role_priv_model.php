<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *权限模块
 */
class Role_priv_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'admin_role_priv';
	}
	
	public function get_role_priv_one($where)
	{
		$sql = "SELECT * FROM `ci_admin_role_priv` WHERE role_id = ? AND c = ? AND m = ? AND d = ?";
		return $this->db->query($sql, $where)->first_row();
	}
	
	public function role_list()
	{
	    return $this->db->from('admin_role')->get()->result_array();
	}
	
	public function add_role($data)
	{
	    return $this->db->insert('admin_role', $data);
	}
	
	public function get_role($where)
	{
	    return $this->db->from('admin_role')->where($where)->get()->first_row('array');
	}
	
	public function edit_role($data, $where)
	{
	    return $this->db->update('admin_role', $data, $where);
	}
	
	public function delete_role($where)
	{
	    return $this->db->delete('admin_role', $where);
	}
	
	public function get_role_list()
	{
	    $tmp = $this->db->from('admin_role')->get()->result_array();
	    $data = array();
	    foreach ($tmp as $v)
	    {
	        $data[$v['role_id']] = $v['role_name'];
	    }
	    return $data;
	}
	
	public function role_menu()
	{
	   return $this->db->from('menu')->where(array('parent_id' => 0))->get()->result_array();	    
	}

	public function get_role_priv($where)
	{
	    $tmp = $this->db->from($this->_table)->where($where)->get()->result_array();
	    $data = array();
	    foreach ($tmp as $row)
	    {
	        $k = $row['c']. '-' . $row['m'] . '-' .$row['a'];
	        $data[$k] = 'checked';
	    }
	    return $data;
	}
	
	public function get_role_menu_priv()
	{
	    $tmp = $this->db->from('menu')->get()->result_array();
	    $data = array();
	    foreach ($tmp as $row)
	    {
	        $k = $row['c']. '-' . $row['m'] . '-' .$row['a'];
	        $data[$k] = 1;
	    }
	    return $data;
	}
	
	public function get_channel()
	{
	    $tmp = $this->db->select('*')->from('channel')->get()->result_array();
	    $data = array();
	    foreach ($tmp as $row)
	    {
	        $data[$row['channel_id']] = $row['channel_name'];
	    }
	    return $data;
	}
	
}



/* End of file role_priv_model.php */
/* Location: ./application/model/role_priv_model.php */