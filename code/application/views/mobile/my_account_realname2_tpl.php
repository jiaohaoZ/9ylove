<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="<?=theme_css('mui.min.css') ?>" rel="stylesheet"/>  
    <link href="<?=theme_css('common.css') ?>" rel="stylesheet"/>  
</head>
<body id="realname2">
	<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
		 <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">实名认证</h1>
	</header>
	<div class="mui-content">
		<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请认真填写个人信息</p>
		<form class="mui-input-group my-form" style="margin-top: 0.3rem;" method="post" action="<?php echo site_url('user/my_realname2') ?>">
			<div class="mui-input-row">
				<label>真实姓名</label>
				<input class="mui-input-clear" id="real_name" value="<?php if($is_real){echo $real_name;} ?>" name="real_name" type="text" <?php if($is_real){echo 'disabled';} ?> placeholder="请输入真实姓名">
			</div>
			<div class="mui-input-row">
				<label>身份证号</label>
				<input class="mui-input-clear" id="real_identity" value="<?php if($is_real){echo $identity_card;} ?>" name="real_identity" <?php if($is_real){echo 'disabled';} ?> type="text" placeholder="请输入身份证号">
			</div>
			<input id="dataIp1" style="display: none;" type="text" name="img1" id="" value="" />
			<input id="dataIp2" style="display: none;" type="text" name="img2" id="" value="" />
			<input id="dataIp3" style="display: none;" type="text" name="img3" id="" value="" />
		
		<p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请按提示选择正常放置的图片</p>
		<div class="img-box">
			<div class="img1-box" id="img1-box">
				<div class="view1" id="view1">
					<img id="view1-mask" src="<?php if($is_real){echo base_url($real_img1);}else{echo theme_img('icon/keepid01.png');} ?>"/>
				</div>
			</div>
			<div class="img2-box" id="img2-box">
				<div class="view2" id="view2">
					<img id="view2-mask" src="<?php if($is_real){echo base_url($real_img2);}else{echo theme_img('icon/rn01.png');} ?>" />
				</div>
			</div>
			<div class="img3-box" id="img3-box">
				<div class="view3" id="view3">
					<img id="view3-mask" src="<?php if($is_real){echo base_url($real_img3);}else{echo theme_img('icon/rn02.png');} ?>"/>
				</div>
			</div>
		</div>
			<div style="margin: 0.5rem; margin-bottom: 0;">
		<?php if (!$is_real): ?>
	    		<button id="subBtn" class="mui-btn my-btn-block-green-1">提交审核</button>
	  		 </div>
		<?php endif ?>
		
	   </form>
	</div>
	<div id="clipArea1">
		<button id="cancelBtn1" class="mui-btn left">放弃</button>
		<button id="clipBtn1" class="mui-btn right">裁剪</button>
	</div>
	<?php if (!$is_real): ?>
		<input style="visibility: hidden;" type="file" id="file1">
	<?php endif ?>
	<div id="clipArea2">
		<button id="cancelBtn2" class="mui-btn left">放弃</button>
		<button id="clipBtn2" class="mui-btn right">裁剪</button>
	</div>
	<?php if (!$is_real): ?>
		<input style="visibility: hidden;" type="file" id="file2">
	<?php endif ?>
	<div id="clipArea3">
		<button id="cancelBtn3" class="mui-btn left">放弃</button>
		<button id="clipBtn3" class="mui-btn right">裁剪</button>
	</div>
	<?php if (!$is_real): ?>
		<input style="visibility: hidden;" type="file" id="file3">
	<?php endif ?>
</body>

