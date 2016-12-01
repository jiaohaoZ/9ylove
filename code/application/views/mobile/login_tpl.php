<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<link href="<?=theme_css('login.css') ?>" rel="stylesheet"/>
<body>
<div class="mui-content login-box" id="login-box">
    <!--<img class="bg" src="../images/login/login_bg.png"/>-->
    <div class="logo-box-zw"></div>
    <div class="logo-box">
        <img class="login-logo" src="<?=theme_img('login/login-logo.png')?>"/>
        <!--<div class="user-img"><img src="../images/login/user-img.jpg"/></div>-->
    </div>
    <div class="login-form-box">
        <form name="login" class="mui-input-group login-form" action="<?=site_url('secure/login')?>" method="post">
            <div class="mui-input-row  pr">
                <label><span class="mui-icon mui-icon-contact"></span></label>
                <input id="account" name="user" type="text" class="mui-input-clear" placeholder="手机号 / 用户名">
            </div>
            <div class="mui-input-row password-row  pr">
                <label><span class="mui-icon mui-icon-locked"></span></label>
                <input id="password" name="password" type="password" class="mui-input-password" placeholder="密码">
            </div>
            <input type="hidden" name="redirect" value="<?=$redirect?>">
        </form>
    </div>
    <div class="btn-box">
        <div class="link-area">
            <a id='forgetPassword' href="<?=site_url('secure/forgetPassword')?>">忘记密码</a>
<!--            <a id='reg' href="--><?//=site_url('secure/register')?><!--">注册</a>-->
        </div>
        <button id='login' type="button" class="mui-btn my-btn-login-bg">立即登录</button>
    </div>

</div>
</body>
<script type="text/javascript">
    /*设置页面尺寸*/
    document.getElementById('login-box').style.width=window.innerWidth+"px";
    document.getElementById('login-box').style.height=window.innerHeight+"px";
</script>

<script type="text/javascript" charset="utf-8">
    mui.init();

    (function($, doc) {

        var loginButton = doc.getElementById('login');
        var accountBox = doc.getElementById('account');
        var passwordBox = doc.getElementById('password');
        var regButton = doc.getElementById('reg');
        var forgetButton = doc.getElementById('forgetPassword');
        loginButton.addEventListener('click', function(event) {
            var loginInfo = {
                account: accountBox.value,
                password: passwordBox.value
            };
            validate.login(loginInfo, function(err) {
                if (err) {/*验证不通过*/
                    mui.toast(err);
                    return;
                }else{/*验证通过*/
                    document.login.submit();
                }

            });
        });

    }(mui, document));
</script>
</html>
