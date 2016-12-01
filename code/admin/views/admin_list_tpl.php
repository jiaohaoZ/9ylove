<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="pad_10">
<div class="table-list">
<form name="myform" action="?c=admin_manage&m=admin_list" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="10%"><?php echo lang('userid')?></th>
		<th width="10%" align="left" ><?php echo lang('username')?></th>
		<th width="10%" align="left" ><?php echo lang('userinrole')?></th>
		<th width="10%"  align="left" ><?php echo lang('lastloginip')?></th>
		<th width="10%"  align="left" ><?php echo lang('lastlogintime')?></th>
		<th width="15%"  align="left" ><?php echo lang('email')?></th>
		<th width="10%"><?php echo lang('realname')?></th>
		<th width="15%" ><?php echo lang('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)){
	foreach($list as $info){
?>
<tr>
<td width="10%" align="center"><?php echo $info['user_id']?></td>
<td width="10%" ><?php echo $info['user_name']?></td>
<td width="10%" ><?php echo $roles[$info['role_id']]?></td>
<td width="10%" ><?php echo $info['last_login_ip']?></td>
<td width="10%"  ><?php echo $info['last_login_time'] ? date('Y-m-d H:i:s',$info['last_login_time']) : ''?></td>
<td width="15%"><?php echo $info['email']?></td>
<td width="10%"  align="center"><?php echo $info['real_name']?></td>
<td width="15%"  align="center">
<a href="javascript:edit(<?php echo $info['user_id']?>, '<?php echo $info['user_name']?>')"><?php echo lang('edit')?></a> | 
<?php if($info['user_id'] != 1) {?>
<a href="javascript:confirmurl('?c=admin_manage&m=admin_delete&a=delete&userid=<?php echo $info['user_id']?>', '<?php echo lang('admin_del_cofirm')?>')"><?php echo lang('delete')?></a>
<?php } else {?>
<font color="#cccccc"><?php echo lang('delete')?></font>
<?php } ?>
</td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
 <div id="pages"> <?php echo $pages?></div>
</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">
<!--
	function edit(id, name) {
		window.top.art.dialog({title:'<?php echo lang('edit')?>--'+name, id:'edit', iframe:'?c=admin_manage&m=admin_edit&a=edit&userid='+id ,width:'500px',height:'400px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
	}
//-->
</script>