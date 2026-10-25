<?php
session_start();

// 引入增强版IP用户绑定辅助函数
require_once 'enhanced_ip_user_helper.php';

// 获取房间ID参数
$room_id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (empty($room_id)) {
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>错误 - 聊天室</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
            .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>🚫 访问错误</h2>
            <p>请提供有效的房间ID！</p>
            <p>正确格式：<code>room.php?id=房间ID</code></p>
        </div>
    </body>
    </html>
    ');
}

// 引入数据库配置文件
require_once 'db_config.php';

// 检查房间是否存在 - 使用更兼容的查询
$room_id_escaped = $conn->real_escape_string($room_id);
$room_sql = "SELECT id, room_id, room_name, room_description, created_by, create_time, last_activity, status, max_users FROM chatroom_list WHERE room_id = '$room_id_escaped' AND status = 'active'";
$room_result = $conn->query($room_sql);

// 添加错误检查
if (!$room_result) {
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>数据库错误 - 聊天室</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
            .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>🚫 数据库查询错误</h2>
            <p>错误信息：' . htmlspecialchars($conn->error) . '</p>
            <p>请联系系统管理员</p>
        </div>
    </body>
    </html>
    ');
}

if ($room_result->num_rows == 0) {
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>房间不存在 - 聊天室</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
            .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>🏠 房间不存在</h2>
            <p>房间ID：<code>' . htmlspecialchars($room_id) . '</code></p>
            <p>该聊天室不存在或已被禁用！</p>
        </div>
    </body>
    </html>
    ');
}

$room_info = $room_result->fetch_assoc();

