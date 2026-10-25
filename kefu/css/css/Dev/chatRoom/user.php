<?php
session_start();

// 检查管理员登录状态
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// 引入数据库配置文件
require_once 'db_config.php';

// 处理表单提交
$message = '';
$message_type = '';

if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_room':
                $room_name = trim($_POST['room_name']);
                $room_description = trim($_POST['room_description']);
                $max_users = intval($_POST['max_users']);
                
                if (!empty($room_name)) {
                    // 生成唯一房间ID
                    $room_id = 'room_' . uniqid();
                    
                    $admin_id = $_SESSION['admin_id'];
                    $room_id_escaped = $conn->real_escape_string($room_id);
                    $room_name_escaped = $conn->real_escape_string($room_name);
                    $room_description_escaped = $conn->real_escape_string($room_description);
                    $admin_id_escaped = $conn->real_escape_string($admin_id);
                    
                    $sql = "INSERT INTO chatroom_list (room_id, room_name, room_description, created_by, create_time, last_activity, status, max_users) 
                            VALUES ('$room_id_escaped', '$room_name_escaped', '$room_description_escaped', '$admin_id_escaped', NOW(), NOW(), 'active', $max_users)";
                    
                    if ($conn->query($sql)) {
                        // 将管理员添加到管理员关联表
                        $admin_sql = "INSERT INTO chatroom_admins (room_id, admin_id, permission_level, created_time) VALUES ('$room_id_escaped', '$admin_id_escaped', 'owner', NOW())";
                        $conn->query($admin_sql);
                        
                        // 初始化统计数据
                        $stats_sql = "INSERT INTO chatroom_stats (room_id, total_messages, active_users, last_update) VALUES ('$room_id_escaped', 0, 0, NOW())";
                        $conn->query($stats_sql);
                        
                        // 添加创建提示系统消息
                        $create_message = "螃蟹交付专员-林夕创建了该聊天";
                        $create_message_escaped = $conn->real_escape_string($create_message);
                        $create_msg_sql = "INSERT INTO chatroom_messages (room_id, user_name, user_type, content, message_type, send_time) 
                                          VALUES ('$room_id_escaped', 'system', 'system', '$create_message_escaped', 'text', NOW())";
                        $conn->query($create_msg_sql);
                        
                        // 添加温馨小贴士官方消息
                        $tips_message = "温馨小贴士\n1、买家已付款，请卖家等待客服指令发号（死绑/DSP提前告知，客服确认后卖家再发号）。\n2、买家验号，验号同时，卖家不准登陆等其他行为\n3、验号不能进行游戏哦，否则产生的后果买家承担。\n4、换绑需要客服通知，客服群内通知过后再开始换绑。\n5、群内禁止提供联系方式，私下交易有风险，损失自行承担。\n6、代售交易禁止联系走中介，发现则拉黑处理";
                        $tips_message_escaped = $conn->real_escape_string($tips_message);
                        $tips_msg_sql = "INSERT INTO chatroom_messages (room_id, user_name, user_type, content, message_type, send_time) 
                                        VALUES ('$room_id_escaped', '螃蟹在线客服-林夕', 'admin', '$tips_message_escaped', 'text', NOW())";
                        $conn->query($tips_msg_sql);
                        
                        $_SESSION['message'] = "聊天室 \"$room_name\" 创建成功！房间ID: $room_id";
                        $_SESSION['message_type'] = 'success';
                    } else {
                        $_SESSION['message'] = "创建聊天室失败: " . $conn->error;
                        $_SESSION['message_type'] = 'error';
                    }
                } else {
                    $_SESSION['message'] = "房间名称不能为空！";
                    $_SESSION['message_type'] = 'error';
                }
                
                // 重定向避免重复提交
                header('Location: user.php');
                exit;
                
            case 'delete_room':
                $room_id = $_POST['room_id'];
                
                // 检查是否有权限删除
                $room_id_escaped = $conn->real_escape_string($room_id);
                $admin_id_escaped = $conn->real_escape_string($_SESSION['admin_id']);
                $permission_sql = "SELECT permission_level FROM chatroom_admins WHERE room_id = '$room_id_escaped' AND admin_id = '$admin_id_escaped'";
                $permission_result = $conn->query($permission_sql);
                
                if ($permission_result->num_rows > 0) {
                    $permission_row = $permission_result->fetch_assoc();
                    if ($permission_row['permission_level'] == 'owner') {
                        // 删除相关数据（按依赖关系顺序删除）
                        $conn->query("DELETE FROM chatroom_message_reads WHERE room_id = '$room_id_escaped'");
                        $conn->query("DELETE FROM chatroom_messages WHERE room_id = '$room_id_escaped'");
                        $conn->query("DELETE FROM chatroom_users WHERE room_id = '$room_id_escaped'"); // 新增：清理在线用户表
                        $conn->query("DELETE FROM user_room_bindings WHERE room_id = '$room_id_escaped'");
                        $conn->query("DELETE FROM chatroom_admins WHERE room_id = '$room_id_escaped'");
                        $conn->query("DELETE FROM chatroom_stats WHERE room_id = '$room_id_escaped'");
                        $conn->query("DELETE FROM chatroom_list WHERE room_id = '$room_id_escaped'");
                        
                        $_SESSION['message'] = "聊天室删除成功！所有相关数据已清理。";
                        $_SESSION['message_type'] = 'success';
                    } else {
                        $_SESSION['message'] = "权限不足！只有房间所有者可以删除聊天室。";
                        $_SESSION['message_type'] = 'error';
                    }
                } else {
                    $_SESSION['message'] = "权限不足！您不是该聊天室的管理员。";
                    $_SESSION['message_type'] = 'error';
                }
                
                // 重定向避免重复提交
                header('Location: user.php');
                exit;
                
            case 'toggle_status':
                $room_id = $_POST['room_id'];
                $new_status = $_POST['new_status'];
                
                $new_status_escaped = $conn->real_escape_string($new_status);
                $room_id_escaped = $conn->real_escape_string($room_id);
                $sql = "UPDATE chatroom_list SET status = '$new_status_escaped' WHERE room_id = '$room_id_escaped'";
                
                if ($conn->query($sql)) {
                    $status_text = $new_status == 'active' ? '激活' : '禁用';
                    $_SESSION['message'] = "聊天室状态已更新为：$status_text";
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = "状态更新失败: " . $conn->error;
                    $_SESSION['message_type'] = 'error';
                }
                
                // 重定向避免重复提交
                header('Location: user.php');
                exit;
        }
    }
}

