<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#realname").formValidator({onshow:"<?php echo lang('input').lang('realname')?>",onfocus:"<?php echo lang('realname').lang('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo lang('realname').lang('between_2_to_20')?>"})
	$("#email").formValidator({onshow:"<?php echo lang('input').lang('email')?>",onfocus:"<?php echo lang('input').lang('email')?>",oncorrect:"<?php echo lang('email').lang('format_right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo lang('email').lang('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "?c=admin_manage&m=public_email_ajx",
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
		onerror : "<?php echo lang('email_already_exists')?>",
		onwait : "<?php echo lang('connecting_please_wait')?>"
	}).defaultPassed();
  })
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=admin_manage&m=edit_info" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo lang('username')?></td> 
<td><?php echo $user_name?></td>
</tr>

<tr>
<td width="80"><?php echo lang('lastlogintime')?></td> 
<td><?php echo $last_login_time ? date('Y-m-d H:i:s',$last_login_time) : ''?></td>
</tr>

<tr>
<td width="80"><?php echo lang('lastloginip')?></td> 
<td><?php echo $last_login_ip?></td>
</tr>

<tr>
<td><?php echo lang('realname')?></td>
<td>
<input type="text" name="info[real_name]" id="realname" class="input-text" size="30" value="<?php echo $real_name?>"></input>
</td>
</tr>
<tr>
<td><?php echo lang('email')?></td>
<td>
<input type="text" name="info[email]" id="email" class="input-text" size="40" value="<?php echo $email?>"></input>
</td>
</tr>
</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="button" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
