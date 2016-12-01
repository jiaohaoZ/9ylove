<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body id="cardpackage">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a href="<?php echo site_url('user/index') ?>" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">卡包</h1>
	</header>
	<div class="mui-content" style="padding-bottom: 80px;">
		<ul class="bankcard-list">
			<?php if (isset($lists)): ?>
				<?php foreach ($lists as $k => $v): ?>
					<li class="item">
						<div class="label">
							<div class="img-box">
								<img src="<?php echo base_url().$v['bank_image'] ?>"/>
							</div>
						</div>
						<div class="num">
							<p class="bank"><?php echo $v['bank_name']; ?></p>
							<p class="type">储蓄卡</p>
							<p class="number"><?php echo $v['card_no'] ?></p>
						</div>
						<div class="delete">
							<a class="deleteBtn" val = "<?php echo $v['card_id'] ?>" href="#">解绑</a>
						</div>
					</li>
				<?php endforeach ?>
			<?php endif ?>
			
		</ul>
		<div class="btn">
			<input type="hidden" id="real_val" value="<?php echo $is_real; ?>">
	    	<button id="addBtn" class="mui-btn my-btn-block-green-1">添加银行卡</button>
	    </div>
	</div>
</body>
<style type="text/css">
	html{width: 100%; min-height: 100%; position: relative;}
	#cardpackage{width: 100%; min-height: 100%; }
	#cardpackage .btn{position: absolute; width: 100%; bottom: 0; left: 0; }
	#cardpackage .btn button{width: 4rem; position: absolute; left: 50%; bottom: 30px; -webkit-transform: translateX(-50%); transform: translateX(-50%);}
</style>
<script type="text/javascript" charset="utf-8">
(function($, doc) {
	$.init({
		
	});
	if (document.getElementById("real_val").value==2) {
		document.getElementById("addBtn").addEventListener('tap', function() {
			window.location.href='<?php echo site_url('user/my_card_packge_add') ?>';
		});

	}else{
		document.getElementById("addBtn").addEventListener('tap', function() {
			var btnArray = ['取消', '确定'];
			mui.confirm('当前账号没有实名认证，马上去认证？', '提示', btnArray, function(e) {
				if (e.index == 1) {
					//确认执行内容
					window.location.href='<?php echo site_url('user/my_realname2')?>';
				} else {
					//取消执行内容
				}
			})
		});
	}
	mui(".bankcard-list").on('tap','.deleteBtn',function(){
		var a = this.getAttribute('val');
		console.log(this.getAttribute('val'))
		var btnArray = ['取消', '确定'];
	  	mui.confirm('您确定要解绑此张银行卡？', '提示', btnArray, function(e) {
			if (e.index == 1) {
				//确认执行内容
				window.location.href='<?php echo site_url("user/del_my_cart?card_id=")?>'+a;
			} else {
				//取消执行内容
			}
		})
	});
	
}(mui, document));
</script>
</html>