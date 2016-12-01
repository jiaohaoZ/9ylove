<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 银行卡Model
 */
class User_card_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user_card';
    }
}