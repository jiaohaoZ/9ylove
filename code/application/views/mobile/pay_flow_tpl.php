<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="recharge_details">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">确认订单</h1>
</header>
<div class="mui-content">
    <div>
        <div class="orders">
            <p>订单信息</p>
            <p>向日葵积分：<?=$money?>个</p>
            <p>需要支付：<span class="num"><?=$money?></span>（元）</p>
        </div>
        <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
            <li class="mui-table-view-cell my-cell">
                <span class="num">代理商</span>
                <span class="pull-right"><?=$info['user_name']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">手机号</span>
                <span class="pull-right"><?=$info['mobile']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">QQ</span>
                <span class="pull-right"><?=$info['qq']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">微信</span>
                <span class="pull-right"><?=$info['wechat']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">支付宝</span>
                <span class="pull-right"><?=$agent['alipay']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">银行卡</span>
                <span class="pull-right"><?=$agent['card_no']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">所属银行</span>
                <span class="pull-right"><?=$agent['bank']?></span>
            </li>
            <li class="mui-table-view-cell my-cell">
                <span class="num">银行开户地址</span>
                <span class="pull-right"><?=$agent['card_address']?></span>
            </li>
        </ul>
        <form name="form" action="<?=site_url('pay/done')?>" method="post">
            <input type="hidden" name="money" value="<?=$money?>">
            <input type="hidden" name="agent_id" value="<?=$agent['agent_id']?>">
        </form>
        <div style="margin: 0.5rem;">
            <button id="submitBtn" class="mui-btn my-btn-block-green-1">确认充值</button>
        </div>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({

        });
        document.getElementById('submitBtn').addEventListener('tap',function(){
            document.form.submit();
        })
    }(mui, document));
</script>

</html>
