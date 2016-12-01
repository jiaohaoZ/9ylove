<?php

/**
 * 活动
 */
class Article extends Front_Controller 
{   

    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
    }


    public function index()
    {   
        $data = $this->article_model->article_list();
        $this->view('article_tpl',$data);
    }

    public function article_detail()
    {
        $where['art_id'] = $this->input->get('art_id');
        $clicks = $this->article_model->get_one($where,'clicks');
        $res['clicks'] = $clicks['clicks'] + 1;
        $this->article_model->edit_one($res,$where);
        $data = $this->article_model->get_one($where);
        $this->view('article_detail_tpl',$data);
    }


    public function article_ajax()
    {
       $page = $this->input->post('pnum');
       $data = $this->article_model->article_list($page,5);
       if(!empty($data['lists'])){
            $res = json_encode($data);
            print_r($res);
       }else{
            $qaz = array('sign'=>'none');
            $qaz1 = json_encode($qaz);
            print_r($qaz1);
       }
       
    }

}