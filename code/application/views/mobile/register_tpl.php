<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<link href="<?=theme_css('login.css') ?>" rel="stylesheet"/>
<body>
<header class="mui-bar mui-bar-nav nav-bg">
    <h1 class="mui-title">注册</h1>
    <a id="regLoginBtn" href="<?php echo site_url('secure/login')?>" class="mui-btn mui-btn-blue mui-btn-link mui-pull-right reg-login">登录</a>
</header>
<div class="mui-content">
    <div class="reg-logo">
        <img src="<?=theme_img('login/login-logo.png')?>"/>
    </div>
    <form class="reg-box" style="margin-top: 0;" action="<?=site_url('secure/register')?>" method="post">
		<?php if(isset($user_name)) {?>
			<p class="recommender">推荐人：<?=$user_name?></p>
		<?php } else {?>
			<p style="height: 0.5rem;visibility: hidden;">推荐人：</p>
		<?php }?>
		<input type="hidden" name="info[parent_id]" value="<?=$parent_id?>">
        <div class="login-input-row">
            <input id="accountName" name="info[user_name]" type="text" placeholder="用户名"/>
            <span class="mui-icon mui-icon-person"></span>
        </div>
        <div class="login-input-row">
            <input id="account" name="info[mobile]" type="text" placeholder="输入手机号码"/>
            <span class="mui-icon mui-icon-phone"></span>
        </div>
        <div class="login-input-group">
            <input id="code" name="info[capthca_sms]" type="text" placeholder="输入验证码"/>
            <button id="codeBtn" type="button" class="mui-btn my-btn-green-1">获取验证码</button>
        </div>
        <div class="login-input-row">
            <input id="password" name="info[password]" type="password"  placeholder="输入密码"/>
            <span class="mui-icon mui-icon-locked"></span>
        </div>
        <div class="login-input-row">
            <input id="password_confirm" name="info[confirmPassword]" type="password"  placeholder="输确认密码"/>
            <span class="mui-icon mui-icon-locked"></span>
        </div>
        <div class="login-input-row">
            <button type="submit" id="reg-next" class="mui-btn my-btn-green-1 mui-btn-block" >注册</button>
        </div>
        <div class="mui-input-row mui-checkbox mui-left protocol">
            <label style="width: auto;">注册即表示同意</label><a href="">向日葵爱心用户注册协议</a>
            <input name="info[protocol]" value="1" type="checkbox" checked="checked" >
        </div>
    </form>
</div>

</body>

<script type="text/javascript" charset="utf-8">
(function($, doc) {
		$.init();
	
		var regNextButton = doc.getElementById('reg-next');
		var accountNameBox=doc.getElementById('accountName');
		var accountBox = doc.getElementById('account');
		var passwordBox = doc.getElementById('password');
		var passwordConfirmBox = doc.getElementById('password_confirm');
		var codeBox = doc.getElementById('code');
		var codeButton=doc.getElementById('codeBtn');
		var regLoginButton =doc.getElementById('regLoginBtn');
		
		/*验证用户名是否存在事件*/
		accountNameBox.addEventListener('blur',function(){
			var accountName=accountNameBox.value;
			/*用户名长度小于3不验证*/
			if(accountName.length<3){return};
			$.ajax({
                type : "post",
                url : "<?=site_url('secure/issetUserName')?>",
                data : { user_name : accountName },
                success: function(rs) {
                	rs = $.parseJSON(rs);
                    if(rs.status == 0){
                    	regNextButton.disabled = false;
//                    	mui.toast('用户名可以使用');
                    };
                    if(rs.status == 1){
                    	regNextButton.disabled = true;
                    	mui.toast('用户名已存在');
                    }
                },
                error:function(){
                	
                }
            })
		})

		//验证手机号码是否存在
		accountBox.addEventListener('blur',function(){
			var mobile = accountBox.value;
			var result=validate.phone(mobile,function(err){
				if (err) {
					mui.toast(err);
					regNextButton.disabled = true;
					return false;
				} else {
                    return true;
				}
			});
			if(!result){return}
			$.ajax({
				type : "post",
				url : "<?=site_url('secure/issetMobile')?>",
				data : { mobile : mobile },
				success: function(rs) {
					rs = $.parseJSON(rs);
					if(rs.status == 1){
						regNextButton.disabled = true;
						mui.toast('手机号码已被注册！');
					}
					if(rs.status == 0){
						regNextButton.disabled = false;
					};
				},
				error:function(){

				}
			})
		})


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

            $.ajax({
                type : "post",
                url : "<?php echo site_url('sendsms/send_code?mobile=')?>"+phoneInfo,
                data : "",
                success: function(result) {
                    return true;
                }
            })
		});
		regNextButton.addEventListener('click', function(event) {
			var regInfo = {
				accountName:accountNameBox.value,
				account: accountBox.value,
				password: passwordBox.value,
				code:codeBox.value
			};
			var passwordConfirm = passwordConfirmBox.value;
			if (passwordConfirm != regInfo.password) {
				mui.toast('密码两次输入不一致');
				event.preventDefault();
				return;
			}
			validate.reg(regInfo, function(err) {
				if (err) {
					mui.toast(err);
					event.preventDefault();
					return;
				}else{
					mui.toast('验证通过');
				}
			});
		});
	
}(mui, document)); 
</script>
</html>