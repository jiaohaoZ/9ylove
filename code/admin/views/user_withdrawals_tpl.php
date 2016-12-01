<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl'); ?>
<div class="pad_10">
    <form name="searchform" action="" method="get">
        <input type="hidden" value="user_withdrawals" name="m">
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
                        <input name="traders_code" size="50" placeholder="<?= lang('more_user_name') ?>" type="text" value="<?php if (isset($_GET['traders_code'])) {echo $_GET['traders_code'];} ?>" class="input-text"/>
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
                    <th align="left"><?= lang('mobile') ?></th>
                    <th align="left"><?= lang('money') ?></th>
                    <th align="left"><?= lang('real_money') ?></th>
                    <th align="left"><?= lang('card_no') ?></th>
                    <th align="left"><?= lang('status') ?></th>
                    <th align="left"><?= lang('add_time') ?></th>
                    <th align="left"><?= lang('confirm_time') ?></th>
                    <th align="left"><?= lang('pass_or_refuse') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($list)) {
                    foreach ($list as $k => $row) {
                        ?>
                        <tr>
                            <td><?= $row['user_id'] ?></td>
                            <td><?= $row['mobile'] ?></td>
                            <td><?= $row['money'] ?></td>
                            <td><?= $row['real_money'] ?></td>
                            <td><?= $row['card_no'] ?></td>
                            <td><?= $row['status_text'] ?></td>
                            <td><?= date('Y-m-d H:i:s', $row['add_time']) ?></td>
                            <td><?php if($row['status'])  echo date('Y-m-d H:i:s', $row['confirm_time']) ;?></td>
                            <td>
                                <?php if($row['status'] == 0) {?>
                                <a href="<?php echo site_url("?c=user&m=update_status&a=edit&pass=1&wl_id={$row['wl_id']}&user_id={$row['user_id']}&money={$row['money']}")?>" >[通过]</a>
                                |
                                <a href="<?php echo site_url("?c=user&m=update_status&a=edit&refuse=1&wl_id={$row['wl_id']}")?>" >[拒绝]</a>
                                <?php } else {?>
                                    已处理
                                <?php }?>

                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <div id="pages"><?php echo $pages ?></div>
        </div>
    </form>
</div>
</body>
</html>

<script type="text/javascript">

</script>