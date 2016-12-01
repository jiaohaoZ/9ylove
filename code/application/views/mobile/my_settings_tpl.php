<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		<a href="<?php echo site_url('user/index') ?>" class=" mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">设置</h1>
	</header>
	<div class="mui-content">
		<ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php if($is_real){echo site_url('user/my_realname2');}else{echo site_url('user/my_realname1');} ?>">
	            <span class="num">实名认证</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <?php if ($is_real == 0): ?>
	            	<span class="pull-right">未认证</span>   	
	            <?php endif ?>
	            <?php if ($is_real == 1): ?>
	            	<span class="pull-right">待审核</span>   	
	            <?php endif ?>
	            <?php if ($is_real == 2): ?>
	            	<span class="pull-right">已认证</span>   	
	            <?php endif ?>
	            </a>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_mobile') ?>">
	            <span class="num">手机号</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right"><?php if(!empty($mobile)) echo $mobile; ?></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_email') ?>">
	            <span class="num">邮箱</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            <span class="pull-right"><?php if(!empty($email)) echo $email; ?></span>
	            </a>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/normal_pwd') ?>">
	            <span class="num">登录密码</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/pay_password') ?>">
	            <span class="num">支付密码</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="">
	            <span class="num">关于向日葵</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	    </ul>
	    <div style="margin: 0.5rem;">
	    	<a href="<?=site_url('secure/logout')?>" class="mui-btn my-btn-block-green-1">退出登录</a>
	    </div>
	</div>
</body>


<script type="text/javascript" charset="utf-8">
(function($, doc) {
	$.init({
		
	});
}(mui, document));
</script>
