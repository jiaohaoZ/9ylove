<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="my">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">手机</h1>
	</header>
	<div class="mui-content">
		<ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
	        <li class="mui-table-view-cell my-cell">
	            <span class="num">手机号</span>
	            <span class="pull-right"><?php if(!empty($mobile)) echo $mobile; ?></span>
	        </li>
	    </ul>
	    <div style="margin: 0.5rem;">
	    	<a id="btn" href="<?php echo site_url('user/user_mobile_oper') ?>" class="mui-btn my-btn-block-green-1">更换手机号</a>
	   </div>
	</div>
</body>


<script type="text/javascript" charset="utf-8">
 (function($, doc) {
	$.init({
		
	});
	
}(mui, document));	
</script>
