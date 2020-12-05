SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `union_menus` (`id` ,`name` ,`path` ,`type` ,`pid` ,`level` ,`pre_icon_type` ,`pre_icon` ,`suf_icon_type` ,`suf_icon` ,`selected` ,`order` ,`stauts` ,`create_at` ,`update_at`) VALUES (NULL , '开屏广告列表', 'admin/openAD', 'admin', '57', '2', 'css', '', 'css', '', NULL , NULL , '1', '2020-07-21 17:50:35', '2020-07-21 17:50:35');

CREATE TABLE `union_open_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id主键',
  `app_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '【1=用户端，2=商家端】',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) DEFAULT '#' COMMENT '跳转路径',
  `type` varchar(25) DEFAULT 'self' COMMENT '工具类型，jump=跳转，self=APP自带',
  `is_self_support` tinyint(1) DEFAULT '1' COMMENT '是否自营，1=自营，2=第三方',
  `need_login` tinyint(1) DEFAULT '2' COMMENT '是否需要登录，1=需要，2=不需要',
  `is_company` tinyint(1) DEFAULT '2' COMMENT '是否是公司内部，1=是，2=不是',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态【1=启用，2=禁用】',
  `create_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_at` int(11) DEFAULT NULL COMMENT '更新时间',
  `sorts` tinyint(4) DEFAULT '0' COMMENT '排序',
  `expiration_time` datetime DEFAULT NULL COMMENT '过期时间',
  `count_down` tinyint(4) NOT NULL DEFAULT '5' COMMENT '倒计时',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='开屏广告表';

ALTER TABLE `union_template_message` ADD `template_id` VARCHAR( 50 ) NULL DEFAULT '' COMMENT '模板id' AFTER `template_value` ;

INSERT INTO `union_template_message` VALUES (NULL, '0', '邮件登录', 'mail_login_template', '【邮件】您正在进行邮件登录邮箱操作，验证码为：{$code}！', '', '1', '2020-05-06 14:43:28', '2020-10-09 14:09:28');
INSERT INTO `union_template_message` VALUES (NULL, '0', '认证账户', 'mail_auth_template', '【邮件】您正在进行认证操作，验证码为：{$code}！', '', '1', '2020-08-28 17:30:01', '2020-10-09 14:09:28');
INSERT INTO `union_template_message` VALUES (NULL, '1', '认证账户', 'sms_auth_template', '您正在进行认证操作，验证码为：{$code}！', '', '1', '2020-08-28 17:30:03', '2020-10-09 14:09:28');

ALTER TABLE `union_agreement` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_agreement_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_article` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_article_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_attachments` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_case` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_case_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_contact_us` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_currency` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_faq` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_faq_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_feedback` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_functions` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_join` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_languages` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_member_groups` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_members` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_menus` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_news` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_news_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_notice` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_notice_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_pages` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_product` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_product_category` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_system_message` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';
ALTER TABLE `union_themes` CHANGE `create_at` `create_at` DATETIME NULL DEFAULT NULL COMMENT '创建时间';



SET FOREIGN_KEY_CHECKS = 1;