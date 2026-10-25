<?php
session_start();

// 引入增强版IP用户绑定辅助函数
require_once 'enhanced_ip_user_helper.php';

// 获取房间ID和房间信息
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : (isset($_SESSION['current_room_id']) ? $_SESSION['current_room_id'] : '');
$room_name = isset($_SESSION['current_room_name']) ? $_SESSION['current_room_name'] : '聊天室';
$room_description = isset($_SESSION['current_room_description']) ? $_SESSION['current_room_description'] : '';

if (empty($room_id)) {
    // 没有房间ID，重定向到首页
    header('Location: index.php');
    exit;
}

// 引入数据库配置文件
require_once 'db_config.php';

// 实时验证聊天室是否存在且状态为active
if ($conn->connect_error) {
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
            <h2>🚫 数据库连接错误</h2>
            <p>无法连接到聊天室服务器</p>
            <p><a href="index.php">返回首页</a></p>
        </div>
    </body>
    </html>
    ');
}

// 验证聊天室是否存在且状态为active
$room_id_escaped = $conn->real_escape_string($room_id);
$room_check_sql = "SELECT id, room_id, room_name, room_description, status FROM chatroom_list WHERE room_id = '$room_id_escaped' AND status = 'active'";
$room_check_result = $conn->query($room_check_sql);

