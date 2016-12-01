<?php
/**
 * 代理商model.
 */
class User_agent_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user_agent';
    }

    public function getAllAgent()
    {
        return $this->db->from('user_agent')->where(['user_id <>' => $_SESSION['user_id']])->get()->result_array();
    }
}