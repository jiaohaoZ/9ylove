<!doctype html>
<html lang="zh-CN" id="index">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no, email=no" />
<meta name="keywords" content="">
<meta name="description" content="">
<title>图片裁剪</title>
<style>
body {
	margin: ;
	text-align: center;
}
#clipArea {
	margin-left: 20px;
	margin-right: 20px;
	margin-bottom: 20px;
	margin-top: 60px;

	height: 300px;
}
#file{
	height: 0;
	width: 0;
}
#clipBtn {
	
}
#reBtn{
	margin-bottom: 20px;
	display: none;
}
#view {
	margin: 0 auto;
	width: 200px;
	height: 0px;
}
#jia{font-size: 100px;display: block;width: 100px;line-height: 100px; height: 100px; position: absolute; left: 50%; top: 50%; transform: translate(-50%,-60%);z-index: 100;-webkit-transform: translate(-50%,-60%) ;}
</style>
</head>

<body ontouchstart="">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
	<a href="<?php echo site_url('user/user_info') ?>" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
	<h1 class="mui-title">更换头像</h1>
</header>
<div id="clipArea">
	<span id="jia">+</span>
</div>
<input style="visibility: hidden;" type="file" id="file">
<div>
	<button id="reBtn" class="mui-btn">重新选择</button>
</div>
<button id="clipBtn" class="mui-btn">上传</button>
<div style="visibility: hidden;" id="view"></div>
<form style="visibility: hidden;" name="dataForm" method="post" action="<?php echo site_url('user/user_icon') ?>">
	<input id="dataIp" type="text" name="img_info" value=""/>
</form>
<script src="<?=theme_js('jquery-3.1.1.min.js')?>"></script>
<script src="<?=theme_js('iscroll-zoom.js')?>"></script>
<script src="<?=theme_js('hammer.js')?>"></script>
<script src="<?=theme_js('lrz.all.bundle.js')?>"></script>
<script src="<?=theme_js('PhotoClip.js')?>"></script>
<link href="<?=theme_css('mui.min.css') ?>" rel="stylesheet"/>  
<link href="<?=theme_css('login.css')?>" rel="stylesheet"/>
<link href="<?=theme_css('common.css') ?>" rel="stylesheet"/>
<link href="<?=theme_css('iconfont.css') ?>" rel="stylesheet"/>
<script>
var dataIp=document.getElementById('dataIp');
var clipArea = new PhotoClip("#clipArea", {
	size: [260, 260],
	outputSize: [640, 640],
	file: "#file",
	//img: "img/mm.jpg",
	view: "#view",
	ok: "#clipBtn",
	loadStart: function() {
		console.log("照片读取中");
	},
	loadComplete: function() {
		console.log("照片读取完成");
		jiaBtn.style.display='none';
		reBtn.style.display='inline-block';
	},
	clipFinish: function(dataURL) {
		console.log(dataURL);
		dataIp.value=dataURL;
		if (!dataURL) {return};
		document.dataForm.submit();
		// alert(1)
	}
});
var fileBtn=document.getElementById('file');
var jiaBtn=document.getElementById('jia');
var reBtn=document.getElementById('reBtn')
jiaBtn.addEventListener('click',function(){
	fileBtn.click();
})
reBtn.addEventListener('click',function(){
	fileBtn.click();
})

</script>

</body>
</html>
