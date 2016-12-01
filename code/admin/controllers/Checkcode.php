<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkcode extends MY_Controller
{
	public  function __construct()
	{
		parent::__construct();
	}
	
	public function getcode()
	{
        $this->load->library('captcha');
		if (isset($_GET['code_len']) && intval($_GET['code_len'])) $this->captcha->code_len = intval($_GET['code_len']);
		if ($this->captcha->code_len > 8 || $this->captcha->code_len < 2) 
		{
			$this->captcha->code_len = 4;
		}
		if (isset($_GET['font_size']) && intval($_GET['font_size'])) $this->captcha->font_size = intval($_GET['font_size']);
		if (isset($_GET['width']) && intval($_GET['width'])) $this->captcha->width = intval($_GET['width']);
		if ($this->captcha->width <= 0) 
		{
			$this->captcha->width = 130;
		}
		
		if (isset($_GET['height']) && intval($_GET['height'])) $this->captcha->height = intval($_GET['height']);
		if ($this->captcha->height <= 0)
		{
			$this->captcha->height = 50;
		}
		$max_width = $this->captcha->code_len * 28;
		$max_height = $this->captcha->font_size * 2;
		if($this->captcha->width > $max_width) $this->captcha->width = $max_width;
		if($this->captcha->height > $max_height) $this->captcha->height = $max_height;
		
		if (isset($_GET['font_color']) && trim(urldecode($_GET['font_color'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['font_color'])))) $this->captcha->font_color = trim(urldecode($_GET['font_color']));
		if (isset($_GET['background']) && trim(urldecode($_GET['background'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['background'])))) $this->captcha->background = trim(urldecode($_GET['background']));
		$this->captcha->doimage();
		$this->session->set_userdata('captcha', $this->captcha->get_code());
	}
}

