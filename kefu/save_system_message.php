<?php
require_once './include/conn.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : 'normal';
    $delay = isset($_POST['delay']) ? intval($_POST['delay']) : 0;

    if (empty($message)) {
        echo json_encode([
            'status' => 'error',
            'message' => '消息内容不能为空'
        ]);
        exit;
    }

    $sql = "INSERT INTO h_system_messages (message, type, delay) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db->link, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $message, $type, $delay);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'status' => 'success',
            'message' => '系统消息保存成功'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '保存失败: ' . mysqli_stmt_error($stmt)
        ]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '请求方法不正确'
    ]);
}

$db->close();
?>
