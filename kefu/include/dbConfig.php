<?php
$con_db_host = "127.0.0.1";      //数据库服务器
$con_db_id   = "kefu";           //数据库用户名
$con_db_pass = "kefu@2026";      //数据库密码
$con_db_name = "kefu_db";        //数据库名
$tablepre    = "";               //不用修改
$db_charset  = "utf8mb4";        //支持emoji

// 为兼容 conn.php 中的 extract($db_settings) 提供数组格式
$db_settings = array(
    'con_db_host' => $con_db_host,
    'con_db_id' => $con_db_id,
    'con_db_pass' => $con_db_pass,
    'con_db_name' => $con_db_name,
    'tablepre' => $tablepre,
    'db_charset' => $db_charset
);
?>
