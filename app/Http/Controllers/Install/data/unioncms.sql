/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50643
 Source Host           : localhost:3306
 Source Schema         : unioncmstest

 Target Server Type    : MySQL
 Target Server Version : 50643
 File Encoding         : 65001

 Date: 09/01/2020 12:14:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for union_agreement
-- ----------------------------
DROP TABLE IF EXISTS `union_agreement`;
CREATE TABLE `union_agreement`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `cid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类ID',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cid`(`cid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '协议管理表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_agreement
-- ----------------------------
INSERT INTO `union_agreement` VALUES (1, '注册协议', NULL, 1, '2020-01-09 12:08:31', '2020-01-09 12:08:31', NULL, '');

-- ----------------------------
-- Table structure for union_agreement_category
-- ----------------------------
DROP TABLE IF EXISTS `union_agreement_category`;
CREATE TABLE `union_agreement_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '协议分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_agreement_category
-- ----------------------------
INSERT INTO `union_agreement_category` VALUES (1, '会员注册协议', '会员注册协议', '2019-07-02 17:50:29', '2019-07-02 17:50:29');
INSERT INTO `union_agreement_category` VALUES (2, '扩展协议', '扩展协议', '2019-07-02 17:49:50', '2019-07-02 17:49:50');

-- ----------------------------
-- Table structure for union_attachments
-- ----------------------------
DROP TABLE IF EXISTS `union_attachments`;
CREATE TABLE `union_attachments`  (
  `path` varchar(655) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '路径，也就是文件名',
  `path_md5` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Path 的md5值，用于快速查找',
  `drive` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '驱动，local',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  INDEX `path`(`path`(255)) USING BTREE,
  INDEX `path_md5`(`path_md5`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '附件表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_attachments
-- ----------------------------
INSERT INTO `union_attachments` VALUES ('website/logo.png', '45015146e362f86bb1f7d9721a22c192', 'local', '2019-07-28 21:52:29', '2019-07-28 21:52:29');
INSERT INTO `union_attachments` VALUES ('avatar/avatar.jpg', '5bcd1045b3066ad8d6b58e188d66d49f', 'local', '2019-07-28 21:52:29', '2019-07-28 21:52:29');

-- ----------------------------
-- Table structure for union_blogroll
-- ----------------------------
DROP TABLE IF EXISTS `union_blogroll`;
CREATE TABLE `union_blogroll`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '1=无图标 2=有图标',
  `title` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标题',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '图标路径',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '跳转路径',
  `is_rec` tinyint(1) NULL DEFAULT 0 COMMENT '是否推荐 【0：否 | 1：是】',
  `create_at` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '友情链接表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_case
-- ----------------------------
DROP TABLE IF EXISTS `union_case`;
CREATE TABLE `union_case`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题',
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标签',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '封面',
  `introduct` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '简介',
  `content` text COMMENT '内容',
  `cid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '分类ID',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `is_hot` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否热门：0.否；1.是',
  `is_rec` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否推荐：0.否；1.是',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cid`(`cid`) USING BTREE,
  INDEX `is_hot`(`is_hot`) USING BTREE,
  INDEX `is_rec`(`is_rec`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '案例表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_case_category
-- ----------------------------
DROP TABLE IF EXISTS `union_case_category`;
CREATE TABLE `union_case_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `icon_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Icon 路径',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '常见问题分类' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_contact_us
-- ----------------------------
DROP TABLE IF EXISTS `union_contact_us`;
CREATE TABLE `union_contact_us`  (
  `cid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公司名称',
  `company_desc` varchar(2555) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司简介',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '联系地址',
  `longitude` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '纬度',
  `personal` varchar(2555) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'personal 结构体\npersonal => name , contact ',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '联系我们' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_contact_us
-- ----------------------------
INSERT INTO `union_contact_us` VALUES (1, '联盟之都网络科技（深圳）有限公司', NULL, '深圳市龙岗区龙翔大道9002号志联佳大厦1710', NULL, NULL, '[{\"name\":\"业务咨询\",\"contact\":\"400-0755-540 13570849261\"},{\"name\":\"技术咨询\",\"contact\":\"400-0755-540 13570849261\"},{\"name\":\"固话\",\"contact\":\"(0755)28902284\"},{\"name\":\"Email\",\"contact\":\"822495327@qq.com\"}]', '2019-07-28 21:52:52', '2019-07-28 21:52:52');

-- ----------------------------
-- Table structure for union_currency
-- ----------------------------
DROP TABLE IF EXISTS `union_currency`;
CREATE TABLE `union_currency`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '中文名字',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '英文代码，如RMB',
  `symbol` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '符号代码，如¥',
  `is_fix` tinyint(2) UNSIGNED NULL DEFAULT 0 COMMENT '是否系统固定，1=是，0=否，否可以删除',
  `rate` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '费率，以系统默认的标准，RMB为基准',
  `position` tinyint(2) UNSIGNED NULL DEFAULT 1 COMMENT '符号的位置，1=前面，2=后面',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `is_fix`(`is_fix`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '货币' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_currency
-- ----------------------------
INSERT INTO `union_currency` VALUES (1, '人民币', 'RMB', '¥', 1, '1.00', 2, '2018-10-19 17:12:00', '2018-10-28 21:10:32');
INSERT INTO `union_currency` VALUES (3, '美元', 'USD', '$', 0, '6.80', 1, '2018-10-19 18:45:19', '2018-10-28 21:10:45');

-- ----------------------------
-- Table structure for union_faq
-- ----------------------------
DROP TABLE IF EXISTS `union_faq`;
CREATE TABLE `union_faq`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `qcid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '分类ID',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `qcid`(`qcid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '常见问题表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_faq_category
-- ----------------------------
DROP TABLE IF EXISTS `union_faq_category`;
CREATE TABLE `union_faq_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `icon_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Icon 路径',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '常见问题分类' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_faq_category
-- ----------------------------
INSERT INTO `union_faq_category` VALUES (4, '系统相关', '操作流程、授权使用、提现等等', 'css', NULL, '2018-11-18 17:16:20');
INSERT INTO `union_faq_category` VALUES (5, '云平台相关', '开发者问题、账号问题等等', 'css', NULL, '2018-11-18 17:16:59');
INSERT INTO `union_faq_category` VALUES (6, 'SEO相关', '推广、SEO相关', 'css', NULL, '2018-11-18 17:17:31');
INSERT INTO `union_faq_category` VALUES (7, '代理相关', '代理相关、后台审核等等', 'css', NULL, '2018-11-18 17:19:32');

-- ----------------------------
-- Table structure for union_feedback
-- ----------------------------
DROP TABLE IF EXISTS `union_feedback`;
CREATE TABLE `union_feedback`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '姓名',
  `user_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '邮箱',
  `content` text COMMENT '内容',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `uid` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '会员主键',
  `user_tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机号',
  `reply` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '回复信息【待定】',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员留言管理表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_functions
-- ----------------------------
DROP TABLE IF EXISTS `union_functions`;
CREATE TABLE `union_functions`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '名字',
  `pid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '上级ID',
  `level` int(4) UNSIGNED NULL DEFAULT 0 COMMENT '级别，1=1级，2=二级',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '路径URL',
  `permissions` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '权限名称',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限控制表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_functions
-- ----------------------------
INSERT INTO `union_functions` VALUES (1, '首页', 0, 1, '/', 'admin/index', '2018-11-25 23:25:09');
INSERT INTO `union_functions` VALUES (2, '用户管理', 0, 1, '#', NULL, '2018-11-25 23:33:30');
INSERT INTO `union_functions` VALUES (3, '管理员', 2, 2, 'admin/admins', 'admins', '2018-11-25 23:38:14');
INSERT INTO `union_functions` VALUES (4, '注册会员', 2, 2, 'admin/users', 'users', '2018-12-13 22:19:55');
INSERT INTO `union_functions` VALUES (5, '系统设置', 0, 1, '#', NULL, '2018-12-13 22:21:58');
INSERT INTO `union_functions` VALUES (6, '基本设置', 5, 2, '#', NULL, '2018-12-13 22:22:23');
INSERT INTO `union_functions` VALUES (7, '风格管理', 5, 2, 'admin/themes', 'themes', '2018-12-13 22:26:12');
INSERT INTO `union_functions` VALUES (8, 'SEO设置', 5, 2, '#', NULL, '2018-12-13 22:26:42');
INSERT INTO `union_functions` VALUES (9, '导航管理', 5, 2, '#', NULL, '2018-12-13 22:27:03');
INSERT INTO `union_functions` VALUES (10, '默认设置', 6, 3, 'admin/base', 'admin/base', '2018-12-13 22:33:24');
INSERT INTO `union_functions` VALUES (11, '多语言', 6, 3, 'admin/language', 'language', '2018-12-13 22:34:16');
INSERT INTO `union_functions` VALUES (12, '前台导航', 9, 3, 'admin/menu/home', 'menu/home', '2019-01-03 01:00:02');
INSERT INTO `union_functions` VALUES (13, '前台导航添加', 9, 3, 'admin/menu/home/add', 'menu/home/add', '2019-01-03 01:01:12');
INSERT INTO `union_functions` VALUES (14, '后台导航', 9, 3, 'admin/menu/admin', 'menu/admin', '2019-01-03 01:02:22');
INSERT INTO `union_functions` VALUES (15, '后台导航添加', 9, 3, 'admin/menu/admin/add', 'menu/admin/add', '2019-01-03 01:03:03');
INSERT INTO `union_functions` VALUES (16, '权限组管理', 9, 3, 'admin/menu/group', 'menu/group', '2019-01-03 01:04:11');
INSERT INTO `union_functions` VALUES (17, '权限组添加', 9, 3, 'admin/menu/group/add', 'menu/group/add', '2019-01-03 01:05:01');
INSERT INTO `union_functions` VALUES (18, '权限列表', 9, 3, 'admin/menu/auth', 'menu/auth', '2019-01-03 01:05:52');
INSERT INTO `union_functions` VALUES (19, '权限添加', 9, 3, 'admin/menu/auth/add', 'menu/auth/add', '2019-01-03 01:06:31');
INSERT INTO `union_functions` VALUES (20, '安全与工具', 0, 1, '#', NULL, '2019-01-03 01:07:45');
INSERT INTO `union_functions` VALUES (21, '安全设置', 20, 2, 'admin/safe', 'safe', '2019-01-03 01:08:48');
INSERT INTO `union_functions` VALUES (22, '上传设置', 20, 2, 'admin/upload', 'upload', '2019-01-03 01:09:53');
INSERT INTO `union_functions` VALUES (23, '缓存配置', 20, 2, 'admin/cache', 'cache', '2019-01-03 01:10:38');
INSERT INTO `union_functions` VALUES (24, '数据维护', 20, 2, 'admin/tables', 'tables', '2019-01-03 01:11:15');
INSERT INTO `union_functions` VALUES (25, '计划任务', 20, 2, '#', NULL, '2019-01-03 01:11:53');
INSERT INTO `union_functions` VALUES (26, '其他相关', 0, 1, '#', NULL, '2019-01-05 20:50:56');
INSERT INTO `union_functions` VALUES (27, '单页管理', 26, 2, 'admin/pages', 'pages', '2019-01-05 20:51:43');
INSERT INTO `union_functions` VALUES (28, '访问统计', 26, 2, '#', NULL, '2019-01-05 20:52:13');
INSERT INTO `union_functions` VALUES (29, '常见问题', 26, 2, 'admin/faq', 'faq', '2019-01-05 20:52:55');
INSERT INTO `union_functions` VALUES (30, '功能模块', 0, 1, 'admin/feature', 'feature', '2019-01-05 20:53:43');
INSERT INTO `union_functions` VALUES (31, '云应用', 0, 1, '#', NULL, '2019-01-05 20:54:08');
INSERT INTO `union_functions` VALUES (32, '多货币', 6, 3, 'admin/currency', 'currency', '2019-01-05 22:20:38');
INSERT INTO `union_functions` VALUES (33, '国家与地区', 6, 3, 'admin/country', 'admin/country', '2019-01-05 22:23:24');
INSERT INTO `union_functions` VALUES (34, '协议管理', 6, 3, '#', NULL, '2019-01-05 22:23:53');
INSERT INTO `union_functions` VALUES (35, '代理管理', 2, 2, 'admin/agents', 'agents', '2019-01-07 22:12:37');
INSERT INTO `union_functions` VALUES (36, '获取语言列表', 11, 4, 'admin/getLanguageByType', NULL, '2019-01-16 00:17:11');

-- ----------------------------
-- Table structure for union_home_visit_logs
-- ----------------------------
DROP TABLE IF EXISTS `union_home_visit_logs`;
CREATE TABLE `union_home_visit_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `uid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '会员主键',
  `current_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '当前页面URL',
  `http_referer` varchar(2555) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '页面来源【上一个URL地址】',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '访问IP',
  `useragent` varchar(255) DEFAULT NULL COMMENT '浏览器标识',
  `spider` varchar(255) DEFAULT NULL COMMENT '蜘蛛标识',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '所有Home模块的浏览记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_join
-- ----------------------------
DROP TABLE IF EXISTS `union_join`;
CREATE TABLE `union_join`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `position` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '职位',
  `description` varchar(6000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '岗位职责',
  `requirements` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '岗位要求',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态，0=禁用，1=启用',
  `created_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '加入我们' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_languages
-- ----------------------------
DROP TABLE IF EXISTS `union_languages`;
CREATE TABLE `union_languages`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '语言包位置，api = API语言包 ， admin = 后台语言包，home = 前台语言包',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '语言名字',
  `shortcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '语言缩写',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '状态，1=启用，0=禁用',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '多语言图标',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '  多语言' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_languages
-- ----------------------------
INSERT INTO `union_languages` VALUES (9, 'admin', '中文简体', 'zh', '正式的', 1, 'icon/2019-07-30/5d3fe13edabc3.png', '2019-07-30 14:18:39');
INSERT INTO `union_languages` VALUES (13, 'api', '中文简体', 'zh', '正式的', 1, 'icon/2019-07-30/5d3fe1df88de6.png', '2019-07-30 21:25:45');
INSERT INTO `union_languages` VALUES (14, 'home', '简体中文', 'zh', '正式的', 1, 'icon/2019-07-30/5d3fe1ed09ce5.png', '2019-07-30 21:25:46');

-- ----------------------------
-- Table structure for union_member_groups
-- ----------------------------
DROP TABLE IF EXISTS `union_member_groups`;
CREATE TABLE `union_member_groups`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '名称',
  `fid_lists` varchar(6000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '权限列表',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限分组' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_member_groups
-- ----------------------------
INSERT INTO `union_member_groups` VALUES (1, '普通管理员', '1,2,3,4,5,6,10,11,32,33,34,7,8,9,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31', '2018-11-24 00:11:32', '2019-01-06 17:51:45');
INSERT INTO `union_member_groups` VALUES (2, '财务主管', NULL, '2019-01-06 20:25:49', NULL);
INSERT INTO `union_member_groups` VALUES (3, '一级代理', '1,2,3,4,35', '2019-01-07 22:23:55', '2019-01-07 22:24:27');

-- ----------------------------
-- Table structure for union_members
-- ----------------------------
DROP TABLE IF EXISTS `union_members`;
CREATE TABLE `union_members`  (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像路径',
  `c_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '国家代号，如+86',
  `phone` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联系手机',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `male` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '性别',
  `birthday` date NULL DEFAULT NULL COMMENT '生日',
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `type` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员类型，admin, member,agent,and more',
  `phone_active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '手机是否认证，0=否，1=是',
  `email_active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '邮件是否认证，0=否，1=是',
  `gid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '所在组列表，后台登录才需要,”,”隔开,超级管理员 = 0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '账号状态，0=禁用，1=启用',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `change_username` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否可以更改用户名【0.否；1.是】\r\n1.针对于第三方快捷登陆\r\n2.短信注册',
  `integral` int(11) NULL DEFAULT NULL COMMENT '用户积分',
  `signature` VARCHAR( 555 ) NULL DEFAULT  '' COMMENT  '个性签名',
  PRIMARY KEY (`uid`) USING BTREE,
  KEY `phone` (`phone`),
  KEY `email` (`email`),
  KEY `username` (`username`),
  KEY `password` (`password`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_members_login_logs
-- ----------------------------
DROP TABLE IF EXISTS `union_members_login_logs`;
CREATE TABLE `union_members_login_logs`  (
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录的uid',
  `ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登录ip',
  `login_at` datetime(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '登录时间',
  `device_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '设备类型，PC、iOS、android',
  `device_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '设备名字',
  `device_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '设备token',
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '登录历史' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_members_verify_logs
-- ----------------------------
DROP TABLE IF EXISTS `union_members_verify_logs`;
CREATE TABLE `union_members_verify_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '会员Id',
  `verify_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '认证类型：\r\n0.邮箱\r\n1.手机号',
  `verify_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '验证码',
  `verify_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '发送内容',
  `verify_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '发送标题',
  `verify_receive` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '接收方',
  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否已激活/认证，0=否，1=是',
  `enddate_at` datetime(0) NULL DEFAULT NULL COMMENT '过期时间：默认10分钟',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `origin_type` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '来源类型：\r\n0.小程序API\r\n1.PC站点\r\n2.3D相册\r\n3.开发者中心',
  `bind_type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '绑定类型：\r\n1.绑定\r\n0.解绑',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `is_active`(`is_active`) USING BTREE,
  INDEX `verify_type`(`verify_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员安全认证记录表【邮箱认证等】【API接口类必须要存储】' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_menus
-- ----------------------------
DROP TABLE IF EXISTS `union_menus`;
CREATE TABLE `union_menus`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '导航名字',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '路径，包括外部路径',
  `type` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '导航类型，home=前台，admin=后台',
  `pid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '父ID，0=顶级',
  `level` tinyint(4) UNSIGNED NULL DEFAULT 1 COMMENT '级别，1=一级，2=2级以此类推',
  `pre_icon_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '前缀图标类型，css=css,img = 图标',
  `pre_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '前缀图标，http开头表示外表连接',
  `suf_icon_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '后缀图标类型，css=css img = 图片',
  `suf_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '后缀图标',
  `selected` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '选中状态',
  `order` tinyint(2) NULL DEFAULT NULL COMMENT '排序',
  `stauts` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态，1=启用，0=禁用',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `stauts`(`stauts`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '导航表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_menus
-- ----------------------------
INSERT INTO `union_menus` VALUES (6, '首页', '/admin', 'admin', 0, 1, 'css', 'fa fa-home', 'css', NULL, NULL, NULL, 1, '2018-11-14 23:24:01', NULL);
INSERT INTO `union_menus` VALUES (7, '用户管理', '#', 'admin', 0, 1, 'css', 'fa fa-users', 'css', NULL, NULL, NULL, 1, '2018-11-15 00:16:57', NULL);
INSERT INTO `union_menus` VALUES (8, '管理员', 'admin/admins', 'admin', 7, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-15 00:17:35', NULL);
INSERT INTO `union_menus` VALUES (9, '代理管理', 'admin/agents', 'admin', 7, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-15 00:22:40', NULL);
INSERT INTO `union_menus` VALUES (10, '注册会员', 'admin/users', 'admin', 7, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-15 00:23:14', NULL);
INSERT INTO `union_menus` VALUES (14, '系统设置', '#', 'admin', 0, 1, 'css', 'fa icon-settings', 'css', NULL, NULL, NULL, 1, '2018-11-18 17:43:36', NULL);
INSERT INTO `union_menus` VALUES (15, '基本设置', '#', 'admin', 14, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:44:02', NULL);
INSERT INTO `union_menus` VALUES (16, '默认设置', 'admin/base', 'admin', 15, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:44:59', NULL);
INSERT INTO `union_menus` VALUES (17, '多语言', 'admin/language', 'admin', 15, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:45:28', NULL);
INSERT INTO `union_menus` VALUES (18, '多货币', 'admin/currency', 'admin', 15, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:45:55', NULL);
INSERT INTO `union_menus` VALUES (19, '国家与地区', 'admin/country', 'admin', 15, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:46:21', NULL);
INSERT INTO `union_menus` VALUES (20, '协议管理', 'admin/agreement', 'admin', 15, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-07-02 17:27:30', '2019-07-02 17:27:30');
INSERT INTO `union_menus` VALUES (21, '风格管理', 'admin/themes', 'admin', 14, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:47:14', NULL);
INSERT INTO `union_menus` VALUES (22, 'SEO设置', 'admin/seo', 'admin', 14, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-07-20 15:32:39', '2019-07-20 15:32:39');
INSERT INTO `union_menus` VALUES (23, '导航管理', '#', 'admin', 14, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:48:05', NULL);
INSERT INTO `union_menus` VALUES (24, '前台导航', 'admin/menu/home', 'admin', 23, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:48:39', NULL);
INSERT INTO `union_menus` VALUES (25, '后台导航', 'admin/menu/admin', 'admin', 23, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:49:05', NULL);
INSERT INTO `union_menus` VALUES (26, '权限组管理', 'admin/menu/group', 'admin', 23, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:49:27', NULL);
INSERT INTO `union_menus` VALUES (27, '安全与工具', '#', 'admin', 0, 1, 'css', 'fa fa-wrench', 'css', NULL, NULL, NULL, 1, '2018-11-18 17:50:14', NULL);
INSERT INTO `union_menus` VALUES (28, '安全设置', 'admin/safe', 'admin', 27, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:50:42', NULL);
INSERT INTO `union_menus` VALUES (29, '上传设置', 'admin/upload', 'admin', 27, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:51:07', NULL);
INSERT INTO `union_menus` VALUES (30, '缓存配置', 'admin/cache', 'admin', 27, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:51:36', NULL);
INSERT INTO `union_menus` VALUES (31, '数据维护', 'admin/tables', 'admin', 27, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:52:00', NULL);
INSERT INTO `union_menus` VALUES (32, '计划任务', '#', 'admin', 27, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:52:50', NULL);
INSERT INTO `union_menus` VALUES (33, '其他相关', '#', 'admin', 0, 1, 'css', 'fa fa-bars', 'css', NULL, NULL, NULL, 1, '2018-11-18 17:55:29', NULL);
INSERT INTO `union_menus` VALUES (34, '单页管理', 'admin/pages', 'admin', 33, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-18 17:56:06', NULL);
INSERT INTO `union_menus` VALUES (35, '访问统计', 'admin/visit', 'admin', 33, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-07-06 14:44:03', '2019-07-06 14:44:03');
INSERT INTO `union_menus` VALUES (36, '常见问题', 'admin/faq', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-06-24 18:26:25', '2019-06-24 18:26:25');
INSERT INTO `union_menus` VALUES (39, '权限列表', 'admin/menu/auth', 'admin', 23, 3, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2018-11-25 22:57:52', NULL);
INSERT INTO `union_menus` VALUES (40, '案例管理', 'admin/case', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-06-24 18:26:50', '2019-06-24 18:26:50');
INSERT INTO `union_menus` VALUES (41, '内容管理', '#', 'admin', 0, 1, 'css', 'fa fa-bars', 'css', NULL, NULL, NULL, 1, '2019-05-18 15:53:54', '2019-05-18 15:53:54');
INSERT INTO `union_menus` VALUES (42, '新闻管理', 'admin/content/news', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-05-19 16:54:22', '2019-05-19 16:54:22');
INSERT INTO `union_menus` VALUES (43, '招聘管理', 'admin/content/join', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-05-19 16:54:36', '2019-05-19 16:54:36');
INSERT INTO `union_menus` VALUES (45, '产品管理', '/admin/product', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-06-24 18:51:30', NULL);
INSERT INTO `union_menus` VALUES (46, '留言管理', 'admin/feedbacks', 'admin', 33, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-07-02 11:03:19', '2019-07-02 11:03:19');
INSERT INTO `union_menus` VALUES (47, '公告管理', 'admin/notice', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-09-20 22:14:13', NULL);
INSERT INTO `union_menus` VALUES (48, '友情链接', 'admin/blogroll', 'admin', 41, 2, 'css', NULL, 'css', NULL, NULL, NULL, 1, '2019-09-20 22:15:59', NULL);
INSERT INTO `union_menus` VALUES (49, '首页', '/', 'home', 0, 1, 'css', NULL, 'css', NULL, 'home', 99, 1, '2019-09-21 12:34:41', '2019-09-21 12:34:41');
INSERT INTO `union_menus` VALUES (50, '经典案例', '/case', 'home', 0, 1, 'css', NULL, 'css', NULL, 'case', 98, 1, '2019-09-21 12:34:53', '2019-09-21 12:34:53');
INSERT INTO `union_menus` VALUES (51, '产品列表', '/product', 'home', 0, 1, 'css', NULL, 'css', NULL, 'product', 97, 1, '2019-09-21 12:35:04', '2019-09-21 12:35:04');
INSERT INTO `union_menus` VALUES (52, '新闻资讯', '/news', 'home', 0, 1, 'css', NULL, 'css', NULL, 'news', 96, 1, '2019-09-21 12:35:15', '2019-09-21 12:35:15');
INSERT INTO `union_menus` VALUES (53, '关于我们', '/about', 'home', 0, 1, 'css', NULL, 'css', NULL, 'about', 0, 1, '2019-09-21 12:36:11', '2019-09-21 12:36:11');
INSERT INTO `union_menus` VALUES (54, '联系我们', '/contact', 'home', 0, 1, 'css', NULL, 'css', NULL, 'contact', 93, 1, '2019-09-21 12:36:01', '2019-09-21 12:36:01');
INSERT INTO `union_menus` VALUES (55, '常见问题', '/faq', 'home', 0, 1, 'css', NULL, 'css', NULL, 'faq', 95, 1, '2019-09-21 12:35:33', '2019-09-21 12:35:33');
INSERT INTO `union_menus` VALUES (56, '加入我们', '/join', 'home', 0, 1, 'css', NULL, 'css', NULL, 'join', 94, 1, '2019-09-21 12:35:48', '2019-09-21 12:35:48');
INSERT INTO `union_menus` VALUES (57, '广告管理', '#', 'admin','0','1','css','fa fa-picture-o','css',NULL, '', NULL,'1','2020-03-07 13:44:44','2020-03-07 13:44:44');
INSERT INTO `union_menus` VALUES (58, '广告列表', 'admin/advertisement', 'admin','57','2','css','','css',NULL, '', NULL,'1','2020-03-07 13:45:51','2020-03-07 13:45:51');
INSERT INTO `union_menus` VALUES (59, 'Banner列表', 'admin/banner', 'admin','57','2','css','','css',NULL, '', NULL,'1','2020-03-07 13:46:12','2020-03-07 13:46:12');
INSERT INTO `union_menus` VALUES (60, '文章管理', 'admin/article', 'admin','41','2','css','','css',NULL, '', NULL,'1','2020-03-07 13:46:12','2020-03-07 13:46:12');
INSERT INTO `union_menus` VALUES (61 , '开屏广告列表', 'admin/openAD', 'admin', '57', '2', 'css', '', 'css', '', NULL , NULL , '1', '2020-07-21 17:50:35', '2020-07-21 17:50:35');

-- ----------------------------
-- Table structure for union_modules
-- ----------------------------
DROP TABLE IF EXISTS `union_modules`;
CREATE TABLE `union_modules`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '名称',
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '作者',
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '版本号',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标',
  `identification` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '唯一标识',
  `status` tinyint(4) UNSIGNED NULL DEFAULT 0 COMMENT '模块状态，1=已启用，0=未启用',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `is_index` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '设为首页【0.否；1.是】',
  `cloud_type` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '类型：0.功能模块；1.插件',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `is_index`(`is_index`) USING BTREE,
  INDEX `cloud_type`(`cloud_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '云应用安装记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_modules
-- ----------------------------
INSERT INTO `union_modules` VALUES (49, '创蓝短信', 'UnionCMS', '2.0.0', '创蓝短信', 'chuanglan/icon.png', 'chuanglan', 1, '2019-08-01 21:14:13', '2019-08-01 21:14:13', 0, 1);
INSERT INTO `union_modules` VALUES (50, '短信平台', 'UnionCMS', '1.0.0', '短信平台', 'smsplatform/icon.png', 'smsplatform', 1, '2019-08-01 21:14:35', '2019-08-01 21:14:35', 0, 1);
INSERT INTO `union_modules` VALUES (53, '七牛云', 'UnionCMS', '1.0.0', '七牛云', 'qiniu/icon.png', 'qiniu', 1, '2019-08-17 10:41:06', '2019-08-17 10:41:06', 0, 1);
INSERT INTO `union_modules` VALUES (54, 'unionPay在线支付', 'UnionCMS', '1.0.0', 'unionPay在线支付', 'unionPay/icon.png', 'unionPay', 1, '2019-08-17 10:41:06', '2019-08-17 10:41:06', 0, 1);

-- ----------------------------
-- Table structure for union_news
-- ----------------------------
DROP TABLE IF EXISTS `union_news`;
CREATE TABLE `union_news`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题',
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标签',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '封面',
  `content` text COMMENT '内容',
  `cid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '分类ID',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cid`(`cid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '新闻表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_news_category
-- ----------------------------
DROP TABLE IF EXISTS `union_news_category`;
CREATE TABLE `union_news_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `icon_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Icon 路径',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '新闻分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_notice
-- ----------------------------
DROP TABLE IF EXISTS `union_notice`;
CREATE TABLE `union_notice`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `add_uid` int(11) NULL DEFAULT NULL COMMENT '谁添加的',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `qcid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '分类ID',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `qcid`(`qcid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '常见问题表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_notice_category
-- ----------------------------
DROP TABLE IF EXISTS `union_notice_category`;
CREATE TABLE `union_notice_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `icon_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Icon 路径',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '常见问题分类' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_pages
-- ----------------------------
DROP TABLE IF EXISTS `union_pages`;
CREATE TABLE `union_pages`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '名称',
  `content` text COMMENT '内容',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '自定义url',
  `default` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否系统默认，0=否，1=是',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `default`(`default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '单页管理' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_pages
-- ----------------------------
INSERT INTO `union_pages` VALUES (1, '关于我们', 'PHA+PGJyPjwvcD4=', 'about', 1, '2019-07-20 15:29:01', '2019-07-20 15:29:01', '123', '321');
INSERT INTO `union_pages` VALUES (2, '联系我们', 'PHA+PGJyPjwvcD4=', 'contact', 1, '2019-08-08 22:01:14', '2019-08-08 22:01:14', '顶顶顶顶', '建行卡号监控');

-- ----------------------------
-- Table structure for union_product
-- ----------------------------
DROP TABLE IF EXISTS `union_product`;
CREATE TABLE `union_product`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题',
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标签',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '封面',
  `introduct` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '简介',
  `content` text COMMENT '内容',
  `cid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '分类ID',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `is_hot` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否热门：0.否；1.是',
  `is_rec` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否推荐：0.否；1.是',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关键词搜索',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cid`(`cid`) USING BTREE,
  INDEX `is_hot`(`is_hot`) USING BTREE,
  INDEX `is_rec`(`is_rec`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_product_category
-- ----------------------------
DROP TABLE IF EXISTS `union_product_category`;
CREATE TABLE `union_product_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `icon_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标类型，css=css,img = 图标',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Icon 路径',
  `pid_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '上级路径',
  `classify_grade` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类等级',
  "pid" int(11) DEFAULT NULL,
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_settings
-- ----------------------------
DROP TABLE IF EXISTS `union_settings`;
CREATE TABLE `union_settings`  (
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '设置类型，基本设置=website',
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Key',
  `value` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Key 的值'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '设置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_settings
-- ----------------------------
INSERT INTO `union_settings` VALUES ('website', 'default_currency', '1');
INSERT INTO `union_settings` VALUES ('website', 'default_language', 'zh');
INSERT INTO `union_settings` VALUES ('website', 'multilingual', '1');
INSERT INTO `union_settings` VALUES ('website', 'multi_currency', '1');
INSERT INTO `union_settings` VALUES ('website', 'webicon', 'website/webicon.ico');
INSERT INTO `union_settings` VALUES ('website', 'weblogo', 'website/logo.png');
INSERT INTO `union_settings` VALUES ('website', 'website_desc', 'UnionCMS是一款基于laravel开发框架的cms内容管理系统，采用低耦合、模块化设计思想，适用各行各业使用。感谢广大企业、个人、开发者的支持。');
INSERT INTO `union_settings` VALUES ('website', 'website_keys', 'UnionCMS,cms,免费cms,开源cms,简单cms');
INSERT INTO `union_settings` VALUES ('website', 'website_name', 'UnionCMS内容管理系统1');
INSERT INTO `union_settings` VALUES ('website', 'website_open_reg', '1');
INSERT INTO `union_settings` VALUES ('website', 'website_reg_rqstd', 'phone,email');
INSERT INTO `union_settings` VALUES ('website', 'website_statut', '1');
INSERT INTO `union_settings` VALUES ('website', 'website_statut_when', '正常啊');
INSERT INTO `union_settings` VALUES ('third_party', 'head_codes', NULL);
INSERT INTO `union_settings` VALUES ('third_party', 'foot_codes', NULL);
INSERT INTO `union_settings` VALUES ('safe', 'limit_count', '5');
INSERT INTO `union_settings` VALUES ('safe', 'limit_time', '30');
INSERT INTO `union_settings` VALUES ('safe', 'filter_strings', 'admin');
INSERT INTO `union_settings` VALUES ('safe', 'blacklist_ip', NULL);
INSERT INTO `union_settings` VALUES ('safe', 'admin_login_code', '1');
INSERT INTO `union_settings` VALUES ('safe', 'home_submit_code', '1');
INSERT INTO `union_settings` VALUES ('website', 'admin_page_count', '10');
INSERT INTO `union_settings` VALUES ('upload', 'upload_status', '1');
INSERT INTO `union_settings` VALUES ('upload', 'upload_limit', '500000');
INSERT INTO `union_settings` VALUES ('upload', 'upload_format', 'gif,png,jpg');
INSERT INTO `union_settings` VALUES ('upload', 'upload_driver', 'local');
INSERT INTO `union_settings` VALUES ('upload', 'thumb_auto', '1');
INSERT INTO `union_settings` VALUES ('upload', 'thumb_method', 'draw');
INSERT INTO `union_settings` VALUES ('upload', 'watermark_type', 'text');
INSERT INTO `union_settings` VALUES ('upload', 'watermark_position', 'bottom-right');
INSERT INTO `union_settings` VALUES ('upload', 'watermark_text', 'UnionCMS');
INSERT INTO `union_settings` VALUES ('upload', 'watermark_text_size', '19');
INSERT INTO `union_settings` VALUES ('upload', 'watermark_text_angle', '180');
INSERT INTO `union_settings` VALUES ('upload', 'watermark_text_color', '#000000');
INSERT INTO `union_settings` VALUES ('sms', 'sms_driver', 'smsplatform');
INSERT INTO `union_settings` VALUES ('seo', 'seo_all_title', '');
INSERT INTO `union_settings` VALUES ('seo', 'seo_all_keywords', '');
INSERT INTO `union_settings` VALUES ('seo', 'seo_all_description', '');
INSERT INTO `union_settings` VALUES ('seo', 'seo_faq_title', '{title} - -常见问题');
INSERT INTO `union_settings` VALUES ('seo', 'seo_faq_keywords', '{keywrods},常见问题');
INSERT INTO `union_settings` VALUES ('seo', 'seo_faq_description', '{description}--常见问题');
INSERT INTO `union_settings` VALUES ('seo', 'seo_case_title', '{title} -- 案例展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_case_keywords', '{keywrods} , 案例展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_case_description', '{description} -- 案例展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_news_title', '{title}--新闻展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_news_keywords', '{keywrods},新闻展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_news_description', '{description}--新闻展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_joins_title', '{title}--招聘管理');
INSERT INTO `union_settings` VALUES ('seo', 'seo_joins_keywords', '{keywrods},招聘管理');
INSERT INTO `union_settings` VALUES ('seo', 'seo_joins_description', '{description}--招聘管理');
INSERT INTO `union_settings` VALUES ('seo', 'seo_product_title', '{title}--产品展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_product_keywords', '{keywrods},产品展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_product_description', '{description}--产品展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_module_title', '{title}');
INSERT INTO `union_settings` VALUES ('seo', 'seo_module_keywords', '{keywrods}');
INSERT INTO `union_settings` VALUES ('seo', 'seo_module_description', '{description}');
INSERT INTO `union_settings` VALUES ('seo', 'seo_product_list_title', '产品展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_product_list_keywords', '产品展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_product_list_description', '产品展示');
INSERT INTO `union_settings` VALUES ('seo', 'seo_joins_list_title', '招聘列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_joins_list_keywords', '招聘列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_joins_list_description', '招聘列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_news_list_title', '新闻列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_news_list_keywords', '新闻列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_news_list_description', '新闻列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_case_list_title', '案例列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_case_list_keywords', '案例列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_case_list_description', '案例列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_faq_list_title', '常见问题列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_faq_list_keywords', '常见问题列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_faq_list_description', '常见问题列表');
INSERT INTO `union_settings` VALUES ('seo', 'seo_page_title', '{title}');
INSERT INTO `union_settings` VALUES ('seo', 'seo_page_keywords', '{keywords}');
INSERT INTO `union_settings` VALUES ('seo', 'seo_page_description', '{description}');
INSERT INTO `union_settings` VALUES ('website', 'Useofcloud', 'true');
INSERT INTO `union_settings` VALUES ('pay', 'pay_driver', 'unionPay');

-- ----------------------------
-- Table structure for union_system_message
-- ----------------------------
DROP TABLE IF EXISTS `union_system_message`;
CREATE TABLE `union_system_message`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动增长ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `uid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '发送者用户id',
  `receive_uid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '接收人UID的',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '阅读状态，0=未读，1=已读',
  `created_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `receive_uid`(`receive_uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统站内信' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for union_template_message
-- ----------------------------
DROP TABLE IF EXISTS `union_template_message`;
CREATE TABLE `union_template_message`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_type` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '类型【0.短信；1.邮件】',
  `template_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'key 的 名称',
  `template_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Key',
  `template_value` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Key 的值',
  `is_start` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否开启【0.否；1.是】',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `template_type`(`template_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '模板消息配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_template_message
-- ----------------------------
INSERT INTO `union_template_message` VALUES (1, 0, '找回密码', 'mail_forgot_template', '【邮件】您正在进行找回密码操作，验证码为：{$code}！如若不是本人操作，请忽略。', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (2, 0, '注册账户', 'mail_register_template', '【邮件】您正在进行注册流程操作，验证码为：{$code}！', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (3, 0, '绑定账户', 'mail_bind_template', '【邮件】您正在进行绑定邮箱操作，验证码为：{$code}！', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (4, 0, '解除绑定', 'mail_untying_template', '【邮件】您正在进行解除绑定邮箱操作，验证码为：{$code}！', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (5, 1, '找回密码', 'sms_forgot_template', '您正在进行找回密码操作，验证码为：{$code}！如若不是本人操作，请忽略。', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (6, 1, '注册账户', 'sms_register_template', '您正在进行注册流程操作，验证码为：{$code}！', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (7, 1, '绑定账户', 'sms_bind_template', '您正在进行绑定手机号操作，验证码为：{$code}！', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (8, 1, '解除绑定', 'sms_untying_template', '您正在进行解除手机号绑定操作，验证码为：{$code}！', 1, '2019-07-15 13:40:12', '2019-07-31 01:08:30');
INSERT INTO `union_template_message` VALUES (9, 1, '短信登陆', 'sms_login_template', '您正在登陆，验证码为：{$code}！', 0, '2019-07-19 11:01:23', NULL);

-- ----------------------------
-- Table structure for union_themes
-- ----------------------------
DROP TABLE IF EXISTS `union_themes`;
CREATE TABLE `union_themes`  (
  `identification` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '主题标识，',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 2 COMMENT '1=已启用，2=未启用',
  `create_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '安装时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '主题风格' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of union_themes
-- ----------------------------
INSERT INTO `union_themes` VALUES ('default', 1, '2019-08-01 21:03:54', '2019-08-01 21:03:54');

DROP TABLE IF EXISTS `union_transfer_order`;
CREATE TABLE `union_transfer_order`  (
  `order_num` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `module` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模块',
  `action` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '回调函数名',
  `pay_method` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'WeChat=微信  Alipay=支付宝',
  `create_at` datetime(0) NULL DEFAULT NULL COMMENT '订单时间',
  PRIMARY KEY (`order_num`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '中转订单表' ROW_FORMAT = Compact;

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
  `display_page` varchar(50) DEFAULT '' COMMENT '显示页面',
  `display_position` varchar(20) DEFAULT 'top' COMMENT '显示位置【上=top,中=center,下=bottom】',
  `display_module` varchar(50) DEFAULT '' COMMENT '显示模块，空即所有模块显示',
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

  DROP TABLE IF EXISTS `union_open_ad`;
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
ALTER TABLE `union_members` ADD `pid` INT(11)  DEFAULT '1' COMMENT '上级' AFTER `signature`, ADD `pid_path` VARCHAR(255) DEFAULT '1' COMMENT '上级路径' AFTER `pid`;
ALTER TABLE `union_members` ADD `background_cover` varchar(255) DEFAULT '' COMMENT '背景封面' AFTER `pid_path`;




SET FOREIGN_KEY_CHECKS = 1;
