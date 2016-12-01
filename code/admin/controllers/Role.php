<?php	
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 角色管理
 */

class Role extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		parent::admin_init();
		$this->load->model(array('role_priv_model'));
	}	
	
	/**
	 * 角色管理列表
	 */
	public function init() 
	{
	    $data = array();
	    $data['lists'] = $this->role_priv_model->role_list();
	    $this->load->view('role_list_tpl', $data);
	}
	
	/**
	 * 添加角色
	 */
	public function add() 
	{
	    if($this->input->post())
	    {
	        $data = $this->input->post('info');
	        if(!is_array($data) OR empty($data['role_name']))
	            show_message(lang('operation_failure'));
	        $this->role_priv_model->add_role($data);
			
			$this->admin_log(14, $_SESSION['user_name'].'添加了名称为'.$data['role_name'].'的角色');
	        show_message(lang('operation_success'), '?c=role&m=init&a=init');
	    }
	    else
	    {
	        $this->load->view('role_add_tpl');
	    }

	
	}
	
	/**
	 * 编辑角色
	 */
	public function edit() 
	{
	   $role_id = $this->input->get_post('role_id');
	   if($this->input->post())
	   {
	       	$data = $this->input->post('info');
	        if(!is_array($data) OR empty($data['role_name']))
	            show_message(lang('operation_failure'));
	        $this->role_priv_model->edit_role($data, array('role_id'=>$role_id));
			
			$this->admin_log(14, $_SESSION['user_name'].'修改了ID为'.$role_id.', 名称为'.$data['role_name'].'的角色');
	        show_message(lang('operation_success'), '?c=role&m=init&a=init');
	   }
	   else
	   {
	       $data = $this->role_priv_model->get_role(array('role_id'=>$role_id));
	       $this->load->view('role_edit_tpl', $data);
	   }
	}
	
	/**
	 * 删除角色
	 */
	public function delete() 
	{
	    $role_id = intval($_GET['role_id']);
	    if($role_id == '1') show_message(lang('this_object_not_del'), HTTP_REFERER);
	    $this->role_priv_model->delete_role(array('role_id'=>$role_id));
		
		$this->admin_log(14, $_SESSION['user_name'].'删除了ID为'.$role_id.'的角色');
	    show_message(lang('role_del_success'), '?c=role&m=init&a=init');
	}
	
	/**
	 * 权限设置
	 */
	public function setting_priv()
	{
	    $data = array();
	    $role_id = $this->input->get_post('role_id');	      
	    if($this->input->post())
	    {
	        $priv = $this->input->post('priv');
	        $priv_lists = array();
	        $this->db->delete('admin_role_priv', array('role_id' => $role_id));
	        foreach ($priv as $k=>$v)
	        {
	            if(!empty($k) && $k != 'empty')
	                $tmp = explode('-', $k);
	            $this->db->insert('admin_role_priv', array('role_id' => $role_id, 'c' => $tmp[0], 'm' => $tmp[1], 'a' => $tmp[2]));
	        }
			
			$this->admin_log(14, $_SESSION['user_name'].'设置了ID为'.$role_id.'的角色的权限');
	        show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
	    }
	    else 
	    {
	        $data['menu'] = $this->role_priv_model->role_menu();
	        $data['show_header'] = 1;
	        $data['role_id'] = $role_id;
	        $this->load->model('admin_model');
	        $data['admin_model'] = $this->admin_model;
	        $data['priv'] = $this->role_priv_model->get_role_priv(array('role_id' => $role_id));
	        $data['menu_priv'] = $this->role_priv_model->get_role_menu_priv();
 	        $this->load->view('role_priv_tpl', $data);
	    }
	}
}


/* End of file role.php */
/* Location: ./application/controllers/role.php */
