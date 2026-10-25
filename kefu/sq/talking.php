<?php
require_once '../include/conn.php';
require_once 'header.php';
$h_user = $_GET['user'];

// 处理拉黑请求
if(isset($_POST['action']) && $_POST['action'] == 'block_user') {
    $ip = $_POST['ip'];
    
    // 验证IP格式
    if(!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo json_encode(['success' => false, 'message' => '无效的IP地址']);
        exit;
    }
    
    // 检查是否已在黑名单
    $check = $db->get_one("SELECT * FROM `h_blacklist` WHERE ip = '{$ip}'");
    if($check) {
        echo json_encode(['success' => false, 'message' => '该IP已在黑名单中']);
        exit;
    }
    
    // 添加到黑名单
    $result = $db->query("INSERT INTO `h_blacklist` (ip, add_time) VALUES ('{$ip}', NOW())");
    
    echo json_encode([
        'success' => $result ? true : false,
        'message' => $result ? '拉黑成功' : '拉黑失败'
    ]);
    exit;
}

// 处理总体消息的ID
if(isset($_POST['action']) && $_POST['action'] == 'delete_message') {
    if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode([
            'success' => false,
            'message' => '无效的消息ID'
        ]);
        exit;
    }

    $messageId = intval($_POST['id']);
    
    // 验证消息 
    $message = $db->get_one("SELECT * FROM `h_kefu` WHERE id = {$messageId} AND h_user = '{$h_user}'");
    if(!$message) {
        echo json_encode([
            'success' => false,
            'message' => '消息不存在或无权删除'
        ]);
        exit;
    }

    // 删除消息
    $result = $db->query("DELETE FROM `h_kefu` WHERE id = {$messageId}");

    echo json_encode([
        'success' => $result ? true : false,
        'message' => $result ? '删除成功' : '删除失败'
    ]);
    exit;
}

// 获取备注
if(isset($_GET['action']) && $_GET['action'] == 'get_remark') {
    $user = $_GET['user'];
    $result = $db->get_one("SELECT h_remark FROM `h_kefu_status` WHERE h_user = '{$user}'");
    
    echo json_encode([
        'success' => true,
        'remark' => $result['h_remark']
    ]);
    exit;
}

// 保存备注
if(isset($_POST['action']) && $_POST['action'] == 'save_remark') {
    $user = $_POST['user'];
    $remark = $_POST['remark'];
    
    $result = $db->query("UPDATE `h_kefu_status` SET h_remark = '" . addslashes($remark) . "' WHERE h_user = '{$user}'");
    
    echo json_encode([
        'success' => $result ? true : false
    ]);
    exit;
}

