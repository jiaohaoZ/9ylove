<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *用户模块
 */
class User_withdrawals_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user_withdrawals';
    }

    // 提现列表
    public function get_list($where = [], $page = 1, $size = 20, $extend = [])
    {
        $limit = ($page - 1) * $size;
        if (isset($extend['where_in'])) {
            foreach ($extend['where_in'] as $k => $v) {
                $this->db->where_in($k, $v);
            }
        }

        $data = $this->db
            ->select('w.*, u.mobile')
            ->from('user_withdrawals as w')
            ->join('user as u', 'w.user_id = u.user_id', 'left')
            ->where($where)
            ->get()->result_array();

        foreach ($data as $key => $value) {
            switch ($value['status']) {
                case 0:
                    $data[$key]['status_text'] = '未审核';
                    break;
                case 1:
                    $data[$key]['status_text'] = '已审核';
                    break;
                case 2:
                    $data[$key]['status_text'] = '拒绝';
                    break;
            }
        }

        $count = count($data);
        $tmp['list'] = array_slice($data, $limit ,$size);
        $tmp['count'] = $count;
        return $tmp;
    }

}