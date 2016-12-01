<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<link href="<?= theme_css('dropload.css') ?>" rel="stylesheet">

<body id="transaction_record">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">提现记录</h1>
</header>
<div class="mui-content">
    <div class="record load-content">
        <ul class="record-list lists">
            <?php if(isset($lists[0])) {?>
            <?php foreach ($lists as $val) {?>
            <li class="item">
                <div class="left">
                    <p style="line-height: 1rem;" class="date"><?=$val['add_time']?></p>
                </div>
                <div class="right">
                    <p class="label">提现到银行卡</p>
                    <p class="num"><?=$val['money']?></p>
                </div>
            </li>
            <?php }?>
            <?php }?>
        </ul>
    </div>
</div>
</body>

<!--滚动加载-->
<script src="<?= theme_js('dropload.min.js') ?>"></script>
<script type="text/javascript" charset="utf-8">
    (function ($, doc) {
        $.init({});
    }(mui, document));

    $(function () {
        var num = 1;
        var dropload = $('.load-content').dropload({
            scrollArea: window,
            loadDownFn: function (me) {
                num++;
                $.ajax({
                    type: 'post',
                    url: "<?=site_url('user_withdrawals/withdrawals_record_load')?>",
                    data: {
                        page: num
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 0) {
                            me.lock();
                            me.noData();
                            me.resetload();
                            return;
                        }
                        var result = '';
                        for (var i = 0; i < data.lists.length; i++) {

                            result += '<li class="item">';
                            result += '<div class="left"><p style="line-height: 1rem;" class="date">'+data.lists[i].add_time+'</p></div>';
                            result += '<div class="right"><p class="label">提现到银行卡</p>';
                            result += '<p class="num">'+data.lists[i].money+'</p><div></li>';
                        }

                        $('.lists').eq(0).append(result);
                        // 每次数据加载完，必须重置
                        me.resetload();
                    },

                    error: function (xhr, type) {
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });

            }
        })
    })

</script>


</html>