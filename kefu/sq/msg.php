<?php
require_once '../include/conn.php';
require_once 'header.php';
require_once 'pager.php';

// 初始化变量
$rs_list = array();
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_input = isset($_GET['page_input']) ? intval($_GET['page_input']) : 0;
$clause = isset($_GET['clause']) ? $_GET['clause'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 处理删除操作
if($clause === 'delinfo') {
    try {
        if(!$id) {
            throw new Exception('Invalid ID');
        }
        
        $id = intval($id);
        $query = "DELETE FROM `h_kefu` WHERE id = {$id}";
        $result = $db->query($query);
        
        if($result) {
            header("Location: ?");
            exit;
        } else {
            throw new Exception('Delete failed');
        }
    } catch (Exception $e) {
        error_log("Delete error: " . $e->getMessage());
        header("Location: ?error=1");
        exit;
    }
}

// 获取数据
try {
    $total_count = $db->counter('h_kefu', 'id');
    $list_num = 30;
    
    if($page_input) {
        $page = $page_input;
    }
    
    $rowset = new Pager($total_count, $list_num, $page);
    $from_record = $rowset->_offset();
    
    $query = "SELECT * FROM `h_kefu` ORDER BY h_addTime DESC, id DESC LIMIT {$from_record}, {$list_num}";
    $result = $db->query($query);
    
    while($list = $db->fetch_array($result)) {
        $rs_list[] = $list;
    }

    $page_list = $rowset->link(GetUrl(2) . "?page=");
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    $error_message = "数据加载出错，请稍后重试";
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>消息列表</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/layui/2.8.3/css/layui.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/1layui.css"/>
    <style>
        :root {
            --primary-color: #409EFF;
            --success-color: #67c23a;
            --danger-color: #f56c6c;
            --warning-color: #e6a23c;
            --info-color: #909399;
        }

        /* 整体布局优化 */
        .layui-fluid {
            background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fc 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .layui-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px 1px rgba(0,0,0,.05);
            margin-bottom: 20px;
            background: #fff;
            border: none;
            transition: transform 0.3s ease;
        }
        
        .layui-card:hover {
            transform: translateY(-2px);
        }

        .layui-card-header {
            height: 70px;
            padding: 0 25px;
            border-bottom: 1px solid rgba(0,0,0,.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 12px 12px 0 0;
        }

        .header-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title i {
            font-size: 24px;
            color: var(--primary-color);
            background: rgba(64, 158, 255, 0.1);
            padding: 10px;
            border-radius: 8px;
        }

        .header-extra .layui-badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
        }

        /* 表格样式优化 */
        .layui-table {
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,.02);
            table-layout: fixed;
            width: 100%;
        }

        .layui-table thead tr {
            background: #f8f9fa;
        }

        .layui-table th {
            font-weight: 600;
            color: #2c3e50;
            padding: 16px;
            font-size: 14px;
            word-break: break-all;
            overflow: hidden;
        }

        .layui-table td {
            padding: 16px;
            vertical-align: middle;
            word-break: break-all;
            overflow: hidden;
        }

        .message-content {
            max-width: none;
            padding-left: 25px;
            white-space: normal;
            word-break: break-all;
            line-height: 1.6;
        }

        .message-content:before {
            content: '\f4ad';
            font-family: 'Font Awesome 6 Free';
            position: absolute;
            left: 0;
            color: var(--primary-color);
            opacity: 0.7;
        }

        /* 用户标签样式 */
        .user-tag {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .user-tag.user {
            background-color: rgba(103, 194, 58, 0.1);
            color: var(--success-color);
        }

        .user-tag.admin {
            background-color: rgba(64, 158, 255, 0.1);
            color: var(--primary-color);
        }

        .user-tag i {
            font-size: 14px;
        }

        /* 操作按钮样式 */
        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .delete-btn {
            background-color: rgba(245, 108, 108, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(245, 108, 108, 0.2);
        }

        .delete-btn:hover {
            background-color: var(--danger-color);
            color: #fff;
            transform: translateY(-1px);
        }

        /* 时间和IP样式 */
        .time-col {
            color: var(--info-color);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ip-col {
            font-family: 'SF Mono', monospace;
            color: var(--info-color);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* 响应式优化 */
        @media screen and (max-width: 768px) {
            .layui-fluid {
                padding: 10px;
            }

            .layui-card-header {
                padding: 0 15px;
                height: 60px;
            }

            .header-title {
                font-size: 16px;
            }

            .header-title i {
                font-size: 18px;
                padding: 8px;
            }

            .mobile-hide {
                display: none;
            }

            .message-content {
                max-width: 180px;
                font-size: 13px;
            }

            .layui-table td, .layui-table th {
                padding: 12px 8px;
            }

            .action-btn {
                padding: 6px 12px;
            }

            .user-tag {
                padding: 4px 8px;
                font-size: 12px;
            }
        }

        /* 动画效果 */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .layui-table tbody tr {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* 空状态样式 */
        .empty-state {
            text-align: center;
            padding: 40px 0;
            color: var(--info-color);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* 表格列宽控制 */
        .layui-table {
            table-layout: fixed;
            width: 100%;
        }

        .layui-table th,
        .layui-table td {
            word-break: break-all;
            overflow: hidden;
        }

        /* 各列宽度定义 */
        .col-user {
            width: 15%;
        }

        .col-content {
            width: 35%;
        }

        .col-sender {
            width: 10%;
        }

        .col-ip {
            width: 15%;
        }

        .col-time {
            width: 15%;
        }

        .col-action {
            width: 10%;
        }

        /* 消息内容样式优化 */
        .message-content {
            max-width: none;
            padding-left: 25px;
            white-space: normal;
            word-break: break-all;
            line-height: 1.6;
        }

        /* 移动端适配 */
        @media screen and (max-width: 768px) {
            .col-user {
                width: 20%;
            }

            .col-content {
                width: 40%;
            }

            .col-sender {
                width: 15%;
            }

            .col-time {
                width: 15%;
            }

            .col-action {
                width: 10%;
            }
        }
    </style>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <div class="header-title">
                <i class="fas fa-comments-alt"></i>
                <span>聊天记录管理</span>
            </div>
            <div class="header-extra">
                <span class="layui-badge layui-bg-blue">
                    <i class="fas fa-list-alt"></i>
                    总记录：<?php echo isset($total_count) ? $total_count : 0; ?>
                </span>
            </div>
        </div>
        <div class="layui-card-body">
            <?php if(isset($error_message)): ?>
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php elseif(!empty($rs_list)): ?>
            <table class="layui-table" lay-size="lg">
                <thead>
                    <tr>
                        <th class="col-user"><i class="fas fa-user"></i> </th>
                        <!--访客账号-->
                        <th class="col-content"><i class="fas fa-comment-dots"></i> </th>
                        <!--聊天内容-->
                        <th class="col-sender"><i class="fas fa-user-tag"></i> </th>
                        <!--发送者-->
                        <th class="col-ip mobile-hide"><i class="fas fa-network-wired"></i> </th>
                        <!--发送者IP-->
                        <th class="col-time"><i class="fas fa-clock"></i> </th>
                        <!--发送时间-->
                        <th class="col-action"><i class="fas fa-cog"></i> </th>
                        <!--操作-->
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rs_list as $val): 
                    $pop = ($val['h_who'] == 1) ? '' : '';
                    // 两个空分别是用户和客服
                    $tagClass = ($val['h_who'] == 1) ? 'user' : 'admin';
                    $tagIcon = ($val['h_who'] == 1) ? 'fa-user' : 'fa-headset';
                ?>     
                    <tr>
                        <td class="col-user">
                            <i class="fas fa-user-circle"></i> 
                            <?php echo htmlspecialchars(isset($val['h_user']) ? $val['h_user'] : ''); ?>
                        </td>
                        <td class="col-content">
                            <div class="message-content">
                                <?php echo htmlspecialchars(isset($val['h_content']) ? $val['h_content'] : ''); ?>
                            </div>
                        </td>
                        <td class="col-sender">
                            <span class="user-tag <?php echo $tagClass; ?>">
                                <i class="fas <?php echo $tagIcon; ?>"></i>
                                <?php echo $pop; ?>
                            </span>
                        </td>
                        <td class="col-ip mobile-hide">
                            <i class="fas fa-globe"></i>
                            <?php echo htmlspecialchars(isset($val['h_actIP']) ? $val['h_actIP'] : ''); ?>
                        </td>
                        <td class="col-time">
                            <i class="far fa-clock"></i>
                            <?php echo isset($val['h_addTime']) ? $val['h_addTime'] : ''; ?>
                        </td>
                        <td class="col-action">
                            <a href="javascript:;" class="action-btn delete-btn" onclick="confirmDelete(<?php echo intval($val['id']); ?>)">
                                <i class="fas fa-trash-alt"></i>
                                <span></span>
                                <!--删除-->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>暂无聊天记录</p>
            </div>
            <?php endif; ?>
            
            <?php if(!empty($rs_list) && isset($page_list)): ?>
            <div class="layui-box layui-laypage layui-laypage-default">
                <?php echo $page_list; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.staticfile.org/layui/2.8.3/layui.js"></script>
<script>
layui.use(['layer'], function(){
    var layer = layui.layer;
    <?php if(isset($_GET['error'])): ?>
    layer.msg('操作失败，请重试', {icon: 2});
    <?php endif; ?>
});

function confirmDelete(id) {
    layer.confirm('确定要删除这条记录吗？', {
        title: '<i class="fas fa-exclamation-triangle"></i> 删除确认',
        btn: ['<i class="fas fa-check"></i> 确定删除','<i class="fas fa-times"></i> 取消'],
        icon: 0,
        skin: 'layui-layer-admin',
        anim: 6,
        btnAlign: 'c',
        shade: 0.1
    }, function(){
        window.location.href = '?clause=delinfo&id=' + id;
    });
}
</script>
</body>
</html>