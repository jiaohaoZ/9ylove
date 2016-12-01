<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 公告管理
 */

Class Message extends MY_Controller{

	public function __construct()
    {
        parent::__construct();
        parent::admin_init();
        $this->load->model(array('message_model'));
        $this->load->language(array('message'), 'zh_cn');
    }


   /**
	 * 文件上传
	 */
	public function do_upload($url)
    {
            $config['upload_path']          = $url;
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 1624*1024;

			
            $this->load->library('upload', $config);
			
            if ( ! $this->upload->do_upload('userfile'))
            {
				show_message($this->upload->display_errors(), $_SERVER['HTTP_REFERER']);
            }
    }
	
	/**
	 * 幻灯片
	 */
	public function slide()
	{
		$page = intval($this->input->get('page'));
        $size   = $this->input->get('size') ? intval($this->input->get('size')) : config_item('page_size');
		
		$data = $this->message_model->slide($page, $size);
		
		$cfg['total_rows'] = $data['count'];
        $cfg['per_page']  = $size;
        $data['pages'] = $this->pages($cfg);
		$this->load->view('slide_tpl', $data);
	}

	/**
	 * 添加幻灯片
	 */
	public function slide_add()
	{
		$data = array();
		if($this->input->post() && !empty($_FILES))
		{
				$_FILES['userfile']['name'] = time().".".substr(strrchr($_FILES['userfile']['name'], '.'), 1);
				$filename = $_FILES['userfile']['name'];
				$path = FCPATH.'/data/upload/slide/';
				if(!file_exists($path)){
					mkdir($path);
				}
				$this->do_upload('./data/upload/slide');
				$rs = $this->input->post('slide');
				$data = array(
					'name' => $rs['name'],
					'image' => '',
					'url' => $rs['url'],
					'sort_order' => $rs['sort_order']
				);
				if($this->message_model->new_add_one('ci_slides', $data))
				{
					$user_id = $this->db->insert_id();
					$data = array('image' => 'data/upload/slide/'.$user_id.'.'.substr(strrchr($filename, '.'), 1));
					$this->message_model->new_edit_one('slides', $data, array('id' => $user_id));
					rename($path.$_FILES['userfile']['name'], $path.$user_id.'.'.substr(strrchr($filename, '.'), 1));
					
					$this->admin_log(10, $_SESSION['user_name'].'添加了一条的幻灯片');
					show_message(lang('operation_success'), '?c=message&m=slide');
				}
		}
		else
		{
			$this->load->view('slide_add_tpl');
		}
	}

	/**
	 * 修改幻灯片
	 */
	public function slide_edit()
	{
		if($this->input->post() && $_FILES['userfile']['error'] == 0)
		{
			$_FILES['userfile']['name'] = time().".".substr(strrchr($_FILES['userfile']['name'], '.'), 1);
			$filename = $_FILES['userfile']['name'];
			$path = FCPATH.'/data/upload/slide/';
			$this->do_upload('./data/upload/slide');
			rename($path.$_FILES['userfile']['name'], $path.$this->input->get('slideid').'.'.substr(strrchr($filename, '.'), 1));
			$rs = $this->input->post('slide');
			$where = array('id' => $this->input->get('slideid'));
			
			$data = array(
				'name' => $rs['name'],
				'image' => 'data/upload/slide/'.$this->input->get('slideid').'.'.substr(strrchr($filename, '.'), 1),
				'url' => $rs['url'],
				'sort_order' => $rs['sort_order']
			);
			if($this->message_model->new_edit_one('ci_slides', $data, $where))
			{
				$this->admin_log(10, $_SESSION['user_name'].'修改了ID为'.$this->input->get('slideid').'的幻灯片');
				show_message(lang('operation_success'), '', '', 'edit');
			}
		}
		else if($this->input->post())
		{
			$data = $this->input->post('slide');
			$where = array('id' => $this->input->get('slideid'));
			
			$update = array(
				'name' => $data['name'],
				'url' => $data['url'],
				'sort_order' => $data['sort_order'] ? $data['sort_order'] : 0
			);
			if($this->message_model->new_edit_one('ci_slides', $update, $where))
			{
				$this->admin_log(10, $_SESSION['user_name'].'修改了ID为'.$this->input->get('slideid').'的幻灯片');
				show_message(lang('operation_success'), '', '', 'edit');
			}
		}
		else
		{
			$data = $this->message_model->new_get_one('ci_slides', array('id' => $this->input->get('slideid')));
			$this->load->view('slide_edit_tpl', $data);
		}
	}

	/**
	 * 删除幻灯片
	 */
	public function slide_delete()
	{
		$this->message_model->new_delete('ci_slides', $this->input->get_post('slideid'), 'id');
		if(is_array($this->input->get_post('slideid')))
		{
			$slideid = implode(',', $this->input->get_post('slideid'));
			$slideid = trim($slideid, ',');
		}
		else
		{
			$slideid = $this->input->get_post('slideid');
		}
		
		$this->admin_log(10, $_SESSION['user_name'].'删除了ID为'.$slideid.'的幻灯片');
		show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * 幻灯片排序
	 */
	public function slide_sort_order()
	{
		$this->message_model->sort_order($this->input->post('slideorders'), 'id', 'ci_slides');
		show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 银行管理
	 */
	public function bank()
	{
		$page = intval($this->input->get('page'));
        $size   = $this->input->get('size') ? intval($this->input->get('size')) : config_item('page_size');
		
		$data = $this->message_model->bank($page, $size);
		
		$cfg['total_rows'] = $data['count'];
        $cfg['per_page']  = $size;
        $data['pages'] = $this->pages($cfg);
		$this->load->view('bank_tpl', $data);
	}

	/**
	 * 银行添加
	 */
	public function bank_add()
	{	
		if($this->input->post() && !empty($_FILES))
		{
				$_FILES['userfile']['name'] = time().".".substr(strrchr($_FILES['userfile']['name'], '.'), 1);
				$filename = $_FILES['userfile']['name'];
				$path = FCPATH.'/data/upload/bank_icon/';
				if(!file_exists($path)){
					mkdir($path);
				}
				$this->do_upload('./data/upload/bank_icon');
				$rs = $this->input->post();
				$data = array(
					'bank_name' => $rs['bank_name'],
					'status' => $rs['bank_status']
				);
				if($this->message_model->new_add_one('ci_bank', $data))
				{
					$user_id = $this->db->insert_id();
					$data = array('bank_image' => 'data/upload/bank_icon/'.$user_id.'.'.substr(strrchr($filename, '.'), 1));
					$this->message_model->new_edit_one('bank', $data, array('bank_id' => $user_id));
					rename($path.$_FILES['userfile']['name'], $path.$user_id.'.'.substr(strrchr($filename, '.'), 1));
					
					$this->admin_log(10, $_SESSION['user_name'].'添加了一个的银行');
					show_message(lang('operation_success'), '?c=message&m=bank');
				}
		}else{
			$this->load->view('bank_add_tpl');
		}
	}

	/**
	 * 银行修改
	 */
	public function bank_edit()
	{	
		if($this->input->post() && $_FILES['userfile']['error'] == 0)
		{
			$_FILES['userfile']['name'] = time().".".substr(strrchr($_FILES['userfile']['name'], '.'), 1);
			$filename = $_FILES['userfile']['name'];
			$path = FCPATH.'/data/upload/bank_icon/';
			$this->do_upload('./data/upload/bank_icon');
			rename($path.$_FILES['userfile']['name'], $path.$this->input->get('bank_id').'.'.substr(strrchr($filename, '.'), 1));
			$rs = $this->input->post();
			$where = array('bank_id' => $this->input->get('bank_id'));
			
			$data = array(
				'bank_name' => $rs['bank_name'],
				'bank_image' => 'data/upload/bank_icon/'.$this->input->get('bank_id').'.'.substr(strrchr($filename, '.'), 1),
				'status' => $rs['bank_status']
			);
			if($this->message_model->new_edit_one('ci_bank', $data, $where))
			{
				$this->admin_log(10, $_SESSION['user_name'].'修改了ID为'.$this->input->get('bank_id').'的银行');
				show_message(lang('operation_success'), '', '', 'edit');
			}
		}
		else if($this->input->post())
		{
			$data = $this->input->post();
			$where = array('bank_id' => $this->input->get('bank_id'));
			
			$update = array(
				'bank_name' => $data['bank_name'],
				'status' => $data['bank_status'] 
			);
			if($this->message_model->new_edit_one('ci_bank', $update, $where))
			{
				$this->admin_log(10, $_SESSION['user_name'].'修改了ID为'.$this->input->get('bank_id').'的银行');
				show_message(lang('operation_success'), '', '', 'edit');
			}
		}
		// if($this->input->post())
		// {
		// 	$where = array('bank_id' => $this->input->get('bank_id'));
		// 	$bank_name = $this->input->post('bank_name');
		// 	$bank_status = $this->input->post('bank_status');
		// 	$up_data = array(
		// 			'bank_name' => $bank_name,
		// 			'status' => $bank_status,
		// 		);
	
		// 	if($this->message_model->new_edit_one('ci_bank',$up_data, $where))
		// 	{
		// 		$this->admin_log(10, $_SESSION['user_name'].'修改了ID为'.$this->input->get('bank_id').'的银行');
		// 		show_message(lang('operation_success'), '', '', 'edit');
		// 	}
		// }
		else
		{	
			$data = $this->message_model->new_get_one('ci_bank', array('bank_id' => $this->input->get('bank_id')));
			
			$this->load->view('bank_edit_tpl', $data);
		}
	}


	/**
	 * 删除银行
	 */
	public function bank_delete()
	{
		$this->message_model->new_delete('ci_bank', $this->input->get_post('bank_id'), 'bank_id');
		$bank_id = $this->input->get_post('bank_id');
		$this->admin_log(10, $_SESSION['user_name'].'删除了ID为'.$bank_id.'的银行');
		show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
	}


	/**
	 * 活动管理
	 */
	public function article()
	{
        $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
        $size   = $this->input->get('size') ? intval($this->input->get('size')) : config_item('page_size');
        $start_time = $this->input->get('start_time');
        $end_time = $this->input->get('end_time');
        $title = $this->input->get('title');
        $data = $this->message_model->article($page, $size, $start_time, $end_time, $title);
        $cfg['total_rows'] = $data['count'];
        $cfg['per_page']  = $size;
        $data['pages'] = $this->pages($cfg);
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        $data['article_status'] = lang('article_status');
        $this->load->view('article_list_tpl', $data);

	}

	/**
	 * 添加活动
	 */
	public function article_add()
	{
		$data = array();
        if($this->input->post())
        {	
            $data['title'] = $this->input->post('title');
            $data['content'] = htmlspecialchars($this->input->post('content'));
            $data['status'] = $this->input->post('status');
            $data['add_time'] = time();
            $data['modify_time'] = time();
           	$this->message_model->new_add_one('ci_article', $data);
			$this->admin_log(8, $_SESSION['user_name'].'添加了标题为'.$data['title'].'的活动');
            show_message(lang('operation_success'), site_url('c=message&m=article'));            
        }
        else
        {
            $data['article_status'] = lang('article_status');
            $this->load->view('article_add_tpl', $data);
        }
	}

	/**
	 * 修改活动
	 */
	public function article_edit()
	{	
		$data = array();
		if($this->input->post())
		{	
			$where = array('art_id' => $this->input->post('art_id'));
			$title = $this->input->post('title');
			$content = htmlspecialchars($this->input->post('content'));
			$status = $this->input->post('status');
			$time = time();
			$up_data = array(
					'title' => $title,
					'content' => $content,
					'status' => $status,
					'modify_time' => $time,
				);
			if($this->message_model->new_edit_one('ci_article',$up_data, $where))
			{
				$this->admin_log(8, $_SESSION['user_name'].'修改了ID为'.$where['art_id'].'的活动');
				show_message(lang('operation_success'), site_url('c=message&m=article&menuid=27')); 
			}
		}else{
			$data = $this->message_model->new_get_one('ci_article', array('art_id' => $this->input->get('art_id')));
			$data['article_status'] = lang('article_status');
		
			$this->load->view('article_edit_tpl',$data);
		}
	}

	/**
	 * 删除活动
	 */
	public function article_del()
	{
		$this->message_model->new_delete('ci_article', $this->input->get_post('art_id'), 'art_id');
		$art_id = $this->input->get_post('art_id');
		$this->admin_log(10, $_SESSION['user_name'].'删除了ID为'.$art_id.'的活动');
		show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 活动排序
	 */
	public function article_sort()
	{

		$ids = $this->input->post('ids');
		$listorders = $this->input->post('listorders');
		
		foreach($ids as $v)
		{
			$this->message_model->new_edit_one('ci_article',array('sort_order' => $listorders[$v]), array('art_id' => $v));
		}
		show_message(lang('operation_success'), $_SERVER['HTTP_REFERER']);
	}

}