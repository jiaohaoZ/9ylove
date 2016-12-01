<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl'); ?>

<div class="pad-10">
    <div class="common-form">
        <form action="?m=user_edit&c=user&a=edit" method="post" id="myform" name="myform">
            <fieldset>
                <legend><?php echo lang('basic_configuration') ?></legend>
                <table width="100%" class="table_form">
                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('agent')?></label>
                            <select name="agent">
                                <?php if ($agent) { ?>
                                    <?php foreach ($agent as $val) { ?>
                                        <option><?=$val?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('agent_name')?></label>
                        </td>
                    </tr>



                </table>
            </fieldset>
            <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo lang('submit') ?>" class="dialog">
        </form>
    </div>
</div>