if (!$room_check_result || $room_check_result->num_rows == 0) {
    $conn->close();
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>聊天室不可用 - 聊天室</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
            .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
            .btn { background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 10px; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>🚫 聊天室不可用</h2>
            <p>该聊天室已被删除或禁用</p>
            <p>房间ID：<code>' . htmlspecialchars($room_id) . '</code></p>
            
        </div>
    </body>
    </html>
    ');
}

// 更新SESSION中的房间信息为最新数据
$room_data = $room_check_result->fetch_assoc();
$_SESSION['current_room_id'] = $room_data['room_id'];
$_SESSION['current_room_name'] = $room_data['room_name'];
$_SESSION['current_room_description'] = $room_data['room_description'];

// 更新变量
$room_name = $room_data['room_name'];
$room_description = $room_data['room_description'];

// 先检查用户身份，如果没有则进行IP用户绑定
$user_role = isset($_SESSION['current_user_role']) ? $_SESSION['current_user_role'] : '';
$user_name = isset($_SESSION['current_user_name']) ? $_SESSION['current_user_name'] : '';

if (empty($user_role) || empty($user_name)) {
    // 用户身份不完整，尝试增强版IP用户绑定
    $ip_binding = getOrCreateEnhancedIPUserBinding($room_id, $conn);
    
    if ($ip_binding) {
        // 设置IP绑定用户的session信息
        $_SESSION['current_user_role'] = $ip_binding['user_type'];
        $_SESSION['current_user_name'] = $ip_binding['user_name'];
        $_SESSION['current_room_id'] = $room_id;
        $_SESSION['current_room_name'] = $room_name;
        $_SESSION['current_room_description'] = $room_description;
        $_SESSION['ip_bound_user'] = true; // 标记为IP绑定用户
        $_SESSION['device_fingerprint'] = $ip_binding['device_fingerprint']; // 保存设备指纹
        
        // 更新变量
        $user_role = $ip_binding['user_type'];
        $user_name = $ip_binding['user_name'];
    } else {
        $conn->close();
        $device_info = getDeviceInfo();
        die('
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>用户绑定失败 - 聊天室</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
                .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
                .btn { background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 10px; }
                .debug { text-align: left; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="error">
                <h2>🚫 用户绑定失败</h2>
                <p>无法创建用户绑定，请稍后重试</p>
                <div class="debug">
                    <strong>调试信息：</strong><br>
                    IP: <code>' . htmlspecialchars($device_info['ip']) . '</code><br>
                    设备指纹: <code>' . htmlspecialchars($device_info['device_fingerprint']) . '</code><br>
                    User-Agent: <code>' . htmlspecialchars(substr($device_info['user_agent'], 0, 100)) . '...</code>
                </div>
                
            </div>
        </body>
        </html>
        ');
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo htmlspecialchars($room_name); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* 自定义滚动条 */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* 成员列表动画 */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        /* 隐藏文件输入 */
        #file-input { display: none; }

        /* 消息气泡样式 - 优化版 */
        .message-bubble {
            /* max-width: min(70%, calc(100vw - 140px)); */
            /* max-width: 80%; */
            min-width: 60px;
            position: relative;
            box-sizing: border-box;
            /* 改进换行处理 */
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
        }
        
        /* 优化文字换行 */
        .message-bubble span {
            line-height: 1.4;
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            max-width: 100%;
            box-sizing: border-box;
            display: inline-block;
        }
        
        /* 连续数字/英文处理 */
        .message-bubble .number-sequence {
            word-break: break-all;
        }
        
        .message-bubble img { width: 100%; }

        .sent {
            background-color: #fff0de;
            color: #333;
            border-radius: 18px 0 18px 18px;
        }

        .received {
            background-color: #ffffff;
            color: #333;
            border-radius: 0 18px 18px 18px;
        }

        .system-message {
            background: white;
            border: none;
            box-shadow: none;
            color: #6b7280;
            font-weight: 200;
            border-radius: 12px;
            text-align: center;
            font-size: 0.875rem;
            padding: 8px 16px;
        }
        
        /* 官方消息特殊样式 */
        .admin-message {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .admin-message:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }
        
        /* 删除提示样式 */
        .delete-hint {
            font-size: 10px !important;
            transition: opacity 0.2s ease;
        }
        
        /* 可删除消息的视觉提示 */
        [data-deletable="true"] {
            position: relative;
        }
        
        [data-deletable="true"]:hover .delete-hint {
            opacity: 1 !important;
        }
        
        /* 链接样式 - 统一风格 */
        .message-link {
            display: inline-block;
            padding: 3px 8px;
            margin: 0 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid rgba(255,255,255,0.2);
            cursor: pointer;
            word-break: break-all;
            /* max-width: 200px; */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
        }
        
        .message-link:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .message-link:active {
            transform: translateY(0);
        }
        
        /* 长按效果 */
        [data-deletable="true"].long-pressing .admin-message {
            transform: scale(0.98);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* 聊天图片最大宽高限制 */
        .chat-img {
            max-width: 180px;
            max-height: 180px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
            cursor: pointer;
        }
        
        /* 聊天区域作为水印容器 */
        #chat-area {
            position: relative;
            z-index: 2;
            overflow-X: hidden;

        }
        
        /* 聊天区域背景水印 */
        #chat-area::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            background-repeat: repeat;
            opacity: 1;
            transform: rotate(-20deg);
            transform-origin: center;
            pointer-events: none;
            z-index: 0;
        }
        
        /* 确保消息内容在水印之上 */
        #chat-area > * {
            position: relative;
            z-index: 1;
        }
        

        
        /* 确保聊天内容在水印之上 */
        .main-container,
        .chat-header,
        .input-container,
        #quick-actions {
            position: relative;
            z-index: 10;
        }
        
        /* 弹窗确保在最上层 */
        #member-list,
        #image-preview,
        #video-preview,
        #rating-modal,
        #delete-message-modal,
        #emoji-picker,
        #more-menu {
            z-index: 100;
        }

        .hidden { display: none !important; }

        #emoji-picker {
            display: flex;
            flex-wrap: wrap;
            background: #fff;
            border-top: 1px solid #eee;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.05);
            z-index: 50;
            max-height: 280px;
            overflow-y: auto;
            padding: 8px;
        }
        
        #emoji-picker.hidden {
            display: none !important;
        }
        
        /* 表情选择器滚动条样式 */
        #emoji-picker::-webkit-scrollbar {
            width: 4px;
        }
        
        #emoji-picker::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }
        
        #emoji-picker::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }
        
        #emoji-picker::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* 表情项样式优化 */
        #emoji-picker span[data-emoji] {
            transition: transform 0.15s ease;
            border-radius: 6px;
            padding: 2px;
            margin: 1px;
        }
        
        #emoji-picker span[data-emoji]:hover {
            transform: scale(1.2);
            background-color: #f3f4f6;
        }
        
        /* 关闭按钮样式 */
        #emoji-picker #close-emoji {
            position: sticky;
            top: 0;
            background: white;
            z-index: 51;
            margin-bottom: 5px;
        }

        /* 视频样式 */
        .message-bubble .chat-video {
            max-width: 200px;
            max-height: 200px;
            width: auto;
            height: auto;
            border-radius: 12px;
            background-color: #000;
            position: relative;
        }
        
        .chat-video video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }
        
        .video-play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            cursor: pointer;
            z-index: 10;
        }
        
        .video-duration {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(0,0,0,0.5);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .video-info {
            display: flex;
            align-items: center;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
        
        .video-icon {
            margin-right: 5px;
            color: #3b82f6;
        }
        
        /* 视频预览模态框 */
        #video-preview {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }
        
        .video-container {
            width: 100%;
            max-width: 800px;
            position: relative;
        }
        
        .video-container video {
            width: 100%;
            height: auto;
            max-height: 80vh;
        }
        
        .close-video {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .video-title {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            font-size: 16px;
            background: rgba(0,0,0,0.5);
            padding: 5px 10px;
            border-radius: 4px;
        }

        /* 加载动画 */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* 优化后的标题栏 */
        .chat-header {
            background: rgb(253,255,248);
            background: linear-gradient(55deg, rgba(253,255,248,1) 0%, rgba(253,251,244,1) 37%, rgba(251,250,252,1) 100%);
            box-shadow: 0 3px 3px -4px rgb(35, 34, 34);
        }
        
        /* 输入区优化 */
        .input-container {
            background-color: #efefef;
        }
        
        /* 快捷操作区域样式 */
        #quick-actions {
            background-color: #f9fafb;
            border: none;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        #quick-actions button {
            transition: all 0.2s ease;
            border: solid thin #e5e7eb;
        }
        
        #quick-actions button:hover {
            transform: translateY(-1px);
        }
        
        /* 评价弹窗样式 */
        .rating-option:hover .rating-emoji {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
        
        .rating-option.selected .rating-emoji {
            transform: scale(1.2);
            /* filter: brightness(1.2); */
        }
        
        .rating-option.selected span {
            color: #f59e0b;
            font-weight: 600;
        }
        
        /* 未选中的图标变灰 */
        .rating-option.unselected .rating-emoji {
            filter: grayscale(100%) brightness(0.7);
            opacity: 0.6;
        }
        
        .rating-option.unselected span {
            color: #9ca3af;
        }
        
        /* 过渡效果 */
        .rating-emoji {
            transition: all 0.3s ease;
        }
        
        .rating-option span {
            transition: color 0.3s ease;
        }
        
        .service-tag:hover,
        .problem-status:hover {
            border-color: #f59e0b;
            color: #f59e0b;
            transition: all 0.2s ease;
        }
        
        .service-tag.selected,
        .problem-status.selected {
            background-color: #f59e0b !important;
            border-color: #f59e0b !important;
            color: white;
        }
        
        #submit-rating:hover {
            background-color: #f59e0b;
            transition: background-color 0.2s ease;
        }
        
        #rating-modal {
            backdrop-filter: blur(4px);
        }
        
        /* 置顶开关样式 */
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #ff9933;
        }
        
        input:checked + .slider:before {
            transform: translateX(12.8px);
        }

        *{
           margin: 0;
           padding: 0;
       }
       
       /* 移动端全屏适配 */
       html, body {
           height: 100%;
           background-color: rgba(244, 245, 246);
           overflow: hidden;
           position: fixed;
           width: 100%;
       }
       
       /* 主容器移动端适配 */
       .main-container {
           height: 100vh;
           height: calc(var(--vh, 1vh) * 100);
           min-height: 100vh;
           min-height: calc(var(--vh, 1vh) * 100);
           max-height: 100vh;
           max-height: calc(var(--vh, 1vh) * 100);
           overflow: hidden;
           display: flex;
           flex-direction: column;
           position: relative;
           width: 100%;
           max-width: 448px;
           margin: 0 auto;
       }
       
       /* 移动端安全区域适配 */
       @supports (padding: max(0px)) {
           .main-container {
               padding-top: max(0px, env(safe-area-inset-top));
               padding-bottom: max(0px, env(safe-area-inset-bottom));
               padding-left: max(0px, env(safe-area-inset-left));
               padding-right: max(0px, env(safe-area-inset-right));
           }
       }
       
       /* iOS Safari 地址栏适配 */
       @media screen and (max-width: 768px) {
           body {
               height: 100vh;
               height: calc(var(--vh, 1vh) * 100);
               height: -webkit-fill-available;
               -webkit-text-size-adjust: none;
               -webkit-user-select: none;
               user-select: none;
               -webkit-touch-callout: none;
               overscroll-behavior: none;
           }
           
           .main-container {
               height: 100vh;
               height: calc(var(--vh, 1vh) * 100);
               height: -webkit-fill-available;
           }
           
           /* 防止输入框缩放 */
           input, textarea, select {
               font-size: 16px !important;
               -webkit-appearance: none;
               appearance: none;
               border-radius: 0;
           }
           
           /* 聊天区域优化 */
           #chat-area {
               -webkit-overflow-scrolling: touch;
               overscroll-behavior: contain;
           }
       }
       
       /* 横屏适配 */
       @media screen and (orientation: landscape) and (max-height: 500px) {
           .main-container {
               height: 100vh;
               height: calc(var(--vh, 1vh) * 100);
               max-height: 100vh;
               max-height: calc(var(--vh, 1vh) * 100);
           }
       }
       
       /* 模态框移动端适配 */
       #video-preview, 
       #image-preview,
       #member-list {
           height: 100vh;
           height: calc(var(--vh, 1vh) * 100);
       }
       .wuyun-return{
           width: 100%;
           height: 45px;
           background-color: #FFF;
       }
       .wuyun-return-mar{
           padding-top: 10px;
           padding-left: 10px;
       }
               .wuyun-kefu{
            width: 90%;
            height: 100px;
            background-color: #FFF;
            margin-top: 15px;
            margin-left: 5%;
            border-radius: 10px;
        }
        .kefu-tp{
            width: 100%;
            padding: 24px 15px;
            display: flex;
            align-items: center;
        }
        .wuyun-tp{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .kefu-info{
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .wuyun-txt{
            font-size: 1rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .wuyun-fw{
            font-size: .75rem;
            color: rgb(153 153 153);
            display: flex;
            align-items: center;
        }
        .star-rating{
            display: flex;
            align-items: center;
            margin-left: 5px;
        }
       .wuyun-jyxx{
           width: 90%;
           height: 70px;
           background-color: #FFF;
           margin-top: 15px;
           margin-left: 5%;
           border-radius: 10px;
       }
       .jyxx-zt{
           font-size: 1rem;
           font-weight: 500;
           padding-left: 15px;
           line-height: 70px;
           text-align: center;
       }
        .switch {
            position: relative;
            display: inline-block;
            width: 32.8px;
            height: 20px;
            left: 60%;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 20px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #ff9933;
        }
        input:checked + .slider:before {
            transform: translateX(12.8px);
        }
        .ttc {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            width: 35%;
            max-width: 400px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .zd {
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        
    </style>
</head>

<body class="bg-gray-100 font-sans" style="background-color: #f4f5f6;height: 100%;margin: 0;padding: 0;overflow: hidden;position: fixed;top: 0;left: 0;right: 0;bottom: 0;">
    
    <div class="flex flex-col max-w-md mx-auto bg-white shadow-lg main-container" style="background-color: #f4f5f6;">
    
        <!-- Header -->
        <div class="flex items-center justify-between p-4 text-white chat-header">
            <button id="back-btn" class="text-black">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="flex flex-col items-center" style="color: rgb(46, 46, 46);">
                <h1 class="text-lg font-semibold"><?php echo htmlspecialchars($room_name); ?></h1>
                <p id="member-count" class="text-xs">0 人在线</p>
            </div>
            <button id="members-btn" class="text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M12 16.5a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3m0-6a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3m0-6a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3"/></g></svg>
            </button>
        </div>

        <!-- Chat area -->
        <div id="chat-area" class="flex-1 p-4 overflow-y-auto custom-scrollbar bg-gray-50">
            <div class="flex justify-center items-center h-full text-gray-500">
                <i class="fas fa-spinner spinner mr-2"></i>
                正在加载聊天记录...
            </div>
        </div>

        <!-- 固定在底部的快捷操作 -->
        <div id="quick-actions" class="p-3 border-t border-gray-200" style="padding: 0.5rem 0.5rem;">
            <div class="flex justify-between">
                <button id="urge-service-btn" class="flex items-center px-3 py-1 rounded bg-white  text-gray-700 text-sm mr-2" style="border-radius: 12px;padding:0.25rem 0.5rem">
                    <i class="fas fa-clock mr-1" style="color: #f19337;"></i>催客服
                </button>
                <button id="rate-service-btn" class="flex items-center px-3 py-1 rounded bg-white  text-gray-700 text-sm mr-2" style="border-radius: 12px;padding:0.25rem 0.5rem">
                    <i class="far fa-smile mr-1" style="color: #ef8682;"></i>评价客服
                </button>
                <button id="trade-message-btn" class="flex items-center px-3 py-1 rounded bg-white  text-gray-700 text-sm mr-2" style="border-radius: 12px;padding:0.25rem 0.5rem">
                    <i class="fas fa-file-alt mr-1" style="color: #507afe;"></i>交易信息
                </button>
                <button id="complaint-btn" class="flex items-center px-3 py-1 rounded bg-white  text-gray-700 text-sm" style="border-radius: 12px;padding:0.25rem 0.5rem">
                    <!-- <i class="fas fa-info-circle mr-1" style="color: #6d97ca;"></i> -->
                     <svg xmlns="http://www.w3.org/2000/svg"  width="16" height="16" viewBox="0 0 32 32"><path fill="#6d97ca" d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2m0 26a12 12 0 1 1 12-12a12 12 0 0 1-12 12"/><path fill="#6d97ca" d="M15 8h2v11h-2zm1 14a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 16 22"/></svg>
                    投诉建议
                </button>
            </div>
        </div>

        <!-- Input area -->
        <div class="p-3 border-t border-gray-200 input-container">
            <!-- 引用预览区域 -->
            <div id="quote-preview" class="hidden mb-3 p-3 bg-gray-50 rounded-lg border-l-4 border-blue-500 relative">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
                            <img id="quote-avatar" src="" alt="avatar" class="w-5 h-5 rounded-full mr-2">
                            <span id="quote-username" class="text-xs font-medium text-gray-600"></span>
                            <span id="quote-usertype" class="ml-1"></span>
                        </div>
                        <div id="quote-content" class="text-sm text-gray-700 break-all"></div>
                    </div>
                    <button id="cancel-quote" class="ml-3 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- 输入区 -->
            <div class="flex items-center relative">
                <input type="file" id="file-input" accept="image/*" style="display:none;">
                <div class="relative flex-1">
                    <input id="message-input" type="text" placeholder="请输入..." style="border-radius: 7px;padding: 4px 0.5rem;padding-right: 2rem;font-size: 14px;"
                        class="w-full py-2 pl-4 pr-10 rounded-full border border-gray-300 focus:outline-none focus:border-blue-500">
                    <button id="emoji-btn" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-400">
                        <i class="far fa-smile"></i>
                    </button>
                </div>
                <button id="attach-btn" class="ml-2 p-2 text-gray-500 rounded-full hover:bg-blue-100" title="上传图片" style="background-color: white;border-radius: 7px;">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7q.425 0 .713.288T13 4t-.288.713T12 5H5v14h14v-6q0-.425.288-.712T20 12t.713.288T21 13v6q0 .825-.587 1.413T19 21zM18 5.825l-.9.875q-.275.275-.687.287T15.7 6.7q-.275-.275-.275-.7t.275-.7l2.6-2.6q.15-.15.325-.225T19 2.4t.375.075t.325.225l2.6 2.6q.275.275.288.688T22.3 6.7q-.275.275-.7.275t-.7-.275l-.9-.875V9q0 .425-.287.713T19 10t-.712-.288T18 9zM7 17h10q.3 0 .45-.275t-.05-.525l-2.75-3.675q-.15-.2-.4-.2t-.4.2L11.25 16L9.4 13.525q-.15-.2-.4-.2t-.4.2l-2 2.675q-.2.25-.05.525T7 17"/></svg> -->
                    <img src="./images/icon/图片.png" style="width: 16px;height: 16px;" alt="">
                </button>
                <button id="more-btn" class="ml-2 p-2 text-gray-500 rounded-full hover:bg-gray-100" style="background-color: white;border-radius: 7px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2m1 5h-2v4H7v2h4v4h2v-4h4v-2h-4z"/></svg>
                </button>
                <button id="send-btn" class="ml-2 p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 hidden" style="border-radius: 7px;padding: 4px 0.5rem;background-color: #f5a045;">
                    <p style="color: white;font-size: 1rem;">发送</p>
                </button>
            </div>
        </div>

        <!-- 表情选择区 -->
        <div id="emoji-picker" class="hidden w-full bg-white border-t rounded-t shadow p-2 z-50 flex flex-wrap items-center justify-start">
            <button id="close-emoji" class="mr-2 text-gray-400 hover:text-gray-700 text-xl"><i class="fas fa-times"></i></button>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1">😊 经典表情</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😀">😀</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😂">😂</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤣">🤣</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😊">😊</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😍">😍</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🥰">🥰</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😘">😘</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😉">😉</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🤔 情绪表达</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😮">😮</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😲">😲</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤔">🤔</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤨">🤨</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🧐">🧐</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😏">😏</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😎">😎</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤗">🤗</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">😭 负面情绪</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😢">😢</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😭">😭</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😤">😤</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😡">😡</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤬">🤬</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😱">😱</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😨">😨</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😰">😰</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">😴 状态表情</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😴">😴</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🥱">🥱</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😪">😪</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤤">🤤</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😵">😵</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤯">🤯</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🥳">🥳</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤩">🤩</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">👍 手势动作</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="👍">👍</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="👎">👎</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="👌">👌</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="✌️">✌️</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤞">🤞</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤟">🤟</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤘">🤘</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="👏">👏</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🎉 庆祝爱心</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎉">🎉</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎊">🎊</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="❤️">❤️</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💕">💕</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💖">💖</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💝">💝</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🔥">🔥</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="⭐">⭐</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🍕 食物饮品</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="☕">☕</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍰">🍰</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍕">🍕</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍎">🍎</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍺">🍺</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🥂">🥂</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍻">🍻</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍭">🍭</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🐱 动物萌宠</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🐱">🐱</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🐶">🐶</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🐼">🐼</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🦄">🦄</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🐸">🐸</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🦋">🦋</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🐻">🐻</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🐵">🐵</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🌈 自然天气</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="☀️">☀️</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌙">🌙</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌟">🌟</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌈">🌈</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌸">🌸</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌺">🌺</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌹">🌹</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌻">🌻</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🚗 交通出行</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🚗">🚗</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="✈️">✈️</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🚀">🚀</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🚢">🚢</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🚲">🚲</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🛴">🛴</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎪">🎪</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎭">🎭</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">💎 物品符号</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💎">💎</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎯">🎯</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎲">🎲</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎮">🎮</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="📱">📱</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💡">💡</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🔔">🔔</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎁">🎁</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">👻 特殊角色</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="😷">😷</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤖">🤖</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="👻">👻</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎃">🎃</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="👽">👽</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤡">🤡</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💀">💀</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🦉">🦉</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🙏 实用表情</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🙏">🙏</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💪">💪</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤝">🤝</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🤳">🤳</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🙈">🙈</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🙉">🙉</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🙊">🙊</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💯">💯</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">✅ 常用符号</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="✅">✅</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="❌">❌</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="⚡">⚡</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💥">💥</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="💫">💫</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🌪️">🌪️</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="☔">☔</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="❄️">❄️</span>
            
            <div class="w-full text-xs text-gray-500 font-medium mb-2 ml-1 mt-2">🎂 节日庆祝</div>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎂">🎂</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🍾">🍾</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎈">🎈</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎀">🎀</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🎄">🎄</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🧧">🧧</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🏆">🏆</span>
            <span class="cursor-pointer text-2xl m-1" data-emoji="🥇">🥇</span>

        </div>

        <!-- Member list overlay -->
        <div id="member-list" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
            <div class="absolute right-0 top-0 h-full w-4/5 bg-white shadow-lg slide-in" style="background-color: rgba(244, 245, 246);">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center" style="background-color: #FFF; height: 45px; padding: 10px;">
                    <button id="close-members" class="text-gray-500">
                        <svg width="26" height="26" viewBox="0 0 32 32"><path d="M21.781 7.844l-9.063 8.594 9.063 8.594q0.25 0.25 0.25 0.609t-0.25 0.578q-0.25 0.25-0.578 0.25t-0.578-0.25l-9.625-9.125q-0.156-0.125-0.203-0.297t-0.047-0.359q0-0.156 0.047-0.328t0.203-0.297l9.625-9.125q0.25-0.25 0.578-0.25t0.578 0.25q0.25 0.219 0.25 0.578t-0.25 0.578z" fill="#000000"></path></svg>
                    </button>
                </div>
                <div id="member-list-content" class="overflow-y-auto h-full pb-20 custom-scrollbar">
                    <!--头像客服信息开始-->
                    <div class="wuyun-kefu">
                        <div class="kefu-tp">
                            <img src="https://images-kefu.pxb7.com/kfImg/20240620/20240620212127_74992.png" draggable="false" class="wuyun-tp">
                            <div class="kefu-info">
                                <div class="wuyun-txt">螃蟹在线客服-林夕</div>
                                <div class="wuyun-fw">
                                    服务星级:
                                    <div class="star-rating">
                                        <svg t="1737958546019" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6076" width="18" height="18"><path d="M512 39.384615l169.353846 295.384615 342.646154 63.015385-240.246154 248.123077L827.076923 984.615385l-315.076923-145.723077L196.923077 984.615385l43.323077-334.769231L0 401.723077l342.646154-63.015385L512 39.384615" fill="#F3D958" p-id="6077"></path></svg>
                                        <svg t="1737958546019" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6076" width="18" height="18"><path d="M512 39.384615l169.353846 295.384615 342.646154 63.015385-240.246154 248.123077L827.076923 984.615385l-315.076923-145.723077L196.923077 984.615385l43.323077-334.769231L0 401.723077l342.646154-63.015385L512 39.384615" fill="#F3D958" p-id="6077"></path></svg>
                                        <svg t="1737958546019" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6076" width="18" height="18"><path d="M512 39.384615l169.353846 295.384615 342.646154 63.015385-240.246154 248.123077L827.076923 984.615385l-315.076923-145.723077L196.923077 984.615385l43.323077-334.769231L0 401.723077l342.646154-63.015385L512 39.384615" fill="#F3D958" p-id="6077"></path></svg>
                                        <svg t="1737958546019" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6076" width="18" height="18"><path d="M512 39.384615l169.353846 295.384615 342.646154 63.015385-240.246154 248.123077L827.076923 984.615385l-315.076923-145.723077L196.923077 984.615385l43.323077-334.769231L0 401.723077l342.646154-63.015385L512 39.384615" fill="#F3D958" p-id="6077"></path></svg>
                                        <svg t="1737958546019" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6076" width="18" height="18"><path d="M512 39.384615l169.353846 295.384615 342.646154 63.015385-240.246154 248.123077L827.076923 984.615385l-315.076923-145.723077L196.923077 984.615385l43.323077-334.769231L0 401.723077l342.646154-63.015385L512 39.384615" fill="#F3D958" p-id="6077"></path></svg>
                                        <span style="margin-left: 5px;">5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--交易信息开始-->
                    <div class="wuyun-jyxx" onClick="location.href='/Dev/xyyl.php'">
                        <span class="jyxx-zt">交易信息</span>
                        <svg t="1737959871827" style="padding-left:65%;" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2443" width="24" height="24"><path d="M562.005333 512l-181.034666 181.034667a42.666667 42.666667 0 1 0 60.330666 60.330666l211.2-211.2a42.666667 42.666667 0 0 0 0-60.330666l-211.2-211.2a42.666667 42.666667 0 1 0-60.330666 60.330666L562.005333 512z" fill="#5D6E7F" p-id="2444"></path></svg>
                    </div>
                    <!--置顶开始-->
                    <div class="wuyun-jyxx">
                        <span class="jyxx-zt">置顶交易</span>
                        <label class="switch">
                        <input type="checkbox" id="toggleSwitch">
                        <span class="slider"></span>
                    </label>
                    </div>
                    <!--弹出层-->
                    <div class="ttc" id="cg" style="display:none;">
                        <span class="zd">聊天置顶成功</span>
                    </div>
                    <div class="ttc" id="qx" style="display:none;">
                        <span class="zd">取消置顶成功</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image preview modal -->
        <div id="image-preview" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center">
            <div class="relative max-w-full max-h-full p-4">
                <img id="preview-image" src="" alt="Preview" class="max-w-full max-h-screen">
                <button id="close-preview" class="absolute top-4 right-4 text-white text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- 视频预览模态框 -->
        <div id="video-preview">
            <div class="video-container">
                <video id="preview-video" controls preload="metadata">
                    <source src="" type="video/mp4">
                    您的浏览器不支持视频播放
                </video>
                <div id="close-video" class="close-video">
                    <i class="fas fa-times"></i>
                </div>
                <div id="video-title" class="video-title"></div>
            </div>
        </div>

        <!-- 更多功能菜单 -->
        <div id="more-menu" class="hidden w-full bg-white border-t rounded-t shadow p-4 z-50 flex flex-col items-center justify-center" style="background-color: #f9fafb;">
            <div class="flex w-full justify-around mb-2">
                <button id="album-btn" class="flex flex-col items-center hover:text-blue-700 focus:outline-none">
                    <!-- <i class="fas fa-image text-2xl mb-1"></i> -->
                     <div style="padding:0.5rem;background:white;border-radius: 12px;margin-bottom: 0.25rem;">
                        <img src="./images/icon/图片.png" style="width: 24px;height: 24px;" alt="">
                     </div>
                     
                    <span class="text-xs" style="color:#767676;">相册</span>
                </button>
                <button id="video-btn" class="flex flex-col items-center  hover:text-green-700 focus:outline-none">
                    <!-- <i class="fas fa-video text-2xl mb-1"></i> -->
                     <div style="padding:0.5rem;background:white;border-radius: 12px;margin-bottom: 0.25rem;">
                        <img src="./images/icon/视频.png" style="width: 24px;height: 24px;" alt="">
                     </div>
                    <span class="text-xs" style="color:#767676;">视频</span>
                </button>
                <button id="file-btn" class="flex flex-col items-center  hover:text-gray-700 focus:outline-none">
                    <!-- <i class="fas fa-file-alt text-2xl mb-1"></i> -->
                     <div style="padding:0.5rem;background:white;border-radius: 12px;margin-bottom: 0.25rem;">
                        <img src="./images/icon/文件.png" style="width: 24px;height: 24px;" alt="">
                     </div>
                    <span class="text-xs" style="color:#767676;">文件</span>
                </button>
            </div>
            <button id="close-more" class="mt-2 text-gray-400 hover:text-gray-700 text-xl"><i class="fas fa-times"></i></button>
            <!-- 隐藏的文件选择器 -->
            <input type="file" id="album-input" accept="image/*" style="display:none;">
            <input type="file" id="video-input" accept="video/*" style="display:none;">
            <input type="file" id="file-input-more" style="display:none;">
        </div>

        <!-- 评价客服弹窗 -->
        <div id="rating-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-11/12 max-w-md mx-4 max-h-screen overflow-y-auto">
                <!-- 弹窗标题 -->
                <div class="text-center py-4 px-6 border-b" style="background: linear-gradient(180deg, rgba(255,238,208,1) 0%, rgba(245,244,241,1) 49%, rgba(255,255,255,1) 100%)">
                    <h2 class="text-lg font-medium text-gray-800">您对「螃蟹咨询专员-林夕」的服务满意吗</h2>
                </div>
                
                <!-- 弹窗内容 -->
                <div class="p-6">
                    <!-- 满意度评价 -->
                    <div class="mb-6">
                        <div class="flex justify-around items-center">
                            <div class="flex flex-col items-center cursor-pointer rating-option" data-rating="1">
                                <img src="images/表情/非常不满意.png" alt="非常不满意" class="w-12 h-12 mb-2 rating-emoji">
                                <span class="text-xs text-gray-600">非常不满意</span>
                            </div>
                            <div class="flex flex-col items-center cursor-pointer rating-option" data-rating="2">
                                <img src="images/表情/不满意.png" alt="不满意" class="w-12 h-12 mb-2 rating-emoji">
                                <span class="text-xs text-gray-600">不满意</span>
                            </div>
                            <div class="flex flex-col items-center cursor-pointer rating-option" data-rating="3">
                                <img src="images/表情/一般.png" alt="一般" class="w-12 h-12 mb-2 rating-emoji">
                                <span class="text-xs text-gray-600">一般</span>
                            </div>
                            <div class="flex flex-col items-center cursor-pointer rating-option" data-rating="4">
                                <img src="images/表情/满意.png" alt="满意" class="w-12 h-12 mb-2 rating-emoji">
                                <span class="text-xs text-gray-600">满意</span>
                            </div>
                            <div class="flex flex-col items-center cursor-pointer rating-option" data-rating="5">
                                <img src="images/表情/非常满意.png" alt="非常满意" class="w-12 h-12 mb-2 rating-emoji">
                                <span class="text-xs text-gray-600">非常满意</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 服务评价标签 -->
                    <div class="mb-6">
                        <div class="grid grid-cols-2 gap-3">
                            <button class="service-tag px-3 py-2 rounded-full text-sm border border-gray-300 text-gray-600 bg-white" style="background: #f4f5f7;border-radius: 6px;border: none;" data-tag="服务态度友好">
                                服务态度友好
                            </button>
                            <button class="service-tag px-3 py-2 rounded-full text-sm border border-gray-300 text-gray-600 bg-white" style="background: #f4f5f7;border-radius: 6px;border: none;" data-tag="处理流畅及时">
                                处理流畅及时
                            </button>
                            <button class="service-tag px-3 py-2 rounded-full text-sm border border-gray-300 text-gray-600 bg-white" style="background: #f4f5f7;border-radius: 6px;border: none;" data-tag="专业解答清晰">
                                专业解答清晰
                            </button>
                            <button class="service-tag px-3 py-2 rounded-full text-sm border border-gray-300 text-gray-600 bg-white" style="background: #f4f5f7;border-radius: 6px;border: none;" data-tag="有同理心">
                                有同理心
                            </button>
                        </div>
                    </div>
                    
                    <!-- 问题是否解决 -->
                    <div class="mb-6">
                        <h3 class="text-center text-gray-800 font-medium mb-4">问题是否解决</h3>
                        <div class="flex justify-center gap-4">
                            <button class="problem-status px-6 py-2 rounded-full text-sm border border-gray-300 text-gray-600 bg-white" style="background: #f4f5f7;border-radius: 6px;border: none;"  data-status="已解决">
                                已解决
                            </button>
                            <button class="problem-status px-6 py-2 rounded-full text-sm border border-gray-300 text-gray-600 bg-white" style="background: #f4f5f7;border-radius: 6px;border: none;" data-status="未解决">
                                未解决
                            </button>
                        </div>
                    </div>
                    
                    <!-- 附加评价输入 -->
                    <div class="mb-6">
                        <textarea id="additional-comment" 
                                  placeholder="还想夸一夸～" 
                                  class="w-full p-3 border border-gray-300 rounded-lg resize-none text-sm"
                                  rows="3"></textarea>
                    </div>
                    
                    <!-- 提交按钮 -->
                    <button id="submit-rating" class="w-full bg-orange-400 text-white py-3 rounded-lg font-medium text-lg">
                        匿名评价
                    </button>
                </div>
            </div>
        </div>
        
        <!-- 删除消息确认弹窗 -->
        <div id="delete-message-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-11/12 max-w-sm mx-4">
                <!-- 弹窗标题 -->
                <div class="text-center py-4 px-6 border-b">
                    <h2 class="text-lg font-medium text-gray-800">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        确认删除消息
                    </h2>
                </div>
                
                <!-- 弹窗内容 -->
                <div class="p-6">
                    <p class="text-gray-600 text-center mb-6">
                        确定要删除这条消息吗？<br>
                        <span class="text-sm text-red-500">删除后无法恢复</span>
                    </p>
                    
                    <!-- 操作按钮 -->
                    <div class="flex gap-3">
                        <button id="cancel-delete-btn" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            取消
                        </button>
                        <button id="confirm-delete-btn" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            确认删除
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 消息右键菜单 -->
        <div id="message-context-menu" class="hidden fixed bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50" style="min-width: 160px;">
            <div class="px-3 py-2 text-xs text-gray-500 border-b border-gray-100">消息操作</div>
            
            <button id="menu-copy" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                复制
            </button>
            
            <button id="menu-quote" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                引用
            </button>
            
            <button id="menu-forward" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                转发
            </button>
            
            <button id="menu-select" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                多选
            </button>
            
            <button id="menu-delete" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition-colors hidden">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                删除
            </button>
        </div>
    </div>

    <!-- 消息提示音 -->
    <audio id="message-notification" preload="auto">
        <source src="audio/消息提示音.mp3" type="audio/mpeg">
        您的浏览器不支持音频播放。
    </audio>

    <!-- 音频状态提示 -->
    <!-- <div id="audio-status-banner" class="fixed top-0 left-0 right-0 bg-yellow-500 text-white text-center py-2 px-4 z-50 hidden">
        <div class="flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M6.343 6.343a8 8 0 000 11.314m2.829-4.243a4 4 0 000-5.657"></path>
            </svg>
            <span>点击页面任意位置启用消息提示音</span>
            <button id="enable-audio-btn" class="ml-2 px-2 py-1 bg-white text-yellow-600 rounded text-sm hover:bg-gray-100">
                启用
            </button>
            <button id="dismiss-audio-banner" class="ml-2 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div> -->

    <script>
        // ======================== 移动端适配解决方案 ========================
        
        // 计算并设置正确的视口高度
        function setViewportHeight() {
            // 计算实际可视区域高度
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
            
            // 为主容器设置正确的高度
            const mainContainer = document.querySelector('.main-container');
            if (mainContainer) {
                mainContainer.style.height = `${window.innerHeight}px`;
                mainContainer.style.maxHeight = `${window.innerHeight}px`;
            }
        }
        
        // 防止iOS Safari地址栏影响
        function fixMobileViewport() {
            // 设置初始视口高度
            setViewportHeight();
            
            // 监听窗口大小变化
            window.addEventListener('resize', () => {
                setViewportHeight();
                // 窗口大小变化时重新生成水印
                if (typeof initializeWatermark === 'function') {
                    setTimeout(initializeWatermark, 100);
                }
            });
            window.addEventListener('orientationchange', () => {
                setTimeout(() => {
                    setViewportHeight();
                    // 设备旋转时重新生成水印
                    if (typeof initializeWatermark === 'function') {
                        initializeWatermark();
                    }
                }, 100);
            });
            
            // 防止iOS Safari缩放
            document.addEventListener('touchstart', function(e) {
                if (e.touches.length > 1) {
                    e.preventDefault();
                }
            });
            
            // 防止双击缩放
            let lastTouchEnd = 0;
            document.addEventListener('touchend', function(e) {
                const now = new Date().getTime();
                if (now - lastTouchEnd <= 300) {
                    e.preventDefault();
                }
                lastTouchEnd = now;
            }, false);
            
            // 阻止橡皮筋效果
            document.body.addEventListener('touchmove', function(e) {
                if (e.target === document.body || e.target === document.documentElement) {
                    e.preventDefault();
                }
            }, { passive: false });
        }
        
        // 确保聊天区域正确计算高度
        function adjustChatAreaHeight() {
            const chatArea = document.getElementById('chat-area');
            const header = document.querySelector('.chat-header');
            const quickActions = document.getElementById('quick-actions');
            const inputContainer = document.querySelector('.input-container');
            
            if (chatArea && header && quickActions && inputContainer) {
                const windowHeight = window.innerHeight;
                const headerHeight = header.offsetHeight;
                const quickActionsHeight = quickActions.offsetHeight;
                const inputContainerHeight = inputContainer.offsetHeight;
                
                const availableHeight = windowHeight - headerHeight - quickActionsHeight - inputContainerHeight;
                chatArea.style.height = `${Math.max(availableHeight, 200)}px`;
                chatArea.style.maxHeight = `${Math.max(availableHeight, 200)}px`;
            }
        }
        
        // 页面加载完成后初始化移动端适配
        document.addEventListener('DOMContentLoaded', function() {
            fixMobileViewport();
            
            // 延迟调整布局，确保DOM完全加载
            setTimeout(() => {
                adjustChatAreaHeight();
                setViewportHeight();
            }, 100);
        });
        
        // 页面完全加载后再次调整
        window.addEventListener('load', function() {
            setTimeout(() => {
                adjustChatAreaHeight();
                setViewportHeight();
            }, 200);
        });
        
        // ======================== 原有代码开始 ========================
        
        // 页面变量 - 从PHP获取房间和用户信息
        const ROOM_ID = '<?php echo htmlspecialchars($room_id); ?>';
        const ROOM_NAME = '<?php echo addslashes($room_name); ?>';
        const USER_NAME = '<?php echo htmlspecialchars($user_name); ?>';
        const USER_ROLE = '<?php echo htmlspecialchars($user_role); ?>';
        const API_BASE = 'api/chatroom_api_ultra_simple.php';
        const UPLOAD_API = 'api/upload.php';
        
        // 消息和定时器变量
        let messages = [];
        let lastMessageId = 0;
        let heartbeatInterval, messageInterval, usersInterval, readStatusInterval, roomStatusInterval;
        
        // 音频提示相关
        let messageAudio = null;
        let audioEnabled = true; // 是否启用音频提示
        let audioReady = false; // 音频是否准备就绪（用户已交互）
        let isFirstLoad = true; // 是否首次加载（避免首次加载时播放提示音）
        
        // 其他全局变量
        let currentUser = null;
        let eventListenersInitialized = false; // 防止重复绑定事件监听器
        let sendingMessage = false; // 发送消息防抖标志
        
        // 页面初始化
        console.log('聊天室初始化中...');
        console.log('用户信息:', {
            name: USER_NAME,
            role: USER_ROLE,
            room: ROOM_ID
        });
        
        document.addEventListener('DOMContentLoaded', async function() {
            // 使用从PHP传递的用户信息，并生成稳定的用户ID
            currentUser = {
                user_id: generateStableUserId(USER_ROLE, USER_NAME),
                user_type: USER_ROLE,
                nickname: USER_NAME
            };

            // 初始化聊天室
            try {
                initializeEventListeners();
                
                // 初始化用户专属水印
                initializeWatermark();
                
                // 立即发送心跳以注册为在线用户
                console.log('发送初始心跳，注册为在线用户...');
                await sendHeartbeat();
                
                // 延迟200ms后加载数据，确保心跳已处理
                setTimeout(async () => {
                    await loadMessages();
                    loadOnlineUsers();
                }, 200);
                
                startIntervals();
            } catch (error) {
                console.error('初始化失败:', error);
                alert('初始化失败，请重新进入');
                window.location.href = `room.php?id=${ROOM_ID}`;
            }
        });
        
        // 生成稳定的用户ID（基于用户角色和用户名，而不是时间戳）
        function generateStableUserId(userRole, userName) {
            switch(userRole) {
                case 'admin':
                    // 🔧 修复：管理员使用固定ID，确保不同登录方式身份一致
                    return 'admin_backend';
                case 'buyer':
                    // 买家使用基于用户名的固定ID
                    return 'buyer_' + simpleHash(userName);
                case 'guest':
                    // 游客保持原有逻辑（IP绑定已经确保身份稳定）
                    return 'guest_' + simpleHash(userName);
                default:
                    return 'user_' + simpleHash(userName);
            }
        }
        
        // 简单哈希函数，基于字符串生成稳定的数字
        function simpleHash(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                const char = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash; // 转换为32位整数
            }
            return Math.abs(hash);
        }
        
        // 链接检测和处理函数
        function processLinksAndEscape(text) {
            const links = [];
            let linkIndex = 0;
            
            // 第一步：处理自定义文字链接格式 [文字]链接
            const customLinkRegex = /\[([^\]]*)\](https?:\/\/[^\s<>&"']+|www\.[^\s<>&"']+)/gi;
            let textWithCustomLinks = text.replace(customLinkRegex, function(match, customText, url) {
                // 确保URL有协议
                let fullUrl = url;
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    fullUrl = 'http://' + url;
                }
                
                // 使用自定义文字，如果为空则使用链接地址
                let displayText = customText.trim() || url;
                
                // 对URL进行HTML转义处理
                const escapedUrl = fullUrl.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                const escapedDisplayText = displayText.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                
                // 存储自定义链接HTML（使用统一样式）
                const linkHtml = `<a href="${escapedUrl}" class="message-link" style="display: block;max-width: 14rem;" target="_blank" rel="noopener noreferrer" onclick="return handleLinkClick(event, '${escapedUrl}')">${escapedDisplayText}</a>`;
                links[linkIndex] = linkHtml;
                
                // 返回占位符
                return `__LINK_PLACEHOLDER_${linkIndex++}__`;
            });
            
            // 第二步：处理剩余的普通链接（没有自定义文字的）
            const urlRegex = /(https?:\/\/[^\s<>&"']+|www\.[^\s<>&"']+)/gi;
            const textWithPlaceholders = textWithCustomLinks.replace(urlRegex, function(url) {
                // 确保URL有协议
                let fullUrl = url;
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    fullUrl = 'http://' + url;
                }
                
                // 普通链接直接显示完整URL
                let displayText = url;
                
                // 对URL进行HTML转义处理
                const escapedUrl = fullUrl.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                const escapedDisplayText = displayText.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                
                // 存储链接HTML（使用统一样式）
                const linkHtml = `<a href="${escapedUrl}" class="message-link" style="display: block; max-width: 14rem;" target="_blank" rel="noopener noreferrer" onclick="return handleLinkClick(event, '${escapedUrl}')">${escapedDisplayText}</a>`;
                links[linkIndex] = linkHtml;
                
                // 返回占位符
                return `__LINK_PLACEHOLDER_${linkIndex++}__`;
            });
            
            // 第三步：对文本进行HTML转义
            const escapedText = escapeHtml(textWithPlaceholders);
            
            // 第四步：将占位符替换回链接HTML
            return escapedText.replace(/__LINK_PLACEHOLDER_(\d+)__/g, function(match, index) {
                return links[parseInt(index)] || match;
            });
        }
        
        // 处理链接点击事件
        function handleLinkClick(event, url) {
            // 可以在这里添加确认对话框或其他逻辑
            // if (confirm('确定要打开这个链接吗？\n' + url)) {
            //     // 允许默认行为（在新窗口打开）
            //     return true;
            // } else {
            //     // 阻止默认行为
            //     event.preventDefault();
            //     return false;
            // }
            return true;
        }

        // 初始化事件监听器
        function initializeEventListeners() {
            // 防止重复绑定事件监听器
            if (eventListenersInitialized) {
                console.log('事件监听器已初始化，跳过重复绑定');
                return;
            }
            
            console.log('开始初始化事件监听器...');
            
            // 发送消息 - 添加防抖处理
            document.getElementById('send-btn').addEventListener('click', function(e) {
                e.preventDefault();
                if (!sendingMessage) {
                    sendMessage();
                }
            });
            
            document.getElementById('message-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (!sendingMessage) {
                        sendMessage();
                    }
                }
            });

            // 输入框状态管理
            document.getElementById('message-input').addEventListener('input', function() {
                const sendBtn = document.getElementById('send-btn');
                const moreBtn = document.getElementById('more-btn');
                
                if (this.value.trim().length > 0) {
                    sendBtn.classList.remove('hidden');
                    moreBtn.classList.add('hidden');
                } else {
                    sendBtn.classList.add('hidden');
                    moreBtn.classList.remove('hidden');
                }
            });
            
            // 音频相关事件监听器
            initAudioEventListeners();

            // 表情功能
            document.getElementById('emoji-btn').addEventListener('click', toggleEmojiPicker);
            document.getElementById('close-emoji').addEventListener('click', hideEmojiPicker);
            document.querySelectorAll('[data-emoji]').forEach(emoji => {
                emoji.addEventListener('click', function() {
                    insertEmoji(this.dataset.emoji);
                });
            });

            // 成员列表
            document.getElementById('members-btn').addEventListener('click', showMemberList);
            document.getElementById('close-members').addEventListener('click', hideMemberList);
            document.getElementById('member-list').addEventListener('click', function(e) {
                // 点击背景（非成员列表区域）关闭列表
                if (e.target === this) {
                    hideMemberList();
                }
            });
            
            // 初始化置顶开关功能
            initToggleSwitch();

            // 文件上传
            document.getElementById('attach-btn').addEventListener('click', () => {
                document.getElementById('album-input').click();
            });
            document.getElementById('album-btn').addEventListener('click', () => {
                document.getElementById('album-input').click();
            });
            document.getElementById('video-btn').addEventListener('click', () => {
                document.getElementById('video-input').click();
            });
            
            document.getElementById('album-input').addEventListener('change', handleFileUpload);
            document.getElementById('video-input').addEventListener('change', handleFileUpload);

            // 更多功能菜单
            document.getElementById('more-btn').addEventListener('click', toggleMoreMenu);
            document.getElementById('close-more').addEventListener('click', hideMoreMenu);

            // 图片预览
            document.getElementById('close-preview').addEventListener('click', hideImagePreview);
            document.getElementById('image-preview').addEventListener('click', function(e) {
                // 点击背景（非图片区域）关闭预览
                if (e.target === this) {
                    hideImagePreview();
                }
            });

            // 视频预览
            document.getElementById('close-video').addEventListener('click', hideVideoPreview);
            document.getElementById('video-preview').addEventListener('click', function(e) {
                // 点击背景（非视频区域）关闭预览
                if (e.target === this) {
                    hideVideoPreview();
                }
            });

            // 返回按钮
            document.getElementById('back-btn').addEventListener('click', leaveChatroom);

            // 快捷操作按钮
            document.getElementById('urge-service-btn').addEventListener('click', urgeService);
            document.getElementById('rate-service-btn').addEventListener('click', function(e) {
                e.stopPropagation();
                showRatingModal();
            });
            document.getElementById('trade-message-btn').addEventListener('click', function() {
                window.location.href = '../xyyl.php';
            });
            document.getElementById('complaint-btn').addEventListener('click', function() {
                window.location.href = '../wd.php';
            });

            // 点击外部关闭弹窗
            document.addEventListener('click', handleOutsideClick);
            
            // ESC键关闭弹窗
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideImagePreview();
                    hideVideoPreview();
                    hideMemberList();
                    hideEmojiPicker();
                    hideMoreMenu();
                    hideRatingModal();
                    hideDeleteModal();
                    hideMessageContextMenu();
                }
            });
            
            // 初始化评价弹窗事件
            initRatingModal();
            
            // 初始化删除消息弹窗事件
            initDeleteModal();
            
            // 初始化右键菜单事件监听器
            initContextMenuListeners();
            
            // 初始化引用功能事件监听器
            initQuoteEventListeners();
            
            // 初始化消息提示音
            initializeMessageAudio();
            
            // 标记事件监听器已初始化
            eventListenersInitialized = true;
            console.log('事件监听器初始化完成');
        }

        // 初始化音频事件监听器
        function initAudioEventListeners() {
            // 音频状态横幅事件监听器
            const enableAudioBtn = document.getElementById('enable-audio-btn');
            const dismissBanner = document.getElementById('dismiss-audio-banner');
            
            if (enableAudioBtn) {
                enableAudioBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    enableAudioNotification();
                    hideAudioBanner();
                });
            }
            
            if (dismissBanner) {
                dismissBanner.addEventListener('click', function(e) {
                    e.stopPropagation();
                    hideAudioBanner();
                    disableAudioNotification();
                });
            }
            
            // 多种用户交互触发音频启用
            const audioTriggerEvents = [
                { element: document.getElementById('message-input'), events: ['focus', 'click'] },
                { element: document.getElementById('send-btn'), events: ['click'] },
                { element: document.getElementById('emoji-btn'), events: ['click'] },
                { element: document.getElementById('more-btn'), events: ['click'] },
                { element: document.getElementById('attach-btn'), events: ['click'] },
                { element: document.body, events: ['click'], once: true }
            ];
            
            audioTriggerEvents.forEach(({ element, events, once = false }) => {
                if (element) {
                    events.forEach(event => {
                        const handler = function() {
                            if (audioEnabled && messageAudio && !audioReady) {
                                enableAudioNotification();
                            }
                        };
                        
                        if (once) {
                            element.addEventListener(event, handler, { once: true });
                        } else {
                            element.addEventListener(event, handler);
                        }
                    });
                }
            });
        }

        // 显示音频状态横幅
        function showAudioBanner() {
            const banner = document.getElementById('audio-status-banner');
            if (banner && !audioReady) {
                // banner.classList.remove('hidden');
            }
        }

        // 隐藏音频状态横幅
        function hideAudioBanner() {
            const banner = document.getElementById('audio-status-banner');
            if (banner) {
                banner.classList.add('hidden');
            }
        }

        // 开始定时任务
        function startIntervals() {
            // 启动定时器
            setTimeout(() => {
                sendHeartbeat();
            }, 200);
            
            // 设置定时器 - 优化时间间隔提高响应速度
            heartbeatInterval = setInterval(sendHeartbeat, 15000); // 心跳间隔保持15秒
            
            // 消息和已读状态加载 - 提高频率
            messageInterval = setInterval(loadNewMessages, 2000); // 消息加载保持2秒
            
            // 在线用户检查 - 缩短间隔提高退出检测速度
            usersInterval = setInterval(loadOnlineUsers, 3000); // 5秒 → 3秒
            
            // 已读状态刷新 - 新增专门的已读状态刷新
            readStatusInterval = setInterval(refreshReadStatus, 4000); // 每4秒刷新已读状态
            
            // 延迟一下加载数据，确保心跳先执行
            setTimeout(() => {
                loadNewMessages();
                loadOnlineUsers();
            }, 500);
            
            // 房间状态检查 - 缩短间隔
            roomStatusInterval = setInterval(checkRoomStatus, 20000); // 30秒 → 20秒
        }

        // 停止定时任务
        function stopIntervals() {
            if (heartbeatInterval) clearInterval(heartbeatInterval);
            if (messageInterval) clearInterval(messageInterval);
            if (usersInterval) clearInterval(usersInterval);
            if (readStatusInterval) clearInterval(readStatusInterval);
            if (roomStatusInterval) clearInterval(roomStatusInterval);
        }

        // 检查聊天室状态
        async function checkRoomStatus() {
            try {
                const response = await fetch(`${API_BASE}?action=check_room_status&room_id=${encodeURIComponent(ROOM_ID)}`);
                const result = await response.json();
                
                if (!result.success) {
                    // 聊天室不存在或被禁用
                    console.warn('聊天室状态检查失败:', result.message);
                    
                    // 停止所有定时任务
                    stopIntervals();
                    
                    // 显示错误信息并跳转
                    let errorMessage = '聊天室不可用';
                    if (result.error_code === 'ROOM_NOT_FOUND') {
                        errorMessage = '聊天室已被删除';
                    } else if (result.error_code === 'ROOM_INACTIVE') {
                        errorMessage = '聊天室已被禁用';
                    }
                    
                    alert(`${errorMessage}，即将跳转到首页`);
                    
                    // 跳转到首页
                    setTimeout(() => {
                        // window.location.href = 'index.php';
                    }, 1000);
                    
                    return false;
                }
                
                return true;
            } catch (error) {
                console.error('检查聊天室状态失败:', error);
                return true; // 网络错误时不中断聊天
            }
        }

        // 加载消息
        async function loadMessages() {
            try {
                const response = await fetch(`${API_BASE}?action=get_messages&room_id=${encodeURIComponent(ROOM_ID)}&limit=50`);
                const result = await response.json();
                
                if (result.success) {
                    messages = result.data;
                    if (messages.length > 0) {
                        lastMessageId = Math.max(...messages.map(m => parseInt(m.id)));
                        
                        // 标记历史消息为已读
                        markMessagesAsRead(messages);
                    }
                    renderMessages();
                    
                                    // 首次加载完成，后续新消息可以播放提示音
                isFirstLoad = false;
                console.log('首次消息加载完成，音频提示已激活');
                }
            } catch (error) {
                console.error('加载消息失败:', error);
            }
        }

        // 加载新消息
        async function loadNewMessages() {
            try {
                const response = await fetch(`${API_BASE}?action=get_messages&room_id=${encodeURIComponent(ROOM_ID)}&last_id=${lastMessageId}&limit=20`);
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    const newMessages = result.data;
                    
                    // 过滤掉本地已存在的消息，防止重复
                    const filteredNewMessages = newMessages.filter(newMsg => {
                        const msgId = parseInt(newMsg.id);
                        return !messages.some(existingMsg => parseInt(existingMsg.id) === msgId);
                    });
                    
                    if (filteredNewMessages.length === 0) {
                        return; // 没有真正的新消息
                    }
                    
                    console.log(`获取到 ${filteredNewMessages.length} 条新消息`);
                    
                    // 检查是否有来自其他用户的新消息（非自己发送的）
                    const hasOtherUserMessages = filteredNewMessages.some(msg => 
                        msg.user_name !== USER_NAME && 
                        msg.message_type !== 'system'
                    );
                    
                    messages = messages.concat(filteredNewMessages);
                    lastMessageId = Math.max(...filteredNewMessages.map(m => parseInt(m.id)));
                    renderMessages();
                    
                    // 如果有其他用户的新消息，播放提示音
                    if (hasOtherUserMessages && !isFirstLoad) {
                        playMessageNotification();
                    }
                    
                    // 标记已读
                    markMessagesAsRead(filteredNewMessages);
                }
            } catch (error) {
                console.error('加载新消息失败:', error);
            }
        }

        // 渲染消息
        function renderMessages() {
            const chatArea = document.getElementById('chat-area');
            
            // 清空聊天区域
            chatArea.innerHTML = '';
            
            messages.forEach(msg => {
                const messageDiv = createMessageElement(msg);
                chatArea.appendChild(messageDiv);
            });
            
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        // 创建消息元素
        function createMessageElement(msg) {
            const isSelf = msg.user_name === USER_NAME;
            const isSystem = msg.message_type === 'system' || msg.user_type === 'system' || msg.user_name === 'system';
            const isAdminMessage = msg.user_type === 'admin' && isSelf; // 只有官方自己的消息可以删除
            
            const msgDiv = document.createElement('div');
            
            if (isSystem) {
                msgDiv.className = 'flex justify-center mb-4';
                // 处理换行：将\n转换为<br>标签
                const formattedContent = escapeHtml(msg.content).replace(/\n/g, '<br>');
                msgDiv.innerHTML = `
                    <div class="bg-white text-gray-700 px-4 py-2 rounded-lg shadow-sm border border-gray-200 text-sm" style="
                        background: white;border: none;box-shadow: none;
                    ">
                        ${formattedContent}
                    </div>
                `;
                return msgDiv;
            }
            
            msgDiv.className = `flex mb-12 ${isSelf ? 'justify-end' : ''}`;
            
            // 为所有消息添加右键菜单功能
            msgDiv.setAttribute('data-message-id', msg.id);
            msgDiv.setAttribute('data-message-content', msg.content);
            msgDiv.setAttribute('data-message-user', msg.user_name);
            msgDiv.setAttribute('data-message-type', msg.user_type);
            msgDiv.setAttribute('data-is-self', isSelf);
            msgDiv.style.cursor = 'pointer';
            
            let contentHtml = '';
            if (msg.message_type === 'text') {
                // 检查是否包含引用信息
                const quoteRegex = /^\[QUOTE:(\d+):([^:]+):([^\]]+)\](.*)$/;
                const quoteMatch = msg.content.match(quoteRegex);
                
                if (quoteMatch) {
                    // 解析引用信息
                    const [, quoteId, quoteUser, quoteContent, actualContent] = quoteMatch;
                    
                    // 处理引用内容中的转义字符
                    const cleanQuoteContent = quoteContent.replace(/\\n/g, '\n');
                    const displayQuoteContent = cleanQuoteContent.length > 50 ? 
                        cleanQuoteContent.substring(0, 50) + '...' : cleanQuoteContent;
                    
                    // 处理实际消息内容
                    let processedActualContent = processLinksAndEscape(actualContent.trim());
                    // 识别连续的数字序列并添加特殊class
                    processedActualContent = processedActualContent.replace(/(\d{10,})/g, '<span class="number-sequence">$1</span>');
                    
                    // 构建带引用的消息HTML
                    contentHtml = `
                        <div class="quote-message">
                            <div class="quote-header mb-2 p-2 bg-gray-100 rounded border-l-3 border-blue-400" style="border-left: 3px solid #60a5fa;">
                                <div class="flex items-center text-xs text-gray-600 mb-1">
                                    <i class="fas fa-reply mr-1"></i>
                                    <span class="font-medium">${escapeHtml(quoteUser)}</span>
                                </div>
                                <div class="text-sm text-gray-700" style="word-break: break-word;">
                                    ${escapeHtml(displayQuoteContent)}
                                </div>
                            </div>
                            <div class="actual-content" style="word-break: break-word; overflow-wrap: break-word; white-space: normal; display: block; width: 100%;">
                                ${processedActualContent}
                            </div>
                        </div>
                    `;
                } else {
                    // 普通文本消息处理
                    let processedContent = processLinksAndEscape(msg.content);
                    // 识别连续的数字序列并添加特殊class
                    processedContent = processedContent.replace(/(\d{10,})/g, '<span class="number-sequence">$1</span>');
                    contentHtml = `<span style="word-break: break-word; overflow-wrap: break-word; white-space: normal; display: block; width: 100%;">${processedContent}</span>`;
                }
            } else if (msg.message_type === 'image') {
                contentHtml = `<img src="${msg.file_url || ''}" alt="图片" class="chat-img rounded-lg mb-1" onclick="showImagePreview('${msg.file_url || ''}')">`;
            } else if (msg.message_type === 'video') {
                contentHtml = `
                    <div class="chat-video mb-1">
                        <video class="video-thumbnail" preload="metadata" muted>
                            <source src="${msg.file_url || ''}" type="video/mp4">
                            您的浏览器不支持视频播放
                        </video>
                        <div class="video-play-icon" onclick="showVideoPreview('${msg.file_url || ''}', '${msg.file_name || ''}')">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <i class="fas fa-video video-icon"></i>
                        <span>${msg.file_name || '文件'}</span>
                    </div>
                `;
            } else if (msg.message_type === 'file') {
                contentHtml = `<a href="${msg.file_url || ''}" class="text-blue-500 underline" download="${msg.file_name || '文件'}">${msg.file_name || '文件'}</a>`;
            }
            
            let readStatusHtml = '';
            if (isSelf && msg.read_status) {
                const { read_count, total_count } = msg.read_status;
                if (read_count === 0) {
                    readStatusHtml = `<span class="text-xs text-red-500 mr-1" style="min-width: 4rem;display: flex;justify-content: flex-end;">未读</span>`;
                } else if (read_count < total_count) {
                    readStatusHtml = `<span class="text-xs text-gray-400 mr-1" style="min-width: 4rem;display: flex;justify-content: flex-end;">${read_count}人已读</span>`;
                } else {
                    readStatusHtml = `<span class="text-xs text-green-500 mr-1" style="min-width: 4rem;display: flex;justify-content: flex-end;">全部已读</span>`;
                }
            }
            
            // 根据用户类型显示不同颜色的标签
            let userTypeLabel = '';
            if (msg.user_type === 'admin') {
                userTypeLabel = `<span class="inline-block px-2 py-0 rounded text-xs font-bold ml-1 align-middle" style="background-color: #fdedcd; color: #99845e;">官方</span>`;
            } else if (msg.user_type === 'buyer') {
                userTypeLabel = `<span class="inline-block px-2 py-0 rounded text-xs font-bold ml-1 align-middle" style="background-color: #8fbefe; color: #1e3a8a;">买家</span>`;
            } else if (msg.user_type === 'seller' || msg.user_type === 'guest') {
                userTypeLabel = `<span class="inline-block px-2 py-0 bg-green-100 text-green-600 rounded text-xs font-bold ml-1 align-middle">卖家</span>`;
            }
            
            msgDiv.innerHTML = `
                <div class="flex items-end ${isSelf ? 'flex-row-reverse' : ''}">
                    <img src="${msg.avatar || 'images/user.png'}" alt="avatar" class="message-avatar w-8 h-8 rounded-full mx-2 self-start" data-user-name="${escapeHtml(msg.user_name)}" data-user-type="${msg.user_type}" data-nickname="${escapeHtml(msg.nickname || msg.user_name)}" title="${isSelf ? '' : '右键或长按@该用户，双击也可以'}">
                    <div class="flex flex-col ${isSelf ? 'items-end' : 'items-start'}">
                        <div class="flex items-center mb-1">
                            ${isSelf
                                ? `<span class="text-xs text-gray-400 mr-1">${formatTime(msg.send_time)}</span>${userTypeLabel}<span class="font-bold text-xs text-gray-700 ml-1" style="color: #707173;font-weight: 400;font-family: '黑体', sans-serif;">${escapeHtml(msg.nickname)}</span>`
                                : `<span class="font-bold text-xs text-gray-700 mr-1" style="color: #707173;font-weight: 400;font-family: '黑体', sans-serif;">${escapeHtml(msg.nickname)}</span>${userTypeLabel}<span class="text-xs text-gray-400 ml-1" style="color:#c2c3c6;">${formatTime(msg.send_time)}</span>`
                            } 
                        </div>
                        <div class="flex items-end ${isSelf ? 'flex-row-reverse' : ''}">
                            <div class="message-bubble ${isSelf ? 'sent' : 'received'} p-3" data-message-id="${msg.id}">
                                ${contentHtml}
                            </div>
                            ${isSelf ? readStatusHtml : ''}
                        </div>
                    </div>
                </div>
            `;
            
            // 为消息气泡添加右键菜单事件监听器
            const messageBubble = msgDiv.querySelector('.message-bubble');
            addMessageContextMenuListeners(messageBubble, msg);
            
            // 为头像添加@用户功能事件监听器（只针对非自己的头像）
            if (!isSelf) {
                const avatar = msgDiv.querySelector('.message-avatar');
                addAvatarMentionListeners(avatar, msg);
            }
            
            return msgDiv;
        }

        // 发送消息
        async function sendMessage() {
            // 防止重复发送
            if (sendingMessage) {
                console.log('消息正在发送中，忽略重复请求');
                return;
            }
            
            const input = document.getElementById('message-input');
            const content = input.value.trim();
            
            if (!content) return;
            
            // 设置发送状态，防止重复发送
            sendingMessage = true;
            
            // 用户发送消息时启用音频提示（用户交互）
            if (audioEnabled && messageAudio) {
                enableAudioNotification();
            }
            
            const sendBtn = document.getElementById('send-btn');
            sendBtn.classList.add('loading');
            sendBtn.disabled = true; // 禁用按钮防止重复点击
            
            try {
                // 构建最终的消息内容
                let finalContent = content;
                let quoteInfo = null;
                
                // 如果有引用数据，包含引用信息
                if (currentQuoteData) {
                    quoteInfo = {
                        quote_id: currentQuoteData.id,
                        quote_user: currentQuoteData.nickname,
                        quote_content: currentQuoteData.content,
                        quote_user_type: currentQuoteData.user_type
                    };
                    
                    // 在内容前添加引用标记（用于后端识别）
                    finalContent = `[QUOTE:${currentQuoteData.id}:${currentQuoteData.nickname}:${currentQuoteData.content.replace(/\n/g, '\\n')}]${content}`;
                }
                
                const formData = new FormData();
                formData.append('action', 'send_message');
                formData.append('room_id', ROOM_ID);
                formData.append('user_name', USER_NAME);
                formData.append('user_role', USER_ROLE);
                formData.append('content', finalContent);
                
                // 如果有引用信息，也发送引用数据
                if (quoteInfo) {
                    formData.append('quote_data', JSON.stringify(quoteInfo));
                }
                
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    input.value = '';
                    input.dispatchEvent(new Event('input'));
                    
                    // 清除引用预览
                    if (currentQuoteData) {
                        hideQuotePreview();
                    }
                    
                    // 延迟一点再加载新消息，避免和定时器冲突
                    setTimeout(() => {
                        loadNewMessages();
                    }, 300);
                } else {
                    // 检查是否是聊天室不存在的错误
                    if (result.error_code === 'ROOM_NOT_FOUND' || result.error_code === 'ROOM_INACTIVE') {
                        stopIntervals();
                        alert('聊天室已被删除或禁用，即将跳转到首页');
                        setTimeout(() => {
                            // window.location.href = 'index.php';
                        }, 1000);
                        return;
                    }
                    alert(result.message || '发送失败');
                }
            } catch (error) {
                console.error('发送消息失败:', error);
                alert('网络错误，发送失败');
            } finally {
                sendBtn.classList.remove('loading');
                sendBtn.disabled = false; // 恢复按钮状态
                sendingMessage = false; // 重置发送状态
            }
        }

        // 文件上传处理
        async function handleFileUpload(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('room_id', ROOM_ID);
            formData.append('user_name', USER_NAME);
            formData.append('user_role', USER_ROLE);
            
            try {
                // 显示上传进度
                showUploadProgress();
                
                const response = await fetch(UPLOAD_API, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    loadNewMessages(); // 立即加载新消息
                } else {
                    alert(result.message || '上传失败');
                }
            } catch (error) {
                console.error('文件上传失败:', error);
                alert('网络错误，上传失败');
            } finally {
                hideUploadProgress();
                e.target.value = ''; // 清空文件选择
            }
        }

        // 显示上传进度
        function showUploadProgress() {
            const chatArea = document.getElementById('chat-area');
            const progressDiv = document.createElement('div');
            progressDiv.id = 'upload-progress';
            progressDiv.className = 'flex justify-end mb-12';
            progressDiv.innerHTML = `
                <div class="message-bubble sent p-3">
                    <div class="flex items-center">
                        <i class="fas fa-spinner spinner mr-2"></i>
                        <span>正在上传...</span>
                    </div>
                </div>
            `;
            chatArea.appendChild(progressDiv);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        // 隐藏上传进度
        function hideUploadProgress() {
            const progressDiv = document.getElementById('upload-progress');
            if (progressDiv) {
                progressDiv.remove();
            }
        }

        // 加载在线用户
        async function loadOnlineUsers() {
            try {
                const response = await fetch(`${API_BASE}?action=get_users&room_id=${encodeURIComponent(ROOM_ID)}`);
                const result = await response.json();
                
                if (result.success) {
                    const users = result.data;
                    updateMemberCount(users.length);
                    // 不再渲染成员列表，因为已替换为客服信息页面
                }
            } catch (error) {
                console.error('加载在线用户失败:', error);
            }
        }

        // 更新成员数量
        function updateMemberCount(count) {
            document.getElementById('member-count').textContent = `${count} 人在线`;
        }

        // 标记消息已读
        async function markMessagesAsRead(newMessages) {
            for (const msg of newMessages) {
                if (msg.user_name !== USER_NAME) {
                    try {
                        const formData = new FormData();
                        formData.append('action', 'mark_read');
                        formData.append('room_id', ROOM_ID);
                        formData.append('user_name', USER_NAME);
                        formData.append('user_role', USER_ROLE);
                        formData.append('message_id', msg.id);
                        
                        fetch(API_BASE, {
                            method: 'POST',
                            body: formData
                        });
                    } catch (error) {
                        console.error('标记已读失败:', error);
                    }
                }
            }
        }

        // 刷新已读状态
        async function refreshReadStatus() {
            try {
                // 只获取最近的消息更新已读状态，避免大量数据传输
                const response = await fetch(`${API_BASE}?action=get_messages&room_id=${encodeURIComponent(ROOM_ID)}&last_id=${lastMessageId > 10 ? lastMessageId - 10 : 0}&limit=50`);
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    const latestMessages = result.data;
                    let hasChanges = false;
                    
                    // 只更新已存在消息的已读状态，不添加新消息
                    for (let i = 0; i < messages.length; i++) {
                        const localMsg = messages[i];
                        const serverMsg = latestMessages.find(m => parseInt(m.id) === parseInt(localMsg.id));
                        
                        // 只检查自己发送的消息
                        if (serverMsg && localMsg.user_name === USER_NAME) {
                            const localReadCount = localMsg.read_status ? localMsg.read_status.read_count : 0;
                            const serverReadCount = serverMsg.read_status ? serverMsg.read_status.read_count : 0;
                            const localTotalCount = localMsg.read_status ? localMsg.read_status.total_count : 0;
                            const serverTotalCount = serverMsg.read_status ? serverMsg.read_status.total_count : 0;
                            
                            // 如果已读状态有变化，更新本地消息
                            if (localReadCount !== serverReadCount || localTotalCount !== serverTotalCount) {
                                messages[i].read_status = serverMsg.read_status;
                                hasChanges = true;
                            }
                        }
                    }
                    
                    // 如果有已读状态变化，重新渲染
                    if (hasChanges) {
                        renderMessages();
                    }
                }
            } catch (error) {
                console.error('刷新已读状态失败:', error);
            }
        }

        // 发送心跳
        async function sendHeartbeat() {
            try {
                const formData = new FormData();
                formData.append('action', 'heartbeat');
                formData.append('room_id', ROOM_ID);
                formData.append('user_name', USER_NAME);
                formData.append('user_role', USER_ROLE);
                
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    console.log('心跳发送成功');
                } else {
                    console.warn('心跳失败:', result.message);
                    
                    // 检查是否是聊天室不存在的错误
                    if (result.error_code === 'ROOM_NOT_FOUND' || result.error_code === 'ROOM_INACTIVE') {
                        console.error('聊天室已不存在，停止心跳');
                        stopIntervals();
                        alert('聊天室已被删除或禁用，即将跳转到首页');
                        setTimeout(() => {
                            // window.location.href = 'index.php';
                        }, 1000);
                        return false;
                    }
                }
                
                return result;
            } catch (error) {
                console.error('心跳发送失败:', error);
                throw error;
            }
        }

        // 离开聊天室
        async function leaveChatroom() {
            if (confirm('确定要离开聊天室吗？')) {
                try {
                    const formData = new FormData();
                    formData.append('action', 'leave');
                    formData.append('room_id', ROOM_ID);
                    formData.append('user_name', USER_NAME);
                    formData.append('user_role', USER_ROLE);
                    
                    await fetch(API_BASE, {
                        method: 'POST',
                        body: formData
                    });
                } catch (error) {
                    console.error('离开聊天室失败:', error);
                } finally {
                    stopIntervals();
                    window.location.href = 'https://m1.pxb7.com/';
                }
            }
        }

        // 催客服功能（1分钟防抖）
        let lastUrgeTime = 0; // 记录上次催客服时间
        const URGE_COOLDOWN = 60 * 1000; // 1分钟冷却时间
        
        async function urgeService() {
            const now = Date.now();
            const timeSinceLastUrge = now - lastUrgeTime;
            
            // 检查是否在冷却期内
            if (lastUrgeTime > 0 && timeSinceLastUrge < URGE_COOLDOWN) {
                const remainingSeconds = Math.ceil((URGE_COOLDOWN - timeSinceLastUrge) / 1000);
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                
                let timeText;
                if (minutes > 0) {
                    timeText = `${minutes}分${seconds}秒`;
                } else {
                    timeText = `${seconds}秒`;
                }
                
                alert(`请不要频繁催促客服，请等待 ${timeText} 后再试`);
                return;
            }
            
            try {
                // 更新最后催促时间
                lastUrgeTime = now;
                
                // 发送催客服消息到数据库
                const formData = new FormData();
                formData.append('action', 'send_message');
                formData.append('room_id', ROOM_ID);
                formData.append('user_name', USER_NAME);
                formData.append('user_role', USER_ROLE);
                formData.append('message_type', 'system');
                formData.append('content', '您已催一催客服，正在加急处理中~');
                
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // 成功后立即加载新消息
                    loadNewMessages();
                } else {
                    // 如果API失败，fallback到前端显示
                    showUrgeMessageFallback();
                }
            } catch (error) {
                console.error('催客服消息发送失败:', error);
                // 如果网络错误，fallback到前端显示
                showUrgeMessageFallback();
            }
        }

        // 催客服消息的fallback显示方法
        function showUrgeMessageFallback() {
            const chatArea = document.getElementById('chat-area');
            const urgeDiv = document.createElement('div');
            urgeDiv.className = 'flex justify-center mb-4';
            urgeDiv.innerHTML = `
                <div class="bg-white text-gray-700 px-4 py-2 rounded-lg shadow-sm border border-gray-200 text-sm" style="
                        background: white;border: none;box-shadow: none;
                ">
                    您已催一催客服，正在加急处理中~
                </div>
            `;
            
            // 将提示消息插入到聊天区域底部
            chatArea.appendChild(urgeDiv);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        // UI 交互函数
        function toggleEmojiPicker() {
            const picker = document.getElementById('emoji-picker');
            picker.classList.toggle('hidden');
        }

        function hideEmojiPicker() {
            document.getElementById('emoji-picker').classList.add('hidden');
        }

        function insertEmoji(emoji) {
            const input = document.getElementById('message-input');
            input.value += emoji;
            input.focus();
            input.dispatchEvent(new Event('input'));
            hideEmojiPicker();
        }

        function showMemberList() {
            document.getElementById('member-list').classList.remove('hidden');
        }

        function hideMemberList() {
            document.getElementById('member-list').classList.add('hidden');
        }

        function toggleMoreMenu() {
            const menu = document.getElementById('more-menu');
            menu.classList.toggle('hidden');
        }

        function hideMoreMenu() {
            document.getElementById('more-menu').classList.add('hidden');
        }

        function showImagePreview(src) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-image');
            img.src = src;
            preview.classList.remove('hidden');
        }

        function hideImagePreview() {
            document.getElementById('image-preview').classList.add('hidden');
        }

        function showVideoPreview(src, title = '') {
            const preview = document.getElementById('video-preview');
            const video = document.getElementById('preview-video');
            const titleElement = document.getElementById('video-title');
            
            video.src = src;
            titleElement.textContent = title;
            preview.style.display = 'flex';
            video.play();
        }

        function hideVideoPreview() {
            const preview = document.getElementById('video-preview');
            const video = document.getElementById('preview-video');
            
            video.pause();
            preview.style.display = 'none';
        }

        function handleOutsideClick(e) {
            // 关闭表情选择器
            const emojiPicker = document.getElementById('emoji-picker');
            const emojiBtn = document.getElementById('emoji-btn');
            if (!emojiPicker.contains(e.target) && !emojiBtn.contains(e.target)) {
                hideEmojiPicker();
            }
            
            // 关闭更多菜单
            const moreMenu = document.getElementById('more-menu');
            const moreBtn = document.getElementById('more-btn');
            if (!moreMenu.contains(e.target) && !moreBtn.contains(e.target)) {
                hideMoreMenu();
            }
            
            // 关闭评价弹窗
            const ratingModal = document.getElementById('rating-modal');
            const ratingContent = ratingModal.querySelector('.bg-white');
            if (ratingModal && !ratingModal.classList.contains('hidden') && !ratingContent.contains(e.target)) {
                hideRatingModal();
            }
            
            // 关闭删除消息弹窗
            const deleteModal = document.getElementById('delete-message-modal');
            const deleteContent = deleteModal.querySelector('.bg-white');
            if (deleteModal && !deleteModal.classList.contains('hidden') && !deleteContent.contains(e.target)) {
                hideDeleteModal();
            }
            
            // 关闭右键菜单
            const contextMenu = document.getElementById('message-context-menu');
            if (contextMenu && !contextMenu.classList.contains('hidden') && !contextMenu.contains(e.target)) {
                hideMessageContextMenu();
            }
        }
        
        // 评价弹窗相关函数
        function showRatingModal() {
            document.getElementById('rating-modal').classList.remove('hidden');
        }
        
        function hideRatingModal() {
            document.getElementById('rating-modal').classList.add('hidden');
            // 重置表单
            resetRatingForm();
        }
        
        function resetRatingForm() {
            // 重置满意度选择
            document.querySelectorAll('.rating-option').forEach(option => {
                option.classList.remove('selected', 'unselected');
            });
            
            // 重置服务标签
            document.querySelectorAll('.service-tag').forEach(tag => {
                tag.classList.remove('selected');
            });
            
            // 重置问题状态
            document.querySelectorAll('.problem-status').forEach(status => {
                status.classList.remove('selected');
            });
            
            // 重置评价内容
            document.getElementById('additional-comment').value = '';
        }
        
        // 初始化置顶开关功能
        function initToggleSwitch() {
            const toggleSwitch = document.getElementById('toggleSwitch');
            if (toggleSwitch) {
                toggleSwitch.addEventListener('change', function() {
                    const cgElement = document.getElementById('cg');
                    const qxElement = document.getElementById('qx');
                    
                    if (this.checked) {
                        // 显示置顶成功提示
                        cgElement.style.display = 'flex';
                        qxElement.style.display = 'none';
                        setTimeout(function() {
                            cgElement.style.display = 'none';
                        }, 2000);
                    } else {
                        // 显示取消置顶提示
                        qxElement.style.display = 'flex';
                        cgElement.style.display = 'none';
                        setTimeout(function() {
                            qxElement.style.display = 'none';
                        }, 2000);
                    }
                });
            }
        }
        
        function initRatingModal() {
            // 满意度评价点击事件
            document.querySelectorAll('.rating-option').forEach(option => {
                option.addEventListener('click', function() {
                    // 移除所有选中状态和未选中状态
                    document.querySelectorAll('.rating-option').forEach(opt => {
                        opt.classList.remove('selected', 'unselected');
                    });
                    
                    // 设置当前选中
                    this.classList.add('selected');
                    
                    // 设置其他为未选中（变灰）
                    document.querySelectorAll('.rating-option').forEach(opt => {
                        if (opt !== this) {
                            opt.classList.add('unselected');
                        }
                    });
                });
            });
            
            // 服务标签点击事件（可多选）
            document.querySelectorAll('.service-tag').forEach(tag => {
                tag.addEventListener('click', function() {
                    this.classList.toggle('selected');
                });
            });
            
            // 问题状态点击事件（单选）
            document.querySelectorAll('.problem-status').forEach(status => {
                status.addEventListener('click', function() {
                    document.querySelectorAll('.problem-status').forEach(stat => stat.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            
            // 提交评价
            document.getElementById('submit-rating').addEventListener('click', function() {
                submitRating();
            });
        }
        
        function submitRating() {
            // 获取评价数据
            const selectedRating = document.querySelector('.rating-option.selected');
            const selectedTags = Array.from(document.querySelectorAll('.service-tag.selected')).map(tag => tag.dataset.tag);
            const selectedStatus = document.querySelector('.problem-status.selected');
            const additionalComment = document.getElementById('additional-comment').value.trim();
            
            if (!selectedRating) {
                alert('请选择满意度评价');
                return;
            }
            
            const ratingData = {
                rating: selectedRating.dataset.rating,
                ratingText: selectedRating.querySelector('span').textContent,
                serviceTags: selectedTags,
                problemStatus: selectedStatus ? selectedStatus.dataset.status : '',
                comment: additionalComment
            };
            
            // 这里可以发送评价数据到服务器
            console.log('评价数据:', ratingData);
            
            // 显示提交成功消息
            alert('感谢您的评价！');
            
            // 关闭弹窗
            hideRatingModal();
        }
        
        // 初始化删除消息弹窗
        function initDeleteModal() {
            // 取消删除
            document.getElementById('cancel-delete-btn').addEventListener('click', function() {
                hideDeleteModal();
            });
            
            // 确认删除
            document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                if (currentDeleteMessageId) {
                    deleteMessage(currentDeleteMessageId);
                }
            });
        }

        // 初始化右键菜单事件监听器
        function initContextMenuListeners() {
            console.log('初始化右键菜单事件监听器');
            
            // 复制按钮
            const copyBtn = document.getElementById('menu-copy');
            console.log('复制按钮元素:', copyBtn);
            if (copyBtn) {
                copyBtn.addEventListener('click', copyMessageContent);
                console.log('复制按钮事件监听器已添加');
            }
            
            // 引用按钮
            const quoteBtn = document.getElementById('menu-quote');
            console.log('引用按钮元素:', quoteBtn);
            if (quoteBtn) {
                quoteBtn.addEventListener('click', quoteMessage);
                console.log('引用按钮事件监听器已添加');
            }
            
            // 转发按钮
            const forwardBtn = document.getElementById('menu-forward');
            console.log('转发按钮元素:', forwardBtn);
            if (forwardBtn) {
                forwardBtn.addEventListener('click', forwardMessage);
                console.log('转发按钮事件监听器已添加');
            }
            
            // 多选按钮
            const selectBtn = document.getElementById('menu-select');
            console.log('多选按钮元素:', selectBtn);
            if (selectBtn) {
                selectBtn.addEventListener('click', selectMultipleMessages);
                console.log('多选按钮事件监听器已添加');
            }
            
            // 删除按钮
            const deleteBtn = document.getElementById('menu-delete');
            console.log('删除按钮元素:', deleteBtn);
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    console.log('删除按钮被点击');
                    e.preventDefault();
                    e.stopPropagation();
                    deleteMessageFromMenu();
                });
                console.log('删除按钮事件监听器已添加');
            }
        }
        
        // 初始化引用功能事件监听器
        function initQuoteEventListeners() {
            console.log('初始化引用功能事件监听器');
            
            // 取消引用按钮
            const cancelQuoteBtn = document.getElementById('cancel-quote');
            console.log('取消引用按钮元素:', cancelQuoteBtn);
            if (cancelQuoteBtn) {
                cancelQuoteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    cancelQuote();
                });
                console.log('取消引用按钮事件监听器已添加');
            }
        }

        // 工具函数
        function formatTime(timeStr) {
            const date = new Date(timeStr);
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            const hour = date.getHours().toString().padStart(2, '0');
            const minute = date.getMinutes().toString().padStart(2, '0');
            
            return `${month}/${day} ${hour}:${minute}`;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // 根据用户类型返回标签HTML
        function getUserTypeLabel(userType) {
            if (userType === 'admin') {
                return '<span class="ml-2 text-xs px-2 py-1 rounded" style="background-color: #fdedcd; color: #99845e;">官方</span>';
            } else if (userType === 'buyer') {
                return '<span class="ml-2 text-xs px-2 py-1 rounded" style="background-color: #8fbefe; color: #1e3a8a;">买家</span>';
            } else if (userType === 'seller') {
                return '<span class="ml-2 text-xs px-2 py-1 bg-green-100 text-green-600 rounded">卖家</span>';
            }
            return '';
        }

        // 页面卸载时清理
        window.addEventListener('beforeunload', function() {
            stopIntervals();
            if (USER_NAME) {
                navigator.sendBeacon(API_BASE, new URLSearchParams({
                    action: 'leave',
                    room_id: ROOM_ID,
                    user_name: USER_NAME,
                    user_role: USER_ROLE
                }));
            }
        });
        

    
        // ======================== 用户专属水印功能 ========================
        
        // 水印配置（可根据需要调整）
        const WATERMARK_CONFIG = {
            opacity: 0.3,        // 水印透明度 (0.1-0.3)
            fontSize: {           // 字体大小 - 增大
                mobile: 66,
                desktop: 66
            },
            spacing: {            // 水印间距 - 增大间距
                mobile: { width: 1000, height: 600 },
                desktop: { width: 1000, height: 600 }
            }
        };
        
        // 初始化水印
        function initializeWatermark() {
            const watermarkText = getUserWatermarkText();
            const watermarkImage = generateWatermarkImage(watermarkText);
            applyWatermark(watermarkImage);
        }
        
        // 获取水印文本
        function getUserWatermarkText() {
            // 根据用户角色显示不同的水印文本
            switch(USER_ROLE) {
                case 'admin':
                    return '螃蟹客服-林夕';
                case 'buyer':
                    return '用户_8930147321';
                case 'guest':
                    return '用户_3d74_9049'; // 卖家/访客用户也使用统一的昵称格式
                default:
                    return '用户_3d74_9049';
            }
        }
        
        // 生成水印图片
        function generateWatermarkImage(text) {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // 根据屏幕大小动态调整水印尺寸
            const screenWidth = window.innerWidth;
            const isMobile = screenWidth <= 768;
            
            // 使用配置中的间距设置
            const spacing = isMobile ? WATERMARK_CONFIG.spacing.mobile : WATERMARK_CONFIG.spacing.desktop;
            const cellWidth = spacing.width;
            const cellHeight = spacing.height;
            
            // 增大画布尺寸确保旋转后完全覆盖，使用6x6网格
            canvas.width = cellWidth * 6;
            canvas.height = cellHeight * 6;
            
            // 使用配置中的字体大小
            const fontSize = isMobile ? WATERMARK_CONFIG.fontSize.mobile : WATERMARK_CONFIG.fontSize.desktop;
            ctx.font = `bold ${fontSize}px Arial, "Microsoft YaHei", sans-serif`;
            ctx.fillStyle = `rgba(0, 0, 0, ${WATERMARK_CONFIG.opacity})`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            
            // 在画布上绘制重复的水印文本，使用6x6网格确保完全覆盖
            for (let row = 0; row < 6; row++) {
                for (let col = 0; col < 6; col++) {
                    const x = col * cellWidth + cellWidth / 2;
                    const y = row * cellHeight + cellHeight / 2;
                    
                    ctx.save();
                    ctx.translate(x, y);
                    ctx.rotate(-20 * Math.PI / 180); // 旋转-20度
                    ctx.fillText(text, 0, 0);
                    ctx.restore();
                }
            }
            
            return canvas.toDataURL();
        }
        
        // 应用水印 - 创建旋转水印图片，背景固定
        function applyWatermark(watermarkImage) {
            const chatArea = document.getElementById('chat-area');
            if (chatArea) {
                const isMobile = window.innerWidth <= 768;
                const spacing = isMobile ? WATERMARK_CONFIG.spacing.mobile : WATERMARK_CONFIG.spacing.desktop;
                
                // 清理所有之前的水印
                const oldWatermark = document.getElementById('watermark-overlay');
                if (oldWatermark) {
                    oldWatermark.remove();
                }
                
                // 清理监听器
                if (window.watermarkListeners) {
                    window.watermarkListeners.forEach(listener => {
                        window.removeEventListener('scroll', listener, true);
                        window.removeEventListener('resize', listener, true);
                    });
                    window.watermarkListeners = null;
                }
                
                if (window.watermarkObserver) {
                    window.watermarkObserver.disconnect();
                    window.watermarkObserver = null;
                }
                
                if (window.watermarkInterval) {
                    clearInterval(window.watermarkInterval);
                    window.watermarkInterval = null;
                }
                
                // 移除所有旧样式
                const oldStyles = ['watermark-style', 'watermark-fixed-style', 'watermark-bg-style', 'watermark-simple-style', 'watermark-basic-style', 'watermark-direct-style'];
                oldStyles.forEach(id => {
                    const old = document.getElementById(id);
                    if (old) old.remove();
                });
                
                // 创建旋转的水印图片
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                const img = new Image();
                img.onload = function() {
                    // 设置画布尺寸
                    canvas.width = spacing.width * 2;
                    canvas.height = spacing.height * 2;
                    
                    // 清空画布
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    
                    // 在画布中心绘制旋转的水印
                    ctx.save();
                    ctx.translate(canvas.width / 2, canvas.height / 2);
                    ctx.rotate(-20 * Math.PI / 180);
                    ctx.globalAlpha = WATERMARK_CONFIG.opacity;
                    
                    // 绘制重复的水印图案
                    for (let x = -canvas.width; x <= canvas.width; x += spacing.width) {
                        for (let y = -canvas.height; y <= canvas.height; y += spacing.height) {
                            ctx.drawImage(img, x - spacing.width/2, y - spacing.height/2, spacing.width, spacing.height);
                        }
                    }
                    ctx.restore();
                    
                    const rotatedWatermark = canvas.toDataURL();
                    
                    // 创建CSS样式
                    const styleElement = document.createElement('style');
                    styleElement.id = 'watermark-rotated-style';
                    document.head.appendChild(styleElement);
                    
                    styleElement.textContent = `
                        #chat-area {
                            background-image: url(${rotatedWatermark}) !important;
                            background-size: ${canvas.width}px ${canvas.height}px !important;
                            background-repeat: repeat !important;
                            background-position: center !important;
                            background-attachment: fixed !important;
                        }
                    `;
                };
                img.src = watermarkImage;
            }
        }

        // ======================== 消息右键菜单功能 ========================
        
        let currentContextMenuData = null; // 当前右键菜单关联的消息数据
        let currentDeleteMessageId = null; // 当前要删除的消息ID
        let currentQuoteData = null; // 当前引用的消息数据
        let longPressTimer = null; // 长按定时器
        const LONG_PRESS_DURATION = 800; // 长按时间阈值（毫秒）
        
        // 为消息添加右键菜单事件监听器
        function addMessageContextMenuListeners(msgElement, messageData) {
            let isLongPress = false;
            let startTime = 0;
            
            // 移动端长按事件
            msgElement.addEventListener('touchstart', function(e) {
                isLongPress = false;
                startTime = Date.now();
                
                longPressTimer = setTimeout(() => {
                    isLongPress = true;
                    showMessageContextMenu(e, messageData);
                    
                    // 添加触觉反馈（如果支持）
                    if (navigator.vibrate) {
                        navigator.vibrate(50);
                    }
                }, LONG_PRESS_DURATION);
            });
            
            msgElement.addEventListener('touchend', function(e) {
                clearTimeout(longPressTimer);
            });
            
            msgElement.addEventListener('touchmove', function(e) {
                clearTimeout(longPressTimer);
            });
            
            // 桌面端右键事件
            msgElement.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showMessageContextMenu(e, messageData);
            });
        }
        
        // 显示消息右键菜单
        function showMessageContextMenu(event, messageData) {
            console.log('showMessageContextMenu 被调用');
            console.log('USER_ROLE:', USER_ROLE);
            console.log('messageData:', messageData);
            
            currentContextMenuData = messageData;
            const menu = document.getElementById('message-context-menu');
            const deleteBtn = document.getElementById('menu-delete');
            const selectBtn = document.getElementById('menu-select');
            
            console.log('菜单元素:', menu);
            console.log('删除按钮元素:', deleteBtn);
            console.log('多选按钮元素:', selectBtn);
            
            // 根据用户角色显示不同按钮
            if (USER_ROLE === 'admin') {
                // 官方用户：显示删除按钮，隐藏多选按钮
                deleteBtn.classList.remove('hidden');
                selectBtn.classList.add('hidden');
                console.log('官方用户：显示删除按钮');
            } else {
                // 其他用户：隐藏删除按钮，显示多选按钮
                deleteBtn.classList.add('hidden');
                selectBtn.classList.remove('hidden');
                console.log('普通用户：显示多选按钮');
            }
            
            // 计算菜单位置
            let x, y;
            
            if (event.touches && event.touches.length > 0) {
                // 移动端触摸事件
                x = event.touches[0].clientX;
                y = event.touches[0].clientY;
            } else {
                // 桌面端鼠标事件
                x = event.clientX;
                y = event.clientY;
            }
            
            // 确保菜单不会超出屏幕边界
            const menuWidth = 160;
            const menuHeight = 240;
            
            if (x + menuWidth > window.innerWidth) {
                x = window.innerWidth - menuWidth - 10;
            }
            if (y + menuHeight > window.innerHeight) {
                y = window.innerHeight - menuHeight - 10;
            }
            
            // 设置菜单位置并显示
            menu.style.left = x + 'px';
            menu.style.top = y + 'px';
            menu.classList.remove('hidden');
            console.log('菜单已显示在位置:', x, y);
            
            // 添加点击外部关闭菜单的监听器
            setTimeout(() => {
                document.addEventListener('click', hideContextMenuOnOutsideClick);
                document.addEventListener('touchstart', hideContextMenuOnOutsideClick);
            }, 100);
        }
        
        // 隐藏右键菜单
        function hideMessageContextMenu() {
            const menu = document.getElementById('message-context-menu');
            menu.classList.add('hidden');
            currentContextMenuData = null;
            
            // 移除外部点击监听器
            document.removeEventListener('click', hideContextMenuOnOutsideClick);
            document.removeEventListener('touchstart', hideContextMenuOnOutsideClick);
        }
        
        // 点击外部隐藏菜单
        function hideContextMenuOnOutsideClick(e) {
            const menu = document.getElementById('message-context-menu');
            if (!menu.contains(e.target)) {
                hideMessageContextMenu();
            }
        }
        
        // 复制消息内容
        function copyMessageContent() {
            if (!currentContextMenuData) return;
            
            const content = currentContextMenuData.content;
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(content).then(() => {
                    showToast('消息已复制到剪贴板', 'success');
                }).catch(() => {
                    fallbackCopyText(content);
                });
            } else {
                fallbackCopyText(content);
            }
            
            hideMessageContextMenu();
        }
        
        // 备用复制方法
        function fallbackCopyText(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                showToast('消息已复制到剪贴板', 'success');
            } catch (err) {
                showToast('复制失败，请手动复制', 'error');
            }
            
            document.body.removeChild(textArea);
        }
        
        // 引用消息
        function quoteMessage() {
            if (!currentContextMenuData) return;
            
            // 保存引用数据
            currentQuoteData = {
                id: currentContextMenuData.id,
                content: currentContextMenuData.content,
                user_name: currentContextMenuData.user_name,
                user_type: currentContextMenuData.user_type,
                nickname: currentContextMenuData.nickname || currentContextMenuData.user_name,
                avatar: currentContextMenuData.avatar || 'images/user.png'
            };
            
            // 显示引用预览
            showQuotePreview();
            
            // 聚焦到输入框
            const input = document.getElementById('message-input');
            input.focus();
            
            showToast('消息已引用', 'success');
            hideMessageContextMenu();
        }
        
        // 显示引用预览
        function showQuotePreview() {
            if (!currentQuoteData) return;
            
            const quotePreview = document.getElementById('quote-preview');
            const quoteAvatar = document.getElementById('quote-avatar');
            const quoteUsername = document.getElementById('quote-username');
            const quoteUsertype = document.getElementById('quote-usertype');
            const quoteContent = document.getElementById('quote-content');
            
            // 设置头像
            quoteAvatar.src = currentQuoteData.avatar;
            
            // 设置用户名
            quoteUsername.textContent = currentQuoteData.nickname;
            
            // 设置用户类型标签
            let userTypeLabel = '';
            if (currentQuoteData.user_type === 'admin') {
                userTypeLabel = '<span class="inline-block px-1 py-0 rounded text-xs" style="background-color: #fdedcd; color: #99845e;">官方</span>';
            } else if (currentQuoteData.user_type === 'buyer') {
                userTypeLabel = '<span class="inline-block px-1 py-0 rounded text-xs" style="background-color: #8fbefe; color: #1e3a8a;">买家</span>';
            } else if (currentQuoteData.user_type === 'seller' || currentQuoteData.user_type === 'guest') {
                userTypeLabel = '<span class="inline-block px-1 py-0 bg-green-100 text-green-600 rounded text-xs">卖家</span>';
            }
            quoteUsertype.innerHTML = userTypeLabel;
            
            // 设置消息内容（限制长度）
            let content = currentQuoteData.content;
            if (content.length > 50) {
                content = content.substring(0, 50) + '...';
            }
            quoteContent.textContent = content;
            
            // 显示引用预览区域
            quotePreview.classList.remove('hidden');
        }
        
        // 隐藏引用预览
        function hideQuotePreview() {
            const quotePreview = document.getElementById('quote-preview');
            quotePreview.classList.add('hidden');
            currentQuoteData = null;
        }
        
        // 取消引用
        function cancelQuote() {
            hideQuotePreview();
            showToast('引用已取消', 'info');
        }
        
        // 转发消息 (仅展示，不实现具体功能)
        function forwardMessage() {
            if (!currentContextMenuData) return;
            
            // showToast('转发功能开发中...', 'info');
            hideMessageContextMenu();
        }
        
        // 多选消息 (仅展示，不实现具体功能)
        function selectMultipleMessages() {
            if (!currentContextMenuData) return;
            
            // showToast('多选功能开发中...', 'info');
            hideMessageContextMenu();
        }
        
        // 删除消息 (使用原有的删除功能)
        function deleteMessageFromMenu() {
            console.log('deleteMessageFromMenu 被调用');
            console.log('currentContextMenuData:', currentContextMenuData);
            
            if (!currentContextMenuData) {
                console.log('currentContextMenuData 为空，退出');
                return;
            }
            
            // 先保存消息ID，再隐藏菜单
            const messageId = currentContextMenuData.id;
            console.log('消息ID:', messageId);
            
            hideMessageContextMenu();
            showDeleteModal(messageId);
        }
        
        // 显示删除确认弹窗
        function showDeleteModal(messageId) {
            console.log('showDeleteModal 被调用，messageId:', messageId);
            currentDeleteMessageId = messageId;
            const modal = document.getElementById('delete-message-modal');
            console.log('删除弹窗元素:', modal);
            if (modal) {
                modal.classList.remove('hidden');
                console.log('删除弹窗已显示');
            } else {
                console.error('删除弹窗元素未找到');
            }
        }
        
        // 隐藏删除确认弹窗
        function hideDeleteModal() {
            currentDeleteMessageId = null;
            document.getElementById('delete-message-modal').classList.add('hidden');
        }
        
        // 删除消息
        async function deleteMessage(messageId) {
            console.log('deleteMessage 被调用，messageId:', messageId);
            
            if (!messageId || USER_ROLE !== 'admin') {
                alert('权限不足，只有官方角色可以撤回消息');
                return;
            }
            
            // 查找要删除的消息
            const messageToDelete = messages.find(msg => parseInt(msg.id) === parseInt(messageId));
            console.log('要删除的消息:', messageToDelete);
            console.log('当前用户:', USER_NAME);
            
            if (!messageToDelete) {
                alert('消息不存在');
                return;
            }
            
            // 官方角色可以删除所有角色的消息，不再限制只能删除自己发送的消息
            
            try {
                const formData = new FormData();
                formData.append('action', 'delete_message');
                formData.append('room_id', ROOM_ID);
                formData.append('user_name', USER_NAME);
                formData.append('user_role', USER_ROLE);
                formData.append('message_id', messageId);
                
                console.log('发送删除请求...');
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                console.log('删除请求结果:', result);
                
                if (result.success) {
                    // 删除成功，从本地消息列表中移除
                    messages = messages.filter(msg => parseInt(msg.id) !== parseInt(messageId));
                    
                    // 重新渲染消息
                    renderMessages();
                    
                    // 隐藏弹窗
                    hideDeleteModal();
                    
                    // 显示成功提示
                    showToast('消息删除成功', 'success');
                } else {
                    alert(result.message || '删除失败');
                }
            } catch (error) {
                console.error('删除消息失败:', error);
                alert('网络错误，删除失败');
            }
        }
        
        // 简单的Toast提示
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-lg text-white z-50 transition-opacity duration-300`;
            
            if (type === 'success') {
                toast.style.backgroundColor = '#10b981';
            } else if (type === 'error') {
                toast.style.backgroundColor = '#ef4444';
            } else {
                toast.style.backgroundColor = '#6b7280';
            }
            
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // 3秒后自动移除
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
        
        // ======================== 头像@用户功能 ========================
        
        // 为头像添加@用户功能事件监听器
        function addAvatarMentionListeners(avatarElement, userData) {
            let avatarLongPressTimer = null;
            const AVATAR_LONG_PRESS_DURATION = 600; // 头像长按时间稍短一些
            
            // 添加样式让用户知道头像可以交互
            avatarElement.style.cursor = 'pointer';
            avatarElement.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
            
            // 鼠标悬停效果
            avatarElement.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
            });
            
            avatarElement.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
            
            // 移动端长按事件
            avatarElement.addEventListener('touchstart', function(e) {
                e.stopPropagation(); // 阻止事件冒泡到消息元素
                
                avatarLongPressTimer = setTimeout(() => {
                    mentionUser(userData);
                    
                    // 添加触觉反馈
                    if (navigator.vibrate) {
                        navigator.vibrate(30);
                    }
                }, AVATAR_LONG_PRESS_DURATION);
            });
            
            avatarElement.addEventListener('touchend', function(e) {
                e.stopPropagation();
                clearTimeout(avatarLongPressTimer);
            });
            
            avatarElement.addEventListener('touchmove', function(e) {
                e.stopPropagation();
                clearTimeout(avatarLongPressTimer);
            });
            
            // 桌面端右键事件
            avatarElement.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                e.stopPropagation(); // 阻止事件冒泡到消息元素
                mentionUser(userData);
            });
            
            // 桌面端单击事件（可选，提供更便捷的@功能）
            avatarElement.addEventListener('click', function(e) {
                e.stopPropagation(); // 阻止事件冒泡
                
                // 双击快速@用户
                if (e.detail === 2) {
                    mentionUser(userData);
                }
            });
        }
        
        // @用户功能
        function mentionUser(userData) {
            // 防止在发送消息过程中触发@功能
            if (sendingMessage) {
                console.log('消息发送中，暂时禁用@功能');
                return;
            }
            
            const input = document.getElementById('message-input');
            const nickname = userData.nickname || userData.user_name;
            
            // 构建@用户文本
            const mentionText = `@${nickname} `;
            
            // 获取当前光标位置
            const cursorPosition = input.selectionStart;
            const currentValue = input.value;
            
            // 在光标位置插入@用户文本
            const newValue = currentValue.slice(0, cursorPosition) + mentionText + currentValue.slice(cursorPosition);
            input.value = newValue;
            
            // 设置新的光标位置
            const newCursorPosition = cursorPosition + mentionText.length;
            input.setSelectionRange(newCursorPosition, newCursorPosition);
            
            // 聚焦到输入框
            input.focus();
            
            // 触发input事件以更新UI状态
            input.dispatchEvent(new Event('input'));
            
            // 显示成功提示
            // showToast(`已@${nickname}`, 'success');
            
            console.log(`@用户: ${nickname}`);
        }
        
        // ======================== 消息提示音功能 ========================
        
        // 初始化消息提示音
        function initializeMessageAudio() {
            console.log('初始化消息提示音');
            
            // 获取音频元素
            messageAudio = document.getElementById('message-notification');
            
            if (messageAudio) {
                // 设置音频属性
                messageAudio.volume = 0.6; // 设置音量为60%
                messageAudio.preload = 'auto';
                
                console.log('消息提示音初始化成功');
                
                // 尝试预加载音频
                try {
                    messageAudio.load();
                } catch (error) {
                    console.warn('音频预加载失败:', error);
                }
                
                // 监听音频事件
                messageAudio.addEventListener('canplaythrough', function() {
                    console.log('音频可以播放');
                });
                
                messageAudio.addEventListener('error', function(e) {
                    console.error('音频加载错误:', e);
                    audioEnabled = false;
                });
                
                // 延迟显示音频横幅提示（给用户一些时间查看页面）
                setTimeout(() => {
                    if (!audioReady && audioEnabled) {
                        // showAudioBanner();
                    }
                }, 3000);
                
            } else {
                console.error('消息提示音元素未找到');
                audioEnabled = false;
            }
        }
        
        // 播放消息提示音
        function playMessageNotification() {
            // 检查是否启用音频提示和音频是否准备就绪
            if (!audioEnabled || !messageAudio || !audioReady) {
                console.log('音频播放被跳过:', {
                    enabled: audioEnabled,
                    hasAudio: !!messageAudio,
                    ready: audioReady
                });
                
                // 如果音频未准备就绪但启用了音频，显示提示横幅
                if (audioEnabled && !audioReady) {
                    // showAudioBanner();
                }
                return;
            }
            
            // 避免首次加载时播放提示音
            if (isFirstLoad) {
                console.log('首次加载，跳过提示音');
                return;
            }
            
            try {
                // 重置音频到开始位置
                messageAudio.currentTime = 0;
                
                // 播放音频
                const playPromise = messageAudio.play();
                
                // 处理播放Promise（现代浏览器要求）
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        console.log('消息提示音播放成功');
                    }).catch(error => {
                        console.warn('消息提示音播放失败:', error);
                        
                        // 处理不同类型的播放错误
                        if (error.name === 'NotAllowedError') {
                            console.log('浏览器阻止自动播放音频，需要用户交互');
                            audioReady = false;
                            // showAudioBanner();
                        } else if (error.name === 'NotSupportedError') {
                            console.log('浏览器不支持该音频格式');
                            audioEnabled = false;
                        } else {
                            console.log('其他播放错误:', error.message);
                        }
                    });
                }
            } catch (error) {
                console.error('播放消息提示音时出错:', error);
            }
        }
        
        // 启用音频提示（用户交互后调用）
        function enableAudioNotification() {
            if (!messageAudio || audioReady) return;
            
            console.log('尝试启用音频提示...');
            
            // 测试播放以确认音频权限
            const testPlay = async () => {
                try {
                    messageAudio.currentTime = 0;
                    messageAudio.volume = 0.01; // 设置很小的音量进行测试
                    
                    const playPromise = messageAudio.play();
                    
                    if (playPromise !== undefined) {
                        await playPromise;
                        messageAudio.pause();
                        messageAudio.currentTime = 0;
                        messageAudio.volume = 0.6; // 恢复正常音量
                        
                        // 测试成功，标记音频为就绪状态
                        audioReady = true;
                        audioEnabled = true;
                        hideAudioBanner();
                        
                        console.log('音频提示已成功启用');
                        // showToast('消息提示音已启用', 'success');
                        
                    } else {
                        throw new Error('播放承诺未定义');
                    }
                } catch (error) {
                    console.warn('音频启用测试失败:', error);
                    if (error.name === 'NotAllowedError') {
                        // showToast('需要更多用户交互才能启用音频', 'info');
                    } else {
                        audioEnabled = false;
                        // showToast('音频启用失败', 'error');
                    }
                }
            };
            
            testPlay();
        }
        
        // 禁用音频提示
        function disableAudioNotification() {
            audioEnabled = false;
            audioReady = false;
            hideAudioBanner();
            console.log('音频提示已禁用');
            // showToast('消息提示音已禁用', 'info');
        }

    </script>
</body>

</html>
