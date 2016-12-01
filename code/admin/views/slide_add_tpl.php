<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script type="text/javascript">

	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){}});
	$("#slide_name").formValidator({onshow:"<?php echo lang("input").lang('slide_name')?>",onfocus:"<?php echo lang("input").lang('slide_name')?>"}).inputValidator({min:1,onerror:"<?php echo lang("input").lang('slide_name')?>"});
 	$("#slide_url").formValidator({onshow:"<?php echo lang("input").lang('url')?>",onfocus:"<?php echo lang("input").lang('url')?>"}).inputValidator({min:1,onerror:"<?php echo lang("input").lang('url')?>"});
	 
	})
</script>

<style>  
/*#uploadImg{ font-size:12px; overflow:hidden; position:absolute}*/  
/*#file{ position:absolute; z-index:100; margin-left:-180px; font-size:60px;opacity:0;filter:alpha(opacity=0); margin-top:-5px;}*/  
</style> 
<div class="pad_10">
<form action="?m=slide_add&c=message&a=add" method="post" name="myform" id="myform" enctype="multipart/form-data">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		<tr>
			<th width="100"><?php echo lang('name')?>：</th>
			<td><input type="text" name="slide[name]" id="slide_name"
				size="30" class="input-text" value="<?php if(isset($name)) echo $name;?>"></td>
		</tr>
		
		<tr>
			<th width="100"><?php echo lang('image')?>：</th>
			<td><span id="uploadImg"><input type="file" name="userfile" id="file"  value="图片上传" /></span><strong style="color: red;">*图片上传的尺寸为1140*347</strong>
				
			</td>
		</tr>
		
		<tr>
			<th width="100"><?php echo lang('url')?>：</th>
			<td><input type="text" name="slide[url]" id="slide_url"
				size="30" class="input-text" value="<?php if(isset($url)) echo $url;?>"></td>
		</tr>
		
		<tr id="sortorder">
			<th width="100"><?php echo lang('listorder')?>：</th>
			<td><input type="text" name="slide[sort_order]" id="sort_order" class="input-text" value="<?php if(isset($sort_order)) echo $sort_order; ?>" /></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="hidden" name="forward" value="?m=slide_add&c=message&a=add"> 
				<input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo lang('submit')?> ">
			</td>
		</tr>
	
	</table>
</form>
</div>
</body>
</html>