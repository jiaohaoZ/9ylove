<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *管理员模块
 */
class Admin_manage extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		parent::admin_init();
		$this->load->model(array('admin_manage_model', 'role_priv_model', 'admin_log_model'));
	}
	
	public function admin_list($page = 1)
	{
		$page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
		$size   = $this->input->get('size') ? intval($this->input->get('size')) : config_item('page_size');
		$data = $this->admin_manage_model->admin_list($page, $size);	
		$data['roles'] = $this->role_priv_model->get_role_list();
		$cfg['total_rows'] = $data['count'];
		$cfg['per_page']  = $size;
		$data['pages'] = $this->pages($cfg);
		$this->load->view('admin_list_tpl', $data);
	}
	
	public function admin_add()
	{
		if($this->input->post('dosubmit'))
		{
			$info = $this->input->post('info');
			if($this->admin_manage_model->check_name(array('user_name'=>$info['username'])))
			{
				show_message(lang('admin_already_exists'));
			}
			if(!is_password($info['password']))
			{
				show_message(lang('pwd_incorrect'));
			}
			
			if(! is_email($info['email']))
			{
				show_message(lang('email_illegal'));
			}
			$data = array();
			$passwordinfo = password($info['password']);
			$data['password'] = $passwordinfo['password'];
			$data['encrypt'] = $passwordinfo['encrypt'];
			$data['user_name'] = $info['username'];
			$data['role_id'] = $info['roleid'];
			$data['real_name'] = $info['realname'];
			$data['email'] = $info['email'];
	
			$admin_fields = array('user_name', 'email', 'password', 'encrypt','role_id','real_name');
			foreach ($data as $k=>$value) {
				if (! in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			if($this->admin_manage_model->add_one($data))
			{
				$this->admin_log(15, $_SESSION['user_name'].'添加了管理员'.$data['user_name']);
				show_message(lang('operation_success'), '?c=admin_manage&m=admin_list&a=init');
			}
		}
		else 
		{
			$data['roles'] = $this->role_priv_model->get_role_list();
			$this->load->view('admin_add_tpl', $data);
		}
	}
	
	public function admin_edit()
	{
		if($this->input->post('dosubmit'))
		{
			$info = $this->input->post('info');
			if(!empty($info['password']))
				$data['password'] = password($info['password'], $info['encrypt']);
			
			if(! is_email($info['email']))
			{
				show_message(lang('email_illegal'));
			}
			
			$data['role_id'] = $info['roleid'];
			$data['real_name'] = $info['realname'];
			$data['email'] = $info['email'];
			if($this->admin_manage_model->edit_one($data, array('user_id' => $info['userid'])))
			{
				$this->admin_log(15, $_SESSION['user_name'].'修改了ID为'.$info['userid'].'的管理员');
				show_message(lang('operation_success'), '', '', 'edit');	
			}
				
		}
		else
		{
			$user_id = $this->input->get('userid');
			$data = $this->admin_manage_model->get_one(array('user_id' => $user_id));
			$data['roles'] = $this->role_priv_model->get_role_list();
			$data['show_header'] = 1;
			$this->load->view('admin_edit_tpl', $data);		
		}
	}
	
	public function admin_delete()
	{
		$user_id = $this->input->get('userid');
		if($user_id == '1') show_message(lang('this_object_not_del'), $this->input->server('HTTP_REFERER'));
		$this->admin_manage_model->del_one(array('user_id'=>$user_id));
		
		$this->admin_log(15, $_SESSION['user_name'].'删除了ID为'.$user_id.'的管理员');
		show_message(lang('admin_cancel_succ'), $_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * 异步检测用户名
	 */
	public function checkname_ajax() 
	{
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if ($this->admin_manage_model->check_name(array('user_name'=>$username)))
		{
			exit('0');
		}
		exit('1');
	}
	
	/**
	 * 编辑用户信息
	*/
	public function edit_info() 
	{
		$userid =$this->session->userdata('user_id');
		if($this->input->post('dosubmit'))
		{
			$info = array();
			$info = $this->input->post('info');
			$this->admin_manage_model->edit_one($info,array('user_id'=>$userid));
			
			$log_info = $_SESSION['user_name'].'修改了个人信息';
			$this->admin_log('1', $log_info);
			show_message(lang('operation_success'),$this->input->server('HTTP_REFERER'));
		} 
		else
		{
			$data = $this->admin_manage_model->get_one(array('user_id' => $userid));
			$data['show_header'] = 1;
			$this->load->view('admin_edit_info_tpl', $data);
		}
	}
	
	/**
	 * 修改密码
	 */
	public function edit_pwd() 
	{
		$userid = $this->session->userdata('user_id');
		if($this->input->post('dosubmit')) 
		{
			$r = $this->admin_manage_model->get_one(array('user_id' => $userid));
			if ( password($this->input->post('old_password'),$r['encrypt']) !== $r['password'] ) 
				show_message(lang('old_password_wrong'),$this->input->server('HTTP_REFERER'));
			if( $this->input->post('new_password'))
			{
				$new_password = password($this->input->post('new_password'),$r['encrypt']);
				$this->admin_manage_model->edit_one(array('password' => $new_password), array('user_id' => $userid));
			}
			
			$this->admin_log(2, $_SESSION['user_name'].'修改了登录密码');
			show_message(lang('password_edit_succ_logout'), site_url('c=index&m=logout'));
		} 
		else
		{
			$data = $this->admin_manage_model->get_one(array('user_id' => $userid));
			$data['show_header'] = 1;
			
			$this->load->view('admin_edit_pwd_tpl', $data);
		}	
	}
	
	public function public_email_ajx()
	{
		$email = $this->input->get('email');
		$check = $this->admin_manage_model->check_email(array($email));
		if($check && $check->user_id != $this->session->userdata('user_id'))
		{
			exit('0');
		}
		exit('1');
	}
	
	function public_password_ajx() 
	{
		$userid = $this->session->userdata('user_id');
		$r = array();
		$r = $this->admin_manage_model->get_one(array('user_id' => $userid));
		if ( password($this->input->get('old_password'),$r['encrypt']) == $r['password'] )
		{
			exit('1');
		}
		exit('0');
	}

	public function role_manage()
	{
		
	}
	
	public function admin_log_list()
	{
		$data = array();
		$page = $this->input->get_post('page') ? intval($this->input->get_post('page')) : 1;
		$size   = config_item('page_size');
		$start_time = $this->input->get('start_time');
		$end_time = $this->input->get('end_time');
		$admin_user = $this->admin_manage_model->get_one(array('user_name' => $this->input->get('admin')));
		$type = $this->input->get('operation_type');
		
		$data = $this->admin_log_model->admin_log_list($page, $size, $start_time, $end_time, $admin_user['user_id'], $type);
		
		$cfg['total_rows'] = $data['count'];
		$cfg['per_page']  = $size;
		$data['pages'] = $this->pages($cfg);
		$data['type'] = $type;
		$this->load->view('admin_log_tpl', $data);
	}
	
	
}





/* End of file admin_manage.php */
/* Location: ./application/controllers/admin_manage.php */
