<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为3秒。
 * showmessage('登录成功', array('默认跳转地址'=>'xxx'));
 * @param string $msg 提示信息
 * @param mixed(string/array) $url_forward 跳转地址
 * @param int $ms 跳转等待时间(毫秒)
 */
if (! function_exists ( 'show_message' )) 
{
	function show_message($msg, $url_forward = 'goback', $ms = 1250, $dialog = '') 
	{
		$CI = & get_instance();
        echo $CI->load->view('show_message_tpl', array('msg'=>$msg, 'url_forward'=>$url_forward, 'ms'=>$ms, 'dialog'=>$dialog), TRUE);
		exit;
	}
}

/**
 * 写入缓存，默认为文件缓存
 * @param $name 缓存名称
 * @param $data 缓存数据
 * @param $timeout 过期时间
 * @param $type 缓存类型[file,memcache,apc]
 */
function set_cache($name, $data, $timeout=0, $type='file') 
{
	$CI = & get_instance();
	$CI->load->driver('cache');
	return $CI->cache->$type->save($name, $data, $timeout);
}

/**
 * 读取缓存，默认为文件缓存
 * @param string $name 缓存名称
 */
function get_cache($name, $type='file') 
{
	$CI = & get_instance();
	$CI->load->driver('cache');
	return $CI->cache->$type->get($name);
}

/**
 * 删除缓存，默认为文件缓存
 * @param $name 缓存名称
 * @param $type 缓存类型[file,memcache,apc]
 */
function del_cache($name, $type='file') 
{
	$CI = & get_instance();
	$CI->load->driver('cache');
	return $CI->cache->$type->delete($name);
}

/**
 * 清空缓存，默认为文件缓存
 * @param $type 缓存类型[file,memcache,apc]
 */
function clean_cache($type='file')
{
	$CI = & get_instance();
	$CI->load->driver('cache');
	return $CI->cache->$type->clean();
}

/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password
 * @return 	TRUE or FALSE
 */
function is_password($password)
{
	$strlen = strlen($password);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt='')
{
	$pwd = array();
	$pwd['encrypt'] =  $encrypt ? $encrypt : create_randomstr();
	$pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
	return $encrypt ? $pwd['password'] : $pwd;
}
/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 6)
{
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * 产生随机字符串
 *
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的 ，默认为 0123456789
 * @return   string     字符串
 */
function random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++)
	{
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

/**
 * 判断email格式是否正确
 * @param $email
 */
function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/**
 * 日期时间控件
 *
 * @param $name 控件name，id
 * @param $value 选中值
 * @param $isdatetime 是否显示时间
 * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
 * @param $showweek 是否显示周，使用，true | false
 */
function calendar($name, $value = '', $isdatetime = 0, $loadjs = 0, $showweek = 'true', $timesystem = 1) {
	if($value == '0000-00-00 00:00:00') $value = '';
	$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
	if($isdatetime)
	{
		$size = 21;
		$format = '%Y-%m-%d %H:%M:%S';
		if($timesystem)
		{
			$showsTime = 'true';
		}
		else
		{
			$showsTime = '12';
		}

	}
	else
	{
		$size = 10;
		$format = '%Y-%m-%d';
		$showsTime = 'false';
	}
	$str = '';
	if($loadjs || !defined('CALENDAR_INIT'))
	{
		define('CALENDAR_INIT', 1);
		$str .= '<link rel="stylesheet" type="text/css" href="'.theme_js('calendar/jscal2.css').'"/>
		<link rel="stylesheet" type="text/css" href="'.theme_js('calendar/border-radius.css').'"/>
		<link rel="stylesheet" type="text/css" href="'.theme_js('calendar/win2k.css').'"/>
		<script type="text/javascript" src="'.theme_js('calendar/calendar.js').'"></script>
		<script type="text/javascript" src="'.theme_js('calendar/lang/en.js').'"></script>';
	}
	$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="'.$size.'" class="date" readonly>&nbsp;';
	$str .= '<script type="text/javascript">
		Calendar.setup({
		weekNumbers: '.$showweek.',
	    inputField : "'.$id.'",
	    trigger    : "'.$id.'",
	    dateFormat: "'.$format.'",
	    showTime: '.$showsTime.',
	    minuteStep: 1,
	    onSelect   : function() {this.hide();}
		});
    </script>';
	return $str;
}

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串
 * @param    string   $field_name     字段名称
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
        }
        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}

/**
 * 获取默认图片地址
 * @return string
 */
function get_default_image()
{
    return 'statics/images/default.gif';
}

/**
 * 菜单权限显示
 */
function get_view($c, $m, $a)
{
    if($_SESSION['role_id'] == 1) return TRUE;
    $CI = & get_instance();
    $CI->load->model('role_priv_model');
    return $CI->role_priv_model->get_one(array('c'=>$c,'m'=>$m,'a'=>$a,'role_id'=>$_SESSION['role_id']));
}

/**
 * 获取数据，GET模式
 * @param $url 指定URL完整路径地址
 * @param $timeout 超时时间(秒)
 * @return string
 */
function do_get($url, $timeout = 3)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

/**
 * 获取数据，POST模式
 * @param $url 指定URL完整路径地址
 * @param $para 请求的数据
 * @param $timeout 超时时间(秒)
 * @return string
 */
function do_post($url, $para, $timeout = 5 )
{
    if(is_array($para))
    {
        ksort($para);
        $query_string = array();
        foreach ($para as $key => $val )
        {
            array_push($query_string, $key . '=' . $val);
        }
        $query_string = implode('&', $query_string);
    }
    else
    {
        $query_string = $para;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

/**
 * 同步账号到游戏sdk平台
 * @return bool
 */
function sync_account($user_name, $pwd)
{
    $time = time();
    $game = array(
        'name' => $user_name,
        'mobile_phone' => $user_name,
        'password' => $pwd,
        'time' => $time,
        'channel' => config_item('channel'),
        'sign' => md5($user_name . $time . config_item('login_game_key')),
    );
    $ret = do_post(config_item('login_game_api'), $game);
    return $ret === 'success' ? TRUE : FALSE;
}

/**
 * 排序
 */
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
        	case SORT_ASC:
        	    asort($sortable_array);
        	    break;
        	case SORT_DESC:
        	    arsort($sortable_array);
        	    break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}


/**
 * 判断手机号码格式是否正确
 * @param $mobile
 */
function is_mobile($mobile)
{
    return  preg_match("/^1([0-9]{10})$/", $mobile);
}


