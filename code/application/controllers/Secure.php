<?php

/**
 * 登录注册
 */
class Secure extends Base_Controller
{
    private $view_path = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->language('login_register', 'zh_cn');
        $this->view_path = $this->agent->is_mobile() ? 'mobile/' : '';
    }

    public function login()
    {
        if ($this->input->post()) {
            $user = $this->input->post('user');
            $password = $this->input->post('password');
            $redirect	= $this->input->post('redirect');

            $userData = $this->db
                ->from('user')
                ->where(['user_name' => $user])
                ->or_where(['mobile' => $user])
                ->get()->first_row('array');

            if (!$userData) {
                show_msg(lang('user_error'));
            }

            if ($userData['password'] != md5(md5($password) . $userData['salt'])) {
                show_msg(lang('pwd_error'));
            }
            if ($userData['state'] == 1) {
                show_msg(lang('user_lock'));
            }

            $this->auth->login($user, $password);

            redirect(site_url($redirect));
        } else {
            $data['redirect'] = $this->input->get('redirect');
            $this->load->view($this->view_path . 'login_tpl', $data);
        }
    }


    public function register($parent_id = 0)
    {
        if ($this->input->post()) {
            $data = $this->input->post('info');

            //是否接受协议
            if (!$data['protocol']) {
                show_msg(lang('not_protocol'));
            }

            if (preg_match("/[-:：]+/", $data['user_name'])){
                show_msg(lang('has_special_sign'));
            }

            //是否是手机号码
            if (!is_mobile($data['mobile'])) {
                show_msg(lang('not_mobile'));
            }

            //密码长度
            if (!is_password($data['password'])) {
                show_msg(lang('password_too_short'));
            }

            //两次密码不相同
            if ($data['password'] !== $data['confirmPassword']) {
                show_msg(lang('not_confirm_password'));
            }

            $one = $this->user_model->get_one(['user_name' => $data['user_name']]);

            //用户名已经存在
            if ($one) {
                show_msg(lang('user_isset'));
            }

            //手机已经被注册
            if ($data['mobile'] == $one['mobile']) {
                show_msg(lang('mobile_isset'));
            }

//            if(!$this->user_model->get_one(['user_id' => $data['parent_id']])) {
//                show_msg('推荐人不存在');
//            }

            // 手机验证码
            if(config_item('captcha_register')) {
                if (!$data['capthca_sms']) {
                    show_msg(lang('empty_capthca_sms'));
                } elseif (!isset($_SESSION['sms_code']) OR $data['capthca_sms'] != $_SESSION['sms_code']) {
                    show_msg(lang('not_capthca_sms'));
                } elseif (!isset($_SESSION['sms_phone']) OR $_SESSION['sms_phone'] != $data['mobile']) {
                    show_msg(lang('match_capthca_sms'));
                }
            }

            $this->user_model->register($data);

            show_msg(lang('register_success'), site_url('secure/login'));

        } else {
            $data['parent_id'] = $parent_id;
            if ($parent_id != 0) {
                $user = $this->user_model->get_one(['user_id' => $parent_id]);
                $data['user_name'] = $user['user_name'];
            }
            $this->load->view($this->view_path . 'register_tpl', $data);
        }
    }

    //忘记密码
    public function forgetPassword()
    {
        if ($this->input->post()) {
            $mobile = $this->input->post('mobile');
            $capthca_sms = $this->input->post('capthca_sms');
            $password = $this->input->post('password');
            $confirmPassword = $this->input->post('confirmPassword');

            //验证账户
            $user = $this->user_model->get_one(['mobile' => $mobile]);
            if (!$user) {
                show_msg(lang('user_error'));
            }

            $_SESSION['user_confirm'] = $mobile;

            if ($_SESSION['user_confirm']) {
                if (isset($_SESSION['sms_code']) && isset($_SESSION['sms_phone'])) {
                    if ($_SESSION['sms_code'] == $capthca_sms && $_SESSION['sms_phone'] == $mobile) {
                        //验证成功，重置密码
                        if ($password !== $confirmPassword) {
                            show_msg(lang('not_confirm_password'));
                        }

                        $password = md5(md5($password) . $user['salt']);

                        if ($this->user_model->edit_one(array('password' => $password), array('mobile' => $_SESSION['user_confirm']))) {
                            show_msg(lang('reset_password_success'), site_url('secure/login'), 1000);
                        }
                    } else {
                        //验证码错误
                        show_msg(lang('error_capthca_sms'), site_url('secure/forgetPassword'), 1000);
                    }
                } else {
                    //点击验证码重新获取
                    show_msg(lang('click_capthca_sms'), site_url('secure/forgetPassword'), 1000);
                }
            }

        } else {
            $this->load->view($this->view_path . 'forget_password_tpl');
        }
    }

    //判断用户名是否存在
    public function issetUserName()
    {
        if ($this->input->post()) {
            $user_name = $this->input->post('user_name');
            $return = $this->user_model->get_one(['user_name' => $user_name]);
            //存在
            if ($return) {
                $result['status'] = 1;
            } else {
                $result['status'] = 0;
            }
            echo json_encode($result);
            exit;
        }
    }

    //判断手机号码是否存在
    public function issetMobile()
    {
        if ($this->input->post()) {
            $return = $this->user_model->get_one(['mobile' => $this->input->post('mobile')]);
            //存在
            if ($return) {
                $result['status'] = 1;
            } else {
                $result['status'] = 0;
            }
            echo json_encode($result);
            exit;
        }
    }

    //退出登录
    public function logout()
    {
        session_destroy();
        show_msg(lang('logout'), site_url());
    }


}