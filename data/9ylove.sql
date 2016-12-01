/*Table structure for table `ci_admin_log` */

DROP TABLE IF EXISTS `ci_admin_log`;

CREATE TABLE `ci_admin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `log_info` text,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `log_ip` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `log_type` (`log_type`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_admin_log` */

/*Table structure for table `ci_admin_panel` */

DROP TABLE IF EXISTS `ci_admin_panel`;

CREATE TABLE `ci_admin_panel` (
  `menu_id` smallint(5) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `created_time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`menu_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_admin_panel` */

/*Table structure for table `ci_admin_role` */

DROP TABLE IF EXISTS `ci_admin_role`;

CREATE TABLE `ci_admin_role` (
  `role_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ci_admin_role` */

insert  into `ci_admin_role`(`role_id`,`role_name`,`description`,`disabled`) values (1,'管理员','拥有最大权限',0);

/*Table structure for table `ci_admin_role_priv` */

DROP TABLE IF EXISTS `ci_admin_role_priv`;

CREATE TABLE `ci_admin_role_priv` (
  `role_id` tinyint(4) unsigned NOT NULL,
  `c` varchar(20) NOT NULL DEFAULT '' COMMENT 'controller',
  `m` varchar(20) NOT NULL DEFAULT '' COMMENT 'model/function',
  `d` varchar(40) NOT NULL DEFAULT '' COMMENT 'directory',
  `a` varchar(20) NOT NULL DEFAULT '' COMMENT 'action',
  UNIQUE KEY `priv_id` (`role_id`,`c`,`m`,`a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_admin_role_priv` */

/*Table structure for table `ci_admin_user` */

DROP TABLE IF EXISTS `ci_admin_user`;

CREATE TABLE `ci_admin_user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `role_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色权限id',
  `encrypt` varchar(6) NOT NULL DEFAULT '',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `real_name` varchar(32) NOT NULL DEFAULT '',
  `state` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT '0:正常, 1:停用',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ci_admin_user` */

insert  into `ci_admin_user`(`user_id`,`user_name`,`password`,`role_id`,`encrypt`,`last_login_ip`,`last_login_time`,`email`,`real_name`,`state`) values (1,'gao','4832634e5df6121293c173a720e034c9',1,'hUv2Bz','127.0.0.1',1479197060,'888@qq.com','gao',0),(2,'admin','6b8341b2a75c03a82787fb5e070d0a0a',1,'PQ4jDj','220.115.189.155',1471224734,'admin@admin.com','管理员',0);

/*Table structure for table `ci_bank` */

DROP TABLE IF EXISTS `ci_bank`;

CREATE TABLE `ci_bank` (
  `bank_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bank_name` varchar(120) NOT NULL DEFAULT '' COMMENT '银行名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1正常0停用',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_bank` */

/*Table structure for table `ci_config` */

DROP TABLE IF EXISTS `ci_config`;

CREATE TABLE `ci_config` (
  `setting_key` varchar(32) NOT NULL DEFAULT '',
  `setting` text,
  `is_json` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_config` */

insert  into `ci_config`(`setting_key`,`setting`,`is_json`) values ('max_login_failed_times','10',0);

/*Table structure for table `ci_menu` */

DROP TABLE IF EXISTS `ci_menu`;

CREATE TABLE `ci_menu` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `c` varchar(20) NOT NULL DEFAULT '',
  `m` varchar(20) NOT NULL DEFAULT '',
  `a` varchar(20) NOT NULL DEFAULT '',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `display` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `ci_menu` */

insert  into `ci_menu`(`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) values (1,'panel',0,'panel','panel','init',0,1),(2,'admin',0,'admin','admin','init',1,1),(3,'admininfo',1,'admininfo','admininfo','init',0,1),(4,'editinfo',3,'admin_manage','edit_info','edit',0,1),(5,'editpwd',3,'admin_manage','edit_pwd','edit',0,1),(6,'admin_setting',2,'admin_manage','admin_setting','init',0,1),(7,'admin_manage',6,'admin_manage','admin_list','init',0,1),(8,'admin_add',7,'admin_manage','admin_add','add',1,1),(9,'role_manage',6,'role','init','init',0,1),(10,'role_add',9,'role','add','add',1,1),(11,'admin_manage',7,'admin_manage','admin_list','init',0,1),(12,'role_manage',9,'role','init','init',0,1),(13,'role_manage',9,'role','delete','delete',0,0),(14,'role_manage',9,'role','edit','edit',0,0),(15,'admin_manage',7,'admin_manage','admin_edit','edit',0,0),(16,'admin_manage',7,'admin_manage','admin_delete','delete',0,0),(17,'editinfo',4,'admin_manage','edit_info','edit',0,1),(18,'editpwd',5,'admin_manage','edit_pwd','edit',0,1);

/*Table structure for table `ci_pay_order` */

DROP TABLE IF EXISTS `ci_pay_order`;

CREATE TABLE `ci_pay_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `pay_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:成功',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `agent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '代理商ID',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_pay_order` */

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_sessions` */

insert  into `ci_sessions`(`id`,`ip_address`,`timestamp`,`data`) values ('0ajrmc20tvhrd2ljjrp777atiaoqcbc1','127.0.0.1',1479197547,'__ci_last_regenerate|i:1479197547;captcha|s:4:\"6848\";user_id|s:1:\"1\";user_name|s:3:\"gao\";role_id|s:1:\"1\";email|s:10:\"888@qq.com\";real_name|s:3:\"gao\";lock_screen|i:0;'),('1trfg0u1d99ibfcfgbp4dvo12h8qk86q','127.0.0.1',1479204770,'__ci_last_regenerate|i:1479197547;captcha|s:4:\"6848\";user_id|s:1:\"1\";user_name|s:3:\"gao\";role_id|s:1:\"1\";email|s:10:\"888@qq.com\";real_name|s:3:\"gao\";lock_screen|i:0;'),('3e1dtv0k54qvn7jd2m87ui54dk1md1kk','127.0.0.1',1479112636,'__ci_last_regenerate|i:1479112632;captcha|s:4:\"9666\";user_id|s:1:\"1\";user_name|s:3:\"gao\";role_id|s:1:\"1\";email|s:10:\"888@qq.com\";real_name|s:3:\"gao\";lock_screen|i:0;'),('qr52ekrcambngkjs622iuh007ceh17qr','127.0.0.1',1479111857,'__ci_last_regenerate|i:1479111857;captcha|s:4:\"9972\";'),('smacvvfgsd3qt3f989umfd626hdeit1m','127.0.0.1',1479112632,'__ci_last_regenerate|i:1479112632;captcha|s:4:\"9666\";user_id|s:1:\"1\";user_name|s:3:\"gao\";role_id|s:1:\"1\";email|s:10:\"888@qq.com\";real_name|s:3:\"gao\";lock_screen|i:0;');

/*Table structure for table `ci_slides` */

DROP TABLE IF EXISTS `ci_slides`;

CREATE TABLE `ci_slides` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `sort_order` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_slides` */

/*Table structure for table `ci_times` */

DROP TABLE IF EXISTS `ci_times`;

CREATE TABLE `ci_times` (
  `user_name` char(40) NOT NULL,
  `ip` char(15) NOT NULL,
  `login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `times` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_name`,`isadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_times` */

/*Table structure for table `ci_user` */

DROP TABLE IF EXISTS `ci_user`;

CREATE TABLE `ci_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '会员账号',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `nick_name` varchar(100) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `pay_password` char(32) NOT NULL DEFAULT '' COMMENT '支付密码',
  `user_rank` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '等级',
  `user_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '九月豆',
  `gold_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金豆',
  `shop_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '购物豆',
  `recommend_bonus` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推荐奖',
  `market_bonus` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场奖',
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1主账号,0否',
  `is_cast` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1倍投,0否',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1锁定，0正常',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机码',
  `pay_salt` char(6) NOT NULL DEFAULT '' COMMENT '支付随机码',
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `mobile` (`mobile`),
  KEY `is_main` (`is_main`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_user` */

/*Table structure for table `ci_user_agent` */

DROP TABLE IF EXISTS `ci_user_agent`;

CREATE TABLE `ci_user_agent` (
  `agent_id` int(10) NOT NULL DEFAULT '0' COMMENT '代理号段',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `agent_rank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '代理等级',
  `agent_name` varchar(100) NOT NULL DEFAULT '' COMMENT '代理商名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1正常，2暂停'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_user_agent` */

/*Table structure for table `ci_user_card` */

DROP TABLE IF EXISTS `ci_user_card`;

CREATE TABLE `ci_user_card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `card_no` varchar(100) NOT NULL DEFAULT '' COMMENT '卡号',
  `bank_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '银行卡id',
  PRIMARY KEY (`card_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_user_card` */

/*Table structure for table `ci_user_log` */

DROP TABLE IF EXISTS `ci_user_log`;

CREATE TABLE `ci_user_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `log_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '日志类型',
  `money_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'money类型',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `before_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '变化前（金额）',
  `after_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '变化后（金额）',
  `log_info` varchar(255) NOT NULL DEFAULT '' COMMENT '日志信息',
  `log_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '日志时间',
  PRIMARY KEY (`log_id`),
  KEY `log_type` (`log_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_user_log` */

/*Table structure for table `ci_user_withdrawals` */

DROP TABLE IF EXISTS `ci_user_withdrawals`;

CREATE TABLE `ci_user_withdrawals` (
  `wl_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `real_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未审核1已审核2拒绝',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `confirm_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '确认时间',
  PRIMARY KEY (`wl_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_user_withdrawals` */


