<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a href="<?php echo site_url('user/user_info') ?>" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">QQ</h1>
	</header>
	<div class="mui-content">
		<div>
			<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请输入您的新QQ</p>
			<form class="mui-input-group" name="form" method="post" action="<?php echo site_url('user/user_info_type') ?>" style="margin-top: 0.3rem;">
				<div class="mui-input-row">
					<label>QQ</label>
					<input id="val" name="val" class="mui-input-clear" name="qq" type="text" value="<?php if(!empty($qq)){echo $qq;} ?>" placeholder="请输入QQ">
					<input type="hidden" name="type" value="qq">
				</div>
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

	document.getElementById('submitBtn').addEventListener('tap',function(event){
		var accountBox = document.getElementById('val');
		console.log(document.getElementById('submitBtn').value.length)
		if (document.getElementById('val').value.length==0) {mui.toast('qq号不能为空');
  				event.preventDefault();return}
			var qqInfo=accountBox.value;
			var result=validate.qq(qqInfo,function(err){
				if (err) {
					mui.toast(err);
  					event.preventDefault();
					return false;
				} else {
					document.form.submit();
				}
			});
	})
}(mui, document));
</script>
</html>