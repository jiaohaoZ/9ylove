<?php

/**
 * 活动
 */
class Find extends Front_Controller 
{   

    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        $this->view('find_tpl');
    }

}