<?php

/**
 * 首页Model
 */
class User_cast_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'user_cast';
    }

    //获取倍投账号
    public function getCast($page = 1, $size = 5)
    {
        $limit = ($page - 1) * $size;
        return $this->db->from('user_cast')->where(['user_id' => $_SESSION['user_id']])->limit($size, $limit)->get()->result_array();
    }

}