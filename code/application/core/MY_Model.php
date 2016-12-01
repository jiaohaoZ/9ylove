<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * MY_Model
 */
class MY_Model extends CI_Model {

    protected  $_table;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    /**
     * 插入单条数据
     * @param $data 数据表字段对应的数组
     */
    public function add_one($data = array())
    {
        if(empty($this->_table) OR empty($data))
            return FALSE;
        return $this->db->insert($this->_table, $data);
    }

    /**
     * 插入多条数据
     * @param $data 数据表字段对应的数组
     */
    public function add_batch($data = array())
    {
        if(empty($this->_table) OR empty($data))
            return FALSE;
        return $this->db->insert_batch($this->_table, $data);
    }

    /**
     * 修改单条数据
     * @param $data update字段对应的数组
     * @param $where where条件数组
     */
    public function edit_one($data = array(), $where = array())
    {
        if(empty($this->_table) OR empty($data) OR empty($where))
            return FALSE;
        return $this->db->update($this->_table, $data, $where);
    }

    /**
     * 获取单条数据
     * @param $select 查询字段
     * @param $where  where 条件数组
     * @param $type 返回数组类型（array, object）
     */
    public function get_one($where = array(), $select = '*',  $type = 'array')
    {
        if(empty($this->_table) OR empty($where))
            return FALSE;
        return $this->db->select($select)->from($this->_table)->where($where)->get()->first_row($type);
    }

    /**
     * 获取全部数据
     */
    public function get_all($where = array(), $select = '*', $type = 'array')
    {
        return $this->db->select($select)->from($this->_table)->where($where)->get()->result_array($type);
    }
    /**
     * 删除单条数据
     */
    public function del_one($where = array())
    {
        if(empty($where))
            return FALSE;
        return $this->db->delete($this->_table, $where);
    }

}




















/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */