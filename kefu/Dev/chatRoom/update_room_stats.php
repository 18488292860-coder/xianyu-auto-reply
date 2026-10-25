<?php
/**
 * 聊天室统计数据更新脚本
 * 用于更新chatroom_stats表中的统计信息
 */

function updateRoomStats($room_id, $conn = null) {
    $should_close = false;
    
    // 如果没有传入连接，创建新连接
    if (!$conn) {
        require_once 'db_config.php';
        $should_close = true;
    }
    
    $room_id_escaped = $conn->real_escape_string($room_id);
    
    try {
        // 计算消息总数
        $msg_result = $conn->query("SELECT COUNT(*) as count FROM chatroom_messages WHERE room_id = '$room_id_escaped'");
        $total_messages = 0;
        if ($msg_result) {
            $msg_data = $msg_result->fetch_assoc();
            $total_messages = intval($msg_data['count']);
        }
        
        // 计算活跃用户数（清理离线用户后统计）
        $offline_time = date('Y-m-d H:i:s', strtotime('-2 minutes'));
        $conn->query("UPDATE chatroom_users SET is_online = 0 WHERE last_active < '$offline_time'");
        
        $users_result = $conn->query("SELECT COUNT(*) as count FROM chatroom_users WHERE room_id = '$room_id_escaped' AND is_online = 1");
        $active_users = 0;
        if ($users_result) {
            $users_data = $users_result->fetch_assoc();
            $active_users = intval($users_data['count']);
        }
        
        // 更新或插入统计数据
        $now = date('Y-m-d H:i:s');
        $update_sql = "INSERT INTO chatroom_stats (room_id, total_messages, active_users, last_update) 
                       VALUES ('$room_id_escaped', $total_messages, $active_users, '$now')
                       ON DUPLICATE KEY UPDATE 
                       total_messages = $total_messages, 
                       active_users = $active_users, 
                       last_update = '$now'";
        
        $result = $conn->query($update_sql);
        
        if ($result) {
            // 同时更新chatroom_list表的last_activity
            $conn->query("UPDATE chatroom_list SET last_activity = '$now' WHERE room_id = '$room_id_escaped'");
            
            if ($should_close) {
                $conn->close();
            }
            return array(
                'success' => true,
                'total_messages' => $total_messages,
                'active_users' => $active_users
            );
        } else {
            error_log("统计数据更新失败: " . $conn->error);
            if ($should_close) {
                $conn->close();
            }
            return false;
        }
        
    } catch (Exception $e) {
        error_log("统计数据更新异常: " . $e->getMessage());
        if ($should_close) {
            $conn->close();
        }
        return false;
    }
}

// 如果直接访问此脚本，更新所有聊天室的统计数据
if (basename($_SERVER['PHP_SELF']) === 'update_room_stats.php') {
    header('Content-Type: application/json; charset=utf-8');
    
    // 引入数据库配置文件
    require_once 'db_config.php';
    
    // 获取所有活跃的聊天室
    $rooms_result = $conn->query("SELECT room_id FROM chatroom_list WHERE status = 'active'");
    $updated_rooms = array();
    
    if ($rooms_result) {
        while ($room = $rooms_result->fetch_assoc()) {
            $stats = updateRoomStats($room['room_id'], $conn);
            if ($stats && $stats['success']) {
                $updated_rooms[] = array(
                    'room_id' => $room['room_id'],
                    'total_messages' => $stats['total_messages'],
                    'active_users' => $stats['active_users']
                );
            }
        }
    }
    
    $conn->close();
    
    echo json_encode(array(
        'success' => true,
        'message' => '统计数据更新完成',
        'updated_rooms' => count($updated_rooms),
        'data' => $updated_rooms
    ));
}
?> 