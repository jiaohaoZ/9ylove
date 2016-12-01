<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>
<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">账户激活</h1>
</header>
<div class="mui-content">
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">向日葵积分：<?= $user_money ?></p>
        <form id="myForm" style="margin-top: 0.3rem;" action="<?= site_url('home/accountActivationPay') ?>"
              method="post">
            <div class="mui-input-row mui-input-group">
                <label>请输入密码</label>
                <input class="mui-input-clear" type="password" name="pay_password" id="pay_password" placeholder="支付密码为6位数">
            </div>
            <div style="margin: 0.5rem;">
                <input type="hidden" name="user_id" id="user_id" value="<?= $_GET['user_id'] ?>">
                <button class="mui-btn my-btn-block-green-1" type="button" id="confirm_pay">确认支付</button>
            </div>
        </form>

    </div>
</div>
</body>


<script type="text/javascript" charset="utf-8">
    (function ($, doc) {
        $.init();
        var confirm_pay = doc.getElementById('confirm_pay');
        var myForm = doc.getElementById('myForm');
        var user_id = doc.getElementById('user_id').value;
        confirm_pay.addEventListener('click', function (event) {
            //判断密码
            var pay_password = doc.getElementById('pay_password').value;
            if (pay_password.length < 6) {
                mui.toast('支付密码长度不能小于6位');
                event.preventDefault();
                return;
            }

            //判断余额是否充足
            $.ajax({
                type: "post",
                url: "<?php echo site_url('home/isMoneyEnough')?>",
                data: {
                    user_id: user_id
                },
                success: function (result) {
                    result = $.parseJSON(result);
                    if (result.status == 1) {
                        //余额不足
                        var btnArray = ['取消', '确定'];
                        mui.confirm('账户余额不足，去往充值页面充值？', '提示', btnArray, function (e) {
                            if (e.index == 1) {
                                //确认执行内容
                                window.location.href = '<?=site_url('home/recharge')?>';
                            } else {
                                //取消执行内容
                            }
                        });
                        return false;
                    } else {
                        myForm.submit();
                    }
                }
            });
        });
    }(mui, document));
</script>
</html>