// 在文件开头添加快捷短语处理逻辑
if(isset($_POST['quick_msg_action'])) {
    $action = $_POST['quick_msg_action'];
    
    switch($action) {
        case 'list':
            $query = "SELECT * FROM h_quick_msgs WHERE h_user = '{$h_user}' ORDER BY add_time DESC";
            $result = $db->query($query);
            $msgs = array();
            while($row = $db->fetch_array($result)) {
                $msgs[] = array(
                    'id' => $row['id'],
                    'content' => $row['content']
                );
            }
            
            // 默认快捷短语 我这里需要注释掉
            // if(empty($msgs)) {
            //     // 返回默认快捷短语
            //     $msgs = [
            //         ['id' => 0, 'content' => '您好，请问有什么可以帮您？'],
            //         ['id' => 0, 'content' => '好的，我明白了'],
            //         ['id' => 0, 'content' => '请稍等，我帮您查询'],
            //         ['id' => 0, 'content' => '还有其他问题需要帮助吗？']
            //     ];
            // }
            
            echo json_encode(['code' => 0, 'data' => $msgs]);
            exit;
            
        case 'add':
            $content = trim($_POST['content']);
            if(empty($content)) {
                echo json_encode(['code' => 1, 'msg' => '内容不能为空']);
                exit;
            }
            
           
            $check = $db->get_one("SELECT id FROM h_quick_msgs WHERE h_user = '{$h_user}' AND content = '{$content}'");
            if($check) {
                echo json_encode(['code' => 1, 'msg' => '该快捷短语已存在']);
                exit;
            }
            
           $result = $db->query("INSERT INTO h_quick_msgs (h_user, content, add_time) VALUES ('{$h_user}', '{$content}', NOW())");
            echo json_encode(['code' => $result ? 0 : 1, 'msg' => $result ? '添加成功' : '添加失败']);
            exit;
            
        case 'delete':
            $id = intval($_POST['id']);
            if($id <= 0) {
                echo json_encode(['code' => 1, 'msg' => '无效的ID']);
                exit;
            }
            
            $result = $db->query("DELETE FROM h_quick_msgs WHERE id = {$id} AND h_user = '{$h_user}'");
            echo json_encode(['code' => $result ? 0 : 1, 'msg' => $result ? '删除成功' : '删除失败']);
            exit; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>聊天窗口</title>
    <style>
          
        body {
            margin: 0;
            padding: 0;
            overflow: hidden; /* 这行代码禁止页面滚动 */
            height: 100vh; /* 设置高度为视口高度 */
            position: fixed; /* 固定位置 */
            width: 100%; /* 宽度100% */
        }

          
          
          * {
        
            font-family: MainFont, sans-serif;
        }

        @font-face {
            font-family: 'MainFont';
            src: url('/css/Font.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f2f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #333;
            line-height: 1.6;
        }

      
        .service {
            max-width: 100%;
            height: 100vh;
            margin: 0;
            background: #fff;
            display: flex;
            flex-direction: column;
            position: relative;
        }

       
        @media (max-width: 767px) {
            .service {
                max-width: 100%;
                margin: 0;
                border-radius: 0;
                height: 100vh;
                box-shadow: none;
            }
        }

       
        @media (min-width: 768px) {
            body {
                margin: 0;
                padding: 0;
                overflow: hidden;
            }
            
            .service {
                max-width: 100%;
                height: 100vh;
                margin: 0;
                border-radius: 0;
                box-shadow: none;
            }
        }

       
        .msg-head {
            padding: 12px 16px;
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .msg-head-top {
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
        }

        .user-info {
            flex: 1;
        }

        
        .back-arrow {
            position: relative;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-arrow:hover {
            background: rgba(0, 0, 0, 0.1);
            transform: translateX(-2px);
        }

        .back-arrow::before {
            content: '';
            width: 12px;
            height: 12px;
            border-left: 2px solid #333;
            border-bottom: 2px solid #333;
            transform: rotate(45deg);
            margin-left: 4px;
        }

        .back-arrow::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 2px;
            background: #333;
            left: 8px;
        }

        .tha {
            font-size: 17px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .thb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 13px;
            color: #8e8e93;
            margin-top: 4px;
        }

        
        .msg-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #fff;
            scroll-behavior: smooth;
        }

        .msg {
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .msg.on {
            flex-direction: row-reverse;
        }

        .content {
            position: relative;
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            background: #f0f2f5;
            font-size: 15px;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .msg.on .content {
            background: #C5C1FF;
            color: #fff;
        }

       
        .content::before {
            content: '';
            position: absolute;
            top: 14px;
            left: -6px;
            width: 12px;
            height: 12px;
            background: inherit;
            transform: rotate(45deg);
        }

        .msg.on .content::before {
            left: auto;
            right: -6px;
        }

       
        .msg-post {
            padding: 12px 16px;
            background: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }

        .msg-toolbar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .tool-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            color: #666;
            transition: all 0.2s;
        }

        .tool-btn:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #333;
        }

        .input-area {
            display: flex;
            align-items: flex-end;
            gap: 8px;
        }

        textarea {
            flex: 1;
            min-height: 24px;
            max-height: 120px;
            padding: 12px 16px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 24px;
            background: #f0f2f5;
            font-size: 15px;
            line-height: 1.4;
            resize: none;
            transition: all 0.2s;
        }

        textarea:focus {
            border-color: #C5C1FF;
            background: #fff;
            box-shadow: 0 0 0 2px rgba(10, 124, 255, 0.1);
        }

        .send-btn {
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: 50%;
            background: #C5C1FF;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .send-btn:hover {
            background: #C5C1FF;
            transform: scale(1.05);
        }

        .send-btn .icon {
            width: 20px;
            height: 20px;
        }

      
        .msg-box::-webkit-scrollbar {
            width: 6px;
        }

        .msg-box::-webkit-scrollbar-track {
            background: transparent;
        }

        .msg-box::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

       
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .msg {
            animation: fadeIn 0.3s ease-out;
        }

       
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: normal;
            border-radius: 12px;
            margin-left: 8px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin-right: 4px;
        }

        .status-online {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .status-online::before {
            background: #22C55E;
        }

        .status-offline {
            background: rgba(156, 163, 175, 0.1);
            color: #6B7280;
        }

        .status-offline::before {
            background: #6B7280;
        }

        .status-hidden {
            background: rgba(245, 158, 11, 0.1);
            color: #F59E0B;
        }

        .status-hidden::before {
            background: #F59E0B;
        }

      
        .tha {
            display: flex;
            align-items: center;
            font-size: 17px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        
        .device-info {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #8e8e93;
            font-size: 13px;
        }
        
        .device-icon {
            width: 16px;
            height: 16px;
            color: #8e8e93;
        }
        
        .online-status {
            color: #8e8e93;
            font-size: 13px;
        }
        
       
        .thb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #8e8e93;
            margin-top: 4px;
        }

       
        .fish-card {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            margin-left: 8px;
            background: linear-gradient(135deg, #FF6B6B, #FF8E8E);
            color: white;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(255, 107, 107, 0.2);
            animation: cardPulse 2s infinite;
        }

        @keyframes cardPulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        
        .thb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #8e8e93;
            margin-top: 4px;
            flex-wrap: wrap;
        }

        .device-info {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #8e8e93;
            font-size: 13px;
        }

        .device-icon {
            width: 16px;
            height: 16px;
            color: #8e8e93;
        }

        .online-status {
            color: #8e8e93;
            font-size: 13px;
        }

        
        .collapse-btn {
            padding: 4px 8px;
            font-size: 12px;
            color: #8e8e93;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
            margin-left: auto;
        }

        .collapse-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

       
        .thb {
            max-height: 100px;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .thb.collapsed {
            max-height: 0;
        }

       
        .more-info-btn {
            padding: 2px 6px;
            font-size: 12px;
            color: #8e8e93;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .more-info-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        
        .more-info-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-width: 90%;
            width: 400px;
            animation: modalFadeIn 0.3s ease-out;
        }

        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .more-info-content {
            position: relative;
            margin-bottom: 16px;
            padding-bottom: 8px;
        }

        .more-info-content::before {
            content: "用户详细信息";
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .more-info-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .more-info-item:last-child {
            border-bottom: none;
        }

        .more-info-label {
            color: #8e8e93;
            font-size: 14px;
        }

        .more-info-value {
            color: #1a1a1a;
            font-weight: 500;
            font-size: 14px;
            max-width: 60%;
            text-align: right;
            word-break: break-all;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -48%) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .close-modal-btn {
            display: block;
            width: 100%;
            padding: 8px;
            background: #f0f2f5;
            border: none;
            border-radius: 8px;
            color: #1a1a1a;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .close-modal-btn:hover {
            background: #e4e6e9;
        }

       
        .chat-details-btn {
            padding: 2px 6px;
            font-size: 12px;
            color: #8e8e93;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .chat-details-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

       
        .chat-details-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-width: 90%;
            width: 400px;
            max-height: 80vh;
            overflow-y: auto;
        }

       
        .chat-search {
            margin-bottom: 16px;
            position: relative;
        }

        .chat-search input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e4e6e9;
            border-radius: 8px;
            font-size: 14px;
        }

      
        .chat-functions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }

        .function-btn {
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #f0f2f5;
            color: #1a1a1a;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .function-btn:hover {
            background: #e4e6e9;
        }

        .function-btn.danger {
            color: #ff4d4f;
        }

        .function-btn.danger:hover {
            background: #fff1f0;
        }

        .function-btn.block {
            background: #ffebee;
            color: #d32f2f;
        }

        .function-btn.block:hover {
            background: #ffcdd2;
        }

      
        .chat-history {
            margin-top: 16px;
            border-top: 1px solid #f0f0f0;
            padding-top: 16px;
        }

        .chat-history-item {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chat-history-item:hover {
            background: #f0f2f5;
        }

        .chat-history-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #8e8e93;
            margin-bottom: 4px;
        }

        .chat-history-content {
            font-size: 14px;
            color: #1a1a1a;
        }

       
        .background-settings {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
        }

        .background-settings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .background-settings-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        
        .custom-background {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
        }

        .custom-background-btn {
            width: 100%;
            padding: 12px;
            background: #f0f2f5;
            border: 2px dashed #ccc;
            border-radius: 8px;
            color: #1a1a1a;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .custom-background-btn:hover {
            background: #e4e6e9;
            border-color: #999;
        }

        .custom-background-preview {
            margin-top: 12px;
            width: 100%;
            height: 120px;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: none;
            position: relative;
        }

        .preview-actions {
            position: absolute;
            bottom: 8px;
            right: 8px;
            display: flex;
            gap: 8px;
        }

        .preview-action-btn {
            padding: 4px 8px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .preview-action-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

       
        .background-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
        }

        .background-action-btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .background-action-btn.reset {
            background: #f5f5f5;
            color: #666;
        }

        .background-action-btn.reset:hover {
            background: #e8e8e8;
            color: #333;
        }

       
        .remark-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1001;
            width: 300px;
        }

        .remark-content h3 {
            margin: 0 0 16px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .remark-content textarea {
            width: 100%;
            min-height: 100px;
            padding: 8px;
            border: 1px solid #e4e6e9;
            border-radius: 8px;
            margin-bottom: 16px;
            resize: vertical;
        }

        .remark-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .remark-actions button {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .remark-actions button:first-child {
            background: #C5C1FF;
            color: white;
        }

        .remark-actions button:last-child {
            background: #f0f2f5;
            color: #1a1a1a;
        }

        
        .user-remark {
            font-size: 13px;
            color: #ff6b6b;
            margin-left: 8px;
        }

       
        .msg-time {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.45);
            margin-top: 4px;
            text-align: right;
        }

        .msg.on .msg-time {
            color: rgba(255, 255, 255, 0.7);
        }

       
        .info-left-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        
        .info-right-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

       
        @media (max-width: 767px) {
            .more-info-btn svg,
            .chat-details-btn svg {
                width: 14px;
                height: 14px;
            }
            
            .more-info-btn,
            .chat-details-btn {
                padding: 2px 4px;
            }
        }

      
        .msg-head-top .more-info-btn,
        .msg-head-top .chat-details-btn {
            display: flex; 
        }

        .thb .info-right-group {
            display: none; 
        }

     
        @media (max-width: 767px) {
           
            .msg-head-top .more-info-btn,
            .msg-head-top .chat-details-btn {
                display: none;
            }
            
           
            .thb .info-right-group {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
          
            .thb .more-info-btn,
            .thb .chat-details-btn {
                padding: 2px 4px;
                font-size: 12px;
            }
            
            .thb .more-info-btn svg,
            .thb .chat-details-btn svg {
                width: 14px;
                height: 14px;
            }
            
          
            .thb {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 4px 8px;
            }
            
            .info-left-group {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: nowrap;
                overflow: hidden;
            }
            
         
            .thb .more-info-btn span,
            .thb .chat-details-btn span {
                display: none;  
            }
        }

       
        @media (min-width: 768px) {
            .msg-head-top .more-info-btn,
            .msg-head-top .chat-details-btn {
                display: flex;
            }
            
            .thb .info-right-group {
                display: none;
            }
        }

      
        .delete-msg-btn {
            position: absolute;
            right: 8px;
            top: 8px;
            width: 24px;
            height: 24px;
            border: none;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.1);
            color: #666;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.2s;
        }

        .msg.on .delete-msg-btn {
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.2);
        }

        .content:hover .delete-msg-btn {
            display: flex;
        }

        .delete-msg-btn:hover {
            background: rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }

        .msg.on .delete-msg-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

     
        @media (max-width: 767px) {
            .delete-msg-btn {
                width: 20px;
                height: 20px;
            }
            
            .delete-msg-btn svg {
                width: 12px;
                height: 12px;
            }
        }

      
        .quick-msg-panel {
            position: fixed;
            right: 20px;
            bottom: 80px;
            width: 300px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .quick-msg-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
        }

        .quick-msg-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .close-quick-msg {
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #666;
        }

        .quick-msg-content {
            padding: 16px;
        }

        .quick-msg-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 16px;
        }

        .quick-msg-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            margin-bottom: 8px;
            background: #f5f5f5;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-msg-item:hover {
            background: #e8e8e8;
        }

        .quick-msg-text {
            flex: 1;
            margin-right: 8px;
        }

        .quick-msg-delete {
            opacity: 0;
            transition: opacity 0.2s;
            color: #ff4d4f;
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
        }

        .quick-msg-item:hover .quick-msg-delete {
            opacity: 1;
        }

        .quick-msg-add {
            display: flex;
            gap: 8px;
        }

        .quick-msg-add input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .quick-msg-add button {
            padding: 8px 16px;
            background: #C5C1FF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .quick-msg-add button:hover {
            background: #C5C1FF;
        }

        .quick-msg-empty {
            text-align: center;
            padding: 32px 16px;
            color: #666;
        }

      
        .quick-msg-panel {
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .quick-msg-panel.show {
            transform: translateY(0);
            opacity: 1;
        }

       
        @media (max-width: 767px) {
            .quick-msg-panel {
                right: 10px;
                left: 10px;
                bottom: 70px;
                width: auto;
            }
        }

      
        .emoji-panel {
            position: fixed;
            right: 20px;
            bottom: 80px;
            width: 300px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .emoji-panel.show {
            transform: translateY(0);
            opacity: 1;
        }

        .emoji-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
        }

        .emoji-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .close-emoji {
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #666;
        }

        .emoji-content {
            padding: 16px;
            max-height: 300px;
            overflow-y: auto;
        }

        .emoji-list {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
        }

        .emoji-item {
            width: 100%;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 24px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .emoji-item:hover {
            background: #f5f5f5;
            transform: scale(1.1);
        }

      
        @media (max-width: 767px) {
            .emoji-panel {
                right: 10px;
                left: 10px;
                bottom: 70px;
                width: auto;
            }
            
            .emoji-list {
                grid-template-columns: repeat(6, 1fr);
            }
        }

       
        .trade-script-panel {
            position: fixed;
            right: 20px;
            bottom: 80px;
            width: 360px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .trade-script-panel.show {
            transform: translateY(0);
            opacity: 1;
        }

        .trade-script-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
        }

        .trade-script-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .close-trade-script {
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #666;
        }

        .trade-script-content {
            max-height: 70vh;
            overflow-y: auto;
        }

        .trade-script-categories {
            padding: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            background: white;
            z-index: 1;
        }

        .category-btn {
            padding: 6px 12px;
            border: 1px solid #e4e6e9;
            border-radius: 16px;
            background: white;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
        }

        .category-btn:hover {
            background: #f5f5f5;
        }

        .category-btn.active {
            background: #C5C1FF;
            color: white;
            border-color: #C5C1FF;
        }

        .trade-script-list {
            padding: 12px;
        }

        .script-item {
            padding: 12px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .script-item:hover {
            background: #f0f2f5;
        }

        .script-item-title {
            font-weight: 500;
            margin-bottom: 4px;
            color: #1a1a1a;
        }

        .script-item-content {
            font-size: 14px;
            color: #666;
            white-space: pre-wrap;
        }

       
        @media (max-width: 767px) {
            .trade-script-panel {
                right: 10px;
                left: 10px;
                width: auto;
            }
        }
    </style>
</head>
<body>
	<div class="service">
	    <div class="msg-head">
			<div class="msg-head-top">
				<div class="back-arrow" onclick="history.go(-1);" title="返回"></div>
				<div class="user-info">
					<div class="tha">
						<?php echo $h_user; ?>
						<?php
							$rs3 = $db->get_one("select * from `h_kefu_status` where h_user = '{$h_user}'");
							$date_1 = date("Y-m-d H:i:s"); 
							$date_2 = $rs3['h_addTime'];
							$time = ceil(strtotime($date_1)-strtotime($date_2));
							
							$statusClass = '';
							if($time > 3){
								$status = '离线';
								$statusClass = 'status-offline';
							}else{
								if($rs3['h_status'] == 1){
									$status = '正在会话';
									$statusClass = 'status-online';
								}else if($rs3['h_status'] == 2){
									$status = '隐藏窗口';
									$statusClass = 'status-hidden';
								}
							}
						?>
						<?php
							$remark = $db->get_one("SELECT h_remark FROM `h_kefu_status` WHERE h_user = '{$h_user}'");
							if($remark && $remark['h_remark']) {
								echo "<span class='user-remark'>({$remark['h_remark']})</span>";
							}
						?>
						<span class="status-badge <?php echo $statusClass; ?>"><?php echo $status; ?></span>
					</div>
				</div>
				<div class="collapse-btn" onclick="toggleCollapse()">
					<svg width="16" height="16" viewBox="0 0 24 24">
						<path fill="currentColor" d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
					</svg>
				</div>
				<div class="more-info-btn" onclick="showMoreInfo()">
					<svg width="16" height="16" viewBox="0 0 24 24">
						<path fill="currentColor" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
					</svg>
					更多资料
				</div>
				<div class="chat-details-btn" onclick="showChatDetails()">
					<svg width="16" height="16" viewBox="0 0 24 24">
						<path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
					</svg>
					聊天详情
				</div>
			</div>
			<div class="thb">
				<div class="info-left-group">
					<?php 
						$rsd = $db->get_one("select * from `h_kefu_status` where h_user = '{$h_user}'");
						$device = $rsd['h_address']; // 设备信息
						$online = $rsd['h_online']; // 在线状态
						
				// 		这里好像写错了 我不想改了 有缘者自己改吧
						$deviceIcon = '';
						if(strpos($device, 'Android') !== false) {
							$deviceIcon = '<svg class="device-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M17.6,9.48l1.84-3.18c0.16-0.31,0.04-0.69-0.26-0.85c-0.29-0.15-0.65-0.06-0.83,0.22l-1.88,3.24 c-2.86-1.21-6.08-1.21-8.94,0L5.65,5.67c-0.19-0.29-0.58-0.38-0.87-0.2C4.5,5.65,4.41,6.01,4.56,6.3L6.4,9.48 C3.3,11.25,1.28,14.44,1,18h22C22.72,14.44,20.7,11.25,17.6,9.48z M7,15.25c-0.69,0-1.25-0.56-1.25-1.25 c0-0.69,0.56-1.25,1.25-1.25S8.25,13.31,8.25,14C8.25,14.69,7.69,15.25,7,15.25z M17,15.25c-0.69,0-1.25-0.56-1.25-1.25 c0-0.69,0.56-1.25,1.25-1.25s1.25,0.56,1.25,1.25C18.25,14.69,17.69,15.25,17,15.25z"/></svg>';
						} else if(strpos($device, 'iPhone') !== false || strpos($device, 'iOS') !== false) {
							$deviceIcon = '<svg class="device-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M16,1H8C6.34,1,5,2.34,5,4v16c0,1.66,1.34,3,3,3h8c1.66,0,3-1.34,3-3V4C19,2.34,17.66,1,16,1z M14,21h-4v-1h4V21z M17.25,18H6.75V4h10.5V18z"/></svg>';
						} else if(strpos($device, 'Windows') !== false) {
							$deviceIcon = '<svg class="device-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M3,12V6.75l6-1.32v6.48L3,12z M20,3v8.75l-10,0.15V5.21L20,3z M3,13l6,0.09v6.81l-6-1.15V13z M20,13.25V22l-10-1.91V13.1L20,13.25z"/></svg>';
						} else {
							$deviceIcon = '<svg class="device-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M21,16H3V4h18V16z M21,2H3C1.9,2,1,2.9,1,4v12c0,1.1,0.9,2,2,2h7v2H8v2h8v-2h-2v-2h7c1.1,0,2-0.9,2-2V4C23,2.9,22.1,2,21,2z"/></svg>';
						}
					?>
					<span class='device-info'>
						<?php echo $deviceIcon; ?>
						<?php echo $device; ?>
					</span>
					<span class='online-status'><?php echo $online; ?></span>
				
				</div>
				<div class="info-right-group">
					<div class="more-info-btn" onclick="showMoreInfo()">
						<svg width="16" height="16" viewBox="0 0 24 24">
							<path fill="currentColor" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
						</svg>
						更多资料
					</div>
					<div class="chat-details-btn" onclick="showChatDetails()">
						<svg width="16" height="16" viewBox="0 0 24 24">
							<path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
						</svg>
						聊天详情
					</div>
				</div>
			</div>
	    </div>
		<div class="msg-box">
			<?php
				$rs1 = $db->get_one("select * from `h_kefu` where h_user = '{$h_user}' and h_actIP = '系统' order by h_addTime desc,id desc limit 1");
				$query = "select * from `h_kefu` where h_user = '{$h_user}' and h_isread = 0 and h_addTime < '{$rs1['h_addTime']}'";
				$result = $db->query($query);
				while($rs2 = $db->fetch_array($result))
				{	
					$setRead = 'update h_kefu set h_isread = 1 where id='.$rs2['id'];
					$db->query($setRead);
				}

				$query = "select * from `h_kefu` where h_user = '{$h_user}' and h_isread = 1 order by h_addTime asc,id asc";
				$result = $db->query($query);
				while($rs_list = $db->fetch_array($result))
				{	
					$msg_time = date("Y-m-d H:i:s", strtotime($rs_list['h_addTime']));
					if($rs_list['h_who'] == 1){
						echo '
							<div class="msg clearfix" data-id="'.$rs_list['id'].'">
								<div class="content">
									<span>' . $rs_list['h_content'] . '</span>
									<div class="msg-time">' . $msg_time . '</div>
									<button class="delete-msg-btn" onclick="deleteMessage('.$rs_list['id'].')">
										<svg width="14" height="14" viewBox="0 0 24 24">
											<path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
										</svg>
									</button>
								</div>
							</div>
						';
					}else{
						// 检查是否是卡片消息
						if(strpos($rs_list['h_content'], 'ComponentMessage') !== false) {
							// 根据卡片内容确定显示文本
							$displayText = '发送了一条系统消息';
							
							if(strpos($rs_list['h_content'], 'Hi，我是闲鱼官方认证的游戏账号交易客服') !== false) {
								$displayText = '发送了开场白卡片';
							} else if(strpos($rs_list['h_content'], '⚠️ 安全交易提醒') !== false) {
								$displayText = '发送了安全提示卡片';
							} else if(strpos($rs_list['h_content'], '标准交易流程') !== false) {
								$displayText = '发送了交易流程卡片';
							} else if(strpos($rs_list['h_content'], '遇到交易问题？') !== false) {
								$displayText = '发送了纠纷处理卡片';
							}
							
							echo '
								<div class="msg clearfix on" data-id="'.$rs_list['id'].'">
									<div class="content">
										<span>' . $displayText . '</span>
										<div class="msg-time">' . $msg_time . '</div>
										<button class="delete-msg-btn" onclick="deleteMessage('.$rs_list['id'].')">
											<svg width="14" height="14" viewBox="0 0 24 24">
												<path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
											</svg>
										</button>
									</div>
								</div>
							';
						} else {
							// 普通消息正常显示
							echo '
								<div class="msg clearfix on" data-id="'.$rs_list['id'].'">
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
										<div class="msg-time">' . $msg_time . '</div>
										<button class="delete-msg-btn" onclick="deleteMessage('.$rs_list['id'].')">
											<svg width="14" height="14" viewBox="0 0 24 24">
												<path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
											</svg>
										</button>
									</div>
								</div>
							';
						}
					}
				}
				$query = "select * from `h_kefu` where h_user = '{$h_user}' and h_who = 2 and h_isread = 0 order by h_addTime asc,id asc";
				$result = $db->query($query);
				while($rs_list = $db->fetch_array($result))
				{
					$msg_time = date("Y-m-d H:i:s", strtotime($rs_list['h_addTime']));
				
					if(strpos($rs_list['h_content'], 'ComponentMessage') !== false) {
						$displayText = '发送了一条系统消息';
						
						if(strpos($rs_list['h_content'], 'Hi，我是闲鱼官方认证的游戏账号交易客服') !== false) {
							$displayText = '发送了开场白卡片';
						} else if(strpos($rs_list['h_content'], '⚠️ 安全交易提醒') !== false) {
							$displayText = '发送了安全提示卡片';
						} else if(strpos($rs_list['h_content'], '标准交易流程') !== false) {
							$displayText = '发送了交易流程卡片';
						} else if(strpos($rs_list['h_content'], '遇到交易问题？') !== false) {
							$displayText = '发送了纠纷处理卡片';
						}
						
						echo '
							<div class="msg clearfix on" data-id="'.$rs_list['id'].'">
								<div class="content">
									<span>' . $displayText . '</span>
									<div class="msg-time">' . $msg_time . '</div>
									<button class="delete-msg-btn" onclick="deleteMessage('.$rs_list['id'].')">
										<svg width="14" height="14" viewBox="0 0 24 24">
											<path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
										</svg>
									</button>
								</div>
							</div>
						';
					} else {
						echo '
							<div class="msg clearfix on" data-id="'.$rs_list['id'].'">
								<div class="content">
									<span>' . $rs_list['h_content'] . '</span>
									<div class="msg-time">' . $msg_time . '</div>
									<button class="delete-msg-btn" onclick="deleteMessage('.$rs_list['id'].')">
										<svg width="14" height="14" viewBox="0 0 24 24">
											<path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
										</svg>
									</button>
								</div>
							</div>
						';
					}
				}
			?>
			<p id="msgzone"></p>
		</div>   
		<div class="msg-post">
			<div class="msg-toolbar">
				<div class="tool-btn emoji-btn" title="表情">
					<svg class="icon" width="24" height="24" viewBox="0 0 24 24">
						<path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
					</svg>
				</div>
				<div class="tool-btn quick-msg-btn" title="快捷发送 (Alt+Q)" onclick="toggleQuickMsgPanel()">
					<svg class="icon" width="24" height="24" viewBox="0 0 24 24">
						<path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4A2,2 0 0,0 20,2M6,9H18V11H6M14,14H6V12H14M18,8H6V6H18"/>
					</svg>
				</div>
				<div class="tool-btn trade-script-btn" title="交易话术 (Alt+T)" onclick="toggleTradeScriptPanel()">
					<svg class="icon" width="24" height="24" viewBox="0 0 24 24">
						<path fill="currentColor" d="M21,18H24V16H21V18M17,18H20V16H17V18M13,18H16V16H13V18M9,18H12V16H9V18M5,18H8V16H5V18M1,18H4V16H1V18M3,13H6V11H3V13M7,13H10V11H7V13M11,13H14V11H11V13M15,13H18V11H15V13M19,13H22V11H19V13M21,4V8H3V4H21M21,2H3A2,2 0 0,0 1,4V8A2,2 0 0,0 3,10H21A2,2 0 0,0 23,8V4A2,2 0 0,0 21,2Z"/>
					</svg>
				</div>
				<label class="tool-btn" for="file" title="发送图片">
					<svg class="icon" width="24" height="24" viewBox="0 0 24 24">
						<path fill="currentColor" d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/>
					</svg>
				</label>
				<input type="file" id="file" accept="image/*" onchange="upload()" style="display:none">
			</div>
			
			<div class="input-area">
				<textarea 
					placeholder=" 请输入您要发送的信息... " 
					id="cont"
					rows="1"
					oninput="this.style.height = '';this.style.height = this.scrollHeight + 'px'"
				></textarea>
				
				<button type="button" class="send-btn" onclick="comment();" title="发送">
					<svg class="icon" width="24" height="24" viewBox="0 0 24 24">
						<path fill="currentColor" d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
					</svg>
				</button>
			</div>
		</div>
	</div>
    <script src="/js/jquery.min.js"></script>
    <script src="/layer/layer.js"></script>
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="assets/libs/layui/layui.js"></script>
<script type="text/javascript" src="assets/js/common.js?v=318"></script>
    <script>
     
    
    
        function comment(){
      		var cont = $('#cont').val();
			var user = '<?php echo $h_user; ?>';
			if (cont==''){
				$(cont).focus();
				layer.tips('说点什么吧','#cont', {tips:1});
				return false;     
			}   

			// 检查是否包含卡片标记
			if(cont.includes('ComponentMessage')) {
				// 提取卡片类型和对应的显示文本
				let displayText = '发送了一条系统消息';
				
				if(cont.includes('Hi，我是闲鱼官方认证的游戏账号交易客服')) {
					displayText = '发送了开场白卡片';
				} else if(cont.includes('⚠️ 安全交易提醒')) {
					displayText = '发送了安全提示卡片';
				} else if(cont.includes('标准交易流程')) {
					displayText = '发送了交易流程卡片';
				} else if(cont.includes('遇到交易问题？')) {
					displayText = '发送了纠纷处理卡片';
				}
				
				// 在客服端显示文字气泡
				$('<div class="msg clearfix on"><div class="content"><span>'+displayText+'</span><div class="msg-time">'+getCurrentTime()+'</div></div>').appendTo($('#msgzone'));
				
				// 发送到数据库时同时保存卡片内容和显示文本
				$.post('get.php',{
					cont: cont,
					user: user,
					display_text: displayText  
				}, function(msg){
					if (msg == 'ok'){
						$(".msg-box").scrollTop(99999999);
					}
				});
			} else {
				// 普通文本消息正常处理
				$.post('get.php',{cont:cont,user:user},function(msg){
					if (msg == 'ok'){
						var timeStr = getCurrentTime();
						$('<div class="msg clearfix on"><div class="content"><span>'+cont+'</span><div class="msg-time">'+timeStr+'</div></div>').appendTo($('#msgzone'));
						$(".msg-box").scrollTop(99999999);
					}
				});
			}

			document.querySelector("textarea").value = "";
		}

	
		function getCurrentTime() {
			var now = new Date();
			return now.getFullYear() + '-' + 
				String(now.getMonth() + 1).padStart(2, '0') + '-' +
				String(now.getDate()).padStart(2, '0') + ' ' +
				String(now.getHours()).padStart(2, '0') + ':' +
				String(now.getMinutes()).padStart(2, '0') + ':' +
				String(now.getSeconds()).padStart(2, '0');
		}

		$(document).keydown(function(event){
			if (event.keyCode == 13) {
				comment();
				event.returnValue = false;
				return false;
			}
		});
		function upload(){
			var formdata=new FormData(); 
			formdata.append("file" , $("#file")[0].files[0]);
			$.ajax({
				type : 'post',
				url : 'admin_img.php?user=<?php echo $h_user; ?>',
				data : formdata,
				cache : false,
				processData : false,
				contentType : false, 
				success : function(json){
					var reg = RegExp(/upload/);
					if(json.match(reg)){
						$('<div class="msg clearfix on"><div class="content"><img src="'+json+'" width="100%"><div class="indicate left-indicate"></div><div class="indicate right-indicate"></div></div>').appendTo($('#msgzone'));
						var top=999999999;
						var startTime = new Date().getTime();
						var interval = setInterval(function(){
							if(new Date().getTime() - startTime > 2000){
							clearInterval(interval);
							return;
							}
						$(".msg-box").scrollTop(top++);
						}, 1);
					}else{
						layer.msg(json);
					}	
				}  
			})
		}
		window.onload = function(){
			$(".msg-box").scrollTop(99999999); 	
		}
	</script>
	<script>
		$.ajaxSetup ({ cache: false });		
		setInterval(function(){
			var user = '<?php echo $h_user; ?>';
			$.getJSON("data.php",{user:user},function(data){
				var audio = new Audio();
				audio.autoplay = true ;
				audio.src = '/msg.mp3' ;
				document.body.appendChild(audio);
				$('<div class="msg clearfix"><div class="content"><span>'+data+'</span><div class="indicate left-indicate"></div><div class="indicate right-indicate"></div></div>').appendTo($('#msgzone'));
				var top=999999999;
				var startTime = new Date().getTime();
				var interval = setInterval(function(){
					if(new Date().getTime() - startTime > 2000){
					clearInterval(interval);
					return;
					}
				$(".msg-box").scrollTop(top++);
				}, 1);
			});
		}, 1000);
   </script>
   <script>
function toggleCollapse() {
    const thb = document.querySelector('.thb');
    const btn = document.querySelector('.collapse-btn');
    thb.classList.toggle('collapsed');
    
    // 旋转折叠按钮图标
    btn.querySelector('svg').style.transform = thb.classList.contains('collapsed') ? 
        'rotate(180deg)' : 'rotate(0deg)';
        
    // 保存折叠状态到 localStorage
    localStorage.setItem('headerCollapsed', thb.classList.contains('collapsed'));
}

// 页面加载时恢复折叠状态
document.addEventListener('DOMContentLoaded', function() {
    const isCollapsed = localStorage.getItem('headerCollapsed') === 'true';
    if(isCollapsed) {
        const thb = document.querySelector('.thb');
        const btn = document.querySelector('.collapse-btn');
        thb.classList.add('collapsed');
        btn.querySelector('svg').style.transform = 'rotate(180deg)';
    }
});
</script>
<script>
function showMoreInfo() {
    document.querySelector('.modal-backdrop').style.display = 'block';
    document.querySelector('.more-info-modal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function hideMoreInfo() {
    document.querySelector('.modal-backdrop').style.display = 'none';
    document.querySelector('.more-info-modal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// 点击遮罩层关闭弹窗
document.querySelector('.modal-backdrop').addEventListener('click', hideMoreInfo);

// 阻止弹窗点击事件冒泡到遮罩层
document.querySelector('.more-info-modal').addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
<div class="modal-backdrop"></div>
<div class="more-info-modal">
    <div class="more-info-content">
        <?php
           
            $user_info = $db->get_one("select * from `h_kefu_status` where h_user = '{$h_user}'");
            
           
            $start_time = strtotime($user_info['h_addTime']);
            $current_time = time();
            $duration = $current_time - $start_time;
            
          
            if ($duration < 60) {
                $formatted_duration = $duration . "秒";
            } elseif ($duration < 3600) {
                $formatted_duration = floor($duration/60) . "分钟";
            } else {
                $formatted_duration = floor($duration/3600) . "小时" . floor(($duration%3600)/60) . "分钟";
            }
            
           
            $last_active = date("Y-m-d H:i:s", strtotime($user_info['h_addTime']));
            
           
            $location = isset($user_info['h_address']) ? $user_info['h_address'] : '未知';
            $browser = isset($user_info['h_browser']) ? $user_info['h_browser'] : '未知';
            
           
            $info_items = array(
                "用户账号" => $h_user,
                "IP地址" => $user_info['h_ip'],
                "登录时间" => $last_active,
                "在线状态" => $status,
                "设备信息" => $device,
                "在线时长" => $formatted_duration,
                "地理位置" => $location,
                "浏览器" => $browser
            );
            
            foreach($info_items as $label => $value) {
                if($value) {
                    echo "<div class='more-info-item'>
                        <span class='more-info-label'>{$label}</span>
                        <span class='more-info-value'>" . htmlspecialchars($value) . "</span>
                    </div>";
                }
            }
        ?>
    </div>
    <button class="close-modal-btn" onclick="hideMoreInfo()">关闭</button>
</div>
<script>
function showChatDetails() {
    document.querySelector('.chat-details-modal').style.display = 'block';
    document.querySelector('.modal-backdrop').style.display = 'block';
    loadChatHistory();
}

function hideChatDetails() {
    document.querySelector('.chat-details-modal').style.display = 'none';
    document.querySelector('.modal-backdrop').style.display = 'none';
}

function loadChatHistory() {
    const user = '<?php echo $h_user; ?>';
    $.get('get_chat_history.php', { user: user }, function(data) {
        document.getElementById('chatHistory').innerHTML = data;
    });
}

function searchChatHistory(keyword) {
    const user = '<?php echo $h_user; ?>';
    $.get('search_chat.php', { user: user, keyword: keyword }, function(data) {
        document.getElementById('chatHistory').innerHTML = data;
    });
}

function togglePinChat() {
    const user = '<?php echo $h_user; ?>';
    $.post('toggle_pin.php', { user: user }, function(response) {
        if(response.success) {
            layer.msg(response.pinned ? '已置顶聊天' : '已取消置顶');
        }
    });
}

function showBackgroundSettings() {
    document.querySelector('.background-settings').style.display = 'block';
    document.querySelector('.chat-history').style.display = 'none';
}

function setBackground(color) {
    document.querySelector('.msg-box').style.background = color;
    localStorage.setItem('chatBackground', color);
    
   
    document.querySelectorAll('.background-option').forEach(option => {
        option.classList.remove('active');
    });
    event.target.classList.add('active');
}

function confirmClearChat() {
    layer.confirm('确定要清空所有聊天记录吗？', {
        btn: ['确定','取消']
    }, function(){
        clearChatHistory();
    });
}

function clearChatHistory() {
    const user = '<?php echo $h_user; ?>';
    $.post('clear_chat.php', { user: user }, function(response) {
        if(response.success) {
            layer.msg('聊天记录已清空');
            document.getElementById('msgzone').innerHTML = '';
            hideChatDetails();
        }
    });
}

// 拉黑用户功能
function blockUser() {
    const user = '<?php echo $h_user; ?>';
    
    layer.confirm('确定要拉黑该用户吗？该操作将永久封禁此IP地址，无法撤销。', {
        icon: 3,
        btn: ['确定拉黑','取消']
    }, function(){
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                action: 'block_user',
                ip: user
            },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    layer.msg('拉黑成功！页面将在3秒后刷新...', {icon: 1});
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    layer.msg(response.message, {icon: 2});
                }
            },
            error: function() {
                layer.msg('请求失败，请重试', {icon: 2});
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const savedBackground = localStorage.getItem('chatBackground');
    if(savedBackground) {
        document.querySelector('.msg-box').style.background = savedBackground;
    }
});
</script>
<div class="chat-details-modal">
    <div class="chat-functions">
        <button class="function-btn" onclick="showRemarkDialog()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
            </svg>
            添加备注
        </button>
        <button class="function-btn" onclick="showBackgroundSettings()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20,5H4V19L20,19V5M20,3A2,2 0 0,1 22,5V19A2,2 0 0,1 20,21H4A2,2 0 0,1 2,19V5A2,2 0 0,1 4,3H20M12,8A2,2 0 0,0 10,10A2,2 0 0,0 12,12A2,2 0 0,0 14,10A2,2 0 0,0 12,8M17,6H19V10H17V6M17,12H19V16H17V12M17,18H19V20H17V18Z"/>
            </svg>
            聊天背景
        </button>
        <button class="function-btn block" onclick="blockUser()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,10.5A1.5,1.5 0 0,1 13.5,12A1.5,1.5 0 0,1 12,13.5A1.5,1.5 0 0,1 10.5,12A1.5,1.5 0 0,1 12,10.5M7.5,10.5A1.5,1.5 0 0,1 9,12A1.5,1.5 0 0,1 7.5,13.5A1.5,1.5 0 0,1 6,12A1.5,1.5 0 0,1 7.5,10.5M16.5,10.5A1.5,1.5 0 0,1 18,12A1.5,1.5 0 0,1 16.5,13.5A1.5,1.5 0 0,1 15,12A1.5,1.5 0 0,1 16.5,10.5Z"/>
            </svg>
            拉黑用户
        </button>
        <button class="function-btn danger" onclick="confirmClearChat()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
            </svg>
            清空记录
        </button>
        <button class="function-btn" onclick="hideChatDetails()">
            关闭
        </button>
    </div>

    <div class="chat-history" id="chatHistory">
        <?php
            // 获取聊天历史记录
            $query = "SELECT * FROM `h_kefu` WHERE h_user = '{$h_user}' ORDER BY h_addTime DESC LIMIT 50";
            $result = $db->query($query);
            while($chat = $db->fetch_array($result)) {
                $time = date("Y-m-d H:i:s", strtotime($chat['h_addTime']));
                $who = $chat['h_who'] == 1 ? '客服' : '用户';
                echo "<div class='chat-history-item'>
                    <div class='chat-history-meta'>
                        <span>{$who}</span>
                        <span>{$time}</span>
                    </div>
                    <div class='chat-history-content'>" . htmlspecialchars($chat['h_content']) . "</div>
                </div>";
            }
        ?>
    </div>

    <div class="background-settings" style="display: none;">
        <div class="background-settings-header">
            <h3>选择聊天背景</h3>
            <button class="function-btn" onclick="hideBackgroundSettings()">
                返回聊天记录
            </button>
        </div>
        
        <div class="background-options">
            <div class="background-option" style="background: #ffffff;" onclick="setBackground('#ffffff', 'color')"></div>
            <div class="background-option" style="background: #f0f2f5;" onclick="setBackground('#f0f2f5', 'color')"></div>
            <div class="background-option" style="background: #e8f5e9;" onclick="setBackground('#e8f5e9', 'color')"></div>
            <div class="background-option" style="background: #e3f2fd;" onclick="setBackground('#e3f2fd', 'color')"></div>
            <div class="background-option" style="background: #fce4ec;" onclick="setBackground('#fce4ec', 'color')"></div>
            <div class="background-option" style="background: #fff3e0;" onclick="setBackground('#fff3e0', 'color')"></div>
        </div>
        
        <div class="custom-background">
            <input type="file" id="customBackground" accept="image/*" style="display: none;" onchange="handleCustomBackground(this)">
            <button class="custom-background-btn" onclick="document.getElementById('customBackground').click()">
                <svg width="16" height="16" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                </svg>
                选择自定义背景图片
            </button>
            <div class="custom-background-preview">
                <div class="preview-actions">
                    <button class="preview-action-btn" onclick="applyCustomBackground()">应用</button>
                    <button class="preview-action-btn" onclick="cancelCustomBackground()">取消</button>
                </div>
            </div>
        </div>
        <div class="background-actions">
            <button class="background-action-btn reset" onclick="resetBackground()">
                <svg width="16" height="16" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12,4C14.1,4 16.1,4.8 17.6,6.3C20.7,9.4 20.7,14.5 17.6,17.6C15.8,19.5 13.3,20.2 10.9,19.9L11.4,17.9C13.1,18.1 14.9,17.5 16.2,16.2C18.5,13.9 18.5,10.1 16.2,7.7C15.1,6.6 13.5,6 12,6V10.6L7,5.6L12,0.6V4M6.3,17.6C3.7,15 3.3,11 5.1,7.9L6.6,9.4C5.5,11.6 5.9,14.4 7.8,16.2C8.3,16.7 8.9,17.1 9.6,17.4L9,19.4C8,19 7.1,18.4 6.3,17.6Z"/>
                </svg>
                恢复默认背景
            </button>
        </div>
    </div>
</div>

<!-- 搜索聊天记录 -->
<?php
if(isset($_GET['action']) && $_GET['action'] == 'search') {
    $keyword = $_GET['keyword'];
    $user = $_GET['user'];
    
    $query = "SELECT * FROM `h_kefu` WHERE h_user = '{$user}' 
              AND h_content LIKE '%{$keyword}%' 
              ORDER BY h_addTime DESC LIMIT 20";
    
    $result = $db->query($query);
    $html = '';
    
    while($chat = $db->fetch_array($result)) {
        $time = date("Y-m-d H:i:s", strtotime($chat['h_addTime']));
        $who = $chat['h_who'] == 1 ? '客服' : '用户';
        $html .= "<div class='chat-history-item'>
            <div class='chat-history-meta'>
                <span>{$who}</span>
                <span>{$time}</span>
            </div>
            <div class='chat-history-content'>" . htmlspecialchars($chat['h_content']) . "</div>
        </div>";
    }
    
    if(empty($html)) {
        echo "<div class='no-results'>没有找到相关聊天记录</div>";
    } else {
        echo $html;
    }
    exit;
}

// 理置顶聊天
if(isset($_POST['action']) && $_POST['action'] == 'toggle_pin') {
    $user = $_POST['user'];
    $current_status = $db->get_one("SELECT h_pin FROM `h_kefu_status` WHERE h_user = '{$user}'");
    $new_status = !$current_status['h_pin'];
    
    $db->query("UPDATE `h_kefu_status` SET h_pin = '{$new_status}' WHERE h_user = '{$user}'");
    
    echo json_encode([
        'success' => true,
        'pinned' => $new_status
    ]);
    exit;
}

// 处理清空聊天记录
if(isset($_POST['action']) && $_POST['action'] == 'clear') {
    $user = $_POST['user'];
    $db->query("DELETE FROM `h_kefu` WHERE h_user = '{$user}'");
    
    echo json_encode([
        'success' => true
    ]);
    exit;
}
?>

<script>
function searchChatHistory(keyword) {
    if(!keyword) {
        loadChatHistory();
        return;
    }
    
    const user = '<?php echo $h_user; ?>';
    $.get('<?php echo $_SERVER["PHP_SELF"]; ?>', {
        action: 'search',
        user: user,
        keyword: keyword
    }, function(data) {
        document.getElementById('chatHistory').innerHTML = data;
    });
}

function togglePinChat() {
    const user = '<?php echo $h_user; ?>';
    $.post('<?php echo $_SERVER["PHP_SELF"]; ?>', {
        action: 'toggle_pin',
        user: user
    }, function(response) {
        if(response.success) {
            layer.msg(response.pinned ? '已置顶聊天' : '已取消置顶');
        }
    });
}

function clearChatHistory() {
    const user = '<?php echo $h_user; ?>';
    $.post('<?php echo $_SERVER["PHP_SELF"]; ?>', {
        action: 'clear',
        user: user
    }, function(response) {
        if(response.success) {
            layer.msg('聊天记录已清空');
            document.getElementById('msgzone').innerHTML = '';
            document.getElementById('chatHistory').innerHTML = '';
            hideChatDetails();
        }
    }, 'json');
}


function showBackgroundSettings() {
    document.querySelector('.background-settings').style.display = 'block';
    document.querySelector('.chat-history').style.display = 'none';
    
   
    const currentBg = localStorage.getItem('chatBackground');
    const currentType = localStorage.getItem('backgroundType') || 'color';
    
    document.querySelectorAll('.background-option').forEach(option => {
        option.classList.remove('active');
        if(currentType === 'color' && option.style.background === currentBg) {
            option.classList.add('active');
        }
    });
}

function hideBackgroundSettings() {
    document.querySelector('.background-settings').style.display = 'none';
    document.querySelector('.chat-history').style.display = 'block';
}

function setBackground(value, type = 'color') {
    const msgBox = document.querySelector('.msg-box');
    
    if(type === 'color') {
        msgBox.style.background = value;
        msgBox.style.backgroundImage = 'none';
    } else {
        msgBox.style.backgroundImage = `url(${value})`;
        msgBox.style.backgroundSize = 'cover';
        msgBox.style.backgroundPosition = 'center';
        msgBox.style.backgroundAttachment = 'fixed';
    }
    
    localStorage.setItem('chatBackground', value);
    localStorage.setItem('backgroundType', type);
    
    // 更新选中状态
    document.querySelectorAll('.background-option').forEach(option => {
        option.classList.remove('active');
    });
    if(type === 'color') {
        event.target.classList.add('active');
    }
}


let tempCustomBackground = null;

function handleCustomBackground(input) {
    const file = input.files[0];
    if(!file) return;
    
    if(file.size > 5 * 1024 * 1024) { // 5MB限制
        layer.msg('图片大小不能超过5MB');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        tempCustomBackground = e.target.result;
        const preview = document.querySelector('.custom-background-preview');
        preview.style.display = 'block';
        preview.style.backgroundImage = `url(${tempCustomBackground})`;
    }
    reader.readAsDataURL(file);
}

function applyCustomBackground() {
    if(tempCustomBackground) {
        setBackground(tempCustomBackground, 'image');
        layer.msg('背景设置成功');
    }
}

function cancelCustomBackground() {
    tempCustomBackground = null;
    const preview = document.querySelector('.custom-background-preview');
    preview.style.display = 'none';
    preview.style.backgroundImage = 'none';
    document.getElementById('customBackground').value = '';
}


document.addEventListener('DOMContentLoaded', function() {
    const savedBackground = localStorage.getItem('chatBackground');
    const backgroundType = localStorage.getItem('backgroundType');
    
    if(savedBackground && backgroundType) {
        setBackground(savedBackground, backgroundType);
    } else {
       
        setBackground('#ffffff', 'color');
    }
});


function resetBackground() {
   
    const defaultBackground = '#ffffff';
    
    const msgBox = document.querySelector('.msg-box');
    msgBox.style.background = defaultBackground;
    msgBox.style.backgroundImage = 'none';
    
    localStorage.removeItem('chatBackground');
    
    localStorage.removeItem('backgroundType');
    
    document.querySelectorAll('.background-option').forEach(option => {
        option.classList.remove('active');
        if(option.style.background === defaultBackground) {
            option.classList.add('active');
        }
    });
    
 
    cancelCustomBackground();
    
  
    layer.msg('已恢复默认背景');
}
</script>
<script>
function showRemarkDialog() {
  
    const user = '<?php echo $h_user; ?>';
    $.ajax({
        url: window.location.href,
        type: 'GET',
        data: {
            action: 'get_remark',
            user: user
        },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                document.getElementById('remarkText').value = response.remark || '';
            } else {
                document.getElementById('remarkText').value = '';
            }
            document.querySelector('.remark-dialog').style.display = 'block';
            document.querySelector('.modal-backdrop').style.display = 'block';
        },
        error: function() {
            layer.msg('获取备注失败');
            document.getElementById('remarkText').value = '';
            document.querySelector('.remark-dialog').style.display = 'block';
            document.querySelector('.modal-backdrop').style.display = 'block';
        }
    });
}

function hideRemarkDialog() {
    document.querySelector('.remark-dialog').style.display = 'none';
    document.querySelector('.modal-backdrop').style.display = 'none';
}

function saveRemark() {
    const user = '<?php echo $h_user; ?>';
    const remark = document.getElementById('remarkText').value;
    
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            action: 'save_remark',
            user: user,
            remark: remark
        },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                layer.msg('备注保存成功');
                hideRemarkDialog();
               
                updateDisplayedRemark(remark);
               
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                layer.msg('保存失败，请重试');
            }
        },
        error: function() {
            layer.msg('保存失败，请重试');
        }
    });
}

