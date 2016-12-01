<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 发送短信
 */

class Sendsms extends MY_Controller {
    
    protected $_sms_config = array();
    public function __construct()
    {
        parent::__construct();
		parent::admin_init();
		$this->_sms_config = config_item('sms_config');
        $this->load->library('sms', $this->_sms_config);
    }
    
    public function send_code()
    {
        $mobile = $this->input->get_post('mobile');
		$code = mt_rand(100000, 999999);
		$data = array($code, '5');
		$_SESSION['sms_code'] = $code;
		$_SESSION['sms_phone'] = $mobile;
		
		$this->sms->send($mobile, $data, $this->_sms_config['codeTplId']);
    }
    
    public function send_msg()
    {
        $user_name = $this->input->get_post('user_name');
        $data = array();
        $this->sms->send($user_name, $data, $this->_sms_config['msgTplId']);
    }
    
    
}