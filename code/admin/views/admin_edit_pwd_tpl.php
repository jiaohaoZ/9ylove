<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#old_password").formValidator({empty:true,onshow:"<?php echo lang('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo lang('password').lang('between_6_to_20')?>",oncorrect:"<?php echo lang('old_password_right')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo lang('password').lang('between_6_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "?c=admin_manage&m=public_password_ajx",
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
		onerror : "<?php echo lang('old_password_wrong')?>",
		onwait : "<?php echo lang('connecting_please_wait')?>"
	});
	$("#new_password").formValidator({empty:true,onshow:"<?php echo lang('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo lang('password').lang('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo lang('password').lang('between_6_to_20')?>"});
	$("#new_pwdconfirm").formValidator({empty:true,onshow:"<?php echo lang('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo lang('input').lang('passwords_not_match')?>",oncorrect:"<?php echo lang('passwords_match')?>"}).compareValidator({desid:"new_password",operateor:"=",onerror:"<?php echo lang('input').lang('passwords_not_match')?>"});
  })
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=admin_manage&m=edit_pwd" method="post" id="myform">
<input type="hidden" name="info[userid]" value="<?php echo $user_id?>"></input>
<input type="hidden" name="info[username]" value="<?php echo $user_name?>"></input>
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo lang('username')?></td> 
<td><?php echo $user_name?> (<?php echo lang('realname')?>: <?php echo $real_name?>)</td>
</tr>

<tr>
<td><?php echo lang('email')?></td>
<td>
<?php echo $email?>
</td>
</tr>

<tr>
<td><?php echo lang('old_password')?></td> 
<td><input type="password" name="old_password" id="old_password" class="input-text"></input></td>
</tr>

<tr>
<td><?php echo lang('new_password')?></td> 
<td><input type="password" name="new_password" id="new_password" class="input-text"></input></td>
</tr>
<tr>
<td><?php echo lang('new_pwdconfirm')?></td> 
<td><input type="password" name="new_pwdconfirm" id="new_pwdconfirm" class="input-text"></input></td>
</tr>


</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="button" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
