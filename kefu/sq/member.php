<?php
require_once '../include/conn.php';
require_once 'header.php';
require_once 'pager.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>访客列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/css/1layui.css">
    <style>

        :root {
            --primary-color: #4C6FFF;
            --secondary-color: #6C8FFF;
            --bg-color: #F4F6F9;
            --text-color: #2D3436;
            --text-secondary: #636E72;
            --border-color: #EDF2F7;
            --card-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            --hover-bg: rgba(76, 111, 255, 0.08);
            --danger-color: #EF4444;
            --success-color: #22C55E;
        }

        body {
            background: var(--bg-color);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--text-color);
            margin: 0;
            padding: 20px;
        }

        .wrapper-md {
            max-width: 1200px;
            margin: 0 auto;
        }

        .panel {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .panel-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
        }

        .layui-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background-color: #fff;
        }

        .layui-table th,
        .layui-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .layui-table th {
            background: var(--bg-color);
            font-weight: 600;
            color: var(--text-color);
        }

        .layui-table tr:hover {
            background: var(--hover-bg);
        }

        /* 状态标签样式 */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-online {
            background: rgba(34, 197, 94, 0.1);
            color: var(--success-color);
        }

        .status-offline {
            background: rgba(99, 110, 114, 0.1);
            color: var(--text-secondary);
        }

        .status-hidden {
            background: rgba(76, 111, 255, 0.1);
            color: var(--primary-color);
        }

        /* 操作按钮样式 */
        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .btn-danger:hover {
            background: var(--danger-color);
            color: white;
            transform: translateY(-2px);
        }

        /* 分页样式 */
        .page {
            padding: 20px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .page a,
        .page span {
            padding: 8px 16px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .page a:hover {
            background: var(--hover-bg);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .page span {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* 空状态样式 */
        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: var(--border-color);
        }

        /* 动画效果 */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .panel {
            animation: fadeIn 0.3s ease-out;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .wrapper-md {
                padding: 10px;
            }

            .layui-table th,
            .layui-table td {
                padding: 12px;
            }

            .btn {
                padding: 4px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper-md control">
        <div class="panel panel-default">
            <div class="panel-header">
                <h2 class="panel-title">访客列表</h2>
            </div>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>访客账号</th>
                        <th>状态</th>
                        <th>浏览页面次数</th>
                        <th>最后登录IP</th>
                        <th>最后离线时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_count = $db->counter('h_kefu_status', 'id');
                    $list_num = 30;
                    $page = (int)$page;
                    if($page_input){$page=$page_input;}
                    $rowset = new Pager($total_count,$list_num,$page);
                    $from_record = $rowset->_offset();
                    $query = "select * from `h_kefu_status` order by h_addTime desc,id desc limit $from_record, $list_num";
                    $result = $db->query($query);
                    while($list = $db->fetch_array($result)) {
                        $rs_list[]=$list;
                    }

                    $page_list = $rowset->link(GetUrl(2) . "?page=");
                    
                    if(count($rs_list) > 0) {   
                        foreach ($rs_list as $key=>$val) {
                            $date_1 = date("Y-m-d H:i:s"); 
                            $date_2 = $val['h_addTime'];
                            $time=ceil(strtotime($date_1)-strtotime($date_2));
                            
                            // 设置状态样式类
                            $statusClass = 'status-offline';
                            $status = '离线';
                            
                            if($time <= 3) {
                                if($val['h_status'] == 1) {
                                    $status = '正在会话';
                                    $statusClass = 'status-online';
                                } else if($val['h_status'] == 2) {
                                    $status = '隐藏窗口';
                                    $statusClass = 'status-hidden';
                                }
                            }
                    ?>     
                        <tr>
                            <td><?php echo $val['h_user']; ?></td>
                            <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                            <td><?php echo $val['h_logins']; ?></td>
                            <td><?php echo $val['h_actIP']; ?></td>
                            <td><?php echo $val['h_addTime']; ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="hintandturn('确定要删除吗？对应聊天内容也将同时删除！','?clause=delinfo&id=<?php echo $val['id']; ?>&user=<?php echo $val['h_user']; ?>',true);">
                                    <i class="fas fa-trash-alt"></i>
                                <!--删除图标-->
                                </button>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="6"><div class="empty-state"><i class="fas fa-users"></i><p>暂无访客记录</p></div></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php if(count($rs_list) > 0) echo "<div class=\"page\">{$page_list}</div>";?>
        </div>
    </div>

    <?php  
    if($clause == 'delinfo'){delinfo();}

    function delinfo() {
        global $db,$id,$user;

        $query = "delete from `h_kefu_status` where id = $id";
        $db->query($query);
        
        $sql = "select * from `h_kefu` where h_user = '" . $user . "' ";
        $query1 = $db->query($sql);
        while($rs1 = $db->fetch_array($query1)){
            $query2 = "delete from `h_kefu` where id = '{$rs1['id']}'";
            $db->query($query2);
        }
        
        echo("<script type='text/javascript'> location.href='?'; </script>");
        exit;
    }
    ?>
    <script src="/js/jquery.min.js"></script>
    <script>
        // 添加表格行动画
        document.querySelectorAll('tr').forEach(tr => {
            tr.style.animation = 'fadeIn 0.3s ease-out';
        });

        // 自动刷新
        setInterval(function () {
            $(".panel").load(location.href + " .panel > *");
        }, 1500);
    
        // 确认删除
        function hintandturn(str, url, torf) {
            if(confirm(str) && torf) {
                window.location = url;
                return true;
            }
            return false;
        }

        // 添加表格行悬浮效果
        document.querySelectorAll('tr').forEach(tr => {
            tr.addEventListener('mouseenter', () => {
                tr.style.transform = 'translateX(5px)';
                tr.style.transition = 'all 0.3s';
            });
            
            tr.addEventListener('mouseleave', () => {
                tr.style.transform = '';
            });
        });
    </script>
</body>
</html>