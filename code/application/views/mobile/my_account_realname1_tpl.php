<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
 ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">实名认证</h1>
	</header>
	<div class="mui-content">
		<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请认真填写个人信息</p>
		<form class="mui-input-group my-form" style="margin-top: 0.3rem;" method="post" action="<?php echo site_url('user/my_realname1')?>">
			<div class="mui-input-row">
				<label>真实姓名</label>
				<input class="mui-input-clear" id="real_name" name="real_name" type="text" placeholder="请输入姓名">
			</div>
			<div class="mui-input-row">
				<label>身份证号</label>
				<input class="mui-input-clear" id="real_identity" name="real_identity" type="text" placeholder="请输入身份证号">
			</div>
			<div style="margin: 0.5rem; margin-bottom: 0;">
	    		<button id="subBtn" class="mui-btn my-btn-block-green-1">快速审核</button>
	    	</div>
		</form>
		
	    <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;margin: 0;">自动认证仅支持中国大陆用户，其他用户请进入</p>
	    <a href="<?php echo site_url('user/my_realname2') ?>" style="display: block;text-align: center; line-height: 0.4rem; font-size: 0.36rem;">人工认证</a>
	</div>
</body>

<script type="text/javascript" charset="utf-8">
  	mui.init();
  	


  	document.getElementById('subBtn').addEventListener('click',function(event){
  			var realName = document.getElementById('real_name').value;
  			var realIdentity = document.getElementById('real_identity').value;
			if(realName.length == 0){
				mui.toast('真实姓名不能为空');
  				event.preventDefault();
			}else if(realIdentity.length == 0){
				mui.toast('身份证号不能为空');
  				event.preventDefault();
			}else{
				var result=validate.identity(realIdentity,function(err){
				if (err) {
					mui.toast(err);
  					event.preventDefault();
				} else {
                    return true;
				}
			});
			if(!result){return}
			}

			
			  		
	});

</script>
</html>
