<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 包含数据库连接
require_once '../../../include/conn.php';

// 确保数据库连接支持emoji (utf8mb4)
if (isset($db)) {
    $db->query("SET character_set_client = utf8mb4");
    $db->query("SET character_set_connection = utf8mb4"); 
    $db->query("SET character_set_results = utf8mb4");
    $db->query("SET collation_connection = utf8mb4_unicode_ci");
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch ($action) {
    case 'buyer_login':
        // 买家登录
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        
        if (empty($username) || empty($password)) {
            echo json_encode(array('success' => false, 'message' => '用户名和密码不能为空'));
            break;
        }
        
        try {
            // 加密输入的用户名和密码
            $encrypted_username = substr(md5(sha1(md5($username))), 3);
            $encrypted_password = substr(md5(sha1(md5($password))), 3);
            
            // 查询买家账号
            $buyer = $db->get_one("SELECT id, username, real_name, status FROM buyer_accounts 
                                  WHERE username = '$encrypted_username' AND password = '$encrypted_password'");
            
            if (!$buyer) {
                echo json_encode(array('success' => false, 'message' => '用户名或密码错误'));
                break;
            }
            
            if ($buyer['status'] != 1) {
                echo json_encode(array('success' => false, 'message' => '账号已被禁用，请联系管理员'));
                break;
            }
            
            // 更新最后登录时间
            $now = date('Y-m-d H:i:s');
            $db->query("UPDATE buyer_accounts SET last_login = '$now' WHERE id = {$buyer['id']}");
            
            // 生成用户ID（买家前缀 + 数据库ID）
            $user_id = 'buyer_' . $buyer['id'];
            $nickname = '用户_8930147321';
            
            // 设置买家会话
            $_SESSION['buyer_logged_in'] = true;
            $_SESSION['buyer_id'] = $user_id;
            $_SESSION['buyer_username'] = $nickname;
            $_SESSION['buyer_real_name'] = $buyer['real_name'];
            
            echo json_encode(array(
                'success' => true,
                'message' => '买家登录成功',
                'data' => array(
                    'user_id' => $user_id,
                    'nickname' => $nickname,
                    'real_name' => $buyer['real_name'],
                    'user_type' => 'buyer'
                )
            ));
            
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'message' => '登录失败：' . $e->getMessage()));
        }
        break;
        
    case 'admin_login':
        // 客服管理员登录
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        
        if (empty($username) || empty($password)) {
            echo json_encode(array('success' => false, 'message' => '用户名和密码不能为空'));
            break;
        }
        
        try {
            // 获取管理员配置
            $admin_config = $db->get_one("SELECT h_admin, h_pass FROM h_kefu_config LIMIT 1");
            
            if (!$admin_config) {
                echo json_encode(array('success' => false, 'message' => '未找到管理员配置'));
                break;
            }
            
            // 加密输入的用户名和密码
            $encrypted_username = substr(md5(sha1(md5($username))), 3);
            $encrypted_password = substr(md5(sha1(md5($password))), 3);
            
            $db_username = $admin_config['h_admin'];
            $db_password = $admin_config['h_pass'];
            
            // 验证用户名和密码
            if ($encrypted_username !== $db_username || $encrypted_password !== $db_password) {
                echo json_encode(array('success' => false, 'message' => '用户名或密码错误'));
                break;
            }
            
            // 使用固定的客服用户ID（与管理后台直接进入保持一致）
            $user_id = 'admin_backend';
            $nickname = '螃蟹客服-林夕';
            
            // 设置管理员会话
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user_id;
            $_SESSION['admin_username'] = $nickname;
            
            echo json_encode(array(
                'success' => true,
                'message' => '客服登录成功',
                'data' => array(
                    'user_id' => $user_id,
                    'nickname' => $nickname,
                    'user_type' => 'admin'
                )
            ));
            
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'message' => '登录失败：' . $e->getMessage()));
        }
        break;
        
    default:
        echo json_encode(array('success' => false, 'message' => '无效的操作'));
}
?> 