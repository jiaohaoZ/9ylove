<?php

/**
 * 首页Model
 */
class Bonus_model extends MY_Model
{

    public function __construct()
    {
        $this->_table = 'bonus';
    }

    /**
     * 奖金记录
     */
    final public function bonus_log($user_id, $bonus_type, $bonus_money , $bonus_desc)
    {
        $bonus_log = array(
            'bonus_type' => $bonus_type,
            'bonus_money'   => $bonus_money,
            'user_id'  => $user_id,
            'bonus_time' => time(),
            'bonus_desc' => $bonus_desc,
        );
        $this->add_one($bonus_log);
    }

    //奖金记录列表
    public function bonusRecord($user_id, $is_drop_load = 0, $page = 1, $size = 20)
    {
        $data = $this->db->from('bonus')->where(['user_id'=>$user_id])->get()->result_array();
    }

    //当天推荐奖
    public function get_today_recommend_bonus()
    {
        $this->load->model("user_model");
        $result = $this->user_model->get_all(['main_id' => $_SESSION['user_id']], 'user_id');
        $user_ids = [];
        foreach ($result as $row)
        {
            $user_ids[] = $row['user_id'];
        }
        $user_ids = array_merge($user_ids, [$_SESSION['user_id']]);
        $today = strtotime(date('Y-m-d'));
        $result = $this->db->select_sum('bonus_money')
            ->from($this->_table)
            ->where_in('user_id', $user_ids)
            ->where('bonus_time >=', $today)
            ->where('bonus_type', 1)
            ->get()->row_array();
        return intval($result['bonus_money']);
    }
}