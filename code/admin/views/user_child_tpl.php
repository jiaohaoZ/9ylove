<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl'); ?>
<div class="pad_10">
    <form name="searchform" action="" method="get">
        <input type="hidden" value="view_child" name="m">
        <input type="hidden" value="user" name="c">
        <input type="hidden" value="search" name="a">
        <table width="100%" cellspacing="0" class="search-form">
            <tbody>
            <tr>
                <td>
                    <div class="explain-col">
                        <?= lang('search_mobile') ?>
                        <input name="mobile" size="50" placeholder="<?= lang('more_mobile') ?>" type="text" value="<?php if (isset($_GET['mobile'])) {echo $_GET['mobile'];} ?>" class="input-text"/>
                        <?= lang('search_user_name') ?>
                        <input name="user_name" size="50" placeholder="<?= lang('more_user_name') ?>" type="text" value="<?php if (isset($_GET['user_name'])) {echo $_GET['user_name'];} ?>" class="input-text"/>
                        <input type="submit" name="search" class="button" value="<?php echo lang('search') ?>"/>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>


    <form name="myform" action="?m=member_list&c=member&a=delete" method="post" onsubmit="checkuid();return false;"
          id="myform">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th align="left"><?= lang('user_id') ?></th>
<!--                    <th align="left">--><?//= lang('mobile') ?><!--</th>-->
                    <th align="left"><?= lang('user_name') ?></th>
                    <th align="left"><?= lang('user_money') ?></th>
                    <th align="left"><?= lang('gold_money') ?></th>
                    <th align="left"><?= lang('shop_money') ?></th>
                    <th align="left"><?= lang('status') ?></th>
                    <th align="left"><?= lang('reg_time') ?></th>
<!--                    <th align="left">--><?//= lang('operation') ?><!--</th>-->
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($list)) {
                    foreach ($list as $k => $row) {
                        ?>
                        <tr>
                            <td><?= $row['user_id'] ?></td>
<!--                            <td>-->
<!--                                --><?//= $row['mobile'] ?>
<!--                                <a style="vertical-align: middle;" href="javascript:info(--><?php //echo $row['user_id'] ?><!--)"><img src="--><?php //echo theme_img('admin_img/detail.png') ?><!--"/></a>-->
<!--                            </td>-->
                            <td><?= $row['user_name'] ?></td>
                            <td><?= $row['user_money'] ?></td>
                            <td><?= $row['gold_money'] ?></td>
                            <td><?= $row['shop_money'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><?= date('Y-m-d H:i:s',$row['reg_time']) ?></td>
<!--                            <td>-->
<!--                                <a style="vertical-align: middle;" href="javascript:edit(--><?php //echo $row['user_id'] ?><!--, '--><?php //echo $row['user_name'] ?><!--')">[--><?php //echo lang('edit') ?><!--]</a>-->
<!--                                <a style="vertical-align: middle;" href="javascript:editAgent(--><?php //echo $row['user_id'] ?><!--, '--><?php //echo $row['user_name'] ?><!--')">[--><?php //echo lang('agent_edit') ?><!--]</a>-->
<!--                                <a style="vertical-align: middle;" href="--><?//=site_url('?c=user&m=view_child&a=init&user_id='.$row['user_id'])?><!--">[--><?//=lang('view_child')?><!--]</a>-->
<!---->
<!--                            </td>-->
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>

        </div>
    </form>
</div>
</body>
</html>

