<?php
// 防止任何输出在JSON之前
ob_start();
error_reporting(0); // 禁用错误显示，防止破坏JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../error.log');

// 设置JSON响应头
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 检查请求大小是否超过post_max_size
function checkPostMaxSize() {
    $postMaxSize = ini_get('post_max_size');
    $postMaxBytes = convertToBytes($postMaxSize);
    $contentLength = isset($_SERVER['CONTENT_LENGTH']) ? (int)$_SERVER['CONTENT_LENGTH'] : 0;
    
    if ($contentLength > $postMaxBytes) {
        return false;
    }
    return true;
}

// 将PHP配置值转换为字节
function convertToBytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $num = (float) $val;
    switch($last) {
        case 'g': $num *= 1024;
        case 'm': $num *= 1024;
        case 'k': $num *= 1024;
    }
    return (int) $num;
}

$response = array('success' => false, 'message' => '', 'data' => null);

try {
    // 检查请求方法
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('只支持POST请求');
    }
    
    // 检查POST大小限制
    if (!checkPostMaxSize()) {
        $postMaxSize = ini_get('post_max_size');
        throw new Exception("请求数据超过服务器限制 ({$postMaxSize})，请联系管理员或上传较小的文件");
    }
    
    // 检查是否有POST数据
    if (empty($_POST) && empty($_FILES)) {
        throw new Exception('请求数据为空，可能文件太大或服务器配置问题');
    }
    
    // 检查文件上传错误
    if (!isset($_FILES['file'])) {
        throw new Exception('未找到上传文件');
    }
    
    $file = $_FILES['file'];
    
    // 详细的文件上传错误检查
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
            $maxSize = ini_get('upload_max_filesize');
            throw new Exception("文件超过upload_max_filesize限制 ({$maxSize})");
        case UPLOAD_ERR_FORM_SIZE:
            throw new Exception('文件超过表单MAX_FILE_SIZE限制');
        case UPLOAD_ERR_PARTIAL:
            throw new Exception('文件只上传了一部分，请重试');
        case UPLOAD_ERR_NO_FILE:
            throw new Exception('没有选择文件');
        case UPLOAD_ERR_NO_TMP_DIR:
            throw new Exception('服务器临时目录不存在');
        case UPLOAD_ERR_CANT_WRITE:
            throw new Exception('文件写入失败');
        case UPLOAD_ERR_EXTENSION:
            throw new Exception('PHP扩展阻止了文件上传');
        default:
            throw new Exception('未知的文件上传错误: ' . $file['error']);
    }
    
    // 获取参数
    $room_id = isset($_POST['room_id']) ? trim($_POST['room_id']) : '';
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
    $user_role = isset($_POST['user_role']) ? trim($_POST['user_role']) : 'guest';
    
    if (empty($room_id) || empty($user_name)) {
        throw new Exception('房间ID和用户名不能为空');
    }
    
    // 引入数据库配置文件
    require_once '../db_config.php';
    
    // 转义数据库参数
    $room_id = $conn->real_escape_string($room_id);
    $user_name = $conn->real_escape_string($user_name);
    $user_role = $conn->real_escape_string($user_role);
    
    // 检查房间是否存在
    $room_result = $conn->query("SELECT room_id FROM chatroom_list WHERE room_id = '$room_id' AND status = 'active'");
    if (!$room_result || $room_result->num_rows == 0) {
        throw new Exception('聊天室不存在或已禁用');
    }
    
    // 支持的文件类型
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'mov', 'avi', 'pdf', 'doc', 'docx', 'txt');
    
    // 验证文件类型
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_types)) {
        throw new Exception('不支持的文件类型: ' . $file_ext);
    }
    
    // 确定消息类型和对应的文件大小限制
    $message_type = 'file';
    $max_size = 10 * 1024 * 1024; // 默认10MB
    
    if (in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) {
        $message_type = 'image';
        $max_size = 10 * 1024 * 1024; // 图片：10MB
    } elseif (in_array($file_ext, array('mp4', 'webm', 'mov', 'avi'))) {
        $message_type = 'video';
        $max_size = 150 * 1024 * 1024; // 视频：150MB (提高到150MB)
    } else {
        // 其他文件类型（pdf, doc, docx, txt）
        $max_size = 10 * 1024 * 1024; // 文档：10MB
    }
    
    // 验证文件大小（根据文件类型使用不同的限制）
    if ($file['size'] > $max_size) {
        $file_type_name = $message_type == 'video' ? '视频' : ($message_type == 'image' ? '图片' : '文件');
        throw new Exception($file_type_name . '大小超过限制(' . formatBytes($max_size) . ')，当前文件大小: ' . formatBytes($file['size']));
    }
    
    // 创建上传目录
    $upload_dir = '../../../upload/chatroom/' . date('Y/m/');
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            throw new Exception('无法创建上传目录');
        }
    }
    
    // 检查目录是否可写
    if (!is_writable($upload_dir)) {
        throw new Exception('上传目录不可写');
    }
    
    // 生成文件名
    $new_filename = date('YmdHis') . '_' . uniqid() . '.' . $file_ext;
    $file_path = $upload_dir . $new_filename;
    $relative_path = 'upload/chatroom/' . date('Y/m/') . $new_filename;
    
    // 移动文件
    if (!move_uploaded_file($file['tmp_name'], $file_path)) {
        throw new Exception('文件保存失败，请检查服务器权限');
    }
    
    // 验证文件确实被保存
    if (!file_exists($file_path)) {
        throw new Exception('文件保存后验证失败');
    }
    
    // 如果是图片，生成缩略图
    $thumbnail_url = null;
    if ($message_type === 'image') {
        $thumbnail_url = generateThumbnail($file_path, $relative_path);
    }
    
    // 保存到数据库
    $now = date('Y-m-d H:i:s');
    $file_url = '/' . $relative_path;
    $file_name_escaped = $conn->real_escape_string($file['name']);
    
    // 生成user_id（与API保持一致）
    $user_id = $user_role . '_' . md5($user_name . $room_id);
    $user_id_escaped = $conn->real_escape_string($user_id);
    
    $sql = "INSERT INTO chatroom_messages 
            (user_id, room_id, user_name, user_type, message_type, content, file_name, file_size, file_url, send_time) 
            VALUES ('$user_id_escaped', '$room_id', '$user_name', '$user_role', '$message_type', '$file_url', '$file_name_escaped', '{$file['size']}', '$file_url', '$now')";
    
    if (!$conn->query($sql)) {
        error_log("文件上传-数据库保存失败: " . $conn->error);
        // 删除已上传的文件
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        throw new Exception('数据库保存失败');
    }
    
    $message_id = $conn->insert_id;
    
    // 更新用户活跃时间
    $conn->query("UPDATE chatroom_users SET last_active = '$now' WHERE room_id = '$room_id' AND user_name = '$user_name'");
    
    $response = array(
        'success' => true,
        'message' => '上传成功',
        'data' => array(
            'message_id' => $message_id,
            'file_url' => $file_url,
            'file_name' => $file['name'],
            'file_size' => $file['size'],
            'message_type' => $message_type,
            'thumbnail_url' => $thumbnail_url
        )
    );
    
    $conn->close();
    
} catch (Exception $e) {
    error_log("文件上传异常: " . $e->getMessage());
    $response['message'] = $e->getMessage();
    
    // 记录调试信息
    $debug_info = array(
        'post_max_size' => ini_get('post_max_size'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'content_length' => isset($_SERVER['CONTENT_LENGTH']) ? $_SERVER['CONTENT_LENGTH'] : 'unknown',
        'file_error' => isset($_FILES['file']['error']) ? $_FILES['file']['error'] : 'no file',
        'file_size' => isset($_FILES['file']['size']) ? $_FILES['file']['size'] : 'unknown'
    );
    error_log("上传调试信息: " . json_encode($debug_info));
}

// 清空任何意外的输出
ob_clean();

// 输出JSON响应
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;

// 格式化文件大小
function formatBytes($size, $precision = 2) {
    if ($size == 0) return '0 B';
    
    $units = array('B', 'KB', 'MB', 'GB');
    
    for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
        $size /= 1024;
    }
    
    return round($size, $precision) . ' ' . $units[$i];
}

