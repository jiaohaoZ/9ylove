<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
$this->load->view('mobile/footer_tpl');
?>

<link href="<?= theme_css('iconfont.css') ?>" rel="stylesheet"/>
<link href="<?= theme_css('dropload.css') ?>" rel="stylesheet">

<style>
    .my-activate {
        color: #fff;
        background-color: #4d90e7;
        border-color: #4d90e7;
        -webkit-transition: background-color 0.2s;
    }
</style>
<body id="account">

<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <div id="segmentedControl" class="mui-segmented-control tab">
        <a id="yjzh" class="mui-control-item item cur <?php echo isset($_GET['active']) ? '' : 'mui-active'; ?>"
           href="#yijiu">
            向日葵账户
        </a>
        <a class="mui-control-item item <?php echo isset($_GET['active']) ? 'mui-active' : ''; ?>" href="#beitou">
            倍投账户
        </a>
    </div>
    <a href="#popover" class="mui-icon mui-icon mui-icon-plusempty mui-pull-right"></a>
</header>

<div id="popover" class="mui-popover">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell">
            <a id="popoverBtn">
                <span class="label"><img src="<?= theme_img('icon/icon_assistant.png') ?>"/></span>收积分助手</a>
        </li>
        <li class="mui-table-view-cell">
            <a href="<?= site_url('user_cast/castBuy') ?>">
                <span class="label"><img src="<?= theme_img('icon/icon_extra_add.png') ?>"/></span>倍投账号购买</a>
        </li>
    </ul>
</div>
<div id="popover2" class="mui-popover">
    <ul>
        <li>
            <a href="<?= site_url('money/moneyExchange?type=1') ?>">
                <img src="<?= theme_img('icon/icon_jinbi.png') ?>"/>
                <p>收推荐奖+市场奖</p>
            </a>
        </li>
        <li>
            <a href="<?= site_url('money/moneyExchange?type=2') ?>" >
                <img src="<?= theme_img('icon/icon_yijiubi.png') ?>"/>
                <p>收推荐奖为向日葵积分</p>
            </a>
        </li>
        <li>
            <a href="<?= site_url('money/moneyExchange?type=3') ?>" >
                <img src="<?= theme_img('icon/icon_yijiubi.png') ?>"/>
                <p>收市场奖为向日葵积分</p>
            </a>
        </li>
        <li>
            <a href="<?= site_url('money/moneyExchange?type=4') ?>">
                <img src="<?= theme_img('icon/icon_gouwubi.png') ?>"/>
                <p>收市场奖为购物积分</p>
            </a>
        </li>
    </ul>
</div>
<div id="popover3" class="mui-popover">
    <ul>
        <li>
            <a href="<?= site_url('money/castMoneyExchange?type=5') ?>">
                <img src="<?= theme_img('icon/icon_jinbi.png') ?>"/>
                <p>收市场奖为爱心积分</p>
            </a>
        </li>
        <li>
            <a href="<?= site_url('money/castMoneyExchange?type=6') ?>">
                <img src="<?= theme_img('icon/icon_yijiubi.png') ?>"/>
                <p>收市场奖为向日葵积分</p>
            </a>
        </li>
        <li>
            <a href="<?= site_url('money/castMoneyExchange?type=7') ?>">
                <img src="<?= theme_img('icon/icon_gouwubi.png') ?>"/>
                <p>收市场奖为购物积分</p>
            </a>
        </li>
    </ul>
</div>

