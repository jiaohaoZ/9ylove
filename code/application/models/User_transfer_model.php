<?php

/**
 * 转账
 */
class User_transfer_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'user_transfer';
    }

    // 交易记录
    public function transfer_record($page = 1 , $size = 10)
    {
        $limit = ($page - 1) * $size;
        $data['lists'] = $this->db
            ->from('user_transfer')
            ->where(['user_id' => $_SESSION['user_id']])
            ->limit($size, $limit)
            ->get()->result_array();
        foreach ($data['lists'] as $key => $value) {
            $data['lists'][$key]['add_time'] = date('Y-m-d', $value['add_time']);
        }
        return $data;
    }
}