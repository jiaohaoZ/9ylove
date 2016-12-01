<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *用户模块
 */
class User_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user';
    }

    public function set_company_account($user_name)
    {
        $row = $this->get_one(['user_name' => $user_name]);
        $user_reg_moneys = config_item('user_reg_moneys');
        if($row['user_spend'] < $user_reg_moneys[4]) {
            $this->db->set('user_spend', $user_reg_moneys[4]);
        }
        $this->db->set('user_rank', 4);
        $this->db->set('is_pay', 1);
        $this->db->where('user_name', $user_name);
        $this->db->update('users');
    }

    // 会员列表
    public function user_list($where, $page, $size, $extend)
    {
        $limit = ($page - 1) * $size;
        if (isset($extend['where_in'])) {
            foreach ($extend['where_in'] as $k => $v) {
                $this->db->where_in($k, $v);
            }
        }

        $where['is_main'] = 1;
        $data = $this->db
            ->from('user')
            ->where($where)
            ->get()->result_array();

        foreach ($data as $key => $value) {
            if($value['status'] == 1) {
                $data[$key]['status'] = '未激活';
            } else if ($value['status'] == 2) {
                $data[$key]['status'] = '已激活';
            }
        }
        $tmp['count'] = count($data);
        $tmp['lists'] = array_slice($data, $limit, $size);

        return $tmp;
    }

    // 查看副账号
    public function view_child($user_id)
    {
        $data = $this->db
            ->from('user')
            ->where(['main_id'=>$user_id])
            ->get()->result_array();
        foreach ($data as $key => $value) {
            if($value['status'] == 2) {
                $data[$key]['status'] = '已激活';
            } else {
                $data[$key]['status'] = '未激活';
            }
        }
        return $data;
    }


    public function user_log($start_time,$end_time,$page, $size, $log_type, $user_id)
    {
        $data = array();
        $page = ($page - 1)*$size;
        $this->db->select('a.log_id,a.log_type,a.before_money,a.after_money,a.log_info,a.log_time,b.user_id,b.user_name');

        if($start_time){
            $this->db->where('a.log_time >= ',strtotime($start_time.'00:00:00'));
        }

        if($end_time){
            $this->db->where('a.log_time <= ',strtotime($end_time.'23:59:59'));
        }

        if($log_type){
            $this->db->where('a.log_type', $log_type);
        }

        if($user_id){
            $this->db->where('b.user_id',$user_id);
        }

        $this->db->from('user_log AS a');
        $this->db->join('user AS b','a.user_id = b.user_id');
        $data['list'] = $this->db->limit($size,$page)->order_by('log_id DESC')->get()->result_array();

        if($log_type)
        {
            $this->db->where('log_type', $log_type);
        }
        if($user_id)
        {
            $this->db->where('user_log.user_id', $user_id);
        }

        if($start_time)
        {   
            $this->db->where('log_time >= ', strtotime($start_time.'00:00:00'));
        }

        if($end_time)
        {
            $this->db->where('log_time <= ',strtotime($end_time.'23:59:59'));
        }

        $data['count'] = $this->db->count_all_results('user_log');
        
        return $data;


    }   
}