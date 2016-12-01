<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
$this->load->view('mobile/footer_tpl');
?>
<link href="<?=theme_css('iconfont.css') ?>" rel="stylesheet"/>

<body id="home">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <h1 class="mui-title">向日葵爱心助学计划</h1>
    <a href="#popover" class="mui-icon mui-icon mui-icon-plusempty mui-pull-right"></a>
</header>

<div id="popover" class="mui-popover">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell">
            <a href="<?=site_url('home/inviteFriends')?>"><span class="label"><img src="<?=theme_img('/icon/icon_invite.png')?>"/></span>邀请好友</a>
        </li>
        <li class="mui-table-view-cell">
            <a href="<?=site_url('user_cast/castBuy')?>"><span class="label"><img src="<?=theme_img('/icon/icon_extra_add.png')?>"/></span>倍投账号购买</a>
        </li>
    </ul>
</div>

<div class="mui-content">
    <div class="reward">
        <div class="today">
            <p class="label">今日市场奖励已达</p>
            <p class="num"><?=$today_market_bonus?></p>
        </div>
        <div class="nav-1">
            <a class="item">
                <p class="label">昨日市场奖</p>
                <p class="num"><?=$yesterday_market_bonus?></p>
            </a>
            <a class="item">
                <p class="label">今日推荐奖</p>
                <p class="num"><?=$today_recommend_bonus?></p>
            </a>
        </div>
    </div>

    <div class="nav-2" style="margin-top: 0.3rem;">
        <a class="item"  href="<?=site_url('pay')?>">
            <span class="label"><img src="<?=theme_img('icon/icon_topup.png')?>"/></span>
            <span class="num">充值</span>
        </a>
        <a class="item" href="<?=site_url('home/inviteFriends')?>">
            <span class="label"><img src="<?=theme_img('icon/icon_invite2.png')?>"/></span>
            <span class="num">邀请好友</span>
        </a>
        <a class="item" href="<?=site_url('user_transfer/transfer_record')?>">
            <span class="label"><img src="<?=theme_img('icon/icon_transaction_history2.png')?>"/></span>
            <span class="num">交易记录</span>
        </a>
    </div>
    <div id="slider" class="mui-slider" style="background-color: #f5f5f5; margin-top: 0.3rem;">
        <div class="mui-slider-group">
            <!-- 第一张 -->
            <?php if(is_array($slides)) {?>
                <?php foreach ($slides as $val) {?>
                    <div class="mui-slider-item">
                        <a href="#">
                            <img src="<?=base_url($val['image'])?>">
                        </a>
                    </div>
                <?php }?>
            <?php }?>
        </div>
        <div class="mui-slider-indicator">
            <div class="mui-indicator mui-active"></div>
            <div class="mui-indicator"></div>
        </div>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({

        });
        $('#slider').slider({
            interval: 5000
        })

    }(mui, document));
</script>


</html>