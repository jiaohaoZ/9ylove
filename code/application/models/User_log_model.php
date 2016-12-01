<?php

/**
 * 首页Model
 */
class User_log_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'user_log';
    }

    /**
     * money记录
     * @param $user_id int 用户id
     * @param $log_type tinyint 日志类型
     * @param $money_type tinyint money类型
     * @param $before_money decimal 变化前（金额）
     * @param $after_money decimal 变化后（金额）
     * @param $log_info string 备注
     */
    final public function user_log($user_id, $log_type, $money_type, $before_money , $after_money, $log_info)
    {
        $user_log = array(
            'user_id'  => $user_id,
            'log_type' => $log_type,
            'money_type' => $money_type,
            'before_money'   => $before_money,
            'after_money'   => $after_money,
            'log_time' => time(),
            'log_info' => $log_info,
        );
        $this->add_one($user_log);
    }


}