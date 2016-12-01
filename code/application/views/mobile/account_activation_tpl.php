<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>
<link href="<?=theme_css('iconfont.css') ?>" rel="stylesheet"/>
<body>
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title"><?=$user_name?></h1>
</header>
<div class="mui-content">
    <div class="reward">
        <div class="today">
            <p class="label">可用爱心积分</p>
            <p class="num"><?=intval($recommend_bonus + $market_bonus)?></p>
        </div>
        <div class="nav-1">
            <a class="item">
                <p class="label">当前推荐奖</p>
                <p class="num"><?=$recommend_bonus?></p>
            </a>
            <a class="item">
                <p class="label">当前市场奖</p>
                <p class="num"><?=$market_bonus?></p>
            </a>
        </div>
    </div>
    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
        <li class="mui-table-view-cell my-cell">
            <a href="#">
                <span class="label"><img src="<?=theme_img('icon/icon_total_bonus.png')?>"/></span>
                <span class="num">累计市场奖励</span>
                <span style="color: #999;" class="mui-pull-right number"><?=$market_bonus_total?></span>
            </a>
        </li>
        <li class="mui-table-view-cell my-cell">
            <a href="<?=site_url('home/bonusRecord/').$user_id?>">
                <span class="label"><img src="<?=theme_img('icon/icon_history.png')?>"/></span>
                <span class="num">奖金记录</span>
                <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
            </a>
        </li>
    </ul>
    <input name="user_id" id="user_id" value="<?=$user_id?>" type="hidden">
    <button id="activationBtn" class="my-btn-block-green-1 position-bottom">激活</button>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({

        });
        var pay_password = <?=$pay_password?>;
        //不存在支付密码，跳转设置支付密码
        if(!pay_password){
            document.getElementById("activationBtn").addEventListener('tap', function() {
                var btnArray = ['取消', '确定'];
                mui.confirm('您的账户还没设置支付密码，立即设置？', '提示', btnArray, function(e) {
                    if (e.index == 1) {
                        //确认执行内容
                        window.location.href="<?=site_url('home/setPayPassword?user_id=').$user_id?>";
                    } else {
                        //取消执行内容
                    }
                });
            });
        } else {
            document.getElementById("activationBtn").addEventListener('tap', function() {
                var btnArray = ['取消', '确定'];
                mui.confirm('您确定要激活吗？', '提示', btnArray, function(e) {
                 if (e.index == 1) {
                 //确认执行内容
                 window.location.href='<?=site_url('home/accountActivationPay?user_id=').$user_id?>';
                 } else {
                 //取消执行内容
                 }
                 });
            });
        }

    }(mui, document));
</script>


</html>