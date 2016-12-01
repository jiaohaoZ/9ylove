<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		parent::admin_init();
		$this->load->model(array('admin_model'));
	}
	
	public function login()
	{
		if($this->input->post('dosubmit'))
		{
			$user_name = $this->input->post('username') ?  $this->input->post('username') : show_message(lang('nameerror'), site_url('c=index&m=login'));
			$password   = $this->input->post('password') ? $this->input->post('password') : show_message(lang('password_can_not_be_empty'), site_url('c=index&m=login'));
			$captcha      = $this->input->post('captcha') ? $this->input->post('captcha') : show_message(lang('code_error'), site_url('c=index&m=login'));
			if($captcha != $this->session->userdata('captcha')) 
				show_message(lang('code_error'), site_url('c=index&m=login'));
			$r = $this->admin_model->get_user_name(array('user_name' => $user_name));
			if(!$r) show_message(lang('user_not_exist'), site_url('c=index&m=login'));
			
			//密码错误剩余重试次数
			$rtime = $this->admin_model->login_fail_times(array('user_name'=>$user_name,'isadmin'=>1));
			$maxloginfailedtimes = config_item('max_login_failed_times');
			
			if(isset($rtime['times']) && $rtime['times'] >= $maxloginfailedtimes)
			{
				$minute = 60-floor((time()-$rtime['login_time'])/60);
				if($minute>0) show_message(sprintf(lang('wait_1_hour'),$minute));
			}
			
			$password = md5(md5($password).$r['encrypt']);
			if($r['password'] != $password)
			{
				$ip = $this->input->ip_address();
				if($rtime && $rtime['times'] < $maxloginfailedtimes)
				{
					$times = $maxloginfailedtimes-intval($rtime['times']);
					$this->admin_model->update_login_fail_times(array('ip'=>$ip,'isadmin'=>1,'times'=>$rtime['times']+1),array('user_name'=>$user_name));
				}
				else 
				{
					$this->admin_model->delete_login_fail_times(array('user_name'=>$user_name,'isadmin'=>1));
					$this->admin_model->insert_login_fail_times(array('user_name'=>$user_name,'ip'=>$ip,'isadmin'=>1,'login_time'=>time(),'times'=>1));
					$times = $maxloginfailedtimes;
				}
				show_message(sprintf(lang('password_error'), $times), site_url('c=index&m=login'), 3000);
			}
			$this->admin_model->update_user(array('last_login_ip'=>$this->input->ip_address(),'last_login_time'=>time()), array('user_id'=>$r['user_id']));
			$this->session->set_userdata(
					array('user_id'=>$r['user_id'], 
						  'user_name'=>$r['user_name'],
						  'role_id'	=>$r['role_id'],
						  'email'=>$r['email'],
						  'real_name'=>$r['real_name'],
						  'lock_screen'	=>0
			           )
			);
			
			$this->admin_model->delete_login_fail_times(array('user_name'=>$user_name,'isadmin'=>1));
		    show_message(lang('login_success'), site_url());

		}
		else 
		{
			$this->load->view('login_tpl');
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		show_message(lang('logout_success'), site_url('c=index&m=login'));
	}

	public function index()
	{
		$data['charset'] = $this->config->item('charset');
		$data['admin_menu'] = $this->admin_model->admin_menu(0);
		$data['user_name'] = $this->session->userdata('user_name');
		$data['lock_screen'] = $this->session->userdata('lock_screen');
		$data['adminpanel'] = $this->admin_model->get_panel($this->session->userdata('user_id'));
		$this->load->view('index_tpl', $data);
	}	
	
	public function info()
	{		
		$data['real_name'] = $this->session->userdata('real_name');
		$r = $this->admin_model->get_user_id($this->session->userdata('user_id'));
		$data['last_login_ip'] = $r['last_login_ip'];
		$data['last_login_time'] = date('Y-m-d H:i:s', $r['last_login_time']);
		$data['show_header'] = 1;
		$roles = get_cache('admin_role');
		$data['role_name'] = $roles[$r['role_id']];
		$this->load->view('info_tpl', $data);
	}
	
	/**
	 * 左侧菜单
	 */
	public function left_menu()
	{
	    $menuid = $this->input->get_post('menuid');
		$data['datas'] = $this->admin_model->admin_menu($menuid);
		$data['admin_model'] = $this->admin_model;
		$this->load->view('left_tpl', $data);
	}
	
	/**
	 * 当前位置
	 */
	public function current_pos()
	{
	    $menuid = $this->input->get_post('menuid');
		echo $this->admin_model->current_pos($menuid);
		exit;
	}
	
	/**
	 * 维持 session 登陆状态
	 */
	public function session_life()
	{
		$user_id = $this->session->userdata('user_id');
		return true;
	}
	
	public function ajax_add_panel()
	{
		$menuid = isset($_POST['menuid']) ? $_POST['menuid'] : exit('0');
		$menuarr = $this->admin_model->admin_menu_one($menuid);
		$url = site_url('c='.$menuarr['c'].'&m='. $menuarr['m'] . '&a=' . $menuarr['a']);
		$data = array('menu_id'=>$menuid, 'user_id'=>$this->session->userdata('user_id'), 'name'=>$menuarr['name'], 'url'=>$url, 'created_time'=>time());
		$this->admin_model->add_panel($data);
		$panelarr = $this->admin_model->get_panel($this->session->userdata('user_id'));
		foreach($panelarr as $v) {
			echo "<span><a onclick='paneladdclass(this);' target='right' href='".$v['url'].'&menu_id='.$v['menu_id']."'>".lang($v['name'])."</a>  <a class='panel-delete' href='javascript:delete_panel(".$v['menu_id'].");'></a></span>";
		}
		exit;
	}
	
	public function ajax_delete_panel() 
	{
		$menuid = isset($_POST['menuid']) ? $_POST['menuid'] : exit('0');
		$this->admin_model->delete_panel(array('menu_id'=>$menuid, 'user_id'=>$this->session->userdata('user_id')));	
		$panelarr = $this->admin_model->get_panel($this->session->userdata('user_id'));
		foreach($panelarr as $v) {
			echo "<span><a onclick='paneladdclass(this);' target='right' href='".$v['url']."'>".lang($v['name'])."</a> <a class='panel-delete' href='javascript:delete_panel(".$v['menu_id'].");'></a></span>";
		}
		exit;
	}
	
	/**
	 * 锁屏
	 */
	public function lock_screen() 
	{
		$this->session->set_userdata('lock_screen', 1);
	}
	
	/**
	 * 解锁
	 */
	public function login_screenlock()
	{
		if(empty($_GET['lock_password'])) showmessage(L('password_can_not_be_empty'));
		//密码错误剩余重试次数
		$user_name = $this->session->userdata('user_name');
		$maxloginfailedtimes = config_item('max_login_failed_times');
	
		$rtime = $this->admin_model->login_fail_times(array('user_name'=>$user_name,'isadmin'=>1));
		if(isset($rtime['times']) && $rtime['times'] >= $maxloginfailedtimes) 
		{
			$minute = 60-floor((time()-$rtime['login_time'])/60);
			exit('3');
		}
		//查询帐号
		$r = $this->admin_model->get_user_id(array('userid'=>$this->session->userdata('user_id')));
		$password = md5(md5($_GET['lock_password']).$r['encrypt']);
		if($r['password'] != $password)
		{
			$ip = $this->input->ip_address();
			if($rtime && $rtime['times']<$maxloginfailedtimes)
			{
				$times = $maxloginfailedtimes-intval($rtime['times']);
				$this->admin_model->update_login_fail_times(array('ip'=>$ip,'isadmin'=>1,'times'=>$rtime['times']+1),array('user_name'=>$user_name));
			} 
			else 
			{
				$this->admin_model->insert_login_fail_times(array('user_name'=>$user_name,'ip'=>$ip,'isadmin'=>1,'login_time'=>time(),'times'=>1));
				$times = $maxloginfailedtimes;
			}
			exit('2|'.$times);//密码错误
		}
		$this->admin_model->delete_login_fail_times(array('user_name'=>$user_name));
		$this->session->set_userdata('lock_screen', 0);
		exit('1');
	}
	
	//后台站点地图
	public function site_map() 
	{
		$array = $this->admin_model->admin_menu(0);
		$menu = array();
		foreach ($array as $k=>$v) 
		{
			$menu[$v['id']] = $v;
			$menu[$v['id']]['childmenus'] = $this->admin_model->admin_menu($v['id']);
			foreach ($menu[$v['id']]['childmenus'] as $c)
			{
			    $menu[$v['id']]['children'][$c['id']] = $this->admin_model->admin_menu($c['id']);
			}
			
		}
		$data['menu'] = $menu;
		$data['show_header'] = FALSE;
		$this->load->view('map_tpl', $data);
	}
	
	


}

/* End of file Index.php */
/* Location: ./application/controllers/admin/Index.php */
