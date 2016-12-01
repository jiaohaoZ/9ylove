<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="table-list pad-lr-10">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="10%">ID</th>
		<th width="15%"  align="left" ><?php echo lang('role_name');?></th>
		<th width="265"  align="left" ><?php echo lang('role_desc');?></th>
		<th width="5%"  align="left" ><?php echo lang('role_status');?></th>
		<th class="text-c"><?php echo lang('role_operation');?></th>
		</tr>
        </thead>
<tbody>
<?php 
	foreach($lists as $v){
?>
<tr>
<td width="10%" align="center"><?php echo $v['role_id']?></td>
<td width="15%"  ><?php echo $v['role_name']?></td>
<td width="265" ><?php echo $v['description']?></td>
<td width="5%"><?php echo $v['disabled']? lang('icon_locked'):lang('icon_unlock')?></td>
<td  class="text-c">
<?php if($v['role_id'] > 1) {?>
<a href="javascript:setting_role(<?php echo $v['role_id']?>, '<?php echo $v['role_name']?>')"><?php echo lang('role_setting');?></a> |
<?php } else {?>
<font color="#cccccc"><?php echo lang('role_setting');?></font> |
<?php }?>
<?php if($v['role_id'] > 1) {?><a href="?c=role&m=edit&a=edit&role_id=<?php echo $v['role_id']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo lang('edit')?></a> | 
<a href="javascript:confirmurl('?c=role&m=delete&a=delete&role_id=<?php echo $v['role_id']?>', '<?php echo lang('role_del_cofirm')?>')"><?php echo lang('delete')?></a>
<?php } else {?>
<font color="#cccccc"><?php echo lang('edit')?></font> | <font color="#cccccc"><?php echo lang('delete')?></font>
<?php }?>
</td>
</tr>
<?php 
	}
?>
</tbody>
</table>
</form>
</div>
</body>
<script type="text/javascript">
<!--
function setting_role(id, name) {

	window.top.art.dialog({title:'<?php echo lang('sys_setting')?>《'+name+'》',id:'edit',iframe:'?c=role&m=setting_priv&a=set&role_id='+id,width:'700',height:'500'},
			function(){
		         var d = window.top.art.dialog({id:'edit'}).data.iframe;
	             var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()
		      }
	      );
}
//-->
</script>
</html>
