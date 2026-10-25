<?php
// 增强版IP用户绑定辅助函数

/**
 * 获取用户真实IP地址
 */
function getRealIpAddr() {
    // 检查是否在命令行环境中运行
    if (php_sapi_name() === 'cli') {
        return '127.0.0.1'; // 命令行环境返回本地IP
    }
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   // 检查是否来自代理
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // 检查是否来自远程代理
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = '127.0.0.1'; // 默认本地IP
    }
    return $ip;
}

/**
 * 生成设备指纹
 */
function generateDeviceFingerprint() {
    $fingerprint_data = array();
    
    // User-Agent
    $fingerprint_data[] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    
    // Accept Language
    $fingerprint_data[] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
    
    // Accept Encoding
    $fingerprint_data[] = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '';
    
    // Accept
    $fingerprint_data[] = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
    
    // 组合所有指纹数据并生成短hash
    $combined = implode('|', $fingerprint_data);
    return substr(md5($combined), 0, 8);
}

/**
 * 为设备生成用户名
 */
function generateUserNameFromDevice($ip, $room_id, $device_fingerprint) {
    // 使用IP地址的最后一段作为用户标识
    $ip_parts = explode('.', $ip);
    $last_octet = end($ip_parts);
    
    // 生成简短的房间标识
    $room_suffix = substr(md5($room_id), 0, 4);
    
    // 使用设备指纹的前4位作为设备标识
    $device_suffix = substr($device_fingerprint, 0, 4);
    
    return "用户_" . $last_octet . $device_suffix . $room_suffix;
}

/**
 * 获取或创建增强版IP设备用户绑定
 */
function getOrCreateEnhancedIPUserBinding($room_id, $conn) {
    $ip = getRealIpAddr();
    $device_fingerprint = generateDeviceFingerprint();
    
    $ip_escaped = $conn->real_escape_string($ip);
    $room_id_escaped = $conn->real_escape_string($room_id);
    $device_fingerprint_escaped = $conn->real_escape_string($device_fingerprint);
    
    // 检查是否已存在绑定（基于IP+设备指纹+房间）
    $check_sql = "SELECT id, room_id, ip_address, device_fingerprint, user_name, user_type, created_time, last_access_time 
                  FROM ip_user_binding 
                  WHERE room_id = '$room_id_escaped' AND ip_address = '$ip_escaped' AND device_fingerprint = '$device_fingerprint_escaped'";
    $result = $conn->query($check_sql);
    
    if (!$result) {
        error_log("增强IP绑定查询失败: " . $conn->error);
        return null;
    }
    
    if ($result->num_rows > 0) {
        // 已存在绑定，更新最后访问时间
        $binding = $result->fetch_assoc();
        $result->free(); // 释放结果集
        
        $update_sql = "UPDATE ip_user_binding SET last_access_time = NOW() WHERE id = " . $binding['id'];
        $update_result = $conn->query($update_sql);
        if (!$update_result) {
            error_log("更新访问时间失败: " . $conn->error);
        }
        
        return $binding;
    } else {
        $result->free(); // 释放结果集
        
        // 创建新绑定
        $user_name = generateUserNameFromDevice($ip, $room_id, $device_fingerprint);
        $user_name_escaped = $conn->real_escape_string($user_name);
        
        $insert_sql = "INSERT INTO ip_user_binding (room_id, ip_address, device_fingerprint, user_name, user_type, created_time, last_access_time) 
                       VALUES ('$room_id_escaped', '$ip_escaped', '$device_fingerprint_escaped', '$user_name_escaped', 'guest', NOW(), NOW())";
        
        if ($conn->query($insert_sql)) {
            return [
                'id' => $conn->insert_id,
                'room_id' => $room_id,
                'ip_address' => $ip,
                'device_fingerprint' => $device_fingerprint,
                'user_name' => $user_name,
                'user_type' => 'guest',
                'created_time' => date('Y-m-d H:i:s'),
                'last_access_time' => date('Y-m-d H:i:s')
            ];
        } else {
            error_log("创建增强IP绑定失败: " . $conn->error);
        }
    }
    
    return null;
}

/**
 * 检查房间是否存在
 */
function checkRoomExists($room_id, $conn) {
    $room_id_escaped = $conn->real_escape_string($room_id);
    // 只选择必要的字段，避免JSON类型字段导致的类型245错误
    $sql = "SELECT room_id FROM chatroom_list WHERE room_id = '$room_id_escaped' AND status = 'active'";
    $result = $conn->query($sql);
    
    if (!$result) {
        error_log("房间检查查询失败: " . $conn->error);
        return false;
    }
    
    $exists = $result->num_rows > 0;
    $result->free(); // 释放结果集
    return $exists;
}

/**
 * 显示设备信息（调试用）
 */
function getDeviceInfo() {
    return array(
        'ip' => getRealIpAddr(),
        'device_fingerprint' => generateDeviceFingerprint(),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
        'accept_language' => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '',
        'accept_encoding' => isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : ''
    );
}
?> 