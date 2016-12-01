<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="pad_10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="user_log" name="m">
<input type="hidden" value="user" name="c">
<input type="hidden" value="init" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo lang('log_type')?>：
				<select name="log_type">
					<option value="0"><?php echo lang('all')?></option>
					<?php foreach ($log_types as $k=>$v):?>
					<option value="<?=$k?>" <?php echo $log_type == $k ? 'selected' : '' ?>><?=$v?></option>
					<?php endforeach;?>
				</select>

				<?php echo lang('user_name')?>：
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<?php echo lang('start_time')?>：
					 <?php echo calendar('start_time',$start_time) ?>
				<?php echo lang('end_time')?>：
					 <?php echo calendar('end_time',$end_time) ?>
				<input type="submit" name="search" class="button" value="<?php echo lang('search')?>" />
				<input type="submit" name="export" class="button" value="导出">
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" action="?m=user_log&c=user" method="post"  id="myform">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo lang('log_id')?></th>
			<th align="left"><?php echo lang('log_type')?></th>
			<th align="left"><?php echo lang('user_name')?></th>
			<th align="left"><?php echo lang('before_money')?></th>
			<th align="left"><?php echo lang('after_money')?></th>
			<th align="left"><?php echo lang('log_info')?></th>
			<th align="left"><?php echo lang('log_time')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	foreach($list as $k=>$v) {
?>
    <tr>
		<td align="left"><?php echo $v['log_id']?></td>
		<td align="left"><?php echo $log_types[$v['log_type']] ?></td>
		<td align="left"><?php echo $v['user_name']?></td>
		<td align="left"><?php echo $v['before_money']?></td>
		<td align="left"><?php echo $v['after_money']?></td>
		<td align="left"><pre><?php echo $v['log_info']?></pre></td>
		<td align="left"><?php echo date("Y-m-d H:i:s",$v['log_time'])?></td>
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