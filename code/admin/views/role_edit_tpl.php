<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#role_name").formValidator({onshow:"<?php echo lang('input').lang('role_name')?>",onfocus:"<?php echo lang('role_name').lang('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo lang('role_name').lang('not_empty')?>"});
})
//-->
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=role&m=edit&a=edit" method="post" id="myform">
<input type="hidden" name="role_id" value="<?php echo $role_id?>"></input>
<table width="100%" class="table_form contentWrap">
<tr>
<td><?php echo lang('role_name')?></td> 
<td><input type="text" name="info[role_name]" value="<?php echo $role_name?>" class="input-text" id="role_name"></input></td>
</tr>
<tr>
<td><?php echo lang('role_description')?></td>
<td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:500px;"><?php echo $description?></textarea></td>
</tr>
<tr>
<td><?php echo lang('enabled')?></td>
<td><input type="radio" name="info[disabled]" value="0" <?php echo ($disabled=='0')?' checked':''?>> <?php echo lang('enable')?>  <label><input type="radio" name="info[disabled]" value="1" <?php echo ($disabled=='1')?' checked':''?>><?php echo lang('ban')?></td>
</tr>
</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="button">
</form>
</div>
</div>
</body>
</html>


