<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>

<form action="?m=save&c=setting" method="post" id="myform">
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',5,1);"><?php echo lang('setting_basic_cfg')?></li>
            <li id="tab_setting_2" onclick="SwapTab('setting','on','',5,2);"><?php echo lang('user_account_cfg')?></li>
            <li id="tab_setting_3" onclick="SwapTab('setting','on','',5,3);"><?php echo lang('sms_setting')?></li>
           
</ul>

<div id="div_setting_1" class="contentList pad-10">
<table width="100%"  class="table_form">
		<tr>
		    <th width="120"><?php echo lang('max_login_failed_times')?></th>
		    <td class="y-bg"><input type="text" class="input-text" name="setting[max_login_failed_times]"  size="5" value="<?php echo $max_login_failed_times?>"/></td>
	  	</tr>
	    <tr>
		    <th width="120"><?php echo lang('page_size')?></th>
		    <td class="y-bg"><input type="text" class="input-text" name="setting[page_size]"  size="5"   value="<?php echo $page_size?>"/></td>
	  	</tr>
	  	<tr>
		    <th width="120"><?php echo lang('upload_max_size')?></th>
		    <td class="y-bg"><input type="text" class="input-text" name="setting[upload_max_size]"  size="10" value="<?php echo $upload_max_size?>"/></td>
	  	</tr>
	  	<tr>
		    <th width="120">theme</th>
		    <td class="y-bg"><input type="text" class="input-text" name="setting[theme]"  size="20" value="<?php echo $theme?>"/></td>
	  	</tr>
	  	<tr>
		    <th width="120">admin_folder</th>
		    <td class="y-bg"><input type="text" class="input-text" name="setting[admin_folder]"  size="20" value="<?php echo $admin_folder?>"/></td>
	  	</tr>
	  	<tr>
		    <th width="120">注册发送手机验证码</th>
		    <td class="y-bg">
		    	<select name="setting[captcha_register]">
		    		<option value="0" <?php if($captcha_register == 0) echo 'selected' ?> >关闭</option>
		    		<option value="1" <?php if($captcha_register == 1) echo 'selected' ?> >开启</option>
		    	</select>
		    </td>
	  	</tr>
</table>
</div>
<div id="div_setting_2" class="contentList pad-10 hidden">
<table width="100%"  class="table_form">
		<tr>

			<th width="100">今日市场奖</th>
		    <td class="y-bg"><input type="text" name="setting[market_bonus1]"  size="10" value="<?php echo $market_bonus?>"/></td>
			</td>
		</tr>
		<tr>
			<th width="100">一个倍投账号费用</th>
	    	<td class="y-bg"><input type="text" name="setting[buy_one_cast]"  size="10" value="<?php echo $buy_one_cast?>"/>
	    	</td>
		</tr>
		<tr>
			<th width="100">副账户数量</th>
	    	<td class="y-bg"><input type="text" name="setting[register_create_num]"  size="10" value="<?php echo $register_create_num?>"/>
	    	</td>
		</tr>
		<tr>
			<th width="100">推荐奖金</th>
	    	<td class="y-bg"><input type="text" name="setting[recommend_bonus]"  size="10" value="<?php echo $recommend_bonus?>"/>
	    	</td>
		</tr>
		<tr>
			<th width="100">市场奖金</th>
	    	<td class="y-bg"><input type="text" name="setting[market_bonus2]"  size="10" value="<?php echo $market_bonus?>"/>
	    	</td>
		</tr>
		<tr>
			<th width="100">系统奖金</th>
	    	<td class="y-bg"><input type="text" name="setting[system_bonus]"  size="10" value="<?php echo $system_bonus?>"/>
	    	</td>
		</tr>

		<tr>
			<th width="100">最大奖金</th>
	    	<td class="y-bg">
			<input type="text" name="setting[all_bonus]"  size="10" value="<?php echo $all_bonus?>"/>
	    	<input type="hidden" name="setting[bonus_max]"  size="10" value="<?php echo $bonus_max?>"/>
	    	</td>
		</tr>
		<tr>
			<th width="100">激活奖金</th>
	    	<td class="y-bg"><input type="text" name="setting[active_money]"  size="10" value="<?php echo $active_money?>"/>
	    	</td>
		</tr>

</table>
</div>

<div id="div_setting_3" class="contentList pad-10 hidden">
	<table width="100%" class="table_form" >
		<tr>
			<th width="120"><?php echo lang('codeTplId')?></th>
			<td>
				<input type="text" name="setting[codeTplId]"  value="<?=$sms_config['codeTplId']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('msgTplId')?></th>
			<td>
				<input type="text" name="setting[msgTplId]"  value="<?=$sms_config['msgTplId']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('accountSid')?></th>
			<td>
				<input type="text" name="setting[accountSid]" size="35" value="<?=$sms_config['accountSid']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('accountToken')?></th>
			<td>
				<input type="text" name="setting[accountToken]" size="35"  value="<?=$sms_config['accountToken']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('appId')?></th>
			<td>
				<input type="text" name="setting[appId]" size="35"  value="<?=$sms_config['appId']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('serverIP')?></th>
			<td>
				<input type="text" name="setting[serverIP]"  value="<?=$sms_config['serverIP']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('serverPort')?></th>
			<td>
				<input type="text" name="setting[serverPort]"  value="<?=$sms_config['serverPort']?>" />
			</td>
		</tr>
		<tr>
			<th width="120"><?php echo lang('softVersion')?></th>
			<td>
				<input type="text" name="setting[softVersion]"  value="<?=$sms_config['softVersion']?>" />
			</td>
		</tr>
	</table>
</div>

<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="button">
</div>
</div>
</form>
</body>
<script type="text/javascript">

function SwapTab(name,cls_show,cls_hide,cnt,cur){
    for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}

function showsmtp(obj,hiddenid){
	hiddenid = hiddenid ? hiddenid : 'smtpcfg';
	var status = $(obj).val();
	if(status == 1) $("#"+hiddenid).show();
	else  $("#"+hiddenid).hide();
}
function test_mail() {
	var mail_type = $('input[checkbox=mail_type][checked]').val();
	var mail_auth = $('input[checkbox=mail_auth][checked]').val();
    $.post('?m=admin&c=setting&a=public_test_mail&mail_to='+$('#mail_to').val(),{mail_type:mail_type,mail_server:$('#mail_server').val(),mail_port:$('#mail_port').val(),mail_user:$('#mail_user').val(),mail_password:$('#mail_password').val(),mail_auth:mail_auth,mail_from:$('#mail_from').val()}, function(data){
	alert(data);
	});
}
</script>
</html>