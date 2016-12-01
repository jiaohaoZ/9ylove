<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body>
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">爱心积分提现</h1>
</header>
<div class="mui-content">
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">本次最大可提现金额￥<?= $gold_money ?></p>
        <p style="text-align: center; font-size: 0.28rem;">注 : 提现金额必须为60的整数倍</p>
        <form class="" id="myForm" action="" method="post" style="margin-top: 0.3rem;">
            <div class="mui-input-group">
                <div class="mui-input-row">
                    <label>提现金额</label>
                    <input class="mui-input-clear" name="money" id="money" type="text" placeholder="请输入提现金额">
                </div>
                <div class="mui-input-row">
                    <label>选择银行卡</label>
                    <select name="user_card" id="user_card">
                        <?php if (isset($card[0])) { ?>
                            <?php foreach ($card as $val) { ?>
                                <option
                                    value="<?= $val['card_id'] ?>"><?= $val['bank_name'] ?><?= $val['card_no'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="mui-input-row">
                    <label>支付密码</label>
                    <input class="mui-input-password" id="pay_password" name="pay_password" type="password"
                           placeholder="请输入支付密码">
                </div>
            </div>

            <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
                <li class="mui-table-view-cell my-cell">
                    <span class="num">个人所得税</span>
                    <!--                    <input name="real_money" value="" type="text">-->
                    <span class="pull-right" id="personal_income">0</span>
                </li>

                <li class="mui-table-view-cell my-cell">
                    <span class="num">实际到账金额</span>
                    <span class="pull-right" id="real_money">￥0</span>
                </li>
            </ul>

            <div style="margin: 0.5rem;">
                <button type="button" disabled id="btnConfirm" class="mui-btn my-btn-block-green-1">确认提现</button>
            </div>
        </form>
    </div>
</div>
</body>


<script type="text/javascript" charset="utf-8">
    (function ($, doc) {
        $.init();
        var money = doc.getElementById('money');
        var btnConfirm = doc.getElementById('btnConfirm');
        var myForm = doc.getElementById('myForm');
        var gold_money = Number("<?=$gold_money?>");

        // 未输入金额 提交按钮disable
        money.addEventListener('input', function () {
            if (money.value != '') {
                btnConfirm.disabled = false;
            } else {
                btnConfirm.disabled = true;
            }
            // 计算个人所得税、实际到账
            var personal_income = doc.getElementById('personal_income').innerHTML = money.value * <?=$personal_income_config?> * 0.01;
            doc.getElementById('real_money').innerHTML = money.value - personal_income;
        });


        // 监听按钮点击提交
        document.getElementById('btnConfirm').addEventListener('click', function () {
            var card_id = doc.getElementById('user_card').value;
            var pay_password = doc.getElementById('pay_password').value;
            if (money.value > gold_money) {
                mui.alert('您输入的金额超过期望值！');
                return;
            }

            if (money.value < 60) {
                mui.alert('提现金额必须为60的整数倍！');
                return;
            }

            $.ajax({
                type: "post",
                url: "<?=site_url('user_withdrawals/userWithdrawalsConfirm')?>",
                data: {
                    pay_password: pay_password,
                    money: money.value,
                    personal_income: doc.getElementById('personal_income').innerHTML,
                    real_money: doc.getElementById('real_money').innerHTML,
                    card_id: card_id
                },
                success: function (rs) {
                    rs = $.parseJSON(rs);
                    if (rs.status == 4) {
                        mui.alert('您输入的金额超过期望值！');
                    } else if (rs.status == 1) {
                        mui.alert('支付密码错误！');
                    } else if (rs.status == 2) {
                        mui.alert('提现申请成功，请等待审核！', '提示信息', function () {
                            window.location.href = "<?=site_url('user_transfer/myWallet')?>";
                        });
                    } else if (rs.status == 0) {
                        mui.alert('提现失败！');
                    } else if (rs.status == 5) {
                        mui.alert('提现金额必须为60的整数倍！');
                    }
                },
                error: function () {

                }
            });
        });

    }(mui, document));
</script>
</html>