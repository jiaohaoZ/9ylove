<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a href="<?php echo site_url('user/index') ?>" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">个人信息</h1>
	</header>
	<div class="mui-content">
		<ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li id="avator-img" class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_icon');?>">
	            <span class="num avator">头像</span>
	            <span class="pull-right avator"><img id="img-url" src="<?php echo base_url($portrait); ?>"/></span>
	            </a>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?=site_url('home/inviteFriendsQRCode')?>">
	            <span class="num">我的二维码</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right qrcode"><img src="<?php echo theme_img('icon/icon_qrcode.png') ?>" /></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	            <span class="num">推荐号</span>
	            <span class="pull-right"><?php if(isset($parent_name)){echo $parent_name;} ?></span>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	            <span class="num">登录号</span>
	            <span class="pull-right"><?php echo $user_name; ?></span>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	            <span class="num">会员等级</span>
	            <span class="pull-right"><?php if(isset($user_rank)){echo 'Lv.'.$user_rank;}?></span>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_info_type?type=nick_name') ?>">
	            <span class="num">昵称</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right"><?php if(!empty($nick_name)){echo $nick_name;} ?></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_info_type?type=gender') ?>">
	            <span class="num">性别</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right"><?php if(!empty($gender)){if($gender ==1 ){echo '男';}else{echo '女';}} ?></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_info_type?type=qq') ?>">
	            <span class="num">QQ</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right"><?php if(!empty($qq)){echo $qq;} ?></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_info_type?type=wechat') ?>">
	            <span class="num">微信</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right"><?php if(!empty($wechat)){echo $wechat;} ?></span>
	            </a>
	        </li>
	    </ul>
	</div>
</body>

<script type="text/javascript" charset="utf-8">
(function($, doc) {
	$.init({
		
	});
	
}(mui, document));

</script>