// 检查用户身份
$user_role = '';
$user_name = '';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // 管理员已登录
    $user_role = 'admin';
    $user_name = $_SESSION['admin_username'];
} elseif (isset($_SESSION['buyer_logged_in']) && $_SESSION['buyer_logged_in'] === true) {
    // 买家已登录
    $user_role = 'buyer';
    $user_name = $_SESSION['buyer_username'];
} elseif (isset($_GET['guest']) && $_GET['guest'] == '1') {
    // 游客访问 - 使用增强版IP用户绑定
    $ip_binding = getOrCreateEnhancedIPUserBinding($room_id, $conn);
    
    if ($ip_binding) {
        $user_role = $ip_binding['user_type'];
        $user_name = $ip_binding['user_name'];
        
        // 记录设备指纹到session（用于调试）
        $_SESSION['device_fingerprint'] = $ip_binding['device_fingerprint'];
        $_SESSION['ip_bound_user'] = true;
    } else {
        // 增强版绑定失败，显示错误信息
        $device_info = getDeviceInfo();
        $conn->close();
        die('
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>用户绑定失败 - 聊天室</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
                .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
                .debug { text-align: left; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; }
                .btn { background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 10px; }
            </style>
        </head>
        <body>
            <div class="error">
                <h2>🚫 设备识别失败</h2>
                <p>无法为您的设备分配用户身份，请稍后重试</p>
                <div class="debug">
                    <strong>设备信息：</strong><br>
                    IP地址: <code>' . htmlspecialchars($device_info['ip']) . '</code><br>
                    设备指纹: <code>' . htmlspecialchars($device_info['device_fingerprint']) . '</code><br>
                    User-Agent: <code>' . htmlspecialchars(substr($device_info['user_agent'], 0, 100)) . '...</code>
                </div>
                <div style="margin-top: 20px;">
                    <a href="index.php" class="btn">返回首页</a>
                    <a href="?id=' . urlencode($room_id) . '&guest=1" class="btn">重新尝试</a>
                </div>
            </div>
        </body>
        </html>
        ');
    }
} else {
    // 未登录，显示登录选择页面
    $conn->close();
    ?>
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($room_info['room_name']); ?> - 聊天室</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .login-container {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                padding: 40px;
                max-width: 500px;
                width: 100%;
                text-align: center;
            }
            .room-info {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 30px;
                border-left: 4px solid #667eea;
            }
            .room-title {
                font-size: 1.5em;
                font-weight: 700;
                color: #333;
                margin-bottom: 10px;
            }
            .room-id {
                font-family: monospace;
                font-size: 0.9em;
                color: #666;
                background: #e9ecef;
                padding: 5px 10px;
                border-radius: 5px;
                display: inline-block;
                margin-bottom: 10px;
            }
            .room-description { color: #666; line-height: 1.5; }
            .login-options { display: grid; gap: 20px; margin-top: 30px; }
            .login-option {
                background: white;
                border: 2px solid #e9ecef;
                border-radius: 12px;
                padding: 25px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                color: inherit;
            }
            .login-option:hover {
                border-color: #667eea;
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
            .option-icon { font-size: 2.5em; margin-bottom: 15px; }
            .option-title {
                font-size: 1.2em;
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
            }
            .option-description {
                color: #666;
                font-size: 0.9em;
                line-height: 1.4;
            }
            .admin-option { border-color: #28a745; }
            .admin-option:hover { border-color: #1e7e34; background: #f8fff9; }
            .buyer-option { border-color: #007bff; }
            .buyer-option:hover { border-color: #0056b3; background: #f8f9ff; }
            .guest-option { border-color: #6c757d; }
            .guest-option:hover { border-color: #495057; background: #f8f9fa; }
            .enhanced-notice {
                background: #e8f5e8;
                border: 1px solid #28a745;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 20px;
                text-align: left;
            }
            .enhanced-notice h4 {
                color: #155724;
                margin-bottom: 8px;
                font-size: 1em;
            }
            .enhanced-notice p {
                color: #155724;
                font-size: 0.9em;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="room-info">
                <div class="room-title"><?php echo htmlspecialchars($room_info['room_name']); ?></div>
                <div class="room-id"><?php echo htmlspecialchars($room_info['room_id']); ?></div>
                <?php if ($room_info['room_description']): ?>
                    <div class="room-description"><?php echo htmlspecialchars($room_info['room_description']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="enhanced-notice">
                <h4>🚀 智能设备识别</h4>
                <p>我们采用增强版设备识别技术，不同设备访问时会自动分配独立的用户身份，无需重复注册！</p>
            </div>
            
            <h2 style="color: #333; margin-bottom: 20px;">👋 欢迎进入聊天室</h2>
            <p style="color: #666; margin-bottom: 20px;">请选择您的身份登录</p>
            
            <div class="login-options">
                <a href="admin_login.php?redirect=<?php echo urlencode("room.php?id=$room_id"); ?>" class="login-option admin-option">
                    <div class="option-icon">👑</div>
                    <div class="option-title">管理员登录</div>
                    <div class="option-description">拥有完全管理权限，可以管理聊天室</div>
                </a>
                
                <a href="buyer_login.php?redirect=<?php echo urlencode("room.php?id=$room_id"); ?>" class="login-option buyer-option">
                    <div class="option-icon">🛒</div>
                    <div class="option-title">买家登录</div>
                    <div class="option-description">注册买家账号，享受专属服务</div>
                </a>
                
                <a href="?id=<?php echo urlencode($room_id); ?>&guest=1" class="login-option guest-option">
                    <div class="option-icon">🔍</div>
                    <div class="option-title">智能游客进入</div>
                    <div class="option-description">无需登录，系统自动识别您的设备并分配专属身份</div>
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// 用户已认证，存储房间信息并跳转到聊天页面
$_SESSION['current_room_id'] = $room_id;
$_SESSION['current_room_name'] = $room_info['room_name'];
$_SESSION['current_room_description'] = $room_info['room_description'];
$_SESSION['current_user_role'] = $user_role;
$_SESSION['current_user_name'] = $user_name;

$conn->close();

// 跳转到聊天页面
header("Location: chat.php?room_id=" . urlencode($room_id));
exit;
?> 