<?php

/**
 * 积分兑换处理
 */
class Money extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->language('money', 'zh_cn');
    }

    // 爱心积分兑换向日葵积分
    public function exchangeUserMoney()
    {
        $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'gold_money, user_money, pay_password, pay_salt');
        if ($this->input->post()) {
            $pay_password = $this->input->post('pay_password');
            $num = $this->input->post('num');
            //判断支付密码是否正确
            if ($data['pay_password'] != md5(md5($pay_password) . $data['pay_salt'])) {
                $result['status'] = 1; //密码错误
                echo json_encode($result);
                exit;
            }

            // 判断余额 > 兑换
            if ($data['gold_money'] < $num) {
                $result['status'] = 4; //超出期望值
                echo json_encode($result);
                exit;
            }

            // 开始兑换
            $this->db->trans_begin();

            // 扣除爱心积分、添加向日葵积分
            $this->db
                ->where(['user_id' => $_SESSION['user_id']])
                ->set('gold_money', 'gold_money - ' . $num, false)
                ->set('user_money', 'user_money + ' . $num, false)
                ->update('user');

            $this->load->model('user_log_model');
            // 扣除爱心积分日志
            $this->user_log_model->user_log($_SESSION['user_id'], 5, 1, $data['gold_money'], ($data['gold_money'] - $num), '[兑换向日葵积分]扣' . $num . '个爱心积分');
            // 添加向日葵积分日志
            $this->user_log_model->user_log($_SESSION['user_id'], 5, 2, $data['user_money'], ($data['user_money'] + $num), '[爱心积分兑换向日葵积分]增加' . $num . '个向日葵积分');

            if ($this->db->trans_status() === FALSE) {
                $result['status'] = 0; //购买失败
                $this->db->trans_rollback();
            } else {
                $result['status'] = 2; //购买成功
                $this->db->trans_commit();
            }
            echo json_encode($result);
            exit;

        } else {
            $this->view('exchange_user_money', $data);
        }
    }

    // 兑换购物积分
    public function exchangeShopMoney()
    {
        $data = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'gold_money, shop_money, pay_password, pay_salt');
        if ($this->input->post()) {
            $pay_password = $this->input->post('pay_password');
            $num = $this->input->post('num');
            //判断支付密码是否正确
            if ($data['pay_password'] != md5(md5($pay_password) . $data['pay_salt'])) {
                $result['status'] = 1; //密码错误
                echo json_encode($result);
                exit;
            }

            // 判断余额 > 兑换
            if ($data['gold_money'] < $num) {
                $result['status'] = 4; //超出期望值
                echo json_encode($result);
                exit;
            }

            // 开始兑换
            $this->db->trans_begin();

            // 扣除爱心积分、添加向日葵积分
            $this->db
                ->where(['user_id' => $_SESSION['user_id']])
                ->set('gold_money', 'gold_money - ' . $num, false)
                ->set('shop_money', 'shop_money + ' . $num, false)
                ->update('user');

            $this->load->model('user_log_model');
            // 扣除爱心积分日志
            $this->user_log_model->user_log($_SESSION['user_id'], 5, 1, $data['gold_money'], ($data['gold_money'] - $num), '[兑换购物积分]扣' . $num . '个爱心积分');
            // 添加向日葵积分日志
            $this->user_log_model->user_log($_SESSION['user_id'], 5, 3, $data['shop_money'], ($data['shop_money'] + $num), '[爱心积分兑换购物积分]增加' . $num . '个购物积分');

            if ($this->db->trans_status() === FALSE) {
                $result['status'] = 0; //购买失败
                $this->db->trans_rollback();
            } else {
                $result['status'] = 2; //购买成功
                $this->db->trans_commit();
            }
            echo json_encode($result);
            exit;

        } else {
            $this->view('exchange_shop_money', $data);
        }
    }

    // 向日葵账户收积分助手
    public function moneyExchange()
    {
        $this->load->model('user_log_model');
        $this->load->model('money_exchange_model');
        $type = $this->input->get('type');

        $data = $this->db
            ->select('user_id, user_money, gold_money, shop_money, recommend_bonus, market_bonus, status')
            ->from('user')
            ->where(['main_id' => $_SESSION['user_id']])
            ->or_where(['user_id' => $_SESSION['user_id']])
            ->order_by('user_id asc')
            ->get()->result_array();

        $this->db->trans_begin();

        foreach ($data as $key => $value) {
            $main = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_id, user_money, gold_money, shop_money, recommend_bonus, market_bonus, status');

            // 1、推荐奖 + 市场奖 = 爱心积分
            if ($type == 1) {
                $recommend_and_market = $value['recommend_bonus'] + $value['market_bonus'];

                if ($recommend_and_market >= config_item('exchange_gold_min')) {
                    // 账号扣除
                    $this->db
                        ->where(['user_id' => $value['user_id']])
                        ->set('recommend_bonus', '0', false)
                        ->set('market_bonus', '0', false)
                        ->update('user');

                    // 登录账号添加
                    $this->db
                        ->where(['user_id' => $_SESSION['user_id']])
                        ->set('gold_money', 'gold_money + ' . $recommend_and_market, false)
                        ->update('user');

                    // money日志
                    $this->user_log_model->user_log($_SESSION['user_id'], 6, 1, $main['gold_money'], ($main['gold_money'] + $recommend_and_market), '收推荐奖 + 市场奖为爱心积分');
                    // 收积分记录
                    $this->money_exchange_model->money_exchange_log($_SESSION['user_id'], $value['user_id'], 0, 1, $recommend_and_market);
                }
            }

            // 2、推荐奖 = 向日葵积分
            if ($type == 2) {
                if ($value['recommend_bonus'] > 0) {
                    // 账号扣除
                    $this->db
                        ->where(['user_id' => $value['user_id']])
                        ->set('recommend_bonus', '0', false)
                        ->update('user');

                    // 登录账号添加
                    $this->db
                        ->where(['user_id' => $_SESSION['user_id']])
                        ->set('user_money', 'user_money + ' . $value['recommend_bonus'], false)
                        ->update('user');

                    // 日志
                    $this->user_log_model->user_log($_SESSION['user_id'], 6, 2, $main['user_money'], ($main['user_money'] + $value['recommend_bonus']), '收推荐奖为向日葵积分');
                    // 收积分记录
                    $this->money_exchange_model->money_exchange_log($_SESSION['user_id'], $value['user_id'],0, 2, $value['recommend_bonus']);
                }
            }

            // 3、市场奖 = 向日葵积分
            if ($type == 3) {
                if ($value['market_bonus'] >= 1) {
                    // 账号扣除
                    $this->db
                        ->where(['user_id' => $value['user_id']])
                        ->set('market_bonus', 'market_bonus - ' . (int)$value['market_bonus'], false)
                        ->update('user');

                    // 登录账号添加
                    $this->db
                        ->where(['user_id' => $_SESSION['user_id']])
                        ->set('user_money', 'user_money + ' . (int)$value['market_bonus'], false)
                        ->update('user');

                    // 日志
                    $this->user_log_model->user_log($_SESSION['user_id'], 6, 2, $main['user_money'], ($main['user_money'] + (int)$value['market_bonus']), '收市场奖为向日葵积分');
                    // 收积分记录
                    $this->money_exchange_model->money_exchange_log($_SESSION['user_id'], $value['user_id'], 0, 3, (int)$value['market_bonus']);
                }
            }


            // 4、市场奖 = 购物积分
            if ($type == 4) {
                if ($value['market_bonus'] >= 1) {
                    // 账号扣除
                    $this->db
                        ->where(['user_id' => $value['user_id']])
                        ->set('market_bonus', 'market_bonus - ' . (int)$value['market_bonus'], false)
                        ->update('user');

                    // 登录账号添加
                    $this->db
                        ->where(['user_id' => $_SESSION['user_id']])
                        ->set('shop_money', 'shop_money + ' . (int)$value['market_bonus'], false)
                        ->update('user');

                    // 日志
                    $this->user_log_model->user_log($_SESSION['user_id'], 6, 3, $main['shop_money'], ($main['shop_money'] + (int)$value['market_bonus']), '收市场奖为购物积分');
                    // 收积分记录
                    $this->money_exchange_model->money_exchange_log($_SESSION['user_id'], $value['user_id'], 0, 4, (int)$value['market_bonus']);
                }
            }

        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_msg(lang('money_exchange_failed'));
        } else {
            $this->db->trans_commit();
            show_msg(lang('money_exchange_success'));
        }
    }

    // 倍投账户收积分助手
    public function castMoneyExchange()
    {
        $this->load->model(['user_log_model', 'money_exchange_model', 'user_cast_model']);
        $type = $this->input->get('type');

        //倍投账户
        $data = $this->db
            ->select('cast_id, market_bonus')
            ->from('user_cast')
            ->where(['user_id' => $_SESSION['user_id'], 'status' => 0])
            ->get()->result_array();

        $this->db->trans_begin();

        if ($data) {
            foreach ($data as $key => $value) {
                if ($value['market_bonus'] > 1) {
                    // 5、市场奖 = 爱心积分
                    if ($type == 5) {
                        $this->castExchange($value, 'gold_money', '爱心积分');
                    }

                    // 6、市场奖 = 向日葵积分
                    if ($type == 6) {
                        $this->castExchange($value, 'user_money', '向日葵积分');
                    }

                    // 7、市场奖 = 购物积分
                    if ($type == 7) {
                        $this->castExchange($value, 'shop_money', '购物积分');
                    }

                }

            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_msg(lang('money_exchange_failed'));
        } else {
            $this->db->trans_commit();
            show_msg(lang('money_exchange_success'));
        }
    }

    // 倍投收积分兑换
    public function castExchange($cast = [], $money_string, $money_text)
    {
        //登录账户
        $main = $this->user_model->get_one(['user_id' => $_SESSION['user_id']], 'user_id, user_money, gold_money, shop_money');

        // 账号扣除
        $this->db
            ->where(['cast_id' => $cast['cast_id']])
            ->set('market_bonus', 'market_bonus - ' . (int)$cast['market_bonus'], false)
            ->update('user_cast');

        // 登录账号添加
        $this->db
            ->where(['user_id' => $_SESSION['user_id']])
            ->set($money_string, "$money_string + " . (int)$cast['market_bonus'], false)
            ->update('user');

        // 日志
        $this->user_log_model->user_log($_SESSION['user_id'], 6, 1, $main[$money_string], ($main[$money_string] + (int)$cast['market_bonus']), '倍投收市场奖为'.$money_text);
        // 收积分记录
        $this->money_exchange_model->money_exchange_log($_SESSION['user_id'], 0, $cast['cast_id'], 5, (int)$cast['market_bonus']);
    }

    // 收积分记录列表
    public function moneyExchangeLogList()
    {
        $this->load->model('money_exchange_model');
        $data = $this->money_exchange_model->moneyExchangeLogList();
        $this->view('money_exchange_log_list', $data);
    }

    // 收积分记录滚动加载
    public function moneyExchangeLoad()
    {
        $page = $this->input->post('page');
        $this->load->model('money_exchange_model');
        $data = $this->money_exchange_model->moneyExchangeLogList($page, 10);
        if (!empty($data['lists'])) {
            $data['status'] = 1;
            echo json_encode($data);
            exit;
        } else {
            $data = [
                'lists' => [],
                'status' => 0,
            ];
            echo json_encode($data);exit;
        }
    }


}