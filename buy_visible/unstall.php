<?php


!defined('DEBUG') and exit('Forbidden');


$tablepre = $db->tablepre;

$sql = "DROP TABLE IF EXISTS {$tablepre}golds_record;DROP TABLE IF EXISTS {$tablepre}thread_tran_record;";
$r = db_exec($sql);
$r === FALSE and message(-1, '创建表结构失败'); // 中断，安装失败。
