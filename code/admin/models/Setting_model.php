<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *设置模块
 */
class Setting_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'config';		
	}
	
	public function edit_config($data)
	{
		$flag = TRUE;
		foreach ($data as $k=>$v)
    	{
			if(!$this->db->update('config', array('setting'=>$v), array('setting_key'=>$k)))
			{
				$flag = FALSE;
			}
    	}
		return $flag;
	}
   	
}



/* End of file setting_model.php */
/* Location: ./application/models/setting_model.php */