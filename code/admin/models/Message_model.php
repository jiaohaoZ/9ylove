<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *公告模块
 */
class Message_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'notice';		
	}

	/**
	 * 友情链接列表
	 */
   	public function links_list($page, $size)
	{
		$data = array();
		$data['lists'] = $this->db->select('*')
								 ->from('ci_link')
								 ->order_by('sort_order', 'desc')
								 ->limit($size, $page)
								 ->get()->result_array();
		$data['count'] = $this->db->count_all_results('ci_link');
		return $data;
	}
	
	/**
	 * 批量排序
	 */
	public function sort_order($listorder, $id, $table)
	{
		foreach($listorder as $key=>$val)
		{
			$this->db->where($id, $key);
			$this->db->update($table, array('sort_order' => $val));
		}
	}
	
	/**
	 * 
	 */
	public function new_delete($table, $data, $id)
	{
		$this->db->where_in($id, $data);
		$this->db->delete($table);
	}
	
	/**
	 * 
	 */
	public function new_get_one($table, $where = array(), $select = '*',  $type = 'array')
	{
		if(empty($table) OR empty($where))
			return FALSE;
		return $this->db->select($select)->from($table)->where($where)->get()->first_row($type);
	}
	
	/**
	 * 
	 */
	public function new_edit_one($table, $data = array(), $where = array())
	{
		if(empty($table) OR empty($data) OR empty($where))
			return FALSE;
		return $this->db->update($table, $data, $where);
	}
	
	/**
	 * 
	 */
	public function new_add_one($table, $data = array())
    {
    	if(empty($table) OR empty($data))
    		return FALSE;
    	return $this->db->insert($table, $data);
    }



	/**
	 * 幻灯片列表
	 */
	public function slide($page, $size)
	{
		$data = array();
		$data['lists'] = $this->db->select('*')
								 ->from('ci_slides')
								 ->order_by('sort_order', 'desc')
								 ->limit($size, $page)
								 ->get()->result_array();
		$data['count'] = $this->db->count_all_results('ci_slides');
		return $data;
	}

	/**
	 * 银行列表
	 */
	public function bank($page,$size)
	{
		$data = array();
		$lists = $this->db->select('*')
								 ->from('ci_bank')
								 ->order_by('bank_id', 'desc')
								 ->limit($size, $page)
								 ->get()->result_array();

		foreach ($lists as $k => $v) {
			if($v['status'] == 1){
				$lists[$k]['status'] = lang('yes');
			}else{
				$lists[$k]['status'] = lang('no');
			}
		}
		
		$data['lists'] = $lists;


		$data['count'] = $this->db->count_all_results('ci_bank');
		return $data;

	}

	/**
	 * 活动列表
	 */
	public function article($page, $size, $start_time, $end_time, $title)
	{
		$data = array();
		$page = $size*($page-1);
		$this->db->select('art_id,title,content,modify_time,status,sort_order');
		if($start_time){
			$this->db->where('add_time >= ',strtotime($start_time.'00:00:00'));
		}
		if($end_time){
			$this->db->where('add_time <= ',strtotime($end_time.'23:59:59'));
		}
		if($title){
			$this->db->like('title',$title);
		}

		$data['lists'] = $this->db->from('article')->order_by('sort_order DESC, modify_time DESC')->limit($size,$page)->get()->result_array();

		if($start_time){
	        $this->db->where('add_time >= ', $start_time);
		}
	    if($end_time){
	        $this->db->where('add_time <= ', $end_time);
	    }
	    if($title){
	        $this->db->like('title', $title);
	    }

	    $data['count'] = $this->db->count_all_results('article');

	    return $data;

	}


}