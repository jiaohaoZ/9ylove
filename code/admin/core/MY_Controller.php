<?php   
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * MY_Controller
 */
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->language(array('admin', 'menu', 'system','admin_log'), 'zh_cn');
		$this->load->model(array('admin_log_model'));
	}
	
	public function admin_init()
	{
		self::check_admin();		
		self::check_priv();
		self::load_config();
	}
	
	/**
	 * 判断用户是否已经登陆
	 */
	final public  function check_admin() 
	{
		if($this->router->fetch_class() =='index' && in_array($this->router->fetch_method(), array('login', 'logout')) ) 
		{
			return true;
		} 
		else 
		{
			if(empty($_SESSION['user_id']))
				show_message(lang('admin_login'), site_url('c=index&m=login'));
		}
	}
	
	/**
	 * 权限判断
	 */
	final public function check_priv()
	{
// 		if($this->router->fetch_class() == 'index' && in_array($this->router->fetch_method(), array('index', 'login')) && $this->router->fetch_directory() == 'admin/')
// 		{
// 			return true;
// 		}
		if($this->router->fetch_class() == 'index' )
		{
		    return true;
		}
		if($_SESSION['role_id'] == 1) return true;
		if(preg_match('/^public_/',$this->router->fetch_method())) return true;
		$CI = & get_instance();
        $CI->load->model('role_priv_model');
        $action = $this->input->get('a');
		$r =$CI->role_priv_model->get_one(array('m'=>$this->router->fetch_method(),'c'=>$this->router->fetch_class(),'a'=>$action,
				'role_id'=>$_SESSION['role_id']));
		if(!$r && $this->input->get_post('is_ajax') == 1) return true;
		if(!$r) show_message(lang('no_priv'),'blank');
	}
	
	/**
	 * 获取菜单 头部菜单导航
	 *
	 * @param $parentid 菜单id
	 */
	final public static function submenu($parentid = '') 
	{
		$CI = & get_instance();
		$CI->load->model(array('admin_model'));
		if(empty($parentid)) 
		{
			$r = $CI->admin_model->get_menu_one(array('m'=>$CI->router->fetch_method(),'c'=>$CI->router->fetch_class()));
			$parentid = $_GET['menuid'] = $r['id'];
		}
		$array = $CI->admin_model->admin_menu($parentid);
		$string = '';
		foreach($array as $_value)
		{
			$classname = $CI->router->fetch_method() == $_value['m'] && $CI->router->fetch_class() == $_value['c'] ? 'class="on"' : '';
			if($_value['parent_id'] == 0 || $_value['m']=='') continue;
			if($classname) 
			{
				$string .= "<a href='javascript:;' $classname><em>".lang($_value['name'])."</em></a><span>|</span>";
			} 
			else 
			{
				$string .= "<a href='".site_url('c='.$_value['c'].'&m='.$_value['m']."&menuid=$parentid")."' $classname><em>".lang($_value['name'])."</em></a><span>|</span>";
			}
		}
		$string = substr($string,0,-14);
		return $string;
	}
	
	/**
	 * @param $config 分页配置数组
	 */
	public function pages($cfg = array())
	{
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('c='.$this->router->fetch_class().'&m='.$this->router->fetch_method());
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['first_link'] = lang('first');
		$config['last_link'] = lang('last');
		$config['next_link'] = lang('next');
		$config['prev_link'] = lang('previous');
		$config['num_links'] = 4;
		$config['cur_tag_open'] = '&nbsp;<span>';
		$config['cur_tag_close'] = '</span>';
		$config['num_tag_open'] = '&nbsp;';
		$config['next_tag_open'] = '&nbsp;';
		$config['next_tag_close'] = '&nbsp;';
		$config['prev_tag_open'] = '&nbsp;';
		$config['full_tag_open'] = '<div><span><em>总条数: </em>' . $cfg['total_rows'] . '</span>';
		$config['full_tag_close'] = '</div>';
		$config = array_merge($config, $cfg);
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	/**
	 * 发送邮件
	 * @param email string OR array
	 * @param subject 标题
	 * @param message 内容
	 * @param cc 抄送
	 * @param attach 附件
	 */
	
	public function send_mail($email, $subject, $message, $cc = '', $attach = array())
	{
	    $this->load->library('email');
	    $config = array(
	        'protocol' => 'smtp',
	        'smtp_host' => config_item('sys_smtp_host'),
	        'smtp_user' => config_item('sys_smtp_user'),
	        'smtp_pass' => config_item('sys_smtp_pass'),
	        'crlf' => "\r\n",
	        'newline' => "\r\n"
	    );
	    $this->email->initialize($config);
	    $this->email->clear();
	    $this->email->from(config_item('sys_smtp_user'));
	    $this->email->to($email);
	    $this->email->subject($subject);
	    $this->email->message($message);
	    $this->email->cc($cc);
	    foreach ($attach as $att)
	    {
	        $this->email->attach($att);
	    }
	    $this->email->send();
	}
	
	
	/**
	 * 载入后台管理配置信息
	 * @access public
	 * @return void
	 */
	final public function load_config()
	{
	    if(get_cache('system_config') == FALSE)
	    {
	        $result = $this->db->get('config')->result_array('array');
	        $arr = array();
	        foreach ($result as $val)
	        {
	            if($val['is_json']) 
	            {
	                $val['setting'] = json_decode($val['setting'], TRUE);
	            }
	            $arr[$val['setting_key']] = $val['setting'];
	        }
	        
	        //set_cache('system_config', $arr, 86400);
	
	    }
	    foreach ($arr as $key => $val)
	    {
	        $this->config->set_item($key, $val);
	    }
	    	     
	}
	
	/**
	 * 日志记录
	 */
	final public function admin_log($log_type, $log_info)
	{
	 	$admin_log = array(
			'log_type' => $log_type,
			'log_info' => $log_info,
			'log_time' => time(),
			'log_ip'   => $this->input->ip_address(),
			'user_id'  => $_SESSION['user_id']
		);
		$this->admin_log_model->add_one($admin_log);
	}
	
}


/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
