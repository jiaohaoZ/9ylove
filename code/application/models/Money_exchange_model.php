<?php

/**
 * 会员Model
 */
class Money_exchange_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'money_exchange';
    }

    // 收积分记录 $type $config['money_exchange_type']
    public function money_exchange_log($login_id, $user_id, $cast_id, $type, $money_num)
    {
        $bonus_log = array(
            'login_id' => $login_id,
            'user_id' => $user_id,
            'cast_id' => $cast_id,
            'type' => $type,
            'money_num' => $money_num,
            'add_time' => time(),
        );
        $this->add_one($bonus_log);
    }

    // 收积分记录列表
    public function moneyExchangeLogList($page = 1, $size = 10)
    {
        $limit = ($page - 1) * $size;
        $this->config->load('user_log');
        $this->load->model(['user_model', 'user_cast_model']);
        $money_exchange_type = $this->config->item('money_exchange_type');
        $data = $this->db->from('money_exchange')->where(['login_id' => $_SESSION['user_id']])->limit($size, $limit)->get()->result_array();
        foreach ($data as $key => $value) {
            $data[$key]['type_name'] = $money_exchange_type[$value['type']];
            $data[$key]['add_time'] = date('Y-m-d', $value['add_time']);
            if($value['user_id']) {
                $user_name = $this->user_model->get_one(['user_id'=>$value['user_id']]);
                $data[$key]['user_name'] = $user_name['user_name'];
            }
            if($value['cast_id']) {
                $cast_name = $this->user_cast_model->get_one(['cast_id'=>$value['cast_id']]);
                $data[$key]['user_name'] = $cast_name['cast_name'];
            }

        }

        $tmp['lists'] = $data;
        return $tmp;
    }
}