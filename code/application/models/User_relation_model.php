<?php
/**
 * 会员关系model
 */
class User_relation_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user_relation';
    }

    /**
     * 设置会员排网关系
     * @param int $parent_id
     * @param int $user_id
     * @return void
     */
    public function set_user_relation($parent_id = 0, $user_id)
    {
        $result = $this->get_all(array('user_id' => $parent_id));
        $data = array();
        foreach ($result as $row)
        {
            $data[] = array('user_id' => $user_id, 'parent_id' => $row['parent_id']);
        }
        $data[] = array('user_id' => $user_id, 'parent_id' => $parent_id);

        $tmp = array_chunk($data, 5000);
        foreach ($tmp as $arr)
        {
            $this->add_batch($arr);
        }
    }

}