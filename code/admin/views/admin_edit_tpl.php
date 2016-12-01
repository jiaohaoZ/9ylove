<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#password").formValidator({empty:true,onshow:"<?php echo lang('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo lang('password').lang('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo lang('password').lang('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({empty:true,onshow:"<?php echo lang('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo lang('input').lang('passwords_not_match')?>",oncorrect:"<?php echo lang('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo lang('input').lang('passwords_not_match')?>"});
	$("#email").formValidator({onshow:"<?php echo lang('input').lang('email')?>",onfocus:"<?php echo lang('email').lang('format_incorrect')?>",oncorrect:"<?php echo lang('email').lang('format_right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo lang('email').lang('format_incorrect')?>"});
  })
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=admin_manage&m=admin_edit" method="post" id="myform">
<input type="hidden" name="info[userid]" value="<?php echo $user_id?>"></input>
<input type="hidden" name="info[username]" value="<?php echo $user_name?>"></input>
<input type="hidden" name="info[encrypt]" value="<?php echo $encrypt?>"></input>
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo lang('username')?></td> 
<td><?php echo $user_name?></td>
</tr>
<tr>
<td><?php echo lang('password')?></td> 
<td><input type="password" name="info[password]" id="password" class="input-text"></input></td>
</tr>
<tr>
<td><?php echo lang('cofirmpwd')?></td> 
<td><input type="password" name="info[pwdconfirm]" id="pwdconfirm" class="input-text"></input></td>
</tr>
<tr>
<td><?php echo lang('email')?></td>
<td>
<input type="text" name="info[email]" value="<?php echo $email?>" class="input-text" id="email" size="30"></input>
</td>
</tr>

<tr>
<td><?php echo lang('realname')?></td>
<td>
<input type="text" name="info[realname]" value="<?php echo $real_name?>" class="input-text" id="realname"></input>
</td>
</tr>
<tr>
<td><?php echo lang('userinrole')?></td>
<td>
<select name="info[roleid]">
<?php 
foreach($roles as $key => $role_name)
{
?>
<option value="<?php echo $key?>" <?php echo (($key==$role_id) ? 'selected' : '')?>><?php echo $role_name?></option>
<?php 
}	
?>
</select>
</td>
</tr>
</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="dialog" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
