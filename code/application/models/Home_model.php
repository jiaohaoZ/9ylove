<?php

/**
 * 首页Model
 */
class Home_model extends MY_Model
{

    public function __construct()
    {

    }

    //首页幻灯片
    public function getSlides()
    {
        return $this->db->select('name, image, url')
            ->from('slides')
            ->order_by('sort_order DESC')
            ->limit(5)
            ->get()->result_array();
    }
}