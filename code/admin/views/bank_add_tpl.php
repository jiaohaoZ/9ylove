<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">

	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){}});
	$("#bank_name").formValidator({onshow:"<?php echo lang("input").lang('bank_name')?>",onfocus:"<?php echo lang("input").lang('bank_name')?>"}).inputValidator({min:1,onerror:"<?php echo lang("input").lang('bank_name')?>"});
	
</script>

<style>  
/*#uploadImg{ font-size:12px; overflow:hidden; position:absolute}*/  
/*#file{ position:absolute; z-index:100; margin-left:-180px; font-size:60px;opacity:0;filter:alpha(opacity=0); margin-top:-5px;}*/  
</style> 
<div class="pad_10">
<form action="?m=bank_add&c=message&a=add" method="post" name="myform" id="myform" enctype="multipart/form-data">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		<tr>
			<th width="100"><?php echo lang('name')?>：</th>
			<td><input type="text" name="bank_name" id="bank_name"
				size="30" class="input-text" ></td>
		</tr>
		<tr>
			<th width="100"><?php echo lang('bank_icon')?>：</th>
			<td><span id="uploadImg"><input type="file" name="userfile" id="file"  value="图片上传" /></span>
			</td>
		</tr>
		
		<tr id="bank_status">
			<th width="100"><?php echo lang('bank_status')?>：</th>
			<td><?php echo lang('yes') ?><input type="radio" class="input-radio"  name="bank_status" value="1" checked>&nbsp;&nbsp;<?php echo lang('no') ?><input type="radio" class="input-radio"  value="0" name="bank_status"></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="hidden" name="forward" value="?m=bank_add&c=message&a=add"> 
				<input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo lang('submit')?> ">
			</td>
		</tr>
	
	</table>
</form>
</div>
</body>
</html>