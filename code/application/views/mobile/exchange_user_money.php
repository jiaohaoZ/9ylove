<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">兑换向日葵积分</h1>
</header>
<div class="mui-content">
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">当前可用爱心积分为<?=$gold_money?>个</p>
        <form action="" method="post" style="margin-top: 0.3rem;" id="myForm">
            <div class="mui-input-row mui-input-group">
                <label>兑换积分数</label>
                <input class="mui-input-clear" name="num" id="num" type="text" placeholder="请输入向日葵积分数量">
            </div>
            <div style="margin: 0.5rem;">
                <button type="button" id="btnConfirm" disabled class="mui-btn my-btn-block-green-1">确认兑换</button>
            </div>
        </form>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function ($, doc) {
        $.init();
        var num = doc.getElementById('num');
        var btnConfirm = doc.getElementById('btnConfirm');
        var myForm = doc.getElementById('myForm');
        var gold_money = Number(<?=$gold_money?>);
        // 未输入数量 提交按钮disable
        num.addEventListener('input', function () {
            if (num.value != '') {
                btnConfirm.disabled = false;
            } else {
                btnConfirm.disabled = true;
            }
        });


        // 监听按钮点击提交
        document.getElementById('btnConfirm').addEventListener('click', function () {
            if (num.value > gold_money) {
                mui.alert('您输入的积分数超过期望值！');
                return;
            }

            var btnArray = ['取消', '确定'];
            mui.prompt('请输入支付密码', '请输入6位密码', '向日葵爱心', btnArray, function (e) {
                if (e.index == 1) {
                    $.ajax({
                        type: "post",
                        url: "<?=site_url('money/exchangeUserMoney')?>",
                        data: {
                            num : num.value,
                            pay_password: e.value
                        },
                        success: function (rs) {
                            rs = $.parseJSON(rs);
                            if (rs.status == 1) {
                                mui.alert('支付密码错误！');
                            } else if (rs.status == 4) {
                                mui.alert('您输入的积分数超过期望值！');
                            } else if (rs.status == 2) {
                                mui.alert('兑换成功！', '提示信息', function () {
                                    window.location.href = "<?=site_url('user_transfer/myWallet')?>";
                                });
                            } else if (rs.status == 0) {
                                mui.alert('兑换失败！');
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
        });

    }(mui, document));
</script>
</html>