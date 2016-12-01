<?php
/**
 * 每日市场奖model
 */
class Market_bonus_log_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'market_bonus_log';
    }

}