<?php   
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 参数设置
 */
class Setting extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        parent::admin_init();
        $this->load->model(array('setting_model'));
    }
    
    public function init()
    {
        $data = array();
        $tmp = $this->setting_model->get_all();
		
        foreach ($tmp as $row)
        {        	
            $data[$row['setting_key']] = $row['setting'];
        }
		$data['sms_config'] = json_decode($data['sms_config'], TRUE);
		$user_cast_config = json_decode($data['user_cast_config'],TRUE);
		$data['market_bonus'] = $user_cast_config['market_bonus'];
		$data['buy_one_cast'] = $user_cast_config['buy_one_cast'];
		$account_bonus_config = json_decode($data['account_bonus_config'],TRUE);
		$data['recommend_bonus'] = $account_bonus_config['recommend_bonus'];
		$data['market_bonus'] = $account_bonus_config['market_bonus'];
		$data['system_bonus'] = $account_bonus_config['system_bonus'];
		$data['all_bonus'] = $account_bonus_config['all_bonus'];
		$data['bonus_max'] = $account_bonus_config['bonus_max'];
        $this->load->view('setting_tpl.php', $data);
    }
    
    public function save()
    {
    	$setting = $this->input->post('setting');
		
		$data = array();
		$data['theme'] = $setting['theme'];
		
		$data['max_login_failed_times'] = $setting['max_login_failed_times'];
		$data['page_size'] = $setting['page_size'];
		$data['upload_max_size'] = $setting['upload_max_size'];
		$data['captcha_register'] = $setting['captcha_register'];
		$data['mobile_region'] = $setting['mobile_region'];
		
		$data['login_game'] = $setting['login_game'];
 	
		$data['login_game_api'] = $setting['login_game_api'];
		$data['login_game_key'] = $setting['login_game_key'];
		$data['send_message'] = $setting['send_message'];
			
		$data['sms_config'] = array(
								'accountSid' => $setting['accountSid'],
								'accountToken' => $setting['accountToken'],
								'appId' => $setting['appId'],
								'serverIP' => $setting['serverIP'],
								'serverPort' => $setting['serverPort'],
								'softVersion' => $setting['softVersion'],
								'codeTplId' => $setting['codeTplId'],
								'msgTplId' => $setting['msgTplId']
							);
		$data['sms_config'] = json_encode($data['sms_config']);

		$data['user_cast_config'] = array(
								'market_bonus' => $setting['market_bonus1'],
								'buy_one_cast' => $setting['buy_one_cast'],
			);
		$data['user_cast_config'] = json_encode($data['user_cast_config']);

		$data['register_create_num'] = $setting['register_create_num'];

		$data['account_bonus_config'] = array(
								'recommend_bonus' => $setting['recommend_bonus'],
								'market_bonus' => $setting['market_bonus2'],
								'system_bonus' => $setting['system_bonus'],
								'all_bonus' => $setting['all_bonus'],
								'bonus_max' => $setting['bonus_max']
			);

		$data['account_bonus_config'] = json_encode($data['account_bonus_config']);
		
		$data['sdk_url'] = $setting['sdk_url'];

		$data['active_money'] = $setting['active_money'];
		
		//代理账号
		
		if($this->setting_model->edit_config($data))
		{
			$this->admin_log(13, $_SESSION['user_name'].'修改了基本设置');
			show_message(lang('operation_success'), site_url('c=setting&m=init'));
		}
		else
		{
			show_message(lang('operation_failure'), site_url('c=setting&m=init'));
		}
    }
    
    
}



/* End of file setting.php */
/* Location: ./application/controllers/setting.php */