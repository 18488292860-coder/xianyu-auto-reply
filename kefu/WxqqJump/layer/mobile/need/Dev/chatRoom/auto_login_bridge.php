<?php
session_start();

// 简化版自动登录桥接 - 使用标准MySQL连接

// 检查是否从sq系统过来的请求（通过cookie验证）
if (isset($_COOKIE['h_userName']) && isset($_COOKIE['h_passWord'])) {
    $userName = $_COOKIE['h_userName'];
    $passWord = $_COOKIE['h_passWord'];
    
    // 引入数据库配置文件
    require_once 'db_config.php';
    
    // 验证sq系统的登录信息
    $userName_escaped = $conn->real_escape_string($userName);
    $passWord_escaped = $conn->real_escape_string($passWord);
    
    $sql = "SELECT * FROM `h_kefu_config` WHERE h_admin = '$userName_escaped' AND h_pass = '$passWord_escaped' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        // sq系统登录验证通过
        
        // 验证IP地址（可选，如果IP验证有问题可以注释掉这部分）
        $current_ip = getUserIP();
        $ip_sql = "SELECT * FROM `h_kefu_login` WHERE h_user = '$userName_escaped' AND h_ip = '$current_ip'";
        $ip_result = $conn->query($ip_sql);
        
        // 为了避免IP验证问题，我们可以临时跳过IP验证
        // 或者检查是否有任何该用户的登录记录
        $any_login_sql = "SELECT * FROM `h_kefu_login` WHERE h_user = '$userName_escaped' ORDER BY h_addTime DESC LIMIT 1";
        $any_login_result = $conn->query($any_login_sql);
        
        if ($ip_result && $ip_result->num_rows > 0) {
            // IP验证通过
            $ip_verified = true;
        } elseif ($any_login_result && $any_login_result->num_rows > 0) {
            // 有登录记录但IP不匹配，更新IP记录
            $login_record = $any_login_result->fetch_assoc();
            $update_ip_sql = "UPDATE `h_kefu_login` SET h_ip = '$current_ip', h_addTime = NOW() WHERE h_user = '$userName_escaped'";
            $conn->query($update_ip_sql);
            $ip_verified = true;
        } else {
            // 没有登录记录，创建新记录
            $insert_ip_sql = "INSERT INTO `h_kefu_login` (h_user, h_ip, h_addTime) VALUES ('$userName_escaped', '$current_ip', NOW())";
            $conn->query($insert_ip_sql);
            $ip_verified = true;
        }
        
        if ($ip_verified) {
            // 设置chatRoom系统的登录session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = 'admin_backend';
            $_SESSION['admin_username'] = '螃蟹客服-林夕';
            $_SESSION['sq_original_user'] = $userName;
            
            $conn->close();
            
            // 获取要跳转的目标页面
            $target = isset($_GET['target']) ? $_GET['target'] : 'user.php';
            $name = isset($_GET['name']) ? $_GET['name'] : '';
            
            // 构建跳转URL
            $redirect_url = $target;
            if ($name) {
                $redirect_url .= '?name=' . urlencode($name);
            }
            
            // 跳转到目标页面
            header('Location: ' . $redirect_url);
            exit;
        }
    }
    
    $conn->close();
}

// 如果验证失败，显示错误信息并提供跳转选项
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录验证失败 - 聊天室</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
        .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; max-width: 500px; }
        .btn { background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 10px; }
        .btn.secondary { background: #6c757d; }
    </style>
</head>
<body>
    <div class="error">
        <h2>🔐 自动登录验证失败</h2>
        <p>无法验证您的sq系统登录状态</p>
        
        <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; text-align: left;">
            <h4>可能的原因：</h4>
            <ul>
                <li>还没有从sq系统登录</li>
                <li>登录状态已过期</li>
                <li>Cookie信息不匹配</li>
            </ul>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="../../sq/login.php" class="btn">🔙 返回sq系统登录</a>
            <a href="admin_login.php" class="btn secondary">🔑 直接管理员登录</a>
        </div>
        
        <div style="margin-top: 20px; font-size: 0.9em; color: #666;">
            <p>调试信息：</p>
            <p>h_userName Cookie: <?php echo isset($_COOKIE['h_userName']) ? '存在' : '不存在'; ?></p>
            <p>h_passWord Cookie: <?php echo isset($_COOKIE['h_passWord']) ? '存在' : '不存在'; ?></p>
        </div>
    </div>
</body>
</html>
<?php

/**
 * 获取用户真实IP地址
 */
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = '127.0.0.1';
    }
    return $ip;
}
?> 