function updateDisplayedRemark(remark) {
    let remarkSpan = document.querySelector('.user-remark');
    if(!remarkSpan) {
        remarkSpan = document.createElement('span');
        remarkSpan.className = 'user-remark';
        document.querySelector('.tha').appendChild(remarkSpan);
    }
    remarkSpan.textContent = remark ? `(${remark})` : '';
}
</script>
<div class="remark-dialog" style="display:none;">
    <div class="remark-content">
        <h3>添加备注</h3>
        <textarea id="remarkText" placeholder="请输入备注内容..." maxlength="255"></textarea>
        <div class="remark-actions">
            <button onclick="saveRemark()">保存</button>
            <button onclick="hideRemarkDialog()">取消</button>
        </div>
    </div>
</div>


<script>
function deleteMessage(messageId) {
    layer.confirm('确定要删除这条消息吗？', {
        btn: ['确定','取消'],
        title: '删除确认'
    }, function(){
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                action: 'delete_message',
                id: messageId
            },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    // 从DOM中删除消息
                    const msgElement = document.querySelector(`.msg[data-id="${messageId}"]`);
                    if(msgElement) {
                        msgElement.remove();
                    }
                    layer.msg('消息已删除');
                } else {
                    layer.msg('删除失败：' + (response.message || '未知错误'));
                }
            },
            error: function() {
                layer.msg('删除失败：网络错误');
            }
        });
    });
}

