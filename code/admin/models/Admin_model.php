<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * admin_model model
 */
class Admin_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function admin_menu($id = 0)
	{
		$sql = "SELECT id, name, c, m, a, parent_id FROM `ci_menu` WHERE parent_id = ?  AND display = 1  ORDER BY listorder ASC";
		return $this->db->query($sql, array($id))->result_array();
	}
	
	public function admin_menu_priv($id)
	{
	    $sql = "SELECT id, name, c, m, a, parent_id FROM `ci_menu` WHERE parent_id = ?  ORDER BY listorder ASC";
	    $tmp = $this->db->query($sql, array($id))->result_array();
	    $priv = array();
	    $priv['priv_init']  = $priv['priv_add'] = $priv['priv_edit'] = $priv['priv_delete'] = 'empty';
	    foreach ($tmp as $row)
	    {
	        switch ($row['a'])
	        {
	        	case 'init': $priv['init'] = 1; $priv['priv_init'] = $row['c'] . '-' . $row['m'] . '-' . $row['a'];break;
	        	case 'add': $priv['add'] = 1; $priv['priv_add'] = $row['c'] . '-' . $row['m'] . '-' . $row['a'];break;
	        	case 'edit': $priv['edit'] = 1; $priv['priv_edit'] = $row['c'] . '-' . $row['m'] . '-' . $row['a'];break;
	        	case 'delete': $priv['delete'] = 1; $priv['priv_delete'] = $row['c'] . '-' . $row['m'] . '-' . $row['a'];break;
	        	default: break;
	        }
	    }
	    return $priv;
	}
	
	/**
	 * 当前位置
	 *
	 * @param $id 菜单id
	 */
	public function current_pos($id) {
		$sql = "SELECT id, name, parent_id  FROM `ci_menu` WHERE id = ? ";
		$r = $this->db->query($sql, array($id))->first_row();
		$str = '';
		if($r->parent_id) 
		{
			$str = $this->current_pos($r->parent_id);
		}
		return $str.lang($r->name).' > ';
	}
	
	/**
	 * 单个菜单信息
	 * @param $id 菜单id
	 */
	public function admin_menu_one($id = 0)
	{
		$sql = "SELECT id, name, parent_id, c, m, a  FROM `ci_menu` WHERE id = ? ";
		return $this->db->query($sql, array($id))->row_array();
	}
	
	/**
	 * 单个菜单信息
	 */
	public function get_menu_one($where)
	{
		$sql = "SELECT id, name, parent_id FROM `ci_menu` WHERE m = ? AND c = ?";
		return $this->db->query($sql, $where)->first_row('array');
	}
	
	/**
	 * 插入admin_panel
	 */
	public function add_panel($data = array())
	{
		if(empty($data)) return ;
		return $this->db->replace('admin_panel', $data);
	}
	
	public function delete_panel($data = array())
	{
		if(empty($data)) return ;
		return $this->db->delete('admin_panel', $data);
	}
	
    public function get_panel($user_id = 0)
    {
    	$sql = "SELECT menu_id, user_id, name, url FROM `ci_admin_panel` WHERE user_id = ? ORDER BY created_time DESC LIMIT 20";
    	return $this->db->query($sql, $user_id)->result_array();
    }
    
    public function get_user_name($user_name)
    {
    	$sql = "SELECT user_id, user_name, role_id, real_name, email, encrypt, password, last_login_time, last_login_ip FROM `ci_admin_user` WHERE user_name = ? ";
    	return $this->db->query($sql, $user_name)->first_row('array');
    }
    
    public function get_user_id($user_id)
    {
    	$sql = "SELECT user_id, user_name, role_id, real_name, email, encrypt, password, last_login_time, last_login_ip FROM `ci_admin_user` WHERE user_id = ? ";
    	return $this->db->query($sql, $user_id)->first_row('array');
    }
    
    public function update_user($data, $where)
    {
    	return $this->db->update('admin_user', $data, $where);
    }
    
    public function login_fail_times($where)
    {
    	$sql = "SELECT times, login_time FROM `ci_times` WHERE user_name = ? AND isadmin = ? ";
    	return $this->db->query($sql, $where)->first_row('array');
    }
    
    public function delete_login_fail_times($where)
    {
    	return $this->db->delete('times', $where);
    }
    
    public function insert_login_fail_times($data)
    {
    	return $this->db->insert('times', $data);
    }
    
    public function update_login_fail_times($data, $where)
    {
    	return $this->db->update('times', $data, $where);
    }
    
    
    
}











/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */