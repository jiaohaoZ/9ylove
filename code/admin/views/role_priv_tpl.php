<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>

<form action="?c=role&m=setting_priv&a=set&role_id=<?php echo $role_id?>" method="post">
<div class="table-list" id="load_priv">
<table width="100%" class="table-list">
<?php foreach ($menu as $m): ?>
	  <thead>
		<tr>
		  <th align='left'  colspan="10"><input type='checkbox'  value='1'  name="priv[<?php echo $m['c'].'-'.$m['m'].'-'.'init' ?>]" <?php echo isset($priv[$m['c'].'-'.$m['m'].'-'.'init']) ? $priv[$m['c'].'-'.$m['m'].'-'.'init'] : ''?>><?php echo lang($m['name'])?></th>
	  </tr>
	  </thead>
	  <tbody>
	       <?php $sub = $admin_model->admin_menu($m['id']); foreach ($sub as $s):?>
	           <tr><td colspan="10"><?php echo lang($s['name'])?></td></tr>
	           <?php $sub_list = $admin_model->admin_menu($s['id']); foreach ($sub_list as $sl): ?>
	           <?php $ch = $admin_model->admin_menu_priv($sl['id']);?>
	           <tr><td><?php echo lang($sl['name'])?></td>
	                   <td align='center'  <?php if(!isset($ch['init'])) echo  ' style="color:#999"'?>><input type='checkbox' name="priv[<?php echo $ch['priv_init']?>]"  value='1'   <?php echo isset($priv[$ch['priv_init']]) ? $priv[$ch['priv_init']] : ''?> <?php if(!isset($ch['init'])) echo 'disabled' ?>><?php echo lang('view')?></td>
				       <td align='center'  <?php if(!isset($ch['add'])) echo ' style="color:#999"'?>><input type='checkbox' name="priv[<?php echo $ch['priv_add'] ?>]"  value='1'  <?php echo isset($priv[$ch['priv_add']]) ? $priv[$ch['priv_add']] : ''?> <?php if(!isset($ch['add'])) echo 'disabled' ?> ><?php echo lang('add')?></td>
				      <td align='center'  <?php if(!isset($ch['edit'])) echo ' style="color:#999"'?>><input type='checkbox' name="priv[<?php echo $ch['priv_edit'] ?>]"   value='1'  <?php echo isset($priv[$ch['priv_edit']]) ? $priv[$ch['priv_edit']] : ''?> <?php if(!isset($ch['edit'])) echo 'disabled' ?> ><?php echo lang('edit')?></td>
				      <td align='center'  <?php if(!isset($ch['delete'])) echo ' style="color:#999"'?>><input type='checkbox' name="priv[<?php echo $ch['priv_delete'] ?>]"   value='1'  <?php echo isset($priv[$ch['priv_delete']]) ? $priv[$ch['priv_delete']] : ''?> <?php if(!isset($ch['delete'])) echo 'disabled' ?> ><?php echo lang('delete')?></td>
				 </tr>
			<?php endforeach;?>
	       <?php endforeach;?>
	  </tbody>
			  
<?php endforeach;?>
</table>
</div>

<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="dialog" id="dosubmit">
</form>
<script type="text/javascript">
<!--
function select_all(name, obj) {
	if (obj.checked) {
		$("input[type='checkbox'][name='priv["+name+"][]']").attr('checked', 'checked');
	} else {
		$("input[type='checkbox'][name='priv["+name+"][]']").removeAttr('checked');
	}
}
//-->
</script>
</body>
</html>
