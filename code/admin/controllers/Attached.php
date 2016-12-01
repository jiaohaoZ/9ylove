<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *kindeditor 附件处理
 */

class Attached extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        parent::admin_init();
    }
    
    public function upload()
    {
        $save_path = FCPATH . 'data/upload/attached/';
        $save_url = base_url() . 'data/upload/attached/';
        if( ! is_dir($save_path))
        {
            mkdir($save_path, 0755, TRUE);
        }
        
        $ext_arr = array(
        	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
        	'flash' => array('swf', 'flv'),
        	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
        	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        
        //最大文件大小
        $max_size = config_item('upload_max_size');

        $save_path = realpath($save_path) . '/';

        //PHP上传失败
        if (!empty($_FILES['imgFile']['error'])) 
        {
        	switch($_FILES['imgFile']['error'])
        	{
        		case '1':
        			$error = '超过php.ini允许的大小。';
        			break;
        		case '2':
        			$error = '超过表单允许的大小。';
        			break;
        		case '3':
        			$error = '图片只有部分被上传。';
        			break;
        		case '4':
        			$error = '请选择图片。';
        			break;
        		case '6':
        			$error = '找不到临时目录。';
        			break;
        		case '7':
        			$error = '写文件到硬盘出错。';
        			break;
        		case '8':
        			$error = 'File upload stopped by extension。';
        			break;
        		case '999':
        		default:
        			$error = '未知错误。';
        	}
        	$this->_alert($error);
        }
        
        if (empty($_FILES) === false) 
        {
        	$file_name = $_FILES['imgFile']['name'];
        	$tmp_name = $_FILES['imgFile']['tmp_name'];
        	$file_size = $_FILES['imgFile']['size'];
        	if (!$file_name) 
        	{
        		$this->_alert("请选择文件。");
        	}
        	if (is_dir($save_path) === false) {
        		$this->_alert("上传目录不存在。");
        	}
        	if (is_writable($save_path) === false) 
        	{
        		$this->_alert("上传目录没有写权限。");
        	}
        	if (is_uploaded_file($tmp_name) === false) 
        	{
        		$this->_alert("上传失败。");
        	}
        	if ($file_size > $max_size) 
        	{
        		$this->_alert("上传文件大小超过限制。");
        	}
        	//检查目录名
        	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
        	if (empty($ext_arr[$dir_name])) 
        	{
        		$this->_alert("目录名不正确。");
        	}
        	//获得文件扩展名
        	$temp_arr = explode(".", $file_name);
        	$file_ext = array_pop($temp_arr);
        	$file_ext = trim($file_ext);
        	$file_ext = strtolower($file_ext);
        	//检查扩展名
        	if (in_array($file_ext, $ext_arr[$dir_name]) === false) 
        	{
        		$this->_alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
        	}
        	//创建文件夹
        	if ($dir_name !== '') 
        	{
        		$save_path .= $dir_name . "/";
        		$save_url .= $dir_name . "/";
        		if ( ! file_exists($save_path)) 
        		{
        			mkdir($save_path, 0755, TRUE);
        		}
        	}
        	$save_path .= date("Ym") . "/";
        	$save_url .= date("Ym") . "/";
        	if ( ! file_exists($save_path)) 
        	{
        		mkdir($save_path, 0755, TRUE);
        	}
        	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
        	$file_path = $save_path . $new_file_name;
        	if (move_uploaded_file($tmp_name, $file_path) === false) 
        	{
        		$this->_alert("上传文件失败。");
        	}
        	chmod($file_path, 0644);
        	$file_url = $save_url . $new_file_name;
        
        	header('Content-type: text/html; charset=UTF-8');
        	echo json_encode(array('error' => 0, 'url' => $file_url));
        	exit;
        }
                
    }
    
    private function _alert($msg)
    {
        header('Content-type: text/html; charset=UTF-8');
        echo json_encode(array('error' => 1, 'message' => $msg));
        exit;
    }
    
    
    
}