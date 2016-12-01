<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="pad_10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="order_list" name="m">
<input type="hidden" value="finance" name="c">
<input type="hidden" value="init" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo lang('pay_time')?>：
				<?php echo calendar('start_time', $start_time)?>-
				<?php echo calendar('end_time', $end_time)?>
				<select name="status">
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>><?php echo lang('all')?></option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>><?php echo lang('success')?></option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>><?php echo lang('failure')?></option>
				</select>
				<?php echo lang('order_sn')?>：
				<input name="keyword" type="text" value="<?php if(isset($order_num)){echo $order_num;} ?>" class="input-text" />
				<?php echo lang('agent_id') ?>
				<input name="agent_id" type="text" value="<?php if(isset($agent_id)){echo $agent_id;} ?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo lang('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="" method="post" onsubmit="checkuid();return false;" id="myform">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
	    <tr><th align="left"  colspan="10">总支付：<strong style="color: red"><?php echo $sum?></strong></th></tr>
		<tr>
			<th align="left"><?php echo lang('order_id')?></th>
			<th align="left"><?php echo lang('user_name')?></th>
			<th align="left"><?php echo lang('order_sn')?></th>
			<th align="left"><?php echo lang('pay_money')?></th>
			<th align="left"><?php echo lang('pay_status')?></th>
			<th align="left"><?php echo lang('pay_time')?></th>
			<th align="left"><?php echo lang('addtime')?></th>
			<th align="left"><?php echo lang('agent_id')?></th>

		</tr>
	</thead>
<tbody>
<?php
	if(is_array($lists)){
	foreach($lists as $v) {
?>
    <tr>
		<td align="left"><?php echo $v['order_id']?></td>
		<td align="left"><?php echo $v['user_name']?></td>
		<td align="left"><?php echo $v['order_sn']?></td>
		<td align="left"><?php echo $v['pay_money']?></td>
		<td align="left"><?php echo $v['pay_status'] == 1 ? '成功' : '失败'?></td>
		<td align="left"><?php echo $v['pay_time'] ? date("Y-m-d H:i:s",$v['pay_time']) : ''?></td>
		<td align="left"><?php echo date("Y-m-d H:i:s",$v['add_time']);?></td>
		<td align="left"><?php echo $v['agent_id']?></td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>
<!-- <div id="pages"><?php //echo $pages?></div> -->
</div>
</form>
</div>
</body>
</html>