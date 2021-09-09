SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `union_video`;
CREATE TABLE `union_video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `type` varchar(50) CHARACTER SET utf8 DEFAULT '' COMMENT '类型',
  `title` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '标题',
  `url` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '视频路径',
  `introduct` varchar(600) CHARACTER SET utf8 DEFAULT '' COMMENT '简介',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否热门：0.否；1.是',
  `is_rec` tinyint(1) unsigned DEFAULT '0' COMMENT '是否推荐：0.否；1.是',
  `sort` int(11) DEFAULT '0' COMMENT '排序，越大越前',
  `cid` int(11) DEFAULT '0' COMMENT '分类id',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `is_hot` (`is_hot`) USING BTREE,
  KEY `is_rec` (`is_rec`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='视频表';
DROP TABLE IF EXISTS `union_video_category`;
CREATE TABLE `union_video_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) DEFAULT '' COMMENT '分类描述',
  `icon_type` varchar(6) DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
  `icon` varchar(255) DEFAULT '' COMMENT 'Icon 路径',
  `create_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `content` text COMMENT '培训说明',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='视频分类表';

INSERT INTO `union_menus` VALUES (NULL, '专辑管理', 'admin/video/category', 'admin', '41', '2', 'css', null, 'css', null, '', '0', '1', '2020-11-17 11:00:23', null);
INSERT INTO `union_modules` VALUES (NULL, '阿里云OSS', 'UnionCMS', '1.0.0', '阿里云OSS', 'ossaliyun/icon.png', 'ossaliyun', '1', '2020-11-26 15:14:38', '2020-11-26 15:14:34', '0', '1');

ALTER TABLE `union_transfer_order` CHANGE `module` `module` VARCHAR( 100 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模块',CHANGE `action` `action` VARCHAR( 100 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '回调函数名';
ALTER TABLE `union_transfer_order` ADD `child_module` VARCHAR( 100 ) NULL DEFAULT '' COMMENT '子模块' AFTER `module` ;




SET FOREIGN_KEY_CHECKS = 1;