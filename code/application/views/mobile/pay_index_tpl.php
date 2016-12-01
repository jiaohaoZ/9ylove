<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">充值</h1>
</header>
<div class="mui-content">
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请输入您要充值的个数，每次充值必须大于50个</p>
        <form name="form" action="<?=site_url('pay/flow')?>" class="mui-input-group" style="margin-top: 0.3rem;" method="post">
            <div class="mui-input-row">
                <label>代理商</label>
                <select name="agent_id">
                    <?php foreach ($agents as $v): ?>
                    <option value="<?=$v['agent_id']?>"><?=$v['agent_name']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="mui-input-row">
                <label>充值</label>
                <input class="mui-input-clear" type="text" name="money" placeholder="请输入充值个数">
            </div>
        </form>
        <div style="margin: 0.5rem;">
            <button id="submitBtn" class="mui-btn my-btn-block-green-1">充值</button>
        </div>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    (function($, doc) {
        $.init({

        });
        document.getElementById('submitBtn').addEventListener('tap',function(){
            document.form.submit();
        })
    }(mui, document));
</script>
</html>