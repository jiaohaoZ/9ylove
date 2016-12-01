<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="transaction_record">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">邀请记录</h1>
</header>
<div class="mui-content">
    <div class="record">
        <ul class="record-list">
            <?php if (isset($list[0])) { ?>
                <?php foreach ($list as $val) { ?>
                    <li class="item">
                        <div class="left">
                            <p class="week"><?=$val['user_name']?></p>
                            <p class="date"><?= date('Y-m-d', $val['reg_time'])?></p>
                        </div>
                        <div class="right">
                            <p class="label">手机号码：<?=$val['mobile']?></p>
<!--                            <p class="num">--><?//=$val['email']?><!--</p>-->
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({

        });

    }(mui, document));
</script>


</html>