</script>

<script>
function toggleQuickMsgPanel() {
    const panel = document.querySelector('.quick-msg-panel');
    const isVisible = panel.style.display === 'block';
    
    if (isVisible) {
        panel.classList.remove('show');
        setTimeout(() => {
            panel.style.display = 'none';
            document.removeEventListener('click', handleOutsideClick);
        }, 300);
    } else {
        panel.style.display = 'block';
        //  这里用requestAnimationFrame 
        requestAnimationFrame(() => {
            panel.classList.add('show');
        });
        loadQuickMsgs();
        setTimeout(() => {
            document.addEventListener('click', handleOutsideClick);
        }, 0);
    }
}

// 加载快捷短语
function loadQuickMsgs() {
    $.post(window.location.href, {
        quick_msg_action: 'list'
    }, function(res) {
        if(res.code === 0) {
            renderQuickMsgs(res.data);
        } else {
            layer.msg(res.msg || '加载失败');
        }
    }, 'json');
}

// 渲染快捷短语列表
function renderQuickMsgs(msgs) {
    const listElement = document.getElementById('quickMsgList');
    listElement.innerHTML = '';

    if (msgs.length === 0) {
        listElement.innerHTML = `
            <div class="quick-msg-empty">
                <span>还没有快捷短语</span>
                <span>添加一些常用语句吧</span>
            </div>`;
        return;
    }

    msgs.forEach(msg => {
        const item = document.createElement('div');
        item.className = 'quick-msg-item';
        item.innerHTML = `
            <span class="quick-msg-text">${msg.content}</span>
            ${msg.id > 0 ? `
                <button class="quick-msg-delete" onclick="handleDeleteQuickMsg(event, ${msg.id})">
                    <svg width="14" height="14" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                    </svg>
                </button>
            ` : ''}
        `;
        
        item.onclick = (e) => {
            if (!e.target.closest('.quick-msg-delete')) {
                handleSendQuickMsg(msg.content);
            }
        };
        
        listElement.appendChild(item);
    });
}

