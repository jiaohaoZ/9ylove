<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">确认转账</h1>
</header>
<div class="mui-content">
    <div id="user" class="user" style="background-color: #F5F5F5;">
        <div class="user-box">
            <div class="user-info">
                <div class="user-img">
                    <img src="<?=base_url().$portrait?>" alt="" />
                </div>
                <p style="color: #222;" class="user-name"><?=$user_name?></p>
                <p style="color: #222;" class="user-phone"><?=$mobile?></p>
            </div>
        </div>
    </div>
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">本次转账可转出<?=$self['user_money']?>个</p>
        <form class="mui-input-group" style="margin-top: 0.3rem;" action="<?= site_url('user_transfer/userTransferConfirm') ?>" method="post">
            <div class="mui-input-row">
                <label>转账积分数</label>
                <input class="mui-input-clear" id="money" name="money" type="text" placeholder="请输入转账积分数">
            </div>
            <div class="mui-input-row">
                <label>备注</label>
                <input class="mui-input-clear" id="transfer_desc" name="transfer_desc" type="text" placeholder="添加备注">
            </div>
        </form>
        <div style="margin: 0.5rem;">
            <button type="button" id="payBtn" disabled class="mui-btn my-btn-block-green-1">确认转账</button>
        </div>
    </div>
</div>
</body>


<script type="text/javascript" charset="utf-8">
//    mui.init();
    (function ($, doc) {
        $.init({});
        var money = document.getElementById('money');
        var payBtn = document.getElementById('payBtn');
        money.addEventListener('input', function () {
            if (money.value != '') {
                payBtn.disabled = false;
            } else {
                payBtn.disabled = true;
            }
        });

        document.getElementById('payBtn').addEventListener('tap', function () {
            var transfer_desc = document.getElementById('transfer_desc').value;
            var btnArray = ['取消', '确定'];
            mui.prompt('请输入支付密码', '请输入6位密码', '向日葵爱心', btnArray, function (e) {
                if (e.index == 1) {
                    $.ajax({
                        type: "post",
                        url: "<?=site_url('user_transfer/userTransferConfirm')?>",
                        data: {
                            money : money.value,
                            transfer_desc : transfer_desc,
                            transfer_user_id : "<?=$user_id?>",
                            transfer_user : "<?=$transfer_user?>",
                            transfer_before_money : "<?=$user_money?>",
                            pay_password: e.value
                        },
                        success: function (rs) {
                            rs = $.parseJSON(rs);
                            if (rs.status == 1) {
                                mui.alert('支付密码错误！');
                            }
                            if (rs.status == 4) {
                                mui.alert('账户余额不足！');
                            }
                            if (rs.status == 2) {
                                mui.alert('转账成功！', '提示信息', function () {
                                    window.location.href = "<?=site_url('user_transfer/myWallet')?>";
                                });
                            }
                            if(rs.status == 0) {
                                mui.alert('转账失败！');
                            }
                        },
                        error: function () {

                        }
                    });
                } else {
                    mui.toast('您取消了支付');
                }
            });
            document.querySelector('.mui-popup-input input').type='password';
        })

    }(mui, document));
</script>
</html>