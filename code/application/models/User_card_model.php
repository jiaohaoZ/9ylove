<?php

/**
 * 会员Model
 */
class User_card_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'user_card';
    }

    // 获取银行卡号
    public function getUserCard()
    {
        return $this->db
            ->from('user_card as u')
            ->join('bank as b', 'u.bank_id = b.bank_id', 'left')
            ->where(['user_id' => $_SESSION['user_id']])
            ->get()->result_array();
    }
}