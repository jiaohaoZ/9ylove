<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl');
?>

<body id="my">
<header class="mui-bar mui-bar-nav nav-bg" style="box-shadow: none;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">转账</h1>
</header>
<div class="mui-content">
    <div>
        <p style="text-align: center; line-height: 1rem; font-size: 0.28rem;">请填写转账信息</p>
        <form name="form" id="myForm" action="<?= site_url('user_transfer/userTransferDetail') ?>" method="post" style="margin-top: 0.3rem;">
            <div class="mui-input-row mui-input-group">
                <label>对方账号</label>
                <input class="mui-input-clear" id="transfer_user" name="transfer_user" type="text"
                       placeholder="手机号 / 邮箱 / 用户名">
            </div>
            <div style="margin: 0.5rem;">
                <input name="transfer_user_id" type="hidden" value="0" >
                <button id="submitBtn" disabled type="button" class="mui-btn my-btn-block-green-1">下一步</button>
            </div>
        </form>
    </div>
</div>
</body>


<script type="text/javascript" charset="utf-8">
    mui.init();
    //判断转账账号是否存在
    $(function () {

        $(':input[name="transfer_user"]').on('input', function () {
            if ($(this).val() != '') {
                $('#submitBtn').attr('disabled', false);
            } else {
                $('#submitBtn').attr('disabled', true);
            }
        });

        $('#submitBtn').click(function () {
            var transfer_user = $(':input[name="transfer_user"]').val();
            var myForm = $('#myForm');
            $.ajax({
                type: "post",
                url: "<?=site_url('user_transfer/isUserIsset')?>",
                data: {
                    userInfo: transfer_user
                },
                success: function (rs) {
                    rs = $.parseJSON(rs);
                    if (rs.status == 1) {
                        $("input[name='transfer_user_id']").val(rs.transfer_user_id);
                        myForm.submit();
                    } else if (rs.status == 0) {
                        mui.alert('该用户不存在！')
                    }
                },
                error: function () {

                }
            })
        });

    });

</script>
</html>
