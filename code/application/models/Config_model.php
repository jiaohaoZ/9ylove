<?php
/**
 * 配置模块
 */
class Config_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'config';
    }

    public function get_settings()
    {
        $result = $this->db->get($this->_table);
        $return = [];
        foreach ($result->result() as $row)
        {
            if($row->is_json)
            {
                $row->setting = json_decode($row->setting, TRUE);
            }

            $return[$row->setting_key] = $row->setting;
        }

        return $return;
    }


}