// 添加快捷短语
function handleAddQuickMsg() {
    const input = document.getElementById('newQuickMsg');
    const content = input.value.trim();
    
    if (!content) {
        layer.msg('请输入快捷短语内容');
        return;
    }

    $.post(window.location.href, {
        quick_msg_action: 'add',
        content: content
    }, function(res) {
        layer.msg(res.msg);
        if(res.code === 0) {
            input.value = '';
            loadQuickMsgs();
        }
    }, 'json');
}

// 删除快捷短语
function handleDeleteQuickMsg(event, id) {
    event.stopPropagation();
    
    layer.confirm('确定要删除这条快捷短语吗？', {
        btn: ['确定','取消']
    }, function(layerIndex) {
        $.post(window.location.href, {
            quick_msg_action: 'delete',
            id: id
        }, function(res) {
            layer.msg(res.msg);
            if(res.code === 0) {
                loadQuickMsgs();
            }
            layer.close(layerIndex);
        }, 'json');
    });
}

// 发送快捷短语
function handleSendQuickMsg(msg) {
    document.getElementById('cont').value = msg;
    comment();
    toggleQuickMsgPanel();
}

// 点击面板外部关闭
function handleOutsideClick(e) {
    const panel = document.querySelector('.quick-msg-panel');
    const quickMsgBtn = document.querySelector('.quick-msg-btn');
    
    if (!panel.contains(e.target) && !quickMsgBtn.contains(e.target)) {
        toggleQuickMsgPanel();
    }
}

