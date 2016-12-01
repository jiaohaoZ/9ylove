<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="recharge_details">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">倍投购买确认</h1>
</header>
<div class="mui-content">
    <form action="<?= site_url('user_cast/castBuyConfirm') ?>" method="post">
        <div>
            <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
                <li class="mui-table-view-cell my-cell">
                    <span class="num">购买份数：</span>
                    <span class="pull-right"><?= $cast_num ?></span>
                </li>
                <li class="mui-table-view-cell my-cell">
                    <span class="num">向日葵积分：</span>
                    <span class="pull-right"><?= $reduce_user_money ?></span>
                </li>
                <li class="mui-table-view-cell my-cell">
                    <span class="num">扣积分账户：</span>
                    <span class="pull-right"><?= $_SESSION['user_name'] ?></span>
                </li>
                <li class="mui-table-view-cell my-cell">
                    <span class="num">账户名称：</span>
                    <span class="pull-right"><?= $cast_name ?></span>
                </li>
            </ul>
            <div style="margin: 0.5rem;">
                <button id="buyBtn" type="button" class="mui-btn my-btn-block-green-1">立即购买</button>
            </div>
        </div>
    </form>
</div>
</body>

<script type="text/javascript" charset="utf-8">

    (function ($, doc) {
        $.init({});
        document.getElementById('buyBtn').addEventListener('tap', function () {
            var btnArray = ['取消', '确定'];
            mui.prompt('请输入支付密码', '6位数', '向日葵爱心', btnArray, function (e) {
                if (e.index == 1) {
                    $.ajax({
                        type: "post",
                        url: "<?=site_url('user_cast/castBuyConfirm')?>",
                        data: {
                            cast_num: "<?= $cast_num ?>",
                            reduce_user_money: "<?= $reduce_user_money ?>",
                            user_name: "<?= $_SESSION['user_name'] ?>",
                            cast_name: "<?= $cast_name ?>",
                            pay_password: e.value
                        },
                        success: function (rs) {
                            rs = $.parseJSON(rs);
                            if (rs.status == 1) {
                                mui.alert('支付密码错误！');
                            }
                            if (rs.status == 2) {
                                mui.alert('倍投账号购买成功！', '提示信息', function () {
                                    window.location.href = "<?=site_url('home/account?active=1')?>";
                                });
                            }
                            if(rs.status == 0) {
                                mui.alert('倍投账号购买失败！');
                            }
                        },
                        error: function () {

                        }
                    });
//                    window.location.href = <?//=site_url('user_cast/castBuyConfirm')?>//;
                } else {
                    mui.toast('您取消了支付');
                }
            });
            document.querySelector('.mui-popup-input input').type='password';
        })

    }(mui, document));
</script>
</html>