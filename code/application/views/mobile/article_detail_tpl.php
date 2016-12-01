<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
 <style type="text/css">
    	body{background-color: #fff;}
    	.loveactivitiesDetails{background-color: #fff; padding: 0.4rem;}
    	.loveactivitiesDetails .tit{font-size: 0.44rem; color: #000; margin: 0; padding: 0; border-bottom: none; line-height: 0.6rem; padding: 0 0.2rem; margin-top: 0.5rem;text-align: center;height: auto;}
    	.loveactivitiesDetails .info{text-align: center; font-size: 0.28rem; margin-top: 0.1rem;}
    	.loveactivitiesDetails .article{margin-top: 0.3rem;}
    	.loveactivitiesDetails .article img{width: 100%;}
    </style>
<body>
	<header class="mui-bar mui-bar-nav nav-bg">
		<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo $title; ?></h1>
	</header>
	<div class="mui-content loveactivitiesDetails">
		<h4 class="tit"><?php echo $title; ?></h4>
		<p class="info">发表时间：<span><?php echo date('Y-m-d',$modify_time); ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp浏览次数：<span><?php echo $clicks; ?></span></p>
		<div class="article">
			<?php echo html_entity_decode($content, ENT_QUOTES, 'UTF-8') ; ?>
		</div>
	</div>
</body>
<script type="text/javascript" charset="utf-8">
(function($, doc) {
		$.init();
	
	
}(mui, document)); 


</script>
