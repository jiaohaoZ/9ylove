<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="pad_10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="admin_log_list" name="m">
<input type="hidden" value="admin_manage" name="c">
<input type="hidden" value="search" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				<?php echo lang('operation_type')?>：
				<select name="operation_type">
					<option value='' ><?php echo lang('all')?></option>
					<?php foreach(lang('admin_logs') as $k => $v) { ?>
						<option value='<?php echo $k?>' <?php if($type == $k) echo 'selected'?> ><?php echo $v?></option>
					<?php } ?>
				</select>
				<?php echo lang('admin_user')?>：
					<input name="admin" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<?php echo lang('start_time')?>：
					 <?php echo calendar('start_time') ?>
				<?php echo lang('end_time')?>：
					 <?php echo calendar('end_time') ?>
				<input type="submit" name="search" class="button" value="<?php echo lang('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" action="" method="post"  id="myform">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo lang('admin_user')?></th>
			<th align="left"><?php echo lang('operation_type')?></th>
			<th align="left"><?php echo lang('log_info')?></th>
			<th align="left"><?php echo lang('log_time')?></th>
			<th align="left"><?php echo lang('log_ip')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	foreach($list as $k=>$v) {
?>
    <tr>
		<td align="left"><?php echo $v['user_name']?></td>
		<td align="left"><?php echo lang('admin_logs')[$v['log_type']]?></td>
		<td align="left"><?php echo $v['log_info']?></td>
		<td align="left"><?php echo date("Y-m-d H:i:s",$v['log_time'])?></td>
		<td align="left"><?php echo $v['log_ip']?></td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>
<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>