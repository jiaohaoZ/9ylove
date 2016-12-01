<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');
?>
<div id="main_frameid" class="pad-10"  style="_margin-right:-12px;_width:98.9%;">
<script type="text/javascript">
$(function(){if (!$.support.leadingWhitespace) $('#browserVersionAlert').show();});
</script>
<div class="explain-col mb10" style="display:none" id="browserVersionAlert">
<?=lang('ie8_tip')?></div>
<div class="col-2 lf mr10" style="width:48%">
	<h6><?=lang('personal_information')?></h6>
	<div class="content">
	<?=lang('main_hello')?><?=$real_name?><br />
	<?=lang('main_role')?><?=$role_name?><br />
	<div class="bk20 hr"><hr /></div>
	<?=lang('main_last_logintime')?><?=$last_login_time?><br />
	<?=lang('main_last_loginip')?><?=$last_login_ip?><br />
	</div>
</div>
<div class="bk10"></div>

</div>
</body></html>