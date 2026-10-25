<?php
/**
 * 数据库配置文件
 * 集中管理数据库连接配置，方便修改和维护
 */

// 数据库配置参数
define('DB_HOST', 'localhost');     // 数据库主机
define('DB_USER', '110');          // 数据库用户名
define('DB_PASS', '110');        // 数据库密码
define('DB_NAME', '110');          // 数据库名

/**
 * 创建数据库连接
 * @return mysqli 数据库连接对象
 */
function createDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // 检查连接是否成功
    if ($conn->connect_error) {
        error_log("数据库连接失败: " . $conn->connect_error);
        die("数据库连接失败: " . $conn->connect_error);
    }
    
    // 设置字符集
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

/**
 * 获取数据库连接（全局变量方式，兼容现有代码）
 */
if (!isset($conn)) {
    $conn = createDBConnection();
}
?> 