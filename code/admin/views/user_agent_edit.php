<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl'); ?>

<div class="pad-10">
    <div class="common-form">
        <form action="?m=agent_edit&c=user_agent&a=edit" method="post" id="myform" name="myform">
            <fieldset>
                <legend><?php echo lang('basic_configuration') ?></legend>
                <table width="100%" class="table_form">
                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('agent')?></label>
                            <select name="agent_rank">
                                <?php if ($agent_all) { ?>
                                    <option value="-1">非代理</option>
                                    <?php foreach ($agent_all as $key => $val) { ?>
                                        <option value="<?=$key?>" <?php if($user_agent['agent_rank'] == $key) { echo 'selected';}?>>
                                            <?=$val?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('alipay')?></label>
                            <input type="text" name="alipay" value="<?=$user_agent['alipay']?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('card_no')?></label>
                            <input type="text" name="card_no" value="<?=$user_agent['card_no']?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('bank')?></label>
                            <input type="text" name="bank" value="<?=$user_agent['bank']?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="width: 100px; display: inline-block;"><?= lang('card_address')?></label>
                            <input type="text" name="card_address" value="<?=$user_agent['card_address']?>">
                        </td>
                    </tr>

<!--                    <tr>-->
<!--                        <td>-->
<!--                            <label style="width: 100px; display: inline-block;">--><?//= lang('card_info')?><!--</label>-->
<!--                            <select name="card_id">-->
<!--                                --><?php //if ($card[0]) { ?>
<!--                                    --><?php //foreach ($card as $key => $val) { ?>
<!--                                        <option value="--><?//=$val['card_id']?><!--">--><?//=$val['bank_name']?><!-----><?//=$val['card_no']?><!-----><?//=$val['card_address']?><!--</option>-->
<!--                                    --><?php //} ?>
<!--                                --><?php //} ?>
<!--                            </select>-->
<!--                        </td>-->
<!--                    </tr>-->

                </table>
            </fieldset>
            <input name="user_id" value="<?=$user_id?>" type="hidden">
            <input name="user_name" value="<?=$user_name?>" type="hidden">

            <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo lang('submit') ?>" class="dialog">
        </form>
    </div>
</div>