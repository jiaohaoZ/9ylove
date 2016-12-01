<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
$this->load->view('mobile/footer_tpl');
 ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
	    <h1 class="mui-title">我的</h1>
	</header>
	<div class="mui-content">
	   	<div id="user" class="user">
			<div class="user-box">
				<a href="<?php echo site_url("user/user_info"); ?>">
				<div class="user-info">
					<span class="mui-icon mui-icon-arrowright mui-pull-right"></span>
					<div class="user-img" style="background-color:white;">
						<img src="<?php echo base_url($portrait);?>" alt="" />
						<div class="grade-box"><?php echo 'V'.$user_rank; ?></div>
					</div>
					<p class="user-name"><?php echo $user_name; ?></p>
					<p class="user-phone"><?php echo $mobile;?></p>
				</div>
				</a>
			</div>
		</div>
		<ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?=site_url('user_transfer/myWallet')?>">
	            <span class="label"><img src="<?=theme_img('icon/icon_wallet.png')?>"/></span>
	            <span class="num">钱包</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/my_card_packge') ?>">
	            <span class="label"><img src="<?=theme_img('icon/icon_card_package.png')?>"/></span>
	            <span class="num">卡包</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?=site_url('home/inviteFriends')?>">
	            <span class="label"><img src="<?=theme_img('icon/icon_invite2.png')?>" /></span>
	            <span class="num">邀请好友</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	        	<a href="<?php echo site_url('user/user_settings') ?>">
	            <span class="label"><img src="<?=theme_img('icon/icon_settings.png')?>"/></span>
	            <span class="num">设置</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	            </a>
	        </li>
	    </ul>
	</div>
</body>
<script type="text/javascript" charset="utf-8">
(function($, doc) {
	$.init({
		
	});
	$('.index-footer-bar').on('tap','.mui-tab-item',function(){
		var href=this.getAttribute('href');
		window.location.href=href;
	})
}(mui, document));
</script>