<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">倍投账号购买</h1>
</header>
<div class="mui-content">
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">当前可用向日葵积分为<?=$user_money?>个</p>
        <form action="<?= site_url('user_cast/castBuy') ?>" id="myForm" method="post" style="margin-top: 0.3rem;">
            <div class="mui-input-row mui-input-group">
                <label>购买份数</label>
                <input class="mui-input-clear" name="cast_num" id="cast_num" type="text" placeholder="请输入购买份数">
            </div>

            <small id="prompt" style="margin: 0.2rem 0 0 0.2rem;color: #f00;display: none;">输入的份数超过期望的份数</small>
            <div style="margin: 0.5rem;">
                <button type="button" id="buy_cast_btn" class="mui-btn my-btn-block-green-1">确认购买</button>
            </div>
        </form>

        <p class="importance"><img src="<?= theme_img('icon/icon_importance.png') ?>"/>购买倍投账号每份需要<?=config_item('active_money')?>个向日葵积分。</p>
        <p class="importance"><img src="<?= theme_img('icon/icon_importance.png') ?>"/>根据综合评分：您目前限制在50000个账号。现在还可以购买50000个账号。建议多对冲市场，少提现金有益扩大账号
        </p>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function ($, doc) {
        $.init();
        var castNum = doc.getElementById('cast_num');
        var buy_cast_btn = doc.getElementById('buy_cast_btn');
        var prompt = doc.getElementById('prompt');
        var myForm = doc.getElementById('myForm');
        // 验证购买的倍投份数是否超过期望值
        castNum.addEventListener('keyup', function () {
            var cast_num = castNum.value;
            $.ajax({
                type: "post",
                url: "<?=site_url('user_cast/isMoneyEnough')?>",
                data: {
                    cast_num: cast_num
                },
                success: function (rs) {
                    rs = $.parseJSON(rs);
                    if (rs.status == 1) {
                        buy_cast_btn.disabled = true;
                        prompt.style.display = "block";
                    }
                    if (rs.status == 0) {
                        buy_cast_btn.disabled = false;
                        prompt.style.display = "none";

                        buy_cast_btn.addEventListener('click', function () {
                            myForm.submit();
                        });
                    }
                },
                error: function () {

                }
            });
        })
    }(mui, document));
</script>
</html>
