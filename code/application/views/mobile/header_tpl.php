<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="<?=theme_css('mui.min.css') ?>" rel="stylesheet"/>  

    <link href="<?=theme_css('common.css') ?>" rel="stylesheet"/>
    <link href="<?=theme_css('iconfont.css') ?>" rel="stylesheet"/>

</head>

<script src="<?=theme_js('common.js')?>"></script>
<script src="<?=theme_js('mui.min.js')?>"></script>
<script src="<?=theme_js('validate.js')?>"></script>

<?php
//注册登录页面不加载jquery
if(current_url() != site_url('secure/login') && current_url() != site_url('secure/register')){
    //其他页面加载jquery
    echo "<script src='".theme_js('jquery.min.js')."'></script>";
} else {
    //登录注册加载
//    echo "<link href='".theme_css('login.css')."' rel='stylesheet'/>";
}
?>