// 获取SESSION中的消息（如果有的话）
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

// 获取聊天室列表（排除JSON字段避免类型245错误）
$admin_id_escaped = $conn->real_escape_string($_SESSION['admin_id']);
$rooms_sql = "SELECT cl.id, cl.room_id, cl.room_name, cl.room_description, cl.created_by, 
                     cl.create_time, cl.last_activity, cl.status, cl.max_users,
                     ca.permission_level, cs.total_messages, cs.active_users 
              FROM chatroom_list cl
              LEFT JOIN chatroom_admins ca ON cl.room_id = ca.room_id AND ca.admin_id = '$admin_id_escaped'
              LEFT JOIN chatroom_stats cs ON cl.room_id = cs.room_id
              ORDER BY cl.create_time DESC";
$rooms_result = $conn->query($rooms_sql);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天室管理后台</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.5em;
            font-weight: 700;
        }
        
        .logout-btn {
            background: #ff4757;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #ff3838;
            transform: translateY(-2px);
        }
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8em;
            display: flex;
            align-items: center;
        }
        
        .section h2::before {
            content: "🏠";
            margin-right: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn.danger {
            background: #ff4757;
        }
        
        .btn.danger:hover {
            background: #ff3838;
        }
        
        .btn.warning {
            background: #ffa726;
        }
        
        .btn.warning:hover {
            background: #ff9800;
        }
        
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .room-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .room-card:hover {
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .room-card.disabled, .room-card.deleted {
            opacity: 0.6;
            background: #fff5f5;
            border-color: #fed7d7;
        }
        
        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .room-title {
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .room-id {
            font-size: 0.9em;
            color: #666;
            font-family: monospace;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
        }
        
        .room-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        .room-status.active {
            background: #d4edda;
            color: #155724;
        }
        
        .room-status.disabled, .room-status.deleted {
            background: #f8d7da;
            color: #721c24;
        }
        
        .room-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .room-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 8px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.2em;
            font-weight: 700;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 0.85em;
            color: #666;
        }
        
        .room-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .room-actions .btn {
            flex: 1;
            min-width: 80px;
            padding: 8px 12px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .permission-badge {
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        .btn.copy {
            background: #17a2b8;
            position: relative;
        }
        
        .btn.copy:hover {
            background: #138496;
        }
        
        .btn.copy.copied {
            background: #28a745;
        }
        
        .copy-tooltip {
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 1000;
        }
        
        .copy-tooltip.show {
            opacity: 1;
        }
        
        .copy-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #333;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .rooms-grid {
                grid-template-columns: 1fr;
            }
            
            .room-actions {
                flex-direction: column;
            }
            
            .room-actions .btn {
                min-width: unset;
                margin-bottom: 5px;
            }
        }
    </style>
    <script>
        // 复制到剪切板功能
        function copyBuyerLink(roomId, buttonElement) {
            // 构建买家登录链接
            const baseUrl = window.location.protocol + '//' + window.location.host + window.location.pathname.replace('/user.php', '');
            const buyerLink = baseUrl + '/buyer_login.php?redirect=' + encodeURIComponent('room.php?id=' + roomId);
            
            // 复制到剪切板
            if (navigator.clipboard && window.isSecureContext) {
                // 现代浏览器API
                navigator.clipboard.writeText(buyerLink).then(function() {
                    showCopySuccess(buttonElement);
                }).catch(function(err) {
                    // 如果失败，使用备用方法
                    fallbackCopy(buyerLink, buttonElement);
                });
            } else {
                // 备用方法
                fallbackCopy(buyerLink, buttonElement);
            }
        }
        
        // 备用复制方法
        function fallbackCopy(text, buttonElement) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess(buttonElement);
                } else {
                    showCopyError(buttonElement);
                }
            } catch (err) {
                showCopyError(buttonElement);
            }
            
            document.body.removeChild(textArea);
        }
        
        // 显示复制成功
        function showCopySuccess(buttonElement) {
            const originalText = buttonElement.innerHTML;
            const originalClass = buttonElement.className;
            
            buttonElement.innerHTML = '✅ 已复制';
            buttonElement.className = originalClass + ' copied';
            
            // 显示提示
            showTooltip(buttonElement, '买家链接已复制到剪切板！');
            
            setTimeout(function() {
                buttonElement.innerHTML = originalText;
                buttonElement.className = originalClass;
            }, 2000);
        }
        
        // 显示复制失败
        function showCopyError(buttonElement) {
            showTooltip(buttonElement, '复制失败，请手动复制');
        }
        
        // 显示提示气泡
        function showTooltip(element, message) {
            // 创建提示元素
            const tooltip = document.createElement('div');
            tooltip.className = 'copy-tooltip show';
            tooltip.textContent = message;
            element.style.position = 'relative';
            element.appendChild(tooltip);
            
            // 3秒后移除
            setTimeout(function() {
                if (tooltip && tooltip.parentNode) {
                    tooltip.parentNode.removeChild(tooltip);
                }
            }, 3000);
        }
        
        // 页面加载完成后的初始化
        document.addEventListener('DOMContentLoaded', function() {
            console.log('聊天室管理后台加载完成');
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 聊天室管理后台</h1>
            <div>
                <span style="margin-right: 15px; color: #666;">欢迎, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="admin_login.php?action=logout" class="logout-btn">退出登录</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- 创建聊天室 -->
        <div class="section">
            <h2>创建新聊天室</h2>
            <form method="post">
                <input type="hidden" name="action" value="create_room">
                <div class="form-row">
                    <div class="form-group">
                        <label for="room_name">房间名称 *</label>
                        <input type="text" id="room_name" name="room_name" required>
                    </div>
                    <div class="form-group">
                        <label for="max_users">最大用户数</label>
                        <input type="number" id="max_users" name="max_users" value="5" min="1" max="5">
                    </div>
                </div>
                <div class="form-group">
                    <label for="room_description">房间描述</label>
                    <textarea id="room_description" name="room_description" rows="3" placeholder="描述您的聊天室..."></textarea>
                </div>
                <button type="submit" class="btn">🚀 创建聊天室</button>
            </form>
        </div>

        <!-- 聊天室列表 -->
        <div class="section">
            <h2>聊天室列表</h2>
            
            <?php if ($rooms_result->num_rows > 0): ?>
                <div class="rooms-grid">
                    <?php while ($room = $rooms_result->fetch_assoc()): ?>
                        <div class="room-card <?php echo $room['status'] == 'active' ? '' : $room['status']; ?>">
                            <div class="room-header">
                                <div>
                                    <div class="room-title"><?php echo htmlspecialchars($room['room_name']); ?></div>
                                    <div class="room-id"><?php echo htmlspecialchars($room['room_id']); ?></div>
                                </div>
                                <div>
                                    <span class="room-status <?php echo $room['status']; ?>">
                                        <?php echo $room['status'] == 'active' ? '🟢 活跃' : '🔴 禁用'; ?>
                                    </span>
                                    <?php if ($room['permission_level']): ?>
                                        <div style="margin-top: 5px;">
                                            <span class="permission-badge">
                                                <?php echo $room['permission_level'] == 'owner' ? '👑 所有者' : '🛡️ 管理员'; ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if ($room['room_description']): ?>
                                <div class="room-description">
                                    <?php echo htmlspecialchars($room['room_description']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="room-stats">
                                <div class="stat-item">
                                    <div class="stat-value"><?php echo $room['total_messages'] ?: 0; ?></div>
                                    <div class="stat-label">消息数</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value"><?php echo $room['active_users'] ?: 0; ?></div>
                                    <div class="stat-label">活跃用户</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value"><?php echo $room['max_users']; ?></div>
                                    <div class="stat-label">最大用户</div>
                                </div>
                            </div>
                            
                            <div class="room-actions">
                                <div style="display: flex;flex-direction: column;width: 100%;">
                                    <a href="room.php?id=<?php echo urlencode($room['room_id']); ?>" class="btn" target="_blank">
                                        💬 以官方身份进入聊天（仅在此页面生效）
                                    </a>
                                    
                                    <button style="margin-top:1rem;" type="button" class="btn copy" onclick="copyBuyerLink('<?php echo addslashes($room['room_id']); ?>', this)" title="复制买家登录链接">
                                        🛒 复制买家链接
                                    </button>
                                </div>
                                
                                
                                <?php if ($room['permission_level'] == 'owner'): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>">
                                        <input type="hidden" name="new_status" value="<?php echo $room['status'] == 'active' ? 'disabled' : 'active'; ?>">
                                        <button type="submit" class="btn warning">
                                            <?php echo $room['status'] == 'active' ? '⏸️ 禁用' : '▶️ 启用'; ?>
                                        </button>
                                    </form>
                                    
                                    <form method="post" style="display: inline;" onsubmit="return confirm('确定要删除聊天室「<?php echo htmlspecialchars($room['room_name']); ?>」吗？此操作不可撤销！');">
                                        <input type="hidden" name="action" value="delete_room">
                                        <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>">
                                        <button type="submit" class="btn danger">🗑️ 删除</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            
                            <div style="margin-top: 10px; font-size: 0.85em; color: #999;">
                                创建于: <?php echo date('Y-m-d H:i', strtotime($room['create_time'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; color: #999;">
                    <div style="font-size: 3em; margin-bottom: 20px;">🏠</div>
                    <h3>暂无聊天室</h3>
                    <p>创建您的第一个聊天室开始使用吧！</p>
                </div>
            <?php endif; ?>
        </div>
        
        
    </div>
</body>
</html>

<?php
$conn->close();
?> 