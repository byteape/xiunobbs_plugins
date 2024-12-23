<?php


!defined('DEBUG') and exit('Forbidden');


$tablepre = $db->tablepre;

$sql = "CREATE TABLE `{$tablepre}golds_record` (
	`record_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`uid` INT(10) UNSIGNED NOT NULL,
	`direction` TINYINT(1) UNSIGNED NOT NULL COMMENT '0：-；1：+',
	`number` INT(10) UNSIGNED NOT NULL COMMENT '数量',
	`type` TINYINT(1) UNSIGNED NOT NULL COMMENT '1：充值+；2：提现-；4：出售+；3：购买-',
	`create_time` INT(10) UNSIGNED NOT NULL,
	`tran_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '帖子交易id',
	`tid` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '帖子id',
	`remark` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`record_id`)
)
COMMENT='金币变更记录表'
COLLATE='utf8_general_ci'
ENGINE=MyISAM;

CREATE TABLE `{$tablepre}thread_tran_record` (
	`tran_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`tid` INT(10) UNSIGNED NOT NULL COMMENT '帖子id',
	`b_uid` INT(10) UNSIGNED NOT NULL COMMENT '购买用户id',
	`s_uid` INT(10) UNSIGNED NOT NULL COMMENT '出售用户id',
	`price` INT(10) UNSIGNED NOT NULL COMMENT '价格',
	`create_time` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`tran_id`)
)
COMMENT='帖子交易记录'
COLLATE='utf8_general_ci'
ENGINE=MyISAM;
";

$r = db_exec($sql);
$r === FALSE and message(-1, '创建表结构失败'); // 中断，安装失败。
