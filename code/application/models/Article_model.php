<?php
/**
 * 会员Model
 */
class Article_model extends MY_Model {

    public function __construct()
    {
        $this->_table = 'article';
    }

    public function article_list($page=1,$size=5)
    {	
        $offset = ($page - 1)*$size;
    	$where = array();
    	$where['status'] = 1;
        $arr = $this->db->from('article')->select('*')->order_by('sort_order DESC, modify_time DESC')->limit($size,$offset)->where($where)->get()->result_array();
        foreach ($arr as $k => $v) {
        	preg_match_all('/&lt;img.*\/&gt;/iUs', $v['content'], $out);
        	if(!empty($out[0])){
        		$img = $out[0][0];
                $img = html_entity_decode($img, ENT_QUOTES, 'UTF-8');
                $arr[$k]['img'] = $img;
        	}else{
        		$arr[$k]['img'] = 0;
        	}
        	unset($arr[$k]['content']);
        	$arr[$k]['year'] = date('Y',$arr[$k]['modify_time']);
        	$arr[$k]['month'] = date('m',$arr[$k]['modify_time']);
        	$arr[$k]['day'] = date('d',$arr[$k]['modify_time']);
        }
        
        $data['lists'] = $arr;

        // echo '<pre>';
        // print_r($arr);

        return $data;

    }


}
