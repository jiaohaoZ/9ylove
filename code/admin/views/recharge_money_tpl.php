<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?c=finance&m=recharge_manage" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"></td> 
<td>
</tr>																		   
<tr>
<td width="10%"><?php echo lang('user_num')?></td>
<td>
	<input type="text" name="user_name" id="user_name" value="" required="required"/><span style="color:red;margin-left:10px;">（充值账号只能是主账号）</span>
</td>
</tr>

<tr>
<td width="10%"><?php echo lang('recharge_type')?></td>
<td>
	<select name="type">
	       <?php foreach ($log_types as $k=>$v): ?>
			<option value="<?=$k?>"><?=$v?></option>
            <?php endforeach;?>
	</select>
</td>
</tr>
<tr>
<td width="10%"><?php echo lang('recharge_num')?></td> 
<td><input type="text" name="money" id="money" class="input-text" required="required"></input></td>
</tr>

</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="button" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
