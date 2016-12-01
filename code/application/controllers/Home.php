<?php

/**
 * 首页
 */
class Home extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
        $this->load->model('user_model');
        $this->load->language('account', 'zh_cn');
    }

    //首页
    public function index()
    {
        $data['slides'] = $this->home_model->getSlides();
        $data['today_market_bonus'] = mt_rand('4700', '5000') / 10000;
        $yesterday = date('Y-m-d', time() - 86400);
        $this->load->model('market_bonus_log_model');
        $log = $this->market_bonus_log_model->get_one(['log_date' => $yesterday]);
        $data['yesterday_market_bonus'] = $log ? $log['market_bonus'] : 0;
        $this->load->model('bonus_model');
        $data['today_recommend_bonus'] = $this->bonus_model->get_today_recommend_bonus();
        $this->view('home_tpl', $data);
    }

    //充值页面
    public function recharge()
    {
        $this->view('recharge_tpl');
    }

    //邀请好友
    public function inviteFriends()
    {
        $this->view('invite_friends_tpl');
    }

    //邀请好友二维码
    public function inviteFriendsQRCode()
    {
        //主账号的最后一个副账号
        $user = $this->db->from('user')->where(['main_id' => $_SESSION['user_id']])->order_by('user_id desc')->get()->first_row('array');
        //文件夹不存在自动创建
        $dir_path = FCPATH . 'data/qrcode/';
        if (!is_dir($dir_path)) {
            mkdir($dir_path, 0777);
        }
        //二维码路径
        $filename = $dir_path . $user['user_id'] . '.png';

        $this->load->library('qrcodes');
        if (!file_exists($filename)) {
            $text = site_url('secure/register/' . $user['user_id']);
            $logo = FALSE;
            $outfile = $filename;
            $this->qrcodes->qrpng($text, $outfile, $level = 'L', $size = 8, $margin = 0, $logo, $filename);
        }

        $data['user_name'] = $user['user_name'];
        $data['qrcode'] = base_url('data/qrcode/' . $user['user_id'] . '.png');
        $this->view('invite_friends_qrcode', $data);
    }

    // 邀请好友记录
    public function inviteFriendsRecord()
    {
        $data['list'] = $this->user_model->inviteFriendsRecord();

        $this->view('invite_friends_record', $data);
    }

    // 账户
    public function account()
    {
        //向日葵账户
        $data = $this->user_model->getAccount();
        
        //倍投账户
        $this->load->model('user_cast_model');
        $data['castList'] = $this->user_cast_model->getCast();

        // 获取未收数量
        $data['no'] = $this->user_model->getNoExchange();

        $this->view('account_tpl', $data);
    }

    // 向日葵账号滚动加载
    public function account_load()
    {
        $page = $this->input->post('page');
        $data = $this->user_model->getAccount($page, 5);
        if (!empty($data['lists'])) {
            echo json_encode($data);exit;
        } else {
            $data = [
                'lists' => [],
                'status' => 0,
            ];
            echo json_encode($data);exit;
        }
    }

    // 倍投账号滚动加载
    public function cast_load()
    {
        $page = $this->input->post('page');
        $this->load->model('user_cast_model');
        $data = $this->user_cast_model->getCast($page, 5);
        if (!empty($data)) {
            $tmp['castList'] = $data;
            echo json_encode($tmp);exit;
        } else {
            $data = [
                'castList' => [],
                'status' => 0,
            ];
            echo json_encode($data);exit;
        }
    }

    //点击激活按钮，进入激活页面
    public function clickActivations()
    {
        $user_id = $this->input->get('user_id');
        $data = $this->user_model->get_one(['user_id' => $user_id], 'user_id, user_name, recommend_bonus, market_bonus, gold_money, user_money,
        market_bonus_total');

        //登录账号的支付密码
        $result = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'pay_password');
        $data['pay_password'] = !empty($result['pay_password']) ? 1 : 0;
        $this->view('account_activation_tpl', $data);
    }

    // 激活支付页面
    public function accountActivationPay()
    {
        $user_id = $this->input->get('user_id');
        if($this->input->post()) {
            $pay_password = $this->input->post('pay_password');
            // 判断支付密码是否正确
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_id, pay_password, pay_salt');
            if ($data['pay_password'] != md5(md5($pay_password) . $data['pay_salt'])) {
                show_msg(lang('pwd_error'));
            }
            // 激活账户
            $this->user_model->accountActivation($this->input->post('user_id'));
            // 账户激活成功提示
            show_msg(lang('activation_success'), site_url('home/account'));
        } else {
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_id, user_money');
            $this->view('account_activation_pay', $data);
        }
    }

    // ajax判断余额是否不足
    public function isMoneyEnough()
    {
        if ($this->input->post()) {
            $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_money');
            // 余额 < 扣除的数量
            if ($data['user_money'] < config_item('active_money')) {
                $result['status'] = 1;
            } else {
                $result['status'] = 0;
            }
            echo json_encode($result);
            exit;
        }
    }

    //设置支付密码
    public function setPayPassword()
    {
        if ($this->input->post()) {
            $password = $this->input->post('password');
            $confirmPassword = $this->input->post('confirmPassword');
            //密码长度
            if (!is_password($password)) {
                show_msg(lang('password_too_short'));
            }

            //两次密码不相同
            if ($password !== $confirmPassword) {
                show_msg(lang('not_confirm_password'));
            }

            $password = password($password);

            //更新支付密码
            $this->user_model->edit_one(['pay_password' => $password['password'], 'pay_salt' => $password['salt']], ['user_id' => $_SESSION['user_id']]);

            show_msg(lang('pay_password_success'),site_url('home/clickActivations?user_id=').$this->input->post('user_id'));
        } else {
            $this->view('account_set_pay_password');
        }
    }

    //奖金记录
    public function bonusRecord($user_id)
    {
        $this->load->model('bonus_model');
        $this->bonus_model->bonusRecord($user_id);
        $this->view('bonus_record');
    }
}