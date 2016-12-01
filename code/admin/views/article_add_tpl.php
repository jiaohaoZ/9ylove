<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<script charset="utf-8" src="<?=theme_js('')?>kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?=theme_js('')?>kindeditor/lang/zh_CN.js"></script>
<script>
	KindEditor.ready(function(K) {
		var editor = K.create('textarea[name="content"]', {
			cssPath : '<?php echo site_url()?>assets/admin/js/plugins/code/prettify.css',
			uploadJson : '<?php echo site_url()?>?c=attached&m=upload',
			//fileManagerJson : '../php/file_manager_json.php',
			allowFileManager : true,
			afterCreate : function() {
				var self = this;
				K.ctrl(document, 13, function() {
					self.sync();
					K('form[name=myform]')[0].submit();
				});
				K.ctrl(self.edit.doc, 13, function() {
					self.sync();
					K('form[name=myform]')[0].submit();
				});
			}
		});
		prettyPrint();
	});
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=message&m=article_add" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo lang('title')?></td> 
<td><input type="test" name="title"  class="input-text" id="title"  size="60"></input></td>
</tr>
<tr>
<td><?php echo lang('content')?></td>
<td>
<textarea name="content" style="width:800px;height:500px;visibility:hidden;"></textarea>
</td>
</tr>
<tr>
<td><?php echo lang('status')?></td>
<td>
<select name="status">
<?php 
foreach($article_status as $key => $value)
{
?>
<option value="<?php echo $key?>"><?php echo $value?></option>
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

