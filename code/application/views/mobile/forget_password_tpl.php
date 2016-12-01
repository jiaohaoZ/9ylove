<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body>
<header class="mui-bar mui-bar-nav nav-bg">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">忘记密码</h1>
    <a id="regLoginBtn" href="<?=site_url('secure/login')?>" class="mui-btn mui-btn-blue mui-btn-link mui-pull-right reg-login">登录</a>
</header>
<div class="mui-content">
    <form class="forget-password-box" style="margin-top: 0;" action="<?=site_url('secure/forgetPassword')?>" method="post">
        <div class="login-input-row">
            <input id="account" name="mobile" type="text" placeholder="输入手机号码"/>
            <span class="mui-icon mui-icon-phone"></span>
        </div>
        <div class="login-input-group">
            <input id="code" name="capthca_sms" type="text" placeholder="输入验证码"/>
            <button id="codeBtn" type="button" class="mui-btn my-btn-green-1">获取验证码</button>
        </div>
        <div class="login-input-row">
            <input id="password" name="password" type="password" placeholder="输入新密码"/>
            <span class="mui-icon mui-icon-locked"></span>
        </div>
        <div class="login-input-row">
            <input id="password_confirm" name="confirmPassword" type="password" placeholder="确认新密码"/>
            <span class="mui-icon mui-icon-locked"></span>
        </div>
        <div class="login-input-row">
            <button id="fg-login" type="submit" class="mui-btn my-btn-green-1 mui-btn-block" >找回密码</button>
        </div>
    </form>
</div>

</body>
<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init();

        var fgLoginButton = doc.getElementById('fg-login');
        var accountBox = doc.getElementById('account');
        var codeBox = doc.getElementById('code');
        var passwordBox = doc.getElementById('password');
        var passwordConfirmBox = doc.getElementById('password_confirm');
        var codeButton = doc.getElementById('codeBtn');
        /*获取验证码*/
        codeButton.addEventListener('click',function(event){
            var phoneInfo=accountBox.value;
            var result=validate.phone(phoneInfo,function(err){
                if (err) {
                    mui.toast(err);
                    return false;
                }else{
                    return true;
                }
            })
            if(!result){return};
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
                success: function(rs) {
                    console.log(rs);
                    return true;
                }
            })
        });
        fgLoginButton.addEventListener('click', function(event) {
            var forgetInfo = {
                account: accountBox.value,
                password: passwordBox.value,
                code:codeBox.value
            };
            var passwordConfirm = passwordConfirmBox.value;
            if (passwordConfirm != forgetInfo.password) {
                mui.toast('密码两次输入不一致');
                event.preventDefault();
                return;
            }
            validate.forget(forgetInfo, function(err) {
                if (err) {
                    mui(err);
                    event.preventDefault();
                    return;
                }else{
                    mui('成功找回密码');
                    return;
                }
            });
        });

    }(mui, document));
</script>
