SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `union_members` ADD `pid` INT(11)  DEFAULT '1' COMMENT '上级' AFTER `signature`, ADD `pid_path` VARCHAR(255) DEFAULT '1' COMMENT '上级路径' AFTER `pid`;
ALTER TABLE `union_members` ADD `background_cover` varchar(255) DEFAULT '' COMMENT '背景封面' AFTER `pid_path`;

SET FOREIGN_KEY_CHECKS = 1;