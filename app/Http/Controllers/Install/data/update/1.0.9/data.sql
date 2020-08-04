SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE  `union_members` ADD  `signature` VARCHAR(555) NULL DEFAULT  '' COMMENT  '个性签名';
ALTER TABLE  `union_members` DROP  `open_id` ;
ALTER TABLE  `union_members` DROP  `wx_openid` ;
ALTER TABLE  `union_members` DROP  `smallwx_openid` ;
SET FOREIGN_KEY_CHECKS = 1;