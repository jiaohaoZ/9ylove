<?php 
/**
 * 用户 
 */
Class User extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->language('my', 'zh_cn');
	}

	public function index()
	{	
		$where['user_id'] = $_SESSION['user_id'];
		$data = $this->user_model->get_one($where);
		$this->view('my_tpl',$data);
	}

	public function user_info()
	{	
		$where['user_id'] = $_SESSION['user_id'];
		$data = $this->user_model->get_one($where);
		$arr = $this->user_model->get_parent_id($where);
		if($arr){
			$data['parent_name'] = $arr;
		}
		$this->view('my_user_info_tpl',$data);
	}

	public function user_icon()
	{
		if($this->input->post()){
			$img_info = $this->input->post('img_info');
			$base64_body = substr(strstr($img_info,','),1);
			$data= base64_decode($base64_body);
			$save_path = FCPATH.'data/upload/user_icon';
			if(!file_exists($save_path)){
				mkdir($save_path);
			}
			$ext = rand(10000,99999).time().'.jpg';
			$file_name = $save_path.'/'.$ext;
			$where['user_id'] = $_SESSION['user_id'];
			$map['portrait'] = 'data/upload/user_icon/'.$ext;
			$this->user_model->edit_one($map,$where);
			$arr = file_put_contents($file_name,$data);
			if($arr){
				show_msg(lang('success'),site_url('user/user_info'));
			}
		}else{
			$this->view('my_user_icon_tpl');

		}
	}


	public function user_info_type()
	{	
		if($this->input->post()){
			$where['user_id'] = $_SESSION['user_id'];
			$type = $this->input->post('type');
			$value = $this->input->post('val');
			$data[$type] = $value;
			if($this->user_model->edit_one($data,$where)){
				show_msg(lang('success'),site_url('user/user_info'));
			}
			
		}else{
			$type = $this->input->get('type');
			$arr = array('nick_name','gender','qq','wechat');
			$where['user_id'] = $_SESSION['user_id'];
			if(!in_array($type,$arr)){
				$type = 'info';
				$this->view('my_user_'.$type.'_tpl');
			}else{
				$data = $this->user_model->get_one($where,$type);
				$this->view('my_user_'.$type.'_tpl',$data);
			}
			
		}
	}

	public function user_settings()
	{	
		$where['user_id'] = $_SESSION['user_id'];
		$data = $this->user_model->get_one($where);
		$this->view('my_settings_tpl',$data);
	}

	public function user_mobile()
	{
		if($this->input->post()){

		}else{
			$where['user_id'] = $_SESSION['user_id'];
			$data = $this->user_model->get_one($where,'mobile');
			$this->view('my_mobile_tpl',$data);
		}
	}

	public function user_email()
	{
		$where['user_id'] = $_SESSION['user_id'];
		$data = $this->user_model->get_one($where,'email');
		$this->view('my_email_tpl',$data);
		
	}


	/**
	 * 更换电话详情页
	 */
	public function user_mobile_oper()
	{	
		if($this->input->post()){
			$data = $this->input->post();
			if (!$data['phone_yzm']) {
                show_msg(lang('empty_capthca_sms'));
            } elseif (!isset($_SESSION['sms_code']) OR $data['phone_yzm'] != $_SESSION['sms_code']) {
                show_msg(lang('not_capthca_sms'));
            } elseif (!isset($_SESSION['sms_phone']) OR $_SESSION['sms_phone'] != $data['phone_num']) {
                show_msg(lang('match_capthca_sms'));
            }else{
            	$map['mobile'] = $data['phone_num'];
            	$where['user_id'] = $_SESSION['user_id'];
				$this->user_model->edit_one($map,$where);
				show_msg(lang('success'),site_url('secure/logout'));
            }
		}else{
			$this->view('my_mobile_oper_tpl');
		}
	}


	/**
	 * 更换邮件详情页
	 */
	public function user_email_oper()
	{	
		if($this->input->post()){
			$data = $this->input->post();
			if($_SESSION['mail_yzm'] != $data['email_yzm']){
				show_msg(lang('mail_yzm_error'));
			}elseif(empty($data['email_yzm'])){
				show_msg(lang('mail_yzm_empty'));
			}else{
				$map['email'] = $data['email_num'];
				$where['user_id'] = $_SESSION['user_id'];
				$this->user_model->edit_one($map,$where);
				show_msg(lang('success'),site_url('user/user_settings'));
			}
		}else{
			$this->view('my_email_oper_tpl');
		}
	}


	/**
	 * 邮件ajax
	 * @return [type] [description]
	 */
	public function email()
	{
		$to = $this->input->post('emailInfo');

		$this->load->library('Mailer');

		$code = mt_rand(100000, 999999);
		$_SESSION['mail_yzm'] = $code;
		$_SESSION['mail_num'] = $to;   
		$mailer = new Mailer();          
		$mailer->From = '690805319@qq.com';//邮件发送者          
		$mailer->FromName = '向日葵网络';//邮件发送者姓名          
		$mailer->Address =  $to;//邮件接受者          
		$mailer->AddresName = '19爱心用户';//邮件接受者姓名          
		$mailer->Subject = '修改绑定邮箱验证码';//邮件标题         
		$mailer->isHtml = TRUE;//是否以html形式发送  
		$mailer->Body =  '<html><body><div style="margin-top:30px;margin-left:30px;">尊敬的19用户,你的修改绑定邮箱的验证码是：'.$code.'。</div></body></html>';//邮件内容          
		$info  = $mailer->send();         
		if($info['statu']){   
			echo 'ok';         
		}else{
			echo $info['msg'];     
		}
		
	}


	/**
	 * /登陆密码
	 */
	public function normal_pwd()
	{
		if($this->input->post()){
			$input = $this->input->post();
			$where['user_id'] = $_SESSION['user_id'];
			$data = $this->user_model->get_one($where,'password,salt');
			$old_pwd = $input['old_pwd'];
			$new_pwd = $input['new_pwd'];
			$new_re_pwd = $input['new_re_pwd'];
			$new_len = strlen($new_pwd);
			$new_re_len = strlen($new_re_pwd);
			if(empty($old_pwd)){
				show_msg(lang('old_empty'));
			}
			if(empty($new_pwd)){
				show_msg(lang('new_empty'));
			}
			if($new_pwd != $new_re_pwd){
				show_msg(lang('re_diffent'));
			}
			if($new_len <6){
				show_msg(lang('new_len_small'));
			}
			if($new_len >20){
				show_msg(lang('new_len_big'));
			}
			$old_pwd_s = md5(md5($old_pwd).$data['salt']);
			if($old_pwd_s == $data['password']){
				$map['password'] = md5(md5($new_pwd).$data['salt']);
				if($this->user_model->edit_one($map,$where)){
					show_msg(lang('success_login'),site_url('secure/login'));
				}
			}else{
				show_msg(lang('old_pwd_error'));
			}
		}else{
			$this->view('my_normal_pwd_tpl');
		}
	}


	/**
	 * /支付密码
	 */
	public function pay_password()
	{
		if($this->input->post()){
			$input = $this->input->post();
			$where['user_id'] = $_SESSION['user_id'];
			$data = $this->user_model->get_one($where,'pay_password,pay_salt');
			if(!empty($data['pay_password'])){
				$old_pwd = $input['old_pwd'];
				$old_pwd_s = md5(md5($old_pwd).$data['pay_salt']);
				if(empty($old_pwd)){
					show_msg(lang('old_empty'));				
				}
				if($old_pwd_s != $data['pay_password']){
					show_msg(lang('old_pwd_error'));
				}
			}
			$new_pwd = $input['new_pwd'];
			$new_re_pwd = $input['new_re_pwd'];
			$new_len = strlen($new_pwd);
			$new_re_len = strlen($new_re_pwd);
			if(empty($new_pwd)){
				show_msg(lang('new_empty'));
			}
			if($new_pwd != $new_re_pwd){
				show_msg(lang('re_diffent'));
			}
			if($new_len <6){
				show_msg(lang('new_len_small'));
			}
			if($new_len >20){
				show_msg(lang('new_len_big'));
			}
			$password = password($new_pwd);
			$map['pay_password'] = $password['password'];
			$map['pay_salt'] = $password['salt'];
			if($this->user_model->edit_one($map,$where)){
				show_msg(lang('success'),site_url('user/user_settings'));
			}
		}else{
			$where['user_id'] = $_SESSION['user_id'];
			$data = $this->user_model->get_one($where,'pay_password');
			$this->view('my_pay_pwd_tpl',$data);
		}
	}


	/**
	 * /身份证验证1
	 */
	public function my_realname1()
	{
		if($this->input->post()){
			$data = $this->input->post();
			if(empty($data['real_name'])){
				show_msg(lang('real_name_empty'));
			}elseif (empty($data['real_identity'])) {
				show_msg(lang('real_identity_empty'));
			}else{
				if(!preg_match('/(^\d{15}$)|(^\d{17}([0-9]|X)$)/',$data['real_identity'])){
					show_msg(lang('real_identity_error'));
				}
				$where['user_id'] = $_SESSION['user_id'];
				$map['is_real'] = 1;
				$map['identity_card'] = $data['real_identity'];
				$map['real_name'] = $data['real_name'];
				if($this->user_model->edit_one($map,$where)){
					show_msg(lang('sub_success'),site_url('user/user_settings'));
				}
			}
		}else{
			$this->view('my_account_realname1_tpl');
		}
	}

	/**
	 * /身份证验证2
	 */
	public function my_realname2()
	{
		if($this->input->post()){
			$data = $this->input->post();
			if(empty($data['real_name'])){
				show_msg(lang('real_name_empty'));
			}elseif (empty($data['real_identity'])) {
				show_msg(lang('real_identity_empty'));
			}elseif (empty($data['img1'])){
				show_msg(lang('img1_empty'));
			}elseif (empty($data['img2'])){
				show_msg(lang('img2_empty'));
			}elseif (empty($data['img3'])){
				show_msg(lang('img3_empty'));
			}
			if(!preg_match('/(^\d{15}$)|(^\d{17}([0-9]|X)$)/',$data['real_identity'])){
				show_msg(lang('real_identity_error'));
			}

			$save_path = FCPATH.'data/upload/user_identity';

			if(!file_exists($save_path)){
				mkdir($save_path);
			}
			
			$img1 = $data['img1'];
			$img1_body = substr(strstr($img1,','),1);
			$img2 = $data['img2'];
			$img2_body = substr(strstr($img2,','),1);
			$img3 = $data['img3'];
			$img3_body = substr(strstr($img3,','),1);
			$resi1= base64_decode($img1_body);
			$resi2= base64_decode($img2_body);
			$resi3= base64_decode($img3_body);
			$ext = rand(10000,99999).time();
			$file_name1 = $save_path.'/'.$ext.'1.jpg';
			$file_name2 = $save_path.'/'.$ext.'2.jpg';
			$file_name3 = $save_path.'/'.$ext.'3.jpg';
			$where['user_id'] = $_SESSION['user_id'];
			$map['user_id'] = $_SESSION['user_id'];
			$map['real_img1'] = 'data/upload/user_identity/'.$ext.'1.jpg';
			$map['real_img2'] = 'data/upload/user_identity/'.$ext.'2.jpg';
			$map['real_img3'] = 'data/upload/user_identity/'.$ext.'3.jpg';
			$map2['is_real'] = 1;
			$map2['identity_card'] = $data['real_identity'];
			$map2['real_name'] = $data['real_name'];
			$arr = $this->user_model->edit_one($map2,$where);
			if($arr){
				$res = $this->user_model->real_img_add($map);
				if($res){
					file_put_contents($file_name1,$resi1);
					file_put_contents($file_name2,$resi2);
					file_put_contents($file_name3,$resi3);
					show_msg(lang('sub_success'),site_url('user/user_settings'));
				}
			}else{
				show_msg(lang('sub_error'));
			}	

			$this>view('my_account_realname2_tpl');

		}else{
			$where['a.user_id'] = $_SESSION['user_id'];
			$data = $this->user_model->get_real_img($where);
			$this->view('my_account_realname2_tpl',$data);
		}
	}


	/**
	 * 卡包
	 */
	public function my_card_packge()
	{
		$data = $this->user_model->my_card_packge();
		$this->view('my_card_packge_tpl',$data);
	}


	/**
	 * 银行卡添加
	 * @return [type] [description]
	 */
	public function my_card_packge_add()
	{	
		if($this->input->post()){
			$data = $this->input->post();

			$card_len = strlen($data['card_num']);

			if(empty($data['card_num'])){
				show_msg(lang('cardNum_empty'));
			}
			if($card_len < 20){
				if(!preg_match('/^\d{4}(?:\s\d{4}){3}$/',$data['card_num'])){
					show_msg(lang('cardNum_error'));
				}
			}

			if($card_len > 19){
				if(!preg_match('/^\d{4}(?:\s\d{4}){3}\s\d{3}$/',$data['card_num'])){
					show_msg(lang('cardNum_error'));
				}
			}

			$map['user_id'] = $_SESSION['user_id'];
			$map['card_no'] = strtr($data['card_num'],array(' '=>''));
			$map['bank_id'] = $data['bank_type'];

			$arr = $this->user_model->add_card($map);

			if($arr){
				show_msg(lang('sub_success'),site_url('user/my_card_packge'));
			}else{
				show_msg(lang('sub_error'));
			}
		}else{
			$data = $this->user_model->add_card_info();
			
			$this->view('add_bank_card_tpl',$data);

		}
	}

	/**
	 * 解除绑定银行卡
	 * @return [type] [description]
	 */
	public function del_my_cart()
	{

		$card_id =$this->input->get('card_id');
		$res = $this->user_model->del_my_cart($card_id);
		if($res){
			show_msg(lang('del_card'),site_url('user/my_card_packge'));
		}else{
			show_msg(lang('del_card_error'));
		}
		
	}
}