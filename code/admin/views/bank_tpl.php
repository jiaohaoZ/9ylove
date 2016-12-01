<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>

<div class="pad-lr-10">
<form action="searchform" method="get" action="">
	<input type="hidden" value="bank" name="m">
	<input type="hidden" value="message" name="c">
	<input type="hidden" value="36" name="menuid">
</form>

<form name="myform" id="myform" action="?m=slide_sort_order&c=message&a=sortorder" onsubmit="checkuid();return false;" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="5%" align="center"><?php echo lang('bank_id')?></th>
			<th width="5%" align="center"><?php echo lang('bank_name')?></th>
			<th width="5%" align="center"><?php echo lang('bank_icon')?></th>
			<th width="5%" align="center"><?php echo lang('bank_status')?></th>
			<th width="5%" align="center"><?php echo lang('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($lists)){
	foreach($lists as $info){
		?>
	<tr>
		<td align="center" width="15%"><?php echo $info['bank_id'];?></td>
		<td align="center" width="25%"><?php echo $info['bank_name'];?></td>
		<td align="center" width="25%"><img width="50" height="50" src="<?php echo base_url().$info['bank_image'];?>"></td>
		<td align="center" width="25%"><?php echo $info['status'];?></td>
		<td align="center" width="5%"><a href="###"
			onclick="edit(<?php echo $info['bank_id']?>, '<?php echo $info['bank_name']?>')"
			title="<?php echo lang('edit')?>"><?php echo lang('edit')?></a> |  <a
			href='?m=bank_delete&c=message&a=delete&bank_id=<?php echo $info['bank_id']?>'
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
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo lang('edit')?> '+name+' ',id:'edit',iframe:'?m=bank_edit&c=message&a=edit&bank_id='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
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