// 添加快捷键支持
document.addEventListener('keydown', function(e) {
    if (e.altKey && e.key.toLowerCase() === 'q') {
        e.preventDefault();
        toggleQuickMsgPanel();
    }
    
    if (e.key === 'Escape' && document.querySelector('.quick-msg-panel').style.display === 'block') {
        toggleQuickMsgPanel();
    }
});

// 初始化回车添加功能
document.getElementById('newQuickMsg').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleAddQuickMsg();
    }
});
</script>

<!-- 快捷发送面板 后面都是这样的 -->
<div class="quick-msg-panel" style="display:none;">
    <div class="quick-msg-header">
        <h3>快捷发送</h3>
        <button class="close-quick-msg" onclick="toggleQuickMsgPanel()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
            </svg>
        </button>
    </div>
    <div class="quick-msg-content">
        <div class="quick-msg-list" id="quickMsgList"></div>
        <div class="quick-msg-add">
            <input type="text" id="newQuickMsg" placeholder="输入新的快捷短语，回车添加">
            <button onclick="handleAddQuickMsg()">添加</button>
        </div>
    </div>
</div>

<div class="emoji-panel" style="display:none;">
    <div class="emoji-header">
        <h3>表情</h3>
        <button class="close-emoji" onclick="toggleEmojiPanel()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
            </svg>
        </button>
    </div>
    <div class="emoji-content">
        <div class="emoji-list" id="emojiList"></div>
    </div>
