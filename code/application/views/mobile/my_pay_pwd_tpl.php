<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">输入密码</h1>
	</header>
	<div class="mui-content">
		<form class="mui-input-group my-form" method="post" action="<?php echo site_url('user/pay_password') ?>" style="margin-top: 0.3rem;">
			<?php if (!empty($pay_password)): ?>
				<div class="mui-input-row">
					<label>原密码</label>
					<input class="mui-input-password" id="old_pwd" name="old_pwd" type="password" placeholder="请输入原密码">
				</div>
			<?php endif; ?>	
			<div class="mui-input-row">
				<label>新密码</label>
				<input class="mui-input-password" id="new_pwd" name="new_pwd" type="password" placeholder="请输入密码（6-20位字符）">
			</div>
			<div class="mui-input-row">
				<label>确认密码</label>
				<input class="mui-input-password" id="new_re_pwd" name="new_re_pwd" type="password" placeholder="请确认密码">
			</div>
			<div style="margin: 0.5rem;">
	    	<button id="subBtn" class="mui-btn my-btn-block-green-1">提交</button>
	    	</div>
		</form>
	</div>
</body>

<script type="text/javascript" charset="utf-8">
  	mui.init();
	document.getElementById('subBtn').addEventListener('click',function(event){
		var newVal = document.getElementById('new_pwd').value;
  		var newReVal = document.getElementById('new_re_pwd').value;
		if(!document.getElementById('old_pwd')){
			if(newVal.length == 0){
  			mui.toast('新密码不能为空');
  			event.preventDefault();
	  		}else if(newVal.length < 6){
	  			mui.toast('新密码不能少于6个字符');
	  			event.preventDefault();
	  		}else if(newVal.length > 20){
	  			mui.toast('新密码不能多于20个字符');
	  			event.preventDefault();
	  		}else if(newVal != newReVal){
	  			mui.toast('两次密码不相同');
	  			event.preventDefault();
	  		}
		}else{
			var oldVal = document.getElementById('old_pwd').value;
			if( oldVal.length == 0){
	  			mui.toast('原密码不能为空');
	  			event.preventDefault();
	  		}else if(newVal.length == 0){
		  			mui.toast('新密码不能为空');
		  			event.preventDefault();
		  		}else if(newVal.length < 6){
		  			mui.toast('新密码不能少于6个字符');
		  			event.preventDefault();
		  		}else if(newVal.length > 20){
		  			mui.toast('新密码不能多于20个字符');
		  			event.preventDefault();
		  		}else if(newVal != newReVal){
		  			mui.toast('两次密码不相同');
		  			event.preventDefault();
		  		}
		}
		

		


		// var a = document.getElementById('old_pwd');
		// if(a){
			

		// }
  		// var newVal = document.getElementById('new_pwd').value;
  		// var newReVal = document.getElementById('new_re_pwd').value;
  		// if(document.getElementById('old_pwd')){
  			
  		// }
  // 		if( oldVal.length == 0){
  // 			mui.toast('原密码不能为空');
  // 			event.preventDefault();
  // 		}else if(newVal.length == 0){
  // 			mui.toast('新密码不能为空');
  // 			event.preventDefault();
  // 		}else if(newVal.length < 6){
  // 			mui.toast('新密码不能少于6个字符');
  // 			event.preventDefault();
  // 		}else if(newVal.length > 20){
  // 			mui.toast('新密码不能多于20个字符');
  // 			event.preventDefault();
  // 		}else if(newVal != newReVal){
  // 			mui.toast('两次密码不相同');
  // 			event.preventDefault();
  // 		}
  		// alert(1);
  		
	});


</script>
