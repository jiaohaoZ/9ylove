<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>
<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">设置支付密码</h1>
</header>
<div class="mui-content">
    <form action="<?=site_url('home/setPayPassword')?>" method="post">
        <div class="mui-input-group" style="margin-top: 0.3rem;">
            <div class="mui-input-row">
                <label>输入密码</label>
                <input class="mui-input-password" name="password" id="password" type="password" placeholder="请输入支付密码（6位数字）">
            </div>
            <div class="mui-input-row">
                <label>确认密码</label>
                <input class="mui-input-password" name="confirmPassword" id="confirmPassword" type="password" placeholder="请确认支付密码">
            </div>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']?>">
        <div style="margin: 0.5rem;">
            <button type="submit" id="set_password_submit" class="mui-btn my-btn-block-green-1">提交</button>
        </div>
    </form>
</div>
</body>


<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init();
        var set_password_submit = doc.getElementById('set_password_submit');

        set_password_submit.addEventListener('click', function(event) {
            var password = doc.getElementById('password').value;
            var confirmPassword = doc.getElementById('confirmPassword').value;
            if (password.length < 6) {
                mui.toast('支付密码长度不能小于6位');
                event.preventDefault();
                return;
            }

            if (password != confirmPassword) {
                mui.toast('密码两次输入不一致');
                event.preventDefault();
                return;
            }
        });
    }(mui, document));
</script>
</html>