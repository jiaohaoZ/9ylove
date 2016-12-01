<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
$this->load->view('mobile/footer_tpl.php');
 ?>
<body id="find">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
	    <h1 class="mui-title">发现</h1>
	</header>
	<div class="mui-content">
		<ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell" >
			<a href="<?php echo site_url('article/index'); ?>">
	            <span class="label"><img src="<?php echo theme_img('icon/icon_love.png'); ?>"/></span>
	            <span class="num">爱心活动</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	        </a>	      
	        </li>
	        <li class="mui-table-view-cell my-cell" href="http://m.septmall.com/mobile/index.php?">
	            <span class="label"><img src="<?php echo theme_img('icon/icon_video.png'); ?>"/></span>
	            <span class="num">活动视频</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell" href="http://m.septmall.com/mobile/index.php?">
	            <span class="label"><img src="<?php echo theme_img('icon/icon_latest_dynamics.png'); ?>"/></span>
	            <span class="num">最新动态</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	        </li>
	    </ul>
	    <ul class="mui-table-view my-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell" href="http://m.septmall.com/mobile/index.php?">
	            <span class="label"><img src="<?php echo theme_img('icon/icon_shopping.png'); ?>"/></span>
	            <span class="num">购物</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
	        </li>
	        <li class="mui-table-view-cell my-cell" href="http://m.septmall.com/mobile/index.php?">
	            <span class="label"><img src="<?php echo theme_img('icon/icon_game.png'); ?>"/></span>
	            <span class="num">游戏</span>
	            <span class="mui-pull-right mui-icon mui-icon-arrowright"></span>
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
</html>