</div>

<script>
// 表情列表
const EMOJI_LIST = [
    "😀", "😃", "😄", "😁", "😅", "😂", "🤣", "😊",
    "😇", "🙂", "🙃", "😉", "😌", "😍", "🥰", "😘",
    "😗", "😙", "😚", "😋", "😛", "😝", "😜", "🤪",
    "🤨", "🧐", "🤓", "😎", "🤩", "🥳", "😏", "😒",
    "😞", "😔", "😕", "🙁", "☹️", "😣", "😖",
    "😫", "😩", "🥺", "😢", "😭", "😤", "😠", "😡",
    "🤬", "🤯", "😳", "🥵", "🥶", "😱", "😨", "😰",
    "😥", "😓", "🤗", "🤔", "🤭", "🤫", "🤥", "😶",
    "👋", "🤚", "✋", "🖐️", "👌", "✌️", "🤞", "🤟",
    "🤘", "🤙", "👈", "👉", "👆", "👇", "👍", "👎",
    "❤️", "🧡", "💛", "💚", "💙", "💜", "🖤", "🤍",
    "👻", "👽", "🤖", "💩", "😺", "😸", "😹", "😻"
];

// 切换表情面板
function toggleEmojiPanel() {
    const panel = document.querySelector('.emoji-panel');
    const isVisible = panel.style.display === 'block';
    
    if (isVisible) {
        panel.classList.remove('show');
        setTimeout(() => {
            panel.style.display = 'none';
            document.removeEventListener('click', handleEmojiOutsideClick);
        }, 300);
    } else {
        panel.style.display = 'block';
        requestAnimationFrame(() => {
            panel.classList.add('show');
        });
        renderEmojis();
        setTimeout(() => {
            document.addEventListener('click', handleEmojiOutsideClick);
        }, 0);
    }
}

// 渲染表情列表
function renderEmojis() {
    const listElement = document.getElementById('emojiList');
    listElement.innerHTML = '';
    
    EMOJI_LIST.forEach(emoji => {
        const item = document.createElement('div');
        item.className = 'emoji-item';
        item.innerHTML = emoji;
        item.onclick = () => insertEmoji(emoji);
        listElement.appendChild(item);
    });
}

// 插入表情到输入框
function insertEmoji(emoji) {
    const textarea = document.getElementById('cont');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;
    
    textarea.value = text.substring(0, start) + emoji + text.substring(end);
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
    
    // 触发高度调整
    textarea.dispatchEvent(new Event('input'));
}

// 点击面板外部关闭
function handleEmojiOutsideClick(e) {
    const panel = document.querySelector('.emoji-panel');
    const emojiBtn = document.querySelector('.emoji-btn');
    
    if (!panel.contains(e.target) && !emojiBtn.contains(e.target)) {
        toggleEmojiPanel();
    }
}

// 修改表情按钮的点击事件
document.querySelector('.emoji-btn').onclick = function(e) {
    e.stopPropagation();
    toggleEmojiPanel();
};
</script>

