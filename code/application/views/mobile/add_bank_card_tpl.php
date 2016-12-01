<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>
<body id="recharge_details">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">添加银行卡</h1>
	</header>
	<div class="mui-content">
		<div>
			<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请添加持卡人本人的账号</p>
			<ul class="mui-table-view my-setting-list" style="margin-top: 0.4rem;">
		        <li class="mui-table-view-cell my-cell">
		            <span class="num">持卡人</span>
		            <span class="pull-right"><?php echo $lists1[0]['real_name'] ?></span>
		        </li>
		        <li class="mui-table-view-cell my-cell">
		            <span class="num">身份证</span>
		            <span class="pull-right"><?php echo $lists1[0]['identity_card']?></span>
		        </li>
		    </ul>
			<form class="mui-input-group my-form" method="post" action="<?php echo site_url('user/my_card_packge_add') ?>" style="margin-top: 0.3rem;">
				<div class="mui-input-row">
					<label>账户类型</label>
					<select name="bank_type">
						<?php if (isset($lists2)): ?>
							<?php foreach ($lists2 as $k => $v): ?>
								<option value="<?php echo $v['bank_id'] ?>"><?php echo $v['bank_name'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</div>
				<div class="mui-input-row">
					<label>卡号</label>
					<input class="mui-input-clear" id="card_num" name="card_num" type="text" placeholder="请输入本人卡号">
				</div>
				<div style="margin: 0.5rem;">
		    		<button id="codeBtn" class="mui-btn my-btn-block-green-1">确认添加</button>
		   		</div>
			</form>
			
		   
		    
		</div>
	</div>
</body>

<script type="text/javascript" charset="utf-8">
  	
(function($, doc) {
	$.init({
	 	
	});
	document.getElementById('card_num').addEventListener('keyup',function(){
    	var value=this.value.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");
    	this.value=value;
    });
	var accountBox = document.getElementById('card_num');
	var codeButton=document.getElementById('codeBtn');

	codeButton.addEventListener('click',function(event){
			var cardNums=accountBox.value;

			var result=validate.cardNum(cardNums,function(err){
				if (err) {
					mui.toast(err);
					// mui.toast('银行卡号错误');
  					event.preventDefault();
					return false;
				} else {
                    return true;
				}
			});

			if(!result){return}

		});



	
}(mui, document)); 
</script>
</html>