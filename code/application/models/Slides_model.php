<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Slides_model extends  MY_Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'slides';
    }
    
    public function get_slides()
    {
        return $this->db->select('name, image, url')
                                    ->from('slides')
                                    ->order_by('sort_order DESC')
                                    ->limit(5)
                                    ->get()->result_array();
    }
    
    
}