<script src="<?=theme_js('common.js')?>"></script>
<script src="<?=theme_js('mui.min.js')?>"></script>
<script src="<?=theme_js('hammer.js')?>"></script>
<script src="<?=theme_js('iscroll-zoom.js')?>"></script>
<script src="<?=theme_js('jquery-3.1.1.min.js')?>"></script>
<script src="<?=theme_js('lrz.all.bundle.js')?>"></script>
<script src="<?=theme_js('PhotoClip.js')?>"></script>
<script src="<?=theme_js('validate.js')?>"></script>
<script type="text/javascript" charset="utf-8">
  	mui.init();
  	var clipArea1 = new PhotoClip("#clipArea1", {
		size: [256.8, 162],
		outputSize: [256.8, 162],
		file: "#file1",
		//img: "img/mm.jpg",
		view: "#view1",
		ok: "#clipBtn1",
		loadStart: function() {
			console.log("照片读取中");
		},
		loadComplete: function() {
			console.log("照片读取完成");
			document.getElementById('clipArea1').style.visibility='visible';
		},
		clipFinish: function(dataURL) {
			console.log(dataURL);
			document.getElementById('clipArea1').style.visibility='hidden';
			document.getElementById('view1-mask').style.visibility='hidden';
			document.getElementById('dataIp1').value=dataURL;
		}
	});
	var clipArea2 = new PhotoClip("#clipArea2", {
		size: [256.8, 162],
		outputSize: [256.8, 162],
		file: "#file2",
		//img: "img/mm.jpg",
		view: "#view2",
		ok: "#clipBtn2",
		loadStart: function() {
			console.log("照片读取中");
		},
		loadComplete: function() {
			console.log("照片读取完成");
			document.getElementById('clipArea2').style.visibility='visible';
		},
		clipFinish: function(dataURL) {
			console.log(dataURL);
			document.getElementById('clipArea2').style.visibility='hidden';
			document.getElementById('view2-mask').style.visibility='hidden';
			document.getElementById('dataIp2').value=dataURL;
		}
	});
	var clipArea3 = new PhotoClip("#clipArea3", {
		size: [256.8, 162],
		outputSize: [256.8, 162],
		file: "#file3",
		//img: "img/mm.jpg",
		view: "#view3",
		ok: "#clipBtn3",
		loadStart: function() {
			console.log("照片读取中");
		},
		loadComplete: function() {
			console.log("照片读取完成");
			document.getElementById('clipArea3').style.visibility='visible';
		},
		clipFinish: function(dataURL) {
			console.log(dataURL);
			document.getElementById('clipArea3').style.visibility='hidden';
			document.getElementById('view3-mask').style.visibility='hidden';
			document.getElementById('dataIp3').value=dataURL;
		}
	});
	document.getElementById('img1-box').addEventListener('click',function(){
		document.getElementById('file1').click();
	})
	document.getElementById('img2-box').addEventListener('click',function(){
		document.getElementById('file2').click();
	})
	document.getElementById('img3-box').addEventListener('click',function(){
		document.getElementById('file3').click();
	})
	document.getElementById('cancelBtn1').addEventListener('click',function(){
		document.getElementById('clipArea1').style.visibility='hidden';
	})
	document.getElementById('cancelBtn2').addEventListener('click',function(){
		document.getElementById('clipArea2').style.visibility='hidden';
	})
	document.getElementById('cancelBtn3').addEventListener('click',function(){
		document.getElementById('clipArea3').style.visibility='hidden';
	})

	document.getElementById('subBtn').addEventListener('click',function(event){
			var realName = document.getElementById('real_name').value;
			var realIdentity = document.getElementById('real_identity').value;
			var imgVal1 = document.getElementById('dataIp1').value;
			var imgVal2 = document.getElementById('dataIp2').value;
			var imgVal3 = document.getElementById('dataIp3').value;


			if(realName.length == 0){
				mui.toast('真实姓名不能为空');
				event.preventDefault();
			}else if(realIdentity.length == 0){
				mui.toast('身份证号不能为空');
				event.preventDefault();
			}else if(imgVal1.length == 0){
				mui.toast('图片1不能为空');
				event.preventDefault();
			}else if(imgVal2.length == 0){
				mui.toast('图片2不能为空');
					event.preventDefault();
			}else if(imgVal3.length == 0){
				mui.toast('图片3不能为空');
					event.preventDefault();
			}else{
				var result=validate.identity(realIdentity,function(err){
				if (err) {
					mui.toast(err);
  					event.preventDefault();
				} else {
                    return true;
				}
			});

			}

			
			  		
	});



</script>
</html>