<div class="mui-content load-content" style="padding-top: 60px;">
    <div id="yijiu" class="mui-control-content <?php echo isset($_GET['active']) ? '' : 'mui-active'; ?>">
        <div class="top-bar">
            <div class="item">
                <span class="label">未收推荐奖：</span>
                <span class="num">￥<?=$no['account']['recommend']?></span>
            </div>
            <div class="item">
                <span class="label">未收市场奖：</span>
                <span class="num">￥<?=$no['account']['market']?></span>
            </div>
        </div>

        <ul class="mui-table-view my-list lists">
            <?php if (isset($lists[0])) { ?>
                <?php foreach ($lists as $val) { ?>
                    <li class="mui-table-view-cell my-cell">
                        <a href="<?= $val['href'] ?>">
                            <div class="wrap-1">
                                <p class="mui-pull-left name"><?= $val['user_name'] ?></p>
                                <?php if($val['status'] == 2) {?>
                                    <p class="mui-pull-right active">已激活</p>
                                <?php } else {?>
                                    <p class="mui-pull-right status">停止</p>
                                <?php }?>
                            </div>
                            <div class="wrap-2 mui-row">
                                <div class="mui-col-sm-4 mui-col-xs-4">
                                    <p class="label">推荐奖</p>
                                    <p class="num"><?= $val['recommend_bonus'] ?></p>
                                </div>
                                <div class="mui-col-sm-4 mui-col-xs-4 textcenter">
                                    <p class="label">当前市场奖</p>
                                    <p class="num"><?= $val['market_bonus'] ?></p>
                                </div>
                                <div class="mui-col-sm-4 mui-col-xs-4 textright">
                                    <?php if($val['status'] == 2) {?>
                                        <p class="label">市场奖励记录</p>
                                        <p class="num"><?= $val['market_bonus_total'] ?></p>
                                    <?php } else {?>
                                        <button class="mui-btn my-btn-green-1" <?=$val['disabled']?>>激活</button>
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>

    </div>


    <div id="beitou" class="mui-control-content  <?php echo isset($_GET['active']) ? 'mui-active' : ''; ?>">
        <div class="top-bar">
            <div class="item">
                <span class="label">倍投分数：</span>
                <span class="num"><?=$no['cast']['cast']?></span>
            </div>
            <div class="item">
                <span class="label">未收市场奖：</span>
                <span class="num">￥<?=$no['cast']['market']?></span>
            </div>
        </div>


        <ul class="mui-table-view my-list lists">
            <?php if (isset($castList[0])) { ?>
                <?php foreach ($castList as $val) { ?>
                    <li class="mui-table-view-cell my-cell">
                        <div class="wrap-1">
                            <p class="mui-pull-left name"><?= $val['cast_name'] ?></p>
                            <?php if($val['status'] == 0) {?>
                                <p class="mui-pull-right active">已激活</p>
                            <?php } else {?>
                                <p class="mui-pull-right status">停止</p>
                            <?php }?>
                        </div>
                        <div class="wrap-2 mui-row">
                            <div class="mui-col-sm-4 mui-col-xs-4">
                                <p class="label">份数</p>
                                <p class="num"><?= $val['cast_num'] ?></p>
                            </div>
                            <div class="mui-col-sm-4 mui-col-xs-4 textcenter">
                                <p class="label">当前市场奖</p>
                                <p class="num"><?= $val['market_bonus'] ?></p>
                            </div>
                            <div class="mui-col-sm-4 mui-col-xs-4 textright">
                                <?php if($val['status'] == 0) {?>
                                    <p class="label">市场奖记录</p>
                                    <p class="num"><?= $val['market_bonus_total'] ?></p>
                                <?php } else {?>
                                    <button class="mui-btn my-btn-green-1" >激活</button>
                                <?php }?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>

    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    mui.init();

</script>
<!--滚动加载-->
<script src="<?= theme_js('dropload.min.js') ?>"></script>

<script>
    (function ($, doc) {
        mui.init();
        document.getElementById('popoverBtn').addEventListener('tap', function () {
            if (document.getElementById('yjzh').classList.contains('mui-active')) {
                mui('#popover2').popover('show');
            } else {
                mui('#popover3').popover('show');
            }
        });
        $('.index-footer-bar').on('tap', '.mui-tab-item', function () {
            var href = this.getAttribute('href');
            window.location.href = href;
        })
    }(mui, document));

    // 滚动加载
    $(function () {
    	if(document.getElementById('yjzh').classList.contains('mui-active')){
    		var itemIndex = 0;
    	}else{
    		var itemIndex = 1;
    	}
        
        var tab1LoadEnd = false;
        var tab2LoadEnd = false;
        // tab
        $('.tab').on('tap', '.item', function () {
            var $this = $(this);
            itemIndex = $this.index();
            console.log(itemIndex);
            $this.addClass('cur').siblings('.item').removeClass('cur');
            $('.lists').eq(itemIndex).show().siblings('.lists').hide();

            // 如果选中菜单一
            if (itemIndex == '0') {
                // 如果数据没有加载完
                if (!tab1LoadEnd) {
                    // 解锁
                    dropload.unlock();
                    dropload.noData(false);
                } else {
                    // 锁定
                    dropload.lock('down');
                    dropload.noData();
                }
                // 如果选中菜单二
            } else if (itemIndex == '1') {
                if (!tab2LoadEnd) {
                    // 解锁
                    dropload.unlock();
                    dropload.noData(false);
                } else {
                    // 锁定
                    dropload.lock('down');
                    dropload.noData();
                }
            }
            // 重置
            setTimeout(function(){dropload.resetload(),100})
        });
			
			var num = 1;
			var cast_num = 1;
			var dropload = $('.load-content').dropload({
                scrollArea: window,
                loadDownFn: function (me) {
                   if(itemIndex == '0'){
                   	num++;
                    $.ajax({
                        type: 'post',
                        url: "<?=site_url('home/account_load')?>",
                        data: {
                            page: num
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == 0) {
                                me.lock();
                                me.noData();
                                me.resetload();
                                return;
                            }
                            var result = '';
                            for (var i = 0; i < data.lists.length; i++) {
                                var status_str = '';
                                if(data.lists[i].status == 2) {
                                    status_str = '<p class="mui-pull-right active">已激活</p>';
                                } else {
                                    status_str = '<p class="mui-pull-right status">停止</p>';
                                }

                                var string = '';
                                if(data.lists[i].status == 2) {
                                    string = '<p class="label">市场奖励记录</p><p class="num">'+data.lists[i].market_bonus_total+'</p>';
                                } else {
                                    string = '<button class="mui-btn my-btn-green-1" '+data.lists[i].disabled+'>激活</button>';
                                }

                                result += '<li class="mui-table-view-cell my-cell">';
                                result += '<a href="' + data.lists[i].href + '">';
                                result += '<div class="wrap-1"><p class="mui-pull-left name">' + data.lists[i].user_name + '</p>'+status_str+'</div>';
                                result += '<div class="wrap-2 mui-row">';
                                result += '<div class="mui-col-sm-4 mui-col-xs-4"><p class="label">推荐奖</p><p class="num">' + data.lists[i].recommend_bonus + '</p></div>';
                                result += '<div class="mui-col-sm-4 mui-col-xs-4 textcenter"><p class="label">当前市场奖</p><p class="num">' + data.lists[i].market_bonus + '</p></div>';
                                result += '<div class="mui-col-sm-4 mui-col-xs-4 textright">'+string+'</div>';
                                result += '</div></a></li>';
                            }

                            $('.lists').eq(0).append(result);
                            // 每次数据加载完，必须重置
                            me.resetload();
                        },

                        error: function (xhr, type) {
                            // 即使加载出错，也得重置
                            me.resetload();
                        }
                    });
                    // 加载菜单二的数据
                   }else if(itemIndex == '1'){
                   		cast_num++;
	                    $.ajax({
	                        type: 'post',
	                        url: "<?=site_url('home/cast_load')?>",
	                        data: {
	                            page: cast_num
	                        },
	                        dataType: 'json',
	                        success: function (data) {
                                if (data.status == 0) {
                                    me.lock();
                                    me.noData();
                                    me.resetload();
                                    return;
                                }
	                            var result = '';
	                            for (var i = 0; i < data.castList.length; i++) {

                                    var status_str = '';
                                    if(data.castList[i].status == 0) {
                                        status_str = '<p class="mui-pull-right active">已激活</p>';
                                    } else {
                                        status_str = '<p class="mui-pull-right status">停止</p>';
                                    }

                                    var string = '';
                                    if(data.castList[i].status == 0) {
                                        string = '<p class="label">市场奖记录</p><p class="num">'+data.castList[i].market_bonus_total+'</p>';
                                    } else {
                                        string = '<button class="mui-btn my-btn-green-1" >激活</button>';
                                    }

	                                result += '<li class="mui-table-view-cell my-cell">';
	                                result += '<div class="wrap-1"><p class="mui-pull-left name">' + data.castList[i].cast_name + '</p>'+status_str+'</div>';
	                                result += '<div class="wrap-2 mui-row">';
	                                result += '<div class="mui-col-sm-4 mui-col-xs-4"><p class="label">份数</p><p class="num">' + data.castList[i].cast_num + '</p></div>';
	                                result += '<div class="mui-col-sm-4 mui-col-xs-4 textcenter"><p class="label">当前市场奖</p><p class="num">' + data.castList[i].market_bonus + '</p></div>';
	                                result += '<div class="mui-col-sm-4 mui-col-xs-4 textright">'+string+'</div>';
	                                result += '</div></li>';
	                            }
	
	                            $('.lists').eq(1).append(result);
	                            // 每次数据加载完，必须重置
	                            me.resetload();
	                        },
	
	                        error: function (xhr, type) {
	                            // 即使加载出错，也得重置
	                            me.resetload();
	                        }
	                    });
                   }
                }
            })

    });

</script>

</html>