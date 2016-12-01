<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">验证手机</h1>
	</header>
	<div class="mui-content">
		<div>
			<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请输入你需要绑定的新手机号</p>
			<form class="mui-input-group my-form" name="form" method="post" action="<?php echo site_url('user/user_mobile_oper')?>" style="margin-top: 0.3rem;">
				<div class="mui-input-row">
					<label>手机</label>
					<input id="account" name="phone_num" class="mui-input-clear" type="text" placeholder="请输入手机号">
				</div>
				<div style="margin: 0.5rem;">
			    	<button id="codeBtn" type="button" class="mui-btn my-btn-block-green-1">获取验证码</button>
			    </div>
		 		<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请输入你收到的验证码</p>
				<div class="mui-input-row">
					<label>验证码</label>
					<input id="code" name="phone_yzm" class="mui-input-clear" type="text" placeholder="请输入验证码">
				</div>
				<div style="margin: 0.5rem;">
		    		<button id="subBtn" class="mui-btn my-btn-block-green-1">完成</button>
		    	</div>
			</form>	
	    </div>
	</div>
</body>


<script type="text/javascript" charset="utf-8">
  	mui.init();
  	var accountBox = document.getElementById('account');
	var codeButton=document.getElementById('codeBtn');
	/*获取验证码*/
		codeButton.addEventListener('click',function(event){
			var phoneInfo=accountBox.value;
			var result=validate.phone(phoneInfo,function(err){
				if (err) {
					mui.toast(err);
					return false;
				} else {
                    return true;
				}
			});
			if(!result){return}

			mui.toast('验证码发送成功');
			codeButton.disabled = true;
			var num=60;
			codeButton.innerHTML=num;
			var timer=setInterval(function(){
				num--;
				codeButton.innerHTML=num;
				if(num<0){
					clearInterval(timer);
					codeButton.innerHTML='获取验证码';
					codeButton.disabled = false;
				}
			},1000);
            //开始发送验证码
            mui.ajax({
                type : "post",
                url : "<?php echo site_url('sendsms/send_code')?>",
                data : {'mobile':phoneInfo},
                success: function(rs) {
                    console.log(rs);
                    return true;
                }
            })
		});


		document.getElementById('subBtn').addEventListener('click',function(event){
			var code = document.getElementById('code').value;
			if(code.length == 0){
				mui.toast('验证码不能为空');
  				event.preventDefault();
			}
		});
</script>
