<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="home">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">邀请好友</h1>
</header>
<div class="mui-content">
    <div class="reward">
        <div class="today">
            <p class="label">今日邀请人数</p>
            <p class="num">0</p>
        </div>
        <div class="nav-1">
            <a class="item">
                <p class="label">累计邀请人数</p>
                <p class="num">0</p>
            </a>
            <a class="item">
                <p class="label">累计奖金</p>
                <p class="num">0</p>
            </a>
        </div>
    </div>
    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
        <li class="mui-table-view-cell my-cell"  id="shareBtn">
            <span class="label"><img src="<?= theme_img('icon/icon_share.png') ?>"/></span>
            <span class="num">分享到</span>
            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
        </li>

        <li class="mui-table-view-cell my-cell">
            <a href="<?= site_url('home/inviteFriendsQRCode') ?>">
                <span class="label"><img src="<?= theme_img('icon/icon_qrcode.png') ?>"/></span>
                <span class="num">我的二维码</span>
                <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
            </a>
        </li>
    </ul>
    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
        <li class="mui-table-view-cell my-cell">
            <a href="<?= site_url('home/inviteFriendsRecord') ?>">
                <span class="label"><img src="<?= theme_img('icon/icon_hist_invite.png') ?>"/></span>
                <span class="num">邀请记录</span>
                <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
            </a>
        </li>
    </ul>
	<div style="display: none;" id="nativeShare"></div>
</div>
</body>
<link href="<?=theme_css('nativeShare.css') ?>" rel="stylesheet"/>  
<script src="<?=theme_js('nativeShare.js')?>"></script>
<script type="text/javascript" charset="utf-8">
(function ($, doc) {
    $.init({});
    //分享插件目前该分享插件仅支持手机UC浏览器和QQ浏览器
	var config = {
        url:'http://blog.wangjunfeng.com',
        title:'向日葵爱心会员免费注册',
        desc:'向日葵爱心会员免费注册',
        img:'http://www.wangjunfeng.com/img/face.jpg',
        img_title:'向日葵爱心',
        from:'来自向日葵爱心'
    };
    var share_obj = new nativeShare('nativeShare',config);
    document.getElementById('shareBtn').addEventListener('tap',function(){
    	if(document.getElementById('more')){
    		document.getElementById('more').click();
    	}else{
    		mui.alert('请点击右上角分享按钮');
    	}
    })
}(mui, document));
</script>
</html>