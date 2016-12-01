<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a href="<?php echo site_url('user/user_info') ?>" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">性别</h1>
	</header>
	<div class="mui-content">
		<div>
			<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请选择您的性别</p>
			<form class="mui-input-group" name="form" method="post" action="<?php echo site_url('user/user_info_type') ?>">
				<div class="mui-input-row mui-radio">
					<label>男</label>
					<input name="val" <?php if($gender == 1){echo 'checked';} ?> value="1" type="radio" >
				</div>
				<div class="mui-input-row mui-radio">
					<label>女</label>
					<input name="val" <?php if($gender == 2){echo 'checked';} ?> value="2" type="radio">
				</div>
				<input type="hidden" name="type" value="gender">
			</form>
			<div style="margin: 0.5rem;">
		    	<button id="submitBtn" class="mui-btn my-btn-block-green-1">保存</button>
		   </div>
		</div>
	</div>
</body>

<script type="text/javascript" charset="utf-8">
(function($, doc) {
	$.init({
		
	});
	document.getElementById('submitBtn').addEventListener('tap',function(){
		// console.log(document.getElementById('submitBtn').value.length)
		// if (document.getElementById('val').value.length==0) {return}
		document.form.submit();
	})
}(mui, document));
</script>
</html>