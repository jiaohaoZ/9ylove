<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>

<style type="text/css">
    body{ background: -webkit-linear-gradient(#4d90e7, #35beb6);background: linear-gradient(#4d90e7, #35beb6);}
</style>

<body id="qrcode">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">我的二维码</h1>
</header>
<div class="mui-content">
    <div class="code-box">
        <img class="qrcode-img" src="<?=$qrcode?>"/>
        <p class="name"><?=$user_name?></p>
    </div>
    <p class="text">扫一扫二维码，马上注册</p>
</div>
</body>
<script type="text/javascript">
    document.getElementById('qrcode').style.height=window.innerHeight+"px";
</script>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({
        });

    }(mui, document));
</script>
</html>