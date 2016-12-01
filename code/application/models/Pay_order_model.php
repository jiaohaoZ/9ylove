<?php
/**
 * 支付订单model
 */
class Pay_order_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'pay_order';
    }

    // 充值记录
    public function pay_record($page = 1 , $size = 10)
    {
        $limit = ($page - 1) * $size;
        $data['lists'] = $this->db
            ->from('pay_order as p')
            ->join('user_agent as u',  'p.agent_id = u.agent_id', 'left')
            ->where(['p.user_id' => $_SESSION['user_id']])
            ->limit($size, $limit)
            ->get()->result_array();
        foreach ($data['lists'] as $key => $value) {
            $data['lists'][$key]['add_time'] = date('Y-m-d', $value['add_time']);
        }
        return $data;
    }
}