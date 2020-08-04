SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `union_menus` VALUES (57, '广告管理', '#', 'admin','0','1','css','fa fa-picture-o','css',NULL, '', NULL,'1','2020-03-07 13:44:44','2020-03-07 13:44:44');
INSERT INTO `union_menus` VALUES (58, '广告列表', 'admin/advertisement', 'admin','57','2','css','','css',NULL, '', NULL,'1','2020-03-07 13:45:51','2020-03-07 13:45:51');
INSERT INTO `union_menus` VALUES (59, 'Banner列表', 'admin/banner', 'admin','57','2','css','','css',NULL, '', NULL,'1','2020-03-07 13:46:12','2020-03-07 13:46:12');
INSERT INTO `union_menus` VALUES (60, '文章管理', 'admin/article', 'admin','41','2','css','','css',NULL, '', NULL,'1','2020-03-07 13:46:12','2020-03-07 13:46:12');

DROP TABLE IF EXISTS `union_advertisement`;
CREATE TABLE `union_advertisement` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id主键',
  `req_type` varchar(30) NOT NULL DEFAULT 'app' COMMENT 'small=小程序，public=公众号，pc=PC端，app=APP端',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) DEFAULT '#' COMMENT '跳转路径',
  `type` varchar(25) DEFAULT 'self' COMMENT '工具类型，jump=跳转，self=APP自带',
  `is_self_support` tinyint(1) DEFAULT '1' COMMENT '是否自营，1=自营，2=第三方',
  `need_login` tinyint(1) DEFAULT '2' COMMENT '是否需要登录，1=需要，2=不需要',
  `is_company` tinyint(1) DEFAULT '2' COMMENT '是否是公司内部，1=是，2=不是',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态【1=启用，2=禁用】',
  `create_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='广告表';


DROP TABLE IF EXISTS `union_banner`;
CREATE TABLE `union_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id主键',
  `req_type` varchar(30) NOT NULL DEFAULT 'app' COMMENT 'small=小程序，public=公众号，pc=PC端，app=APP端',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) DEFAULT '#' COMMENT '跳转路径',
  `type` varchar(25) DEFAULT 'self' COMMENT '工具类型，jump=跳转，self=APP自带',
  `is_self_support` tinyint(1) DEFAULT '1' COMMENT '是否自营，1=自营，2=第三方',
  `need_login` tinyint(1) DEFAULT '2' COMMENT '是否需要登录，1=需要，2=不需要',
  `is_company` tinyint(1) DEFAULT '2' COMMENT '是否是公司内部，1=是，2=不是',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态【1=启用，2=禁用】',
  `create_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='广告表';

DROP TABLE IF EXISTS `union_article`;
CREATE TABLE `union_article` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
    `title` varchar(255) DEFAULT '' COMMENT '标题',
    `tags` varchar(255) DEFAULT '' COMMENT '标签',
    `cover` varchar(255) DEFAULT '' COMMENT '封面',
    `introduct` varchar(600) DEFAULT '' COMMENT '简介',
    `content` text COMMENT '内容',
    `cid` int(11) unsigned DEFAULT '0' COMMENT '分类ID',
    `create_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
    `update_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `is_hot` tinyint(1) unsigned DEFAULT '0' COMMENT '是否热门：0.否；1.是',
    `is_rec` tinyint(1) unsigned DEFAULT '0' COMMENT '是否推荐：0.否；1.是',
    `seo_keywords` varchar(255) DEFAULT '' COMMENT '关键词搜索',
    `seo_description` varchar(255) DEFAULT '' COMMENT '描述',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `cid` (`cid`) USING BTREE,
    KEY `is_hot` (`is_hot`) USING BTREE,
    KEY `is_rec` (`is_rec`) USING BTREE
  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章表';

  DROP TABLE IF EXISTS `union_article_category`;
  CREATE TABLE `union_article_category` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
      `name` varchar(255) DEFAULT '' COMMENT '分类名称',
      `describe` varchar(125) DEFAULT '' COMMENT '分类描述',
      `icon_type` varchar(6) DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
      `icon` varchar(255) DEFAULT '' COMMENT 'Icon 路径',
      `create_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
      PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章分类表';

ALTER TABLE `union_home_visit_logs` ADD `useragent` varchar(255) DEFAULT NULL COMMENT '浏览器标识';
ALTER TABLE `union_home_visit_logs` ADD `spider` varchar(255) DEFAULT NULL COMMENT '蜘蛛标识';

SET FOREIGN_KEY_CHECKS = 1;