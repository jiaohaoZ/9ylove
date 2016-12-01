<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *代理模块
 */
class User_agent_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user_agent';
    }


}