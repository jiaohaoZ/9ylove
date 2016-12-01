-- 添加内容管理
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('19','message_manage','0','message','message','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('20','notice_manage','19','message','notice_list','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('21','slide','20','message','slide','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('22','slide','21','message','slide','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('23','slide_add','21','message','slide_add','add',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('24','bank','20','message','bank','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('25','bank','24','message','bank','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('26','bank_add','24','message','bank_add','add',0,1);

-- 添加配置
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES
  ('admin_folder', 'admin', 0),
  ('page_size', '15', 0),
  ('theme', 'default', 0);

--添加倍投账号设置
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('user_cast_config', '{\"market_bonus\":0.5,\"buy_one_cast\":69}', '1');


-- 添加活动
CREATE TABLE `ci_article` (
  `art_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `modify_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未发布1发布',
  `sort_order` tinyint(4) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`art_id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 活动管理
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('27','article','20','message','article','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('28','article','27','message','article','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('29','article_add','27','message','article_add','add',0,1);

--添加配置 upload_max_size
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('upload_max_size',10000000,0);


--注册生成副账户数量配置
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('register_create_num', '20', '0');

--发送验证码
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('sms_config', '{\"accountSid\":\"aaf98f894e52805a014e6136ce2409bb\",\"accountToken\":\"6a114558a4584ca6b7dabaaf5d68ef45\",\"appId\":\"aaf98f894e52805a014e615801d409ef\",\"serverIP\":\"app.cloopen.com\",\"serverPort\":\"8883\",\"softVersion\":\"2013-12-26\",\"codeTplId\":\"25507\",\"msgTplId\":\"27043\"}', '1');

--添加会员管理菜单
INSERT INTO `ci_menu` (`id`, `name`, `parent_id`, `c`, `m`, `a`, `listorder`, `display`) VALUES ('30', 'user_manage', '0', 'user_manage', 'user_manage', 'init', '0', '1');
INSERT INTO `ci_menu` (`id`, `name`, `parent_id`, `c`, `m`, `a`, `listorder`, `display`) VALUES ('31', 'user_manages', '30', 'user_manages', 'user_manages', 'init', '0', '1');
INSERT INTO `ci_menu` (`id`, `name`, `parent_id`, `c`, `m`, `a`, `listorder`, `display`) VALUES ('32', 'user_list', '31', 'user', 'user_list', 'init', '0', '1');
INSERT INTO `ci_menu` (`id`, `name`, `parent_id`, `c`, `m`, `a`, `listorder`, `display`) VALUES ('33', 'user_edit', '31', 'user', 'user_edit', 'edit', '0', '1');

--活动表添加浏览次数字段
ALTER TABLE `ci_article` ADD clicks INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点击数'; 

--增加主账号ID字段
ALTER TABLE ci_user ADD main_id INT(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '主账号ID' AFTER parent_id

--增加会员个人信息字段
ALTER TABLE ci_user ADD portrait VARCHAR(255) NOT NULL COMMENT '头像';
ALTER TABLE ci_user ADD qq VARCHAR(60) NOT NULL COMMENT 'qq';
ALTER TABLE ci_user ADD wechat VARCHAR(60) NOT NULL COMMENT '微信';
ALTER TABLE ci_user ADD gender TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0:保密，1:男，2:女';

--增加奖金记录表
CREATE TABLE `ci_bonus` (
  `bonus_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bonus_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:推荐奖，2:市场奖',
  `bonus_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '奖金',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `bonus_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `bonus_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`bonus_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--增加会员表注册时间，最后登录时间，最后登录ip字段
ALTER TABLE `ci_user` ADD reg_time INT(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册时间';
ALTER TABLE `ci_user` ADD last_time INT(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间';
ALTER TABLE `ci_user` ADD last_ip VARCHAR(45) NOT NULL DEFAULT '' COMMENT '最后登录IP';
--删除会员表is_cast
ALTER TABLE `ci_user` DROP COLUMN is_cast;

--增加倍投表
CREATE TABLE `ci_user_cast` (
  `cast_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cast_name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `cast_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '份数',
  `market_bonus` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场奖',
  `market_bonus_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场奖总计',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`cast_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--会员转账表
CREATE TABLE `ci_user_transfer` (
  `transfer_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `transfer_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:转出 2:转入',
  `money_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:爱心积分',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `transfer_user` varchar(100) NOT NULL DEFAULT '' COMMENT '转账对象会员账号',
  `money` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金额',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `transfer_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`transfer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--账户推荐奖、市场奖等配置
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('account_bonus_config', '{\"recommend_bonus\":\"20\",\"market_bonus\":\"60\",\"system_bonus\":\"20\",\"all_bonus\":\"100\",\"bonus_max\":\"100\"}', '1');

--更新user表status注释
ALTER TABLE `ci_user` MODIFY COLUMN `status` tinyint(1) not null default '0' COMMENT '状态，0未激活，1待激活，2已激活';

--增加user表市场奖总计跟奖金总计字段
ALTER TABLE `ci_user` ADD market_bonus_total DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '市场奖总计' AFTER market_bonus;
ALTER TABLE `ci_user` ADD bonus_total DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '奖金总计' AFTER market_bonus_total;


--银行管理添加image字段
ALTER TABLE `ci_bank` ADD bank_image VARCHAR(255) NOT NULL DEFAULT '' COMMENT '银行图片';

--添加是否认证字段
ALTER TABLE `ci_user` ADD is_real tinyint(1) not null default '0' COMMENT '状态，0未认证，1待审核，2已认证';


--实名认证图片表
CREATE TABLE `ci_identity_image` (
  `real_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `real_img1` varchar(255) NOT NULL COMMENT '图片1',
  `real_img2` varchar(255) NOT NULL COMMENT '图片2',
  `real_img3` varchar(255) NOT NULL COMMENT '图片3',
  PRIMARY KEY (`real_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--转账表添加转账对象id
ALTER TABLE `ci_user_transfer` ADD transfer_user_id int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '转账对象会员id' AFTER user_id;
ALTER TABLE `ci_user_transfer` MODIFY COLUMN `money_type` tinyint(1) UNSIGNED not null default '0' COMMENT '1:爱心积分,2:向日葵积分';

--提现表添加银行卡号id字段
ALTER TABLE `ci_user_withdrawals` ADD card_id int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '银行卡号id' AFTER real_money;

ALTER TABLE `ci_user_withdrawals` ADD card_no varchar(100) NOT NULL NOT NULL DEFAULT '' COMMENT '银行卡号' AFTER card_id;

--添加身份证号
ALTER TABLE `ci_user` ADD identity_card varchar(255) NOT NULL DEFAULT '' COMMENT '身份证号';

--增加激活金额配置
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('active_money', '100', '0');

--添加提现菜单
INSERT INTO `ci_menu` (`id`, `name`, `parent_id`, `c`, `m`, `a`, `listorder`, `display`) VALUES ('31', 'user_withdrawals', '28', 'user', 'user_withdrawals', 'init', '0', '1');
INSERT INTO `ci_menu` (`id`, `name`, `parent_id`, `c`, `m`, `a`, `listorder`, `display`) VALUES ('33', 'user_withdrawals', '28', 'user', 'update_status', 'edit', '0', '1');

--修改提现菜单
UPDATE `ci_menu` SET `id`='33', `name`='update_status', `parent_id`='31', `c`='user', `m`='update_status', `a`='edit', `listorder`='0', `display`='1' WHERE (`id`='33');

--添加基本设置菜单
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('34','setting','6','setting','init','init',0,1);

-- 添加配置
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES
  ('max_login_failed_times', '10', 1),
  ('captcha_register', '1', 0),
  ('mobile_region', '0', 0),
  ('send_message', '0', 0),
  ('login_game', '1', 0),
  ('login_game_api', 'http://api.septmall.com?c=uc&m=add_user', 0),
  ('login_game_key', '287C15806A861CF7DAD7246B817652C6', 0),
  ('sdk_url', 'http://api.septmall.com/', 0)，
  ('mobile_region', '0', 0);



--添加收积分记录表
CREATE TABLE `ci_money_exchange` (
`log_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id' ,
`login_id`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录账户' ,
`user_id`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id' ,
`cast_id`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '倍投user_id' ,
`type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '收积分转换类型,1.推荐奖、市场奖为爱心积分;2.推荐奖为向日葵积分,3.市场奖为向日葵积分,4.市场奖为购物积分,5.倍投收市场奖为爱心积分,6.倍投收市场奖为向日葵积分,7.倍投收市场奖为购物积分' ,
`money_num`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'money数量' ,
`add_time`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '收积分时间' ,
PRIMARY KEY (`log_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--关系表
CREATE TABLE `ci_user_relation` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  KEY `user_id` (`user_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--积分管理
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('35','finance_manage','0','finance','finance','init',0,1);
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('36','finance_manage','35','finance','finance','init',0,1);
--订单列表
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('37','order_list','36','finance','order_list','init',0,1);
--充值管理
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('38','recharge_manage','36','finance','recharge_manage','init',0,1);

--每日市场奖励
CREATE TABLE `ci_market_bonus_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `market_bonus` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '每日市场奖',
  `log_date` date NOT NULL COMMENT '日期',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--代理商表增加银行卡ID
ALTER TABLE `ci_user_agent` ADD card_id INT(10) NOT NULL DEFAULT 0 COMMENT '银行卡ID';

--银行卡表增加银行开户地址
ALTER TABLE `ci_user_card` ADD card_address VARCHAR(255) NOT NULL DEFAULT '' COMMENT '银行卡开户地址';

--配置表转换爱心积分最小金额
INSERT INTO `ci_config` (`setting_key`, `setting`, `is_json`) VALUES ('exchange_gold_min', '50', 0);

--修改代理表
DROP TABLE IF EXISTS `ci_user_agent`;

CREATE TABLE `ci_user_agent` (
`agent_id`  int(10) NOT NULL DEFAULT 0 COMMENT '代理号段' ,
`user_id`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '会员ID' ,
`agent_rank`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '代理等级' ,
`agent_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '代理商名称' ,
`status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1正常，2暂停' ,
`alipay`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '支付宝' ,
`card_no`  varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '银行卡ID' ,
`card_address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '银行卡开户地址' ,
`bank`  varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '所属银行' ,
UNIQUE INDEX `agent_id` (`agent_id`) USING BTREE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--用户日志
INSERT INTO `ci_menu` (`id`,`name`,`parent_id`,`c`,`m`,`a`,`listorder`,`display`) VALUES ('39','user_log','6','user','user_log','init',0,1);