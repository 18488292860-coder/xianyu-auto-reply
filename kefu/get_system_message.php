<?php
require_once './include/conn.php';

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    $sql = "SELECT message, delay FROM h_system_messages WHERE type = ? ORDER BY id DESC LIMIT 1";
    $stmt = mysqli_prepare($db->link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'status' => 'success',
            'message' => $row['message'],
            'delay' => $row['delay']
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '未找到对应的系统消息'
        ]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '缺少必要参数'
    ]);
}

$db->close();
?>
