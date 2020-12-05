SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

alter table union_advertisement add display_page varchar(50) DEFAULT '' COMMENT '显示页面';
alter table union_advertisement add display_position varchar(20) DEFAULT 'top' COMMENT '显示位置【上=top,中=center,下=bottom】';
alter table union_advertisement add display_module varchar(50) DEFAULT '' COMMENT '显示模块，空即所有模块显示';


SET FOREIGN_KEY_CHECKS = 1;