<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 启用错误日志
ini_set('log_errors', 1);
ini_set('error_log', '../error.log');

// 引入统计数据更新功能
require_once '../update_room_stats.php';

// 引入数据库配置文件
require_once '../db_config.php';

/**
 * 验证聊天室是否存在且状态为active
 */
function validateChatroom($room_id, $conn) {
    if (empty($room_id)) {
        return array('success' => false, 'message' => '房间ID不能为空');
    }
    
    $room_id_escaped = $conn->real_escape_string($room_id);
    $check_sql = "SELECT id, room_id, room_name, status FROM chatroom_list WHERE room_id = '$room_id_escaped'";
    $result = $conn->query($check_sql);
    
    if (!$result) {
        error_log("聊天室验证查询失败: " . $conn->error);
        return array('success' => false, 'message' => '聊天室验证失败');
    }
    
    if ($result->num_rows == 0) {
        return array('success' => false, 'message' => '聊天室不存在', 'error_code' => 'ROOM_NOT_FOUND');
    }
    
    $room_data = $result->fetch_assoc();
    if ($room_data['status'] !== 'active') {
        return array('success' => false, 'message' => '聊天室已被禁用或删除', 'error_code' => 'ROOM_INACTIVE');
    }
    
    return array('success' => true, 'room_data' => $room_data);
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

try {
    switch ($action) {
        case 'get_users':
            // 获取在线用户列表
            $room_id = isset($_REQUEST['room_id']) ? $conn->real_escape_string($_REQUEST['room_id']) : '';
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            // 清理离线用户（45秒无活动视为离线，考虑到心跳间隔是15秒和网络延迟）
            $offline_time = date('Y-m-d H:i:s', strtotime('-45 seconds'));
            $conn->query("UPDATE chatroom_users SET is_online = 0 WHERE last_active < '$offline_time'");
            
            $result = $conn->query("SELECT user_name as nickname, user_type, last_active FROM chatroom_users WHERE is_online = 1 AND room_id = '$room_id' ORDER BY user_type DESC, last_active DESC LIMIT 10");
            
            $users = array();
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    // 设置avatar路径
                    switch($row['user_type']) {
                        case 'admin':
                            $row['avatar'] = 'images/管理.png';
                            break;
                        case 'buyer':
                            $row['avatar'] = 'images/买家.png';
                            break;
                        case 'guest':
                        case 'seller':
                        default:
                            $row['avatar'] = 'images/卖家.png';
                            break;
                    }
                    $users[] = $row;
                }
            }
            
            echo json_encode(array('success' => true, 'data' => $users));
            break;
            
        case 'get_messages':
            // 获取消息
            $room_id = isset($_REQUEST['room_id']) ? $conn->real_escape_string($_REQUEST['room_id']) : '';
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            $last_id = intval(isset($_GET['last_id']) ? $_GET['last_id'] : 0);
            $limit = min(intval(isset($_GET['limit']) ? $_GET['limit'] : 50), 100);
            
            $where = $last_id > 0 ? "WHERE room_id = '$room_id' AND id > $last_id" : "WHERE room_id = '$room_id'";
            
            $sql = "SELECT id, room_id, user_name, user_type, message_type, content, send_time, file_url, file_name
                    FROM chatroom_messages 
                    $where
                    ORDER BY send_time ASC 
                    LIMIT $limit";
            
            $result = $conn->query($sql);
            $messages = array();
            
            if ($result) {
                while ($msg = $result->fetch_assoc()) {
                    // 生成昵称（显示用）
                    if ($msg['user_type'] == 'admin') {
                        $msg['nickname'] = '螃蟹客服-林夕';
                    } elseif ($msg['user_type'] == 'buyer') {
                        $msg['nickname'] = '用户_8930147321';
                    } else {
                        // 卖家/访客用户也使用统一的昵称格式
                        $msg['nickname'] = '用户_3d74_9049';
                    }
                    
                    // 设置avatar路径
                    switch($msg['user_type']) {
                        case 'admin':
                            $msg['avatar'] = 'images/管理.png';
                            break;
                        case 'buyer':
                            $msg['avatar'] = 'images/买家.png';
                            break;
                        case 'guest':
                        case 'seller':
                        default:
                            $msg['avatar'] = 'images/卖家.png';
                            break;
                    }
                    
                    // 获取已读状态
                    $msg_id = $msg['id'];
                    $msg_user_name = $msg['user_name'];
                    
                    // 获取已读人数
                    $read_result = $conn->query("SELECT COUNT(*) as count FROM chatroom_message_reads WHERE message_id = $msg_id AND room_id = '$room_id'");
                    $read_count = 0;
                    if ($read_result) {
                        $read_data = $read_result->fetch_assoc();
                        $read_count = intval($read_data['count']);
                    }
                    
                    // 获取在线人数（排除发送者自己）
                    $total_result = $conn->query("SELECT COUNT(*) as count FROM chatroom_users WHERE is_online = 1 AND room_id = '$room_id' AND user_name != '$msg_user_name'");
                    $total_count = 0;
                    if ($total_result) {
                        $total_data = $total_result->fetch_assoc();
                        $total_count = intval($total_data['count']);
                    }
                    
                    $msg['read_status'] = array(
                        'read_count' => $read_count,
                        'total_count' => $total_count
                    );
                    
                    $messages[] = $msg;
                }
            }
            
            echo json_encode(array('success' => true, 'data' => $messages));
            break;
            
        case 'send_message':
            // 发送消息
            $room_id = isset($_POST['room_id']) ? $conn->real_escape_string($_POST['room_id']) : '';
            $user_name = isset($_POST['user_name']) ? $conn->real_escape_string($_POST['user_name']) : '';
            $user_role = isset($_POST['user_role']) ? $conn->real_escape_string($_POST['user_role']) : 'guest';
            $content = trim(isset($_POST['content']) ? $_POST['content'] : '');
            $message_type = isset($_POST['message_type']) ? $_POST['message_type'] : 'text';
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            // 验证用户角色，确保只有有效的ENUM值
            $valid_roles = array('admin', 'buyer', 'seller', 'guest');
            if (!in_array($user_role, $valid_roles)) {
                $user_role = 'guest'; // 默认为guest
            }
            
            if (empty($user_name) || empty($content)) {
                echo json_encode(array('success' => false, 'message' => '参数不完整'));
                break;
            }
            
            $now = date('Y-m-d H:i:s');
            $content_escaped = $conn->real_escape_string($content);
            
            // 生成user_id（基于用户名和类型）
            $user_id = $user_role . '_' . md5($user_name . $room_id);
            $user_id_escaped = $conn->real_escape_string($user_id);
            
            // 插入消息（包含user_id字段）
            $sql = "INSERT INTO chatroom_messages (user_id, room_id, user_name, user_type, message_type, content, send_time) 
                    VALUES ('$user_id_escaped', '$room_id', '$user_name', '$user_role', '$message_type', '$content_escaped', '$now')";
                    
            if ($conn->query($sql)) {
                $message_id = $conn->insert_id;
                
                // 更新用户活跃时间
                $conn->query("UPDATE chatroom_users SET last_active = '$now' WHERE room_id = '$room_id' AND user_name = '$user_name'");
                
                // 更新聊天室统计数据
                updateRoomStats($room_id, $conn);
                
                echo json_encode(array('success' => true, 'message' => '发送成功', 'data' => array('message_id' => $message_id)));
            } else {
                error_log("发送消息失败: " . $conn->error);
                echo json_encode(array('success' => false, 'message' => '发送失败: ' . $conn->error));
            }
            break;
            
        case 'heartbeat':
            // 心跳
            $room_id = isset($_POST['room_id']) ? $conn->real_escape_string($_POST['room_id']) : '';
            $user_name = isset($_POST['user_name']) ? $conn->real_escape_string($_POST['user_name']) : '';
            $user_role = isset($_POST['user_role']) ? $conn->real_escape_string($_POST['user_role']) : 'guest';
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            // 验证用户角色，确保只有有效的ENUM值
            $valid_roles = array('admin', 'buyer', 'seller', 'guest');
            if (!in_array($user_role, $valid_roles)) {
                $user_role = 'guest'; // 默认为guest
            }
            
            if (empty($user_name)) {
                echo json_encode(array('success' => false, 'message' => '参数不完整'));
                break;
            }
            
            $now = date('Y-m-d H:i:s');
            
            // 生成user_id（与send_message保持一致）
            $user_id = $user_role . '_' . md5($user_name . $room_id);
            $user_id_escaped = $conn->real_escape_string($user_id);
            
            // 生成昵称
            if ($user_role == 'admin') {
                $nickname = '螃蟹客服-林夕';
            } elseif ($user_role == 'buyer') {
                $nickname = '用户_8930147321';
            } else {
                // 卖家/访客用户也使用统一的昵称格式
                $nickname = '用户_3d74_9049';
            }
            
            // 先检查chatroom_users表是否有user_id字段
            $check_columns = $conn->query("SHOW COLUMNS FROM chatroom_users LIKE 'user_id'");
            if ($check_columns && $check_columns->num_rows > 0) {
                // 如果有user_id字段，包含它和nickname
                $sql = "INSERT INTO chatroom_users (user_id, room_id, user_name, user_type, nickname, last_active, is_online) 
                        VALUES ('$user_id_escaped', '$room_id', '$user_name', '$user_role', '$nickname', '$now', 1)
                        ON DUPLICATE KEY UPDATE user_type='$user_role', nickname='$nickname', last_active='$now', is_online=1";
            } else {
                // 如果没有user_id字段，使用原来的SQL
                $sql = "INSERT INTO chatroom_users (room_id, user_name, user_type, last_active, is_online) 
                        VALUES ('$room_id', '$user_name', '$user_role', '$now', 1)
                        ON DUPLICATE KEY UPDATE user_type='$user_role', last_active='$now', is_online=1";
            }
                    
            if ($conn->query($sql)) {
                // 更新聊天室统计数据（用户上线/下线会影响活跃用户数）
                updateRoomStats($room_id, $conn);
                
                echo json_encode(array('success' => true, 'message' => '心跳成功'));
            } else {
                error_log("心跳失败: " . $conn->error);
                echo json_encode(array('success' => false, 'message' => '心跳失败: ' . $conn->error));
            }
            break;
            
        case 'leave':
            // 离开
            $room_id = isset($_POST['room_id']) ? $conn->real_escape_string($_POST['room_id']) : '';
            $user_name = isset($_POST['user_name']) ? $conn->real_escape_string($_POST['user_name']) : '';
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            if (empty($user_name)) {
                echo json_encode(array('success' => false, 'message' => '参数不完整'));
                break;
            }
            
            // 基于user_name和room_id更新离线状态
            if ($conn->query("UPDATE chatroom_users SET is_online = 0 WHERE room_id = '$room_id' AND user_name = '$user_name'")) {
                // 更新聊天室统计数据（用户离线会影响活跃用户数）
                updateRoomStats($room_id, $conn);
                
                echo json_encode(array('success' => true, 'message' => '离开成功'));
            } else {
                error_log("离开失败: " . $conn->error);
                echo json_encode(array('success' => false, 'message' => '离开失败: ' . $conn->error));
            }
            break;
            
        case 'mark_read':
            // 标记消息已读
            $room_id = isset($_POST['room_id']) ? $conn->real_escape_string($_POST['room_id']) : '';
            $user_name = isset($_POST['user_name']) ? $conn->real_escape_string($_POST['user_name']) : '';
            $user_role = isset($_POST['user_role']) ? $conn->real_escape_string($_POST['user_role']) : 'guest';
            $message_id = intval(isset($_POST['message_id']) ? $_POST['message_id'] : 0);
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            // 验证用户角色，确保只有有效的ENUM值
            $valid_roles = array('admin', 'buyer', 'seller', 'guest');
            if (!in_array($user_role, $valid_roles)) {
                $user_role = 'guest'; // 默认为guest
            }
            
            if (empty($user_name) || $message_id <= 0) {
                echo json_encode(array('success' => false, 'message' => '参数不完整'));
                break;
            }
            
            $now = date('Y-m-d H:i:s');
            
            // 检查是否已读
            $result = $conn->query("SELECT id FROM chatroom_message_reads WHERE message_id = $message_id AND room_id = '$room_id' AND user_name = '$user_name'");
            
            if (!$result || $result->num_rows == 0) {
                // 生成user_id（与其他操作保持一致）
                $user_id = $user_role . '_' . md5($user_name . $room_id);
                $user_id_escaped = $conn->real_escape_string($user_id);
                
                $sql = "INSERT INTO chatroom_message_reads (message_id, room_id, user_id, user_name, read_time) 
                        VALUES ($message_id, '$room_id', '$user_id_escaped', '$user_name', '$now')";
                        
                if ($conn->query($sql)) {
                    echo json_encode(array('success' => true, 'message' => '标记成功'));
                } else {
                    error_log("标记已读失败: " . $conn->error);
                    echo json_encode(array('success' => false, 'message' => '标记失败: ' . $conn->error));
                }
            } else {
                echo json_encode(array('success' => true, 'message' => '已标记'));
            }
            break;
            
        case 'check_room_status':
            // 检查聊天室状态
            $room_id = isset($_REQUEST['room_id']) ? $conn->real_escape_string($_REQUEST['room_id']) : '';
            
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
            } else {
                echo json_encode(array(
                    'success' => true, 
                    'message' => '聊天室可用',
                    'room_data' => $validation['room_data']
                ));
            }
            break;
            
        case 'delete_message':
            // 删除消息（仅官方角色可删除自己的消息）
            $room_id = isset($_POST['room_id']) ? $conn->real_escape_string($_POST['room_id']) : '';
            $user_name = isset($_POST['user_name']) ? $conn->real_escape_string($_POST['user_name']) : '';
            $user_role = isset($_POST['user_role']) ? $conn->real_escape_string($_POST['user_role']) : '';
            $message_id = intval(isset($_POST['message_id']) ? $_POST['message_id'] : 0);
            
            // 验证聊天室
            $validation = validateChatroom($room_id, $conn);
            if (!$validation['success']) {
                echo json_encode($validation);
                break;
            }
            
            // 验证参数
            if (empty($user_name) || $message_id <= 0) {
                echo json_encode(array('success' => false, 'message' => '参数不完整'));
                break;
            }
            
            // 验证用户角色：只有官方(admin)角色可以删除消息
            if ($user_role !== 'admin') {
                echo json_encode(array('success' => false, 'message' => '权限不足，只有官方角色可以撤回消息'));
                break;
            }
            
            // 查询消息是否存在（官方角色可以删除任何角色的消息）
            $check_sql = "SELECT id, user_name, user_type FROM chatroom_messages 
                         WHERE id = $message_id AND room_id = '$room_id'";
            $check_result = $conn->query($check_sql);
            
            if (!$check_result || $check_result->num_rows == 0) {
                echo json_encode(array('success' => false, 'message' => '消息不存在或无权删除'));
                break;
            }
            
            // 开始事务
            $conn->autocommit(false);
            
            try {
                // 删除消息的已读记录
                $delete_reads_sql = "DELETE FROM chatroom_message_reads WHERE message_id = $message_id AND room_id = '$room_id'";
                $conn->query($delete_reads_sql);
                
                // 删除消息（官方角色可以删除任何用户的消息）
                $delete_message_sql = "DELETE FROM chatroom_messages WHERE id = $message_id AND room_id = '$room_id'";
                $delete_result = $conn->query($delete_message_sql);
                
                if ($delete_result && $conn->affected_rows > 0) {
                    // 提交事务
                    $conn->commit();
                    
                    // 更新聊天室统计数据
                    updateRoomStats($room_id, $conn);
                    
                    echo json_encode(array(
                        'success' => true, 
                        'message' => '消息删除成功',
                        'deleted_message_id' => $message_id
                    ));
                } else {
                    // 回滚事务
                    $conn->rollback();
                    echo json_encode(array('success' => false, 'message' => '删除失败，消息可能已不存在'));
                }
                
            } catch (Exception $e) {
                // 回滚事务
                $conn->rollback();
                error_log("删除消息异常: " . $e->getMessage());
                echo json_encode(array('success' => false, 'message' => '删除失败: ' . $e->getMessage()));
            }
            
            // 恢复自动提交
            $conn->autocommit(true);
            break;
            
        default:
            echo json_encode(array('success' => false, 'message' => '无效的操作'));
    }
    
} catch (Exception $e) {
    error_log("API异常: " . $e->getMessage());
    echo json_encode(array('success' => false, 'message' => 'API异常: ' . $e->getMessage()));
}

$conn->close();
?> 