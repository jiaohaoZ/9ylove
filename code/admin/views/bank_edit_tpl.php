<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}}); 

	$("#link_name").formValidator({onshow:"<?php echo lang("input").lang('link_name')?>",onfocus:"<?php echo lang("input").lang('link_name')?>"}).inputValidator({min:1,onerror:"<?php echo lang("input").lang('link_name')?>"}).ajaxValidator({type : "get",url : "",data :"m=link&c=link&a=public_name&linkid=<?php echo $linkid;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo lang('link_name').lang('exists')?>",onwait : "<?php echo lang('connecting')?>"}).defaultPassed(); 

	$("#link_url").formValidator({onshow:"<?php echo lang("input").lang('url')?>",onfocus:"<?php echo lang("input").lang('url')?>"}).inputValidator({min:1,onerror:"<?php echo lang("input").lang('url')?>"}).regexValidator({regexp:"^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&]*([^<>])*$",onerror:"<?php echo lang('link_onerror')?>"});
	
	})
</script>
<style>  
/*#uploadImg{ font-size:12px; overflow:hidden; position:absolute}  
#file{ position:absolute; z-index:100; margin-left:-180px; font-size:60px;opacity:0;filter:alpha(opacity=0); margin-top:-5px;}  */
</style> 
<div class="pad_10">
<form action="?m=bank_edit&c=message&a=edit&bank_id=<?php if(isset($bank_id)) echo $bank_id; ?>" method="post" name="myform" id="myform" enctype="multipart/form-data">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		<tr>
			<th width="100"><?php echo lang('bank_name')?>：</th>
			<td><input type="text" name="bank_name" id="bank_name"
				size="30" class="input-text" value="<?php if(isset($bank_name)) echo $bank_name;?>" ></td>
		</tr>
		<tr>
			<th width="100"><?php echo lang('bank_icon')?>：</th>
			<td><span id="uploadImg"><input type="file" name="userfile" id="file" value="图片上传" /></span>
		</td>
		</tr>
		
		<tr id="bank_status">
			<th width="100"><?php echo lang('bank_status')?>：</th>
			<td><?php echo lang('yes') ?><input type="radio" class="input-radio"  name="bank_status" value="1" <?php if($status){echo 'checked';} ?>>&nbsp;&nbsp;<?php echo lang('no') ?><input type="radio" class="input-radio"  value="0" name="bank_status" <?php if(!$status){echo 'checked';} ?>></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<!--<input type="hidden" name="forward" value="?m=links_edit&c=message&a=edit">--> 
				<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo lang('submit')?> ">
			</td>
		</tr>
	
	</table>
</form>
</div>
</body>
</html>