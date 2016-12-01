<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>

<body>
<input name="message" id="message" type="hidden" value="<?= $msg ?>"/>
<input name="url" id="url" type="hidden" value="<?= $url_forward ?>"/>
<input name="time" id="time" type="hidden" value="<?php echo isset($ms) ? $ms : '3000'?>"/>
</body>
<script>
    (function ($, doc) {
        $.init();
        var message = doc.getElementById('message').value;
        var url = doc.getElementById('url').value;
        var time=doc.getElementById('time').value;
        mui.alert(message, '提示信息', function () {
            if(url == 'goback' || url =='') {
                window.history.back();
            }else if (url) {
                window.location.href = url;
            }
        });
        setTimeout(function(){
        	if(url == 'goback' || url =='') {
                window.history.back();
            }else if (url) {
                window.location.href = url;
            }
        },time)
    }(mui, document));
</script>