<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?=lang('website_manage');?></title>
<link href="<?=base_url('assets/admin/css/reset.css')?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/admin/css/zh-cn-system.css')?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/admin/css/table_form.css')?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/admin/css/dialog.css')?>" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=base_url('assets/admin/js/dialog.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/admin/css/style/zh-cn-styles1.css')?>" title="styles1" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?=base_url('assets/admin/css/style/zh-cn-styles2.css')?>" title="styles2" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?=base_url('assets/admin/css/style/zh-cn-styles3.css')?>" title="styles3" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?=base_url('assets/admin/css/style/zh-cn-styles4.css')?>" title="styles4" media="screen" />
<script language="javascript" type="text/javascript" src="<?=base_url('assets/admin/js/jquery.min.js')?>"></script>
<script language="javascript" type="text/javascript" src="<?=base_url('assets/admin/js/admin_common.js')?>"></script>
<script language="javascript" type="text/javascript" src="<?=base_url('assets/admin/js/styleswitch.js')?>"></script>
<script language="javascript" type="text/javascript" src="<?=base_url('assets/admin/js/formvalidator.js')?>" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?=base_url('assets/admin/js/formvalidatorregex.js')?>" charset="UTF-8"></script>
<script type="text/javascript">
	window.focus();
</script>
</head>
<body>
<?php if(!isset($show_header)) { ?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php echo MY_Controller::submenu($this->input->get('menuid')); ?>
    </div>
</div>
<?php }else{?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    </div>
</div>
<?php }?>
<style type="text/css">
	html{_overflow-y:scroll}
</style>