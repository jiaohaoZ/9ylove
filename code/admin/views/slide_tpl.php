<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>

<div class="pad-lr-10">
<form action="searchform" method="get" action="">
	<input type="hidden" value="slide" name="m">
	<input type="hidden" value="message" name="c">
	<input type="hidden" value="36" name="menuid">
</form>

<form name="myform" id="myform" action="?m=slide_sort_order&c=message&a=sortorder" onsubmit="checkuid();return false;" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="5%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('slideid[]');"></th>
			<th width="5%" align="center"><?php echo lang('listorder')?></th>
			<th width="25%"><?php echo lang('name')?></th>
			<th width="25%"><?php echo lang('image')?></th>
			<th width="25%" align="center"><?php echo lang('url')?></th>
			<th width="5%" align="center"><?php echo lang('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($lists)){
	foreach($lists as $info){
		?>
	<tr>
		<td align="center" width="5%"><input type="checkbox" name="slideid[]" value="<?php echo $info['id']?>"></td>
		<td align="center" width="5%"><input name='slideorders[<?php echo $info['id']?>]' type='text' size='3' value='<?php echo $info['sort_order']?>' class="input-text-c"></td>
		<td align="center" width="25%"><?php echo $info['name'];?></td>
		<td align="center" width="25%"><img src="<?=base_url()?><?php echo $info['image'];?>" width=200 height=150></td>
		<td align="center" width="25%"><a href="<?php echo $info['url'];?>"><?php echo $info['url'];?></a></td>
		<td align="center" width="5%"><a href="###"
			onclick="edit(<?php echo $info['id']?>, '<?php echo $info['name']?>')"
			title="<?php echo lang('edit')?>"><?php echo lang('edit')?></a> |  <a
			href='?m=slide_delete&c=message&a=delete&slideid=<?php echo $info['id']?>'
			onClick="return confirm('确认删除吗?')"><?php echo lang('delete')?></a> 
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div class="btn"> 
<input name="dosubmit" type="submit" class="button"
	value="<?php echo lang('listorder')?>">&nbsp;&nbsp;<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=slide_delete&c=message&a=delete'" value="<?php echo lang('delete')?>"/></div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo lang('edit')?> '+name+' ',id:'edit',iframe:'?m=slide_edit&c=message&a=edit&slideid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function checkuid() {
	var ids='';
	$("input[name='slideid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo lang('plsease_select').lang('slides')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
//向下移动
function listorder_up(id) {
	$.get('?m=link&c=link&a=listorder_up&linkid='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		alert('<?php echo lang('move_success')?>');
	} else {
	alert(msg); 
	} 
	}); 
} 
</script>
</body>
</html>
