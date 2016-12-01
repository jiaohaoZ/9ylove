<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * base controller
 */

class Base_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $mthd = $this->router->method;
        if($mthd == 'view' || $mthd == 'partial' || $mthd == 'set_template')
        {
            show_404();
        }

        $this->load->database();

        $this->load->model('config_model');
        $settings = $this->config_model->get_settings();
        foreach ($settings as $key => $setting)
        {
            $this->config->set_item($key, $setting);
        }

        $this->load->library(array('session', 'auth'));
        $this->load->helper(array('func', 'url', 'language'));
        $this->load->language('system', 'zh_cn');

        //系统维护
        $shop_notice = config_item('shop_notice');
        if($shop_notice['status'])
        {
            shop_notice();
        }

    }
}


class Front_Controller extends Base_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->auth->is_logged_in(uri_string());
    }

    public function view($view, $vars = array(), $string=false)
    {
        $view_path = $this->agent->is_mobile() ? 'mobile/' : '';
        if($string)
        {
//            $result	 = $this->load->view($view_path . 'header', page_header(), true);
//            $result	.= $this->load->view($view, $vars, true);
//            $result	.= $this->load->view($view_path . 'footer', $vars, true);
            $result	= $this->load->view($view, $vars, true);
            return $result;
        }
        else
        {
//            $this->load->view($view_path . 'header', page_header());
            $this->load->view($view_path . $view, $vars);
//            $this->load->view($view_path . 'footer', $vars);
        }
    }

    public function partial($view, $vars = array(), $string=false)
    {
        if($string)
        {
            return $this->load->view($view, $vars, true);
        }
        else
        {
            $this->load->view($view, $vars);
        }
    }

    public function pages($config = array())
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url($this->router->fetch_class().'/'.$this->router->fetch_method());
        $config['page_query_string'] = FALSE;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['first_link'] = lang('first');
        $config['last_link'] = lang('last');
        $config['first_tag_open']	= '<li>';
        $config['first_tag_close']	= '</li>';
        $config['last_tag_open']	= '<li>';
        $config['last_tag_close']	= '</li>';

        $config['full_tag_open']	= '<ul class="pagination">';
        $config['full_tag_close']	= '</ul>';
        $config['cur_tag_open']		= '<li class="active"><a href="#">';
        $config['cur_tag_close']	= '</a></li>';

        $config['num_tag_open']		= '<li>';
        $config['num_tag_close']	= '</li>';

        $config['prev_link']		= '&laquo;';
        $config['prev_tag_open']	= '<li>';
        $config['prev_tag_close']	= '</li>';

        $config['next_link']		= '&raquo;';
        $config['next_tag_open']	= '<li>';
        $config['next_tag_close']	= '</li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

}

