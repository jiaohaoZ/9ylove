<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>信息提示</title>
    <link href="<?=theme_css('mui.min.css') ?>" rel="stylesheet"/>

</head>
<body style="margin:0;padding:0;width:100%;height:100%;text-align:center; position: relative; background-color: #fff;">
<div style="position:absolute;top: 10px ; right: 10px;">
    <div class="button mui-action-back"><span style="font-size: 30px;" class="mui-icon mui-icon-closeempty"></span>
    </div>
</div>
<p style="font-size: 24px; padding-top: 30px; color: #222222;"></p>
<p style="font-size: 15px; color: #222222;"></p>
<img style="width: 100%;" src="<?=theme_img('login/reg-success.png')?>"/>
<div style="padding: 0 35px;">
<!--    <button id="regSuccessBtn" style="height: 44px; padding-top: 8px;padding-bottom: 8px;"-->
<!--            class="mui-btn mui-btn-primary mui-btn-block">立即登录-->
<!--    </button>-->
    <button  style="height: 44px; padding-top: 8px;padding-bottom: 8px;background: #f00;border: 1px solid #f00;"
            class="mui-btn mui-btn-primary mui-btn-block"><?php if(isset($msg)) echo $msg?>
    </button>
</div>
</body>

<script src="<?=theme_js('common.js')?>"></script>
<script src="<?=theme_js('mui.min.js')?>"></script>

<script type="text/javascript" charset="utf-8">
    mui.init();
</script>
</html>