<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<style type="text/css">
    fieldset label{display: inline-block; width: 100px;}
</style>
<div class="pad-10">
    <div class="common-form">
        <form action="?m=user_info&c=user&a=init" method="post">
            <fieldset>
                <legend>基本信息</legend>
                <table width="100%" class="table_form">
                    <tr align="left">
                        <td><label><?=lang('mobile')?>:</label>
                            <?php echo $mobile?>
                        </td>
                    </tr>
                    <tr align="left">
                        <td><label><?=lang('user_name')?>:</label>
                            <?php echo $user_name?>
                        </td>
                    </tr>

                </table>
            </fieldset>
            <br>
            <fieldset>
                <legend>其他信息</legend>
                <table width="100%" class="table_form">
                    <tr align="left">
                        <td>
                            <label></label>

                        </td>
                    </tr>

                </table>
            </fieldset>
            <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo lang('submit')?>" class="dialog">
        </form>
    </div>
</div>