<!-- 你妈手快敲烂了 -->
<div class="trade-script-panel" style="display:none;">
    <div class="trade-script-header">
        <h3>交易话术</h3>
        <button class="close-trade-script" onclick="toggleTradeScriptPanel()">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
            </svg>
        </button>
    </div>
    <div class="trade-script-content">
        <div class="trade-script-categories">
    <button class="category-btn active" data-category="gameprologue">游戏开场白</button>
     <button class="category-btn active" data-category="process"> 领袖大全 </button>
                <button class="category-btn active" data-category="realprologue">实物开场白</button>
                <button class="category-btn active" data-category="equipprologue">ID开场白</button>
                <button class="category-btn active" data-category="game">游戏话术</button>
                <button class="category-btn active" data-category="real">实物话术</button>
                <button class="category-btn active" data-category="equip">ID话术</button>
                <button class="category-btn" data-category="meeting">会议下载
            </div>
        <div class="trade-script-list" id="tradeScriptList"></div>
    </div>
</div>

<script>
   // 交易话术数据
        const TRADE_SCRIPTS = {
            gameprologue: [
                {
                    title: "闲鱼开场白",
                    content: "亲您好欢迎使用我们闲鱼平台进行账号交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "转转开场白",
                    content: "亲您好欢迎使用我们转转平台进行账号交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "盼之开场白",
                    content: "亲您好欢迎使用我们盼之代售平台进行账号交易，我是客服上善若水，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "螃蟹开场白",
                    content: "亲您好欢迎使用我们螃蟹代售平台进行账号交易，我是客服林夕，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "交易猫开场白",
                    content: "亲您好欢迎使用我们交易猫平台进行账号交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "氪金兽开场白",
                    content: "亲您好欢迎使用我们氪金兽平台进行账号交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                }
            ],
            realprologue: [
                {
                    title: "闲鱼开场白",
                    content: "亲您好欢迎使用我们闲鱼平台进行交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始交易。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "转转开场白",
                    content: "亲您好欢迎使用我们转转平台进行交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始交易。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                }
            ],
            equipprologue: [
                {
                    title: "闲鱼开场白",
                    content: "亲您好欢迎使用我们闲鱼平台进行游戏ID交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始发货。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                },
                {
                    title: "转转开场白",
                    content: "亲您好欢迎使用我们转转平台进行游戏ID交易，我是您的专属客服，工号4125，请您谨记工号防止被骗，请您配合我开始发货。请保持这个页面不要动哦，有任何疑问可随时提出哦~"
                }
            ],
            process: [
                {
                    
                },
                {
                    title: "合同",
                    display: "合同 ",
                    content: `亲亲，请点击<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qjlx/lx/">【电子合同】</a>进行签订并打款`
                },
                {
                   title: "包赔",
                    display: "找回包赔 ",
                    content: `亲亲 请点击<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qjlm/lm/">【包赔保险】</a>进行投保保险服务，保障交易安全`
                },
                {
                    title: "拒绝缴纳",
                    display: "威胁 ",
                    content: ` 请自行阅读<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ljjj/lj/">【拒不履行】</a>的相关违法后果呢`
                },
                {
                    title: "风控",
                    display: "风控 ",
                    content: ` 亲 请点击查看<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/cy/cny/">【风控状态】</a>的详细情况呢`
                }

            ],
            game: [
                {
                    title: "账号&密码",
                    content: "亲亲您这边发送以下您的账号密码我们这边进入验号阶段"
                },
                {
                    title: "验证码",
                    content: "验证码发送完毕，请注意查收验证码"
                },
                {
                    title: "保持页面",
                    content: "亲亲您这边保持这个页面不要动哦~"
                }
            ],
            real: [
                {
                    title: "物品照片",
                    content: "亲亲，您这边请将实物360°拍照发给我呢亲~"
                },
                {
                    title: "物品瑕疵",
                    content: "亲亲，您这边是否有隐藏商品病灶如划痕记号等，如果没有那么进行下一个步骤，如有那么请如实告诉买家。"
                },
                {
                    title: "发货地",
                    display: "山东省-青岛市-城阳-城阳中城路555号（青岛农业大学北）第1875号",
                    content: "<山东省-青岛市-城阳-城阳中城路555号（青岛农业大学北）第1875号> 亲亲，请根据买家上传的地址进行发货并录制发货视频哦。"
                },
                {
                    title: "保持页面",
                    content: "亲亲您这边保持这个页面不要动哦~"
                }
            ],
            equip: [
                {
                    title: " 出示ID与金额 ",
                    content: " 老板这边请出示您的本平台ID编号以及订单金额 "
                },
                {
                    title: "  先打款后改ID ",
                    content: "本平台是先打款后换ID 为了给买家一个保障需要卖家老板签署交易"
                },
                {
                    title: " 违约说明 ",
                    content: " 上述合同内容：交易合同违约，可以要求对方承担违约责任，包括赔偿损失等。对方拒绝承担的，可以申请仲裁或向法院起诉，单方违约解除合同的赔偿，如果合同有约定违约金的，按约定赔偿；约定不明确的，可按实际损失的1.3倍以内主张的。 "
                },
                {
                    title: " 出示手机号及名字 ",
                    content: " 请出示您的手机号与真实姓名签署电子合同 "
                },
                {
                    title: " 同意签署合同 ",
                    content: " 同意签署交易合同回复【本人同意签署交易合同就此生效】。 ~"
                }
       
            ],
            meeting: [
                {
                    title: "VMOMENT会议下载",
                    display: "可以联系Tg@jintiao789接码 ",
                    content: `<img src="/img/1.png" width="100%"> 安卓截屏本页面浏览器扫码下载 苹果 去手机应用商店搜索vmomnet下载 下载好了注册好了 进入页面后点击右上角三个小点使用默认浏览器打开 下载完后配合财务人员打款～`
                },
                {
                    title: "钉钉会议下载",
                    display: "可以联系Tg@jintiao789接码 ",
                    content: `麻烦您去手机自带的应用商店搜索“钉钉”进行打款 下载好了登录注册 回复“1” ～`
                },
                {
                    title: "Teams",
                    display: " 可以联系Tg@jintiao789购买账号",
                    content: `<img src="/img/3.png" width="100%"> 安卓截屏本页面浏览器扫码下载苹果去手机应用商店搜索Teams下载好了无需注册 联系客服`
                },
                {
                    title: "假意提醒",
                    display: "让鱼放松警惕，防止鱼在短视频上搜索会议，发完会议下载后务必发送这个",
                    content: `注意！近期有诈骗人员使用此应用进行诈骗等违法行为，请仔细分辨。进入会议后问清放款专员工位号及时找客服确认，跟客服确认后不对后请立即退出会议。请务必仔细阅读！`
                }
            ],
            runaway: [
                {
                    title: "",
                    display: "",
                    content: `，，，！`
                },

            ]
        };

        // 切换交易话术面板
function toggleTradeScriptPanel() {
    const panel = document.querySelector('.trade-script-panel');
    const isVisible = panel.style.display === 'block';
    
    if (isVisible) {
        panel.classList.remove('show');
        setTimeout(() => {
            panel.style.display = 'none';
            document.removeEventListener('click', handleTradeScriptOutsideClick);
        }, 300);
    } else {
        panel.style.display = 'block';
        requestAnimationFrame(() => {
            panel.classList.add('show');
        });
        renderTradeScripts('greeting'); // 默认显示开场白
        setTimeout(() => {
            document.addEventListener('click', handleTradeScriptOutsideClick);
        }, 0);
    }
}

// 渲染话术列表
function renderTradeScripts(category) {
    const listElement = document.getElementById('tradeScriptList');
    listElement.innerHTML = '';
    
    // 更新分类按钮状态
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.category === category);
    });
    
    TRADE_SCRIPTS[category].forEach(script => {
        const item = document.createElement('div');
        item.className = 'script-item';
        item.innerHTML = `
            <div class="script-item-title">${script.title}</div>
            <div class="script-item-content">${script.display || script.content}</div>
        `;
        item.onclick = () => sendTradeScript(script.content);
        listElement.appendChild(item);
    });
}

// 发送话术
function sendTradeScript(content) {
    // 如果是卡片内容,显示对应的文字描述
    if(content.includes('ComponentMessage')) {
        // 设置文字描述到输入框
        document.getElementById('cont').value = content;
    } else {
        // 普通话术直接设置
        document.getElementById('cont').value = content;
    }
    comment();
    toggleTradeScriptPanel();
}

// 点击面板外部关闭
function handleTradeScriptOutsideClick(e) {
    const panel = document.querySelector('.trade-script-panel');
    const tradeScriptBtn = document.querySelector('.trade-script-btn');
    
    if (!panel.contains(e.target) && !tradeScriptBtn.contains(e.target)) {
        toggleTradeScriptPanel();
    }
}

// 添加快捷键支持
document.addEventListener('keydown', function(e) {
    if (e.altKey && e.key.toLowerCase() === 't') {
        e.preventDefault();
        toggleTradeScriptPanel();
    }
});

// 为分类按钮添加点击事件
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.onclick = () => renderTradeScripts(btn.dataset.category);
    });
});
</script>
</body>
</html>