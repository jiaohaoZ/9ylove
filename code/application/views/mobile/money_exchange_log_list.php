<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<link href="<?= theme_css('dropload.css') ?>" rel="stylesheet">

<body id="transaction_record">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">收积分记录</h1>
</header>
<div class="mui-content">
    <div class="record load-content">
        <ul class="record-list lists">
            <?php if (isset($lists[0])) { ?>
                <?php foreach ($lists as $val) { ?>
                    <li class="item">
                        <div class="left">
                            <p class="week"><?= $val['user_name'] ?></p>
                            <p class="date"><?= $val['add_time'] ?></p>
                        </div>
                        <div class="right">
                            <p class="label"><?= $val['money_num'] ?>-<?= $val['type_name'] ?></p>
<!--                            <p class="num">--><?//=$val['type_name']?><!--</p>-->
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
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
                    url: "<?=site_url('money/moneyExchangeLoad')?>",
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
                            result += '<div class="left"><p class="week">'+data.lists[i].user_name+'</p>';
                            result += '<p class="date">'+data.lists[i].add_time+'</div>';
                            result += '<div class="right"><p class="label">'+data.lists[i].money_num+'-'+data.lists[i].type_name+'</p></div>';
                            result += '</li>';
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