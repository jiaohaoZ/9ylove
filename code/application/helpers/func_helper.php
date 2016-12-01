<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        echo $CI->load->view('mobile/show_message', array('msg'=>$msg, 'url_forward'=>$url_forward, 'ms'=>$ms, 'dialog'=>$dialog), TRUE);
        exit;
    }
}

/**
 * H5提示
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为3秒。
 * showmessage('登录成功', array('默认跳转地址'=>'xxx'));
 * @param string $msg 提示信息
 * @param mixed(string/array) $url_forward 跳转地址
 * @param int $ms 跳转等待时间(毫秒)
 */
if (! function_exists ( 'show_msg' ))
{
    function show_msg($msg, $url_forward = 'goback', $ms = 1250)
    {
        $CI = & get_instance();
        echo $CI->load->view('mobile/show_msg', array('msg'=>$msg, 'url_forward'=>$url_forward, 'ms'=>$ms), TRUE);
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
    $pwd['salt'] =  $encrypt ? $encrypt : create_randomstr();
    $pwd['password'] = md5(md5(trim($password)).$pwd['salt']);
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
function random($length, $chars = '0123456789')
{
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
function is_email($email)
{
    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/**
 * 判断手机号码格式是否正确
 * @param $mobile
 */
function is_mobile($mobile)
{

    return preg_match("/^1[34578]\d{9}$/", $mobile);
//    return  preg_match("/^1([0-9]{10})$/", $mobile);
}

/**
 * 判断电话号码格式是否正确
 */
function is_tel($tel)
{
    return preg_match("/^[\d|\-|\s|\_]+$/", $tel);
}


/**
 * 模板页头
 */
function page_header()
{
    $CI = & get_instance();
    $data = array();
    $navs = array();
    $data['user_name'] = $_SESSION['user_name'];
    if( ! $nav_list = get_cache('nav_list'))
    {
        $navs = $CI->db->order_by('sort_order ASC, nav_id ASC')->get('nav')->result_array();
        foreach ($navs as $val)
        {
            if($val['parent_id'] == 0)
            {
                $nav_list[$val['nav_id']]['name'] = $val['name'];
                $nav_list[$val['nav_id']]['active'] = $CI->router->fetch_class() == $val['c'] ? 1 : 0;
                if($val['c'] == 'index' && $val['m'] == 'index')
                {
                    $nav_list[$val['nav_id']]['url'] = base_url();
                }
                else
                {
                    $nav_list[$val['nav_id']]['url'] = '#';
                }
                $nav_list[$val['nav_id']]['children'] = array();
                $nav_list[$val['nav_id']]['is_show'] = $val['is_show'];
            }
            else
            {
                $nav_list[$val['parent_id']]['children'][] = array(
                    'name' => $val['name'],
                    'url'  => $CI->agent->is_mobile() ? site_url($val['c'].'/'.$val['m']) . '?nav_id=' . $val['parent_id'] : site_url($val['c'].'/'.$val['m']),
                    'is_show' => $val['is_show'],
                );
            }
            //set_cache('nav_list', $nav_list, config_item('sys_config_cache_time'));
        }
    }
    $data['nav_list'] = $nav_list;
    $breads = array();
    $data['flage'] = TRUE;
    foreach ($navs as $val)
    {
        if($CI->router->fetch_class()  == 'index') $data['flage'] = FALSE;
        if($val['c'] == $CI->router->fetch_class() && $val['m'] == 'index')
        {
            $breads[] = $val['name'];
            continue;
        }
        if($val['c'] == $CI->router->fetch_class() && $val['m'] == $CI->router->fetch_method() && $val['m'] != 'index')
        {
            $breads[] = $val['name'];
            break;
        }
    }
    $data['page_title'] = lang('index');
    if($breads)
    {
        $data['breads'] = implode('>', $breads);
        $data['page_title'] = end($breads);
    }
    unset($navs);

    $CI->agent->is_mobile() && $data['nav_id'] = $CI->input->get('nav_id');

    $CI->load->model('slides_model');
    $data['slides'] = $CI->slides_model->get_slides();
    return $data;
}

function page_min_header()
{
    get_instance()->load->view('header_min_tpl');
}


/**
 * 模板页脚
 */
function page_footer()
{
    get_instance()->load->view('footer_tpl');
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
 * 日期时间控件
 *
 * @param $name 控件name，id
 * @param $value 选中值
 * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
 */
function datepicker($name, $value = '', $loadjs = 0)
{
    $id = $name;
    $str = '';
    if($loadjs || !defined('DATEPICKER_INIT'))
    {
        define('DATEPICKER_INIT', 1);
        $str .= '<link rel="stylesheet" type="text/css" href="'.theme_css('bootstrap-datetimepicker.css').'"/>
        <script type="text/javascript" src="'.theme_js('bootstrap-datetimepicker.js').'"></script>
		<script type="text/javascript" src="'.theme_js('bootstrap-datetimepicker.zh-CN.js').'"></script>';
    }
    $str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" class="form-control" >';
    $str .= '<script type="text/javascript">
        $("#'.$id.'").datetimepicker({
            language: "zh-CN",
            format: "yyyy-mm-dd",
            minView: "month",
            autoclose: true,
        });
    </script>';
    return $str;
}


/**
 * 得到新订单号
 * @return  string
 */
function get_order_sn()
{
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);

    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
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
 * 建立请求，以表单HTML形式构造（默认）
 * @param $url 请求的url
 * @param $para 请求参数数组
 * @param $method 提交方式。两个值可选：post、get
 * @param $button_name 确认按钮显示文字
 * @return 提交表单HTML文本
 */
function buildRequestForm($url, $para, $method, $button_name)
{
    $sHtml = "<form id='cisubmit' name='cisubmit' action='".$url."' method='".$method."'>";
    while (list ($key, $val) = each ($para))
    {
        $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
    }

    //submit按钮控件请不要含有name属性
    $sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";

    $sHtml = $sHtml."<script>document.forms['cisubmit'].submit();</script>";

    return $sHtml;
}


/**
 * 截取UTF-8编码下字符串的函数
 *
 * @param   string      $str        被截取的字符串
 * @param   int         $length     截取的长度
 * @param   bool        $append     是否附加省略号
 *
 * @return  string
 */
function sub_str($str, $length = 0, $append = true)
{
    $str = trim($str);
    $strlength = strlen($str);

    if ($length == 0 || $length >= $strlength)
    {
        return $str;
    }
    elseif ($length < 0)
    {
        $length = $strlength + $length;
        if ($length < 0)
        {
            $length = $strlength;
        }
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, 0, $length, config_item('charset'));
    }
    elseif (function_exists('iconv_substr'))
    {
        $newstr = iconv_substr($str, 0, $length, config_item('charset'));
    }
    else
    {
        //$newstr = trim_right(substr($str, 0, $length));
        $newstr = substr($str, 0, $length);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }

    return $newstr;
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
 * @param string $file
 * @return bool
 */
function handle_zip_image($file)
{
    $pathinfo = pathinfo($file);
    if($pathinfo['extension'] != 'zip')
        return FALSE;
    $zip = new ZipArchive;
    if($zip->open($file) == TRUE)
    {
        $zip->extractTo($pathinfo['dirname']);
        $zip->close();
    }
    else
    {
        return FALSE;
    }
    return TRUE;

}

/**
 * 获取Linux uuid
 */
function linux_uuid()
{
    $dh = opendir('/dev/disk/by-uuid/');
    while($file = readdir($dh))
    {
        if(is_link('/dev/disk/by-uuid/'.$file))
        {
            if( realpath('/dev/disk/by-uuid/'.$file) == '/dev/sda1')
            {
                return $file;
            }
        }
    }
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
 * 手机图片处理
 */
function wap_image($html)
{
    return preg_replace('/<img|&lt;img/i', '<img class="img-responsive" ', $html);
}

/**
 * 维护公告
 */
function shop_notice()
{
    $CI = & get_instance();
    $data = config_item('shop_notice');
    echo $CI->load->view('shop_notice_tpl', $data, TRUE);
    exit;
}



