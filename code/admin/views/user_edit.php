<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl'); ?>

<div class="pad-10">
    <div class="common-form">
        <form action="?m=user_edit&c=user&a=edit" method="post" id="myform" name="myform">
            <fieldset>
                <legend><?php echo lang('basic_configuration') ?></legend>
                <table width="100%" class="table_form">
                    <input type="hidden" name="user_id" class="input-text" value="<?php echo $user_id ?>" readonly="readonly"/>
                    <tr align="left">
                        <td><label style="width: 100px; display: inline-block;"><?= lang('mobile') ?></label>
                            <?php echo $mobile ?>
                        </td>
                    </tr>
                    <tr align="left">
                        <td><label style="width: 100px; display: inline-block;"><?= lang('user_name') ?>:</label>
                            <?php echo $user_name ?>
                        </td>
                    </tr>
                    <tr align="left">
                        <td><label style="width: 100px; display: inline-block;">密码：</label>
                            <input type="password" name="password" id="password" maxlength="16" class="input-text" value=""/><font color="#f00">(为空则不修改)</font>
                        </td>
                    </tr>
                    <tr align="left">
                        <td><label style="width: 100px; display: inline-block;">确认密码：</label>
                            <input type="password" name="pwdconfirm" id="pwdconfirm" maxlength="16" class="input-text" value=""/>
                        </td>
                    </tr>

                </table>
            </fieldset>
            <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo lang('submit') ?>" class="dialog">
        </form>
    </div>
</div>