// 生成缩略图
function generateThumbnail($original_path, $relative_path) {
    try {
        $info = getimagesize($original_path);
        if (!$info) return null;
        
        $thumb_dir = dirname($original_path) . '/thumbs/';
        if (!is_dir($thumb_dir)) {
            mkdir($thumb_dir, 0755, true);
        }
        
        $thumb_filename = 'thumb_' . basename($original_path);
        $thumb_path = $thumb_dir . $thumb_filename;
        $thumb_relative = dirname($relative_path) . '/thumbs/' . $thumb_filename;
        
        // 如果缩略图已存在，直接返回
        if (file_exists($thumb_path)) {
            return '/' . $thumb_relative;
        }
        
        $width = $info[0];
        $height = $info[1];
        $type = $info[2];
        
        // 计算缩略图尺寸
        $thumb_width = 150;
        $thumb_height = 150;
        
        if ($width > $height) {
            $thumb_height = intval($height * $thumb_width / $width);
        } else {
            $thumb_width = intval($width * $thumb_height / $height);
        }
        
        // 创建源图像
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($original_path);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($original_path);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($original_path);
                break;
            default:
                return null;
        }
        
        if (!$source) return null;
        
        // 创建缩略图
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        
        // 保持透明度
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
            imagefilledrectangle($thumb, 0, 0, $thumb_width, $thumb_height, $transparent);
        }
        
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
        
        // 保存缩略图
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumb, $thumb_path, 85);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumb, $thumb_path);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumb, $thumb_path);
                break;
        }
        
        imagedestroy($source);
        imagedestroy($thumb);
        
        return '/' . $thumb_relative;
        
    } catch (Exception $e) {
        error_log("缩略图生成失败: " . $e->getMessage());
        return null;
    }
}
?> 