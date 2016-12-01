<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#username").formValidator({onshow:"<?php echo lang('input').lang('username')?>",onfocus:"<?php echo lang('username').lang('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo lang('username').lang('between_2_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "?c=admin_manage&m=checkname_ajax&is_ajax=1",
		data :"",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo lang('user_already_exist')?>",
		onwait : "<?php echo lang('connecting_please_wait')?>"
	});
	$("#password").formValidator({onshow:"<?php echo lang('input').lang('password')?>",onfocus:"<?php echo lang('password').lang('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo lang('password').lang('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({onshow:"<?php echo lang('input').lang('cofirmpwd')?>",onfocus:"<?php echo lang('input').lang('passwords_not_match')?>",oncorrect:"<?php echo lang('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo lang('input').lang('passwords_not_match')?>"});
	$("#email").formValidator({onshow:"<?php echo lang('input').lang('email')?>",onfocus:"<?php echo lang('email').lang('format_incorrect')?>",oncorrect:"<?php echo lang('email').lang('format_right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo lang('email').lang('format_incorrect')?>"});
})
//-->
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=admin_manage&m=admin_add" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo lang('username')?></td> 
<td><input type="test" name="info[username]"  class="input-text" id="username"></input></td>
</tr>
<tr>
<td><?php echo lang('password')?></td> 
<td><input type="password" name="info[password]" class="input-text" id="password" value=""></input></td>
</tr>
<tr>
<td><?php echo lang('cofirmpwd')?></td> 
<td><input type="password" name="info[pwdconfirm]" class="input-text" id="pwdconfirm" value=""></input></td>
</tr>
<tr>
<td><?php echo lang('email')?></td>
<td>
<input type="text" name="info[email]" value="" class="input-text" id="email" size="30"></input>
</td>
</tr>
<tr>
<td><?php echo lang('realname')?></td>
<td>
<input type="text" name="info[realname]" value="" class="input-text" id="realname"></input>
</td>
</tr>
<tr>
<td><?php echo lang('userinrole')?></td>
<td>
<select name="info[roleid]">
<?php 
foreach($roles as $role_id => $role_name)
{
?>
<option value="<?php echo $role_id?>"><?php echo $role_name?></option>
<?php 
}	
?>
</select>
</td>
</tr>
</table>
    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="button">
</form>
</div>
</div>
</body>
</html>

