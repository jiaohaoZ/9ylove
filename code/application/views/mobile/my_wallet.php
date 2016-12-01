<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a href="<?php echo site_url('user/index') ?>" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">我的钱包</h1>
</header>
<div class="mui-content">
    <div class="zc">
        <h4 class="tit">我的资产</h4>
        <ul class="nav-3">
            <li>
                <a class="item">
                    <div class="icon"><img src="<?=theme_img('icon/icon_yijiubi.png')?>"/></div>
                    <div class="text">
                        <p class="label">向日葵积分</p>
                        <p class="num"><?=$user_money?></p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item">
                    <div class="icon"><img src="<?=theme_img('icon/icon_jinbi.png')?>"/></div>
                    <div class="text">
                        <p class="label">爱心积分</p>
                        <p class="num"><?=$gold_money?></p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item">
                    <div class="icon"><img src="<?=theme_img('icon/icon_gouwubi.png')?>"/></div>
                    <div class="text">
                        <p class="label">购物积分</p>
                        <p class="num"><?=$shop_money?></p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="cz" style="margin-top: 0.3rem;">
        <h4 class="tit">常用操作</h4>
        <ul class="nav-3">
            <li>
                <a class="item" href="<?=site_url('pay')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_recharge.png')?>"/></div>
                    <div class="text">
                        <p class="label">充值</p>
                        <p class="num">充值向日葵积分</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('user_transfer/userTransfer')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_transfer.png')?>"/></div>
                    <div class="text">
                        <p class="label">转账</p>
                        <p class="num">转账给他人</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('money/moneyExchangeLogList')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_collection_record.png')?>"/></div>
                    <div class="text">
                        <p class="label">收积分记录</p>
                        <p class="num">收集积分</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('money/exchangeUserMoney')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_collection_3.png')?>"/></div>
                    <div class="text">
                        <p class="label">兑换向日葵积分</p>
                        <p class="num">爱心积分兑换向日葵积分</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('money/exchangeShopMoney')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_collection_2.png')?>"/></div>
                    <div class="text">
                        <p class="label">兑换购物积分</p>
                        <p class="num">爱心积分兑换购物积分</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('user_withdrawals/userWithdrawals')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_withdrawal2.png')?>"/></div>
                    <div class="text">
                        <p class="label">爱心积分提现</p>
                        <p class="num">提现到银行卡</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="jl" style="margin-top: 0.3rem;">
        <h4 class="tit">交易记录</h4>
        <ul class="nav-3">
            <li>
                <a class="item" href="<?=site_url('user_transfer/transfer_record')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_transaction_history.png')?>"/></div>
                    <div class="text">
                        <p class="label">交易记录</p>
                        <p class="num">转账记录</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('pay/pay_record')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_topup.png')?>"/></div>
                    <div class="text">
                        <p class="label">充值记录</p>
                        <p class="num">向日葵积分充值</p>
                    </div>
                </a>
            </li>
            <li>
                <a class="item" href="<?=site_url('user_withdrawals/withdrawals_record')?>">
                    <div class="icon"><img src="<?=theme_img('icon/icon_widthdrawal_history.png')?>"/></div>
                    <div class="text">
                        <p class="label">提现记录</p>
                        <p class="num">爱心积分提现</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({

        });
    }(mui, document));
</script>
</html>