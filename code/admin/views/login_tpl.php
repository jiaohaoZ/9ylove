<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=lang('admin_site_title')?></title>
<style type="text/css">
*{margin:0; padding:0}
body{ background:#06294E;  font:normal 12px Verdana; color:white;font-family:"微软雅黑","黑体","宋体";}
a{ color:white;}
a:hover{ color:#339900;text-decoration:none;}
.wrap{ width:700px; margin:180px auto; overflow:hidden; zoom:1;}
	.logo{ width:350px; height:160px; float:left; background:url(<?=theme_img('admin_img/logo_login.png')?>) no-repeat 100% 0px;}
	.main{ width:300px; margin-left:15px; float:left; line-height:2;}
		.logintb{ margin:8px auto 8px 0; text-align:left;}
			.logintb th, .logintb td{ padding:3px;}
			.logintb th{ width:50px; font-weight:normal; padding-right:8px;}
			.logintb .tag{ text-align:left;  font-size:14px; font-weight:bold;}
textarea, input, select{ padding:2px; border:1px solid; border-color:#697777 #c4cfcf #c4cfcf #697777; background:#fbfef3; color:#333; }
.txt:hover, .txt:focus, textarea:hover, textarea:focus{ border-color:#09C; background:#F5F9FD; }
.btn{ margin:3px; padding:2px 8px; *padding:1px 5px; border-color:#ddd white white #ddd; background:#d8e5e5; color:#000; cursor:pointer; vertical-align:middle; }
	*+html .btn{padding:2px 8px 0px;}
.tt{ width:140px;}
#msg{ text-align:center;}
.copy{ text-align:center; font-size:11px;}

</style>

<script type="text/javascript">
if (self != top)
{
    /* 在框架内，则跳出框架 */
    top.location = self.location;
}
</script>

</head>
<body onload="javascript:document.frm.username.focus();">
<div class="wrap" style="margin-bottom:20px;">
   <div class="logo"></div>
   <div class="main">
        <form action="" method="post" name="frm" id="frm">
            <table class="logintb">
                <tr>
                    <th><?=lang('admin_user')?></th>
                    <td><input type="text" size="16" class="txt1" tabindex="1" style="width:130px;" 
                   		value="" id="username" name="username"/></td>
                </tr>
                <tr>
                    <th><?=lang('password')?></th>
                    <td><input type="password" id="password" name="password" size="16" class="txt2" tabindex="1" style="width:130px;" value=""/></td>
                </tr>
                <tr>
                    <th><?=lang('security_code')?></th>
                    <td style="vertical-align:bottom;">
                    	<input type="text" id="captcha" name="captcha" size="4" class="txt_chk" tabindex="1" style="width:55px;vertical-align:middle;" />
                    	<img style="CURSOR: pointer;vertical-align:middle;" width="90px" height="25px;" src="<?=site_url('c=checkcode&m=getcode&font_size=14&width=90&height=24')?>" border="0"  onClick='this.src=this.src+"&"+Math.random()' title="验证码,看不清楚?请点击刷新验证码">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td> 
                        <input name="dosubmit"  type="hidden" value="1"  />
                    	<input name="Submit" type="submit" class="btn" value="登 录" />
                    </td>
                </tr>
            </table>
        </form>
	</div>
</div>
<p id="msg" style="color:#FF3C3C;margin-bottom:20px;">&nbsp;</p>
<p class="copy">Copyright © 2016 All rights reserved.</p>
</body>
</html>
