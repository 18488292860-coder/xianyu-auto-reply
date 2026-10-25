<?php
require_once '../include/conn.php';
require_once 'header.php';
$webkefu = $db->get_one("SELECT * FROM `h_kefu_config`");
$xs = $db->get_one("SELECT qq,mc,gg FROM bxs");
$qq = $xs["qq"];
$mc = $xs["mc"];
$gg = $xs["gg"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>聊天窗口</title>
  <link rel="stylesheet" href="/css/1layui.css" /> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <style>
        :root {
            --primary: #4318FF;
            --primary-light: #6C5DD3;
            --bg: #F4F7FE;
            --card-bg: #ffffff;
            --text: #2B3674;
            --text-light: #A3AED0;
            --success: #05CD99;
            --warning: #FFB547;
            --danger: #EE5D50;
            --border: #E9EDF7;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --max-width: 800px;
            --mobile-padding: 12px;
        }

        body {
            background: var(--bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text);
            padding: 20px;
            margin: 0;
        }

        .service {
            max-width: 900px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }

        .title i {
            color: var(--primary);
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(5, 205, 153, 0.1);
            border-radius: 20px;
            font-size: 13px;
            color: var(--success);
        }

        .status-badge i {
            font-size: 8px;
        }

        .user-box {
            padding: 16px;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .user-list {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 12px;
            background: #fff;
            transition: all 0.2s;
            border: 1px solid var(--border);
            text-decoration: none;
            cursor: pointer;
        }

        .user-list:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--primary-light);
        }

        .user-list img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            margin-right: 12px;
        }

        .user {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .name {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            margin-bottom: 4px;
            min-width: 0;
            overflow: hidden;
        }

        .name > span:first-child {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .ison {
            flex-shrink: 0;
        }

        .ison.online {
            background: rgba(5, 205, 153, 0.1);
            color: var(--success);
        }

        .ison.offline {
            background: rgba(163, 174, 208, 0.1);
            color: var(--text-light);
        }

        .ison.hidden {
            background: rgba(255, 181, 71, 0.1);
            color: var(--warning);
        }

        .last-msg {
            font-size: 13px;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            padding-right: 8px;
        }

        .data {
            text-align: right;
            margin-left: 12px;
        }

        .time {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            padding: 0 6px;
            border-radius: 9px;
            background: var(--primary);
            color: #fff;
            font-size: 12px;
        }

        .foot {
            padding: 16px;
            border-top: 1px solid var(--border);
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .action-btn {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 10px;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid var(--border);
            cursor: pointer;
        }

        .action-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 32px;
            color: var(--primary-light);
            margin-bottom: 12px;
        }

      
        .user-box::-webkit-scrollbar {
            width: 4px;
        }

        .user-box::-webkit-scrollbar-track {
            background: transparent;
        }

        .user-box::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 2px;
        }

        .user-box::-webkit-scrollbar-thumb:hover {
            background: var(--text-light);
        }

       
        a {
            text-decoration: none;
        }

       
        .user-list {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 12px;
            background: #fff;
            transition: all 0.2s;
            border: 1px solid var(--border);
            text-decoration: none;
            cursor: pointer;
        }

       
        .action-btn {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 10px;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid var(--border);
            cursor: pointer;
        }

      
        .page-link {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 12px;
            border-radius: 6px;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            transition: all 0.2s;
            border: 1px solid var(--border);
        }

       
        a, a:hover, a:visited, a:active {
            color: inherit;
        }

     
        .user img {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--border);
            background: #fff;
        }

       
        :root {
            --max-width: 800px;
            --mobile-padding: 12px;
        }

       
        @media screen and (max-width: 768px) {
            body {
                padding: 8px;
            }
            
            .service {
                max-width: 100%;
                margin: 0;
            }

            .header {
                padding: 12px 16px;
            }

            .title {
                font-size: 15px;
            }

            .status-badge {
                padding: 4px 8px;
                font-size: 12px;
            }
        }

      
        .user-box {
            padding: 12px;
            max-height: calc(100vh - 180px); 
            min-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

       
        .user-list {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 12px;
            background: #fff;
            transition: all 0.2s;
            border: 1px solid var(--border);
            max-height: 72px; 
            overflow: hidden;
            gap: 12px;
        }

     
        .user {
            flex: 1;
            min-width: 0; 
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

      
        .name {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 4px;
            min-width: 0; 
        }

        .name span {
            flex-shrink: 0; 
        }

  
        .last-msg {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%; 
            font-size: 13px;
            color: var(--text-light);
        }

     /*后面是防止压缩我搞的处理*/
        .data {
            flex-shrink: 0; 
            min-width: 60px;
            max-width: 80px; 
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .time {
            font-size: 12px;
            color: var(--text-light);
        }

       
        .user img {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0; 
        }

      
        @media screen and (max-width: 480px) {
            .foot {
                padding: 12px;
                gap: 8px;
            }

            .action-btn {
                padding: 8px;
                font-size: 13px;
            }

            .action-btn i {
                font-size: 14px;
            }
        }

        /* 分页响应式 */
        @media screen and (max-width: 480px) {
            .pagination-wrapper {
                padding: 8px;
            }

            .page-link {
                min-width: 28px;
                height: 28px;
                padding: 0 8px;
                font-size: 13px;
            }

            .page-info {
                font-size: 13px;
            }
        }

        /* 空状态响应式 */
        @media screen and (max-width: 480px) {
            .empty-state {
                padding: 32px 16px;
            }

            .empty-state i {
                font-size: 32px;
            }
        }

        /* 状态标签响应式 */
        @media screen and (max-width: 480px) {
            .ison {
                padding: 2px 6px;
                font-size: 11px;
            }
        }

        /* 未读消息数 */
        .num {
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: white;
            flex-shrink: 0; 
        }

       
        .user-box::-webkit-scrollbar {
            width: 4px;
        }

        .user-box::-webkit-scrollbar-track {
            background: transparent;
        }

        .user-box::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 2px;
        }

        /* 防止长文本溢出的通用类 */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* 溢出处理 */
        .flex-container {
            min-width: 0;
            min-height: 0;
        }

        /* 备注样式 */
        .user-remark {
            flex-shrink: 0;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ison {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .ison.online .status-dot {
            background-color: var(--success);
        }

        .ison.offline .status-dot {
            background-color: var(--text-light);
        }

        .ison.hidden .status-dot {
            background-color: var(--warning);
        }
    /* 小红点通知 */
.badge {
    position: absolute;
    top: 12px;
    margin-left: 15px;
    width: 8px;
    height: 8px;
    background-color: #FA5151;
    border-radius: 50%;
}
    
/* 椭圆形底部导航栏 */
.tab-bar {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 400px;
    height: 60px;
    background: white;
    border-radius: 30px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    z-index: 100;
}

.tab-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 12px;
    text-decoration: none;
    flex: 1;
    height: 100%;
    transition: all 0.3s ease;
    position: relative;
}

.tab-item.active {
    color: #07C160;
}

.tab-icon {
    font-size: 22px;
    margin-bottom: 3px;
    transition: transform 0.3s;
}

/* 活动指示器 */
.tab-item.active .tab-icon {
    transform: translateY(0px);
}

/* 小红点通知 */
.badge {
    position: absolute;
    top: 12px;
    right: calc(50% - 15px);
    width: 8px;
    height: 8px;
    background-color: #FA5151;
    border-radius: 50%;
}

    </style>
</head>
<body>
      <div class="service">
        <div class="service-box">
            <div class="header">
                <div class="title">
                    <i class="fas fa-comments-alt"></i>
                    <span> Tg@jintiao789 </span>
                </div>
                <div class="actions">
                    <div class="status-badge">
                        <i class="fas fa-circle"></i>
                        <span>  金条在线服务中 </span>
                    </div>
                </div>
                
            </div>      <div class="user-box">
                <?php
                    // 添加聊天室入口链接 - 置顶显示
                    echo '
                         <a href="../Dev/chatRoom/auto_login_bridge.php?target=user.php&name='.urlencode('客服').'">
                            <div class="user-list" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: 1px solid #ff6b6b;">
                                <img src="https://q2.qlogo.cn/headimg_dl?dst_uin=3951050426&spec=100" alt="" style="border: 2px solid #ff6b6b;">
                                <div class="user">
                                    <div class="name">
                                        <span style="color: white; font-weight: 600;">💬 聊天室（调试模式）</span>
                                        <span class="ison online" style="background: rgba(255, 255, 255, 0.2); color: white;">
                                            <i class="status-dot" style="background-color: #00ff88;"></i>客服在线
                                        </span>
                                    </div>
                                    <div class="last-msg" style="color: rgba(255, 255, 255, 0.8);">点击进入客服聊天室（调试模式：会显示详细错误信息）</div>
                                </div>
                                <div class="data">
                                    <div class="time" style="color: rgba(255, 255, 255, 0.8);">'.date("m-d H:i").'</div>
                                    <div style="color: white; font-size: 18px;">🔧</div>
                                </div>
                            </div>
                        </a>
                    ';
                ?>
                <?php
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $limit = 10; // 每页显示数量
                    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                    
                    // 构建搜索条件
                    $where = "";
                    if($search) {
                        $where = " WHERE h_user LIKE '%".mysqli_real_escape_string($db->link, $search)."%'";
                    }
                    
                    // 获取总记录数
                    $total_query = "SELECT COUNT(DISTINCT h_user) as total FROM `h_kefu`".$where;
                    $total_result = $db->get_one($total_query);
                    $total = $total_result['total'];
                    
                    // 计算总页数
                    $total_pages = ceil($total / $limit);
                    $offset = ($page - 1) * $limit;
                    
                    // 主查询以支持分页和搜索
                    $query = "SELECT h_user FROM `h_kefu`".$where." GROUP BY h_user ORDER BY max(h_addTime) DESC LIMIT $offset, $limit";
                    $result = $db->query($query);
                    $hasUsers = false;
                    
                    while($rs_list = $db->fetch_array($result))
                    {   
                        $hasUsers = true;
                        $rs1 = $db->get_one("select * from `h_kefu` where h_user = '{$rs_list['h_user']}' order by h_addTime desc,id desc limit 1");
                        $rs1['h_addTime'] = date("m-d H:i",strtotime($rs1['h_addTime']));
                        $rs2 = $db->get_one("select count(*) as tj from `h_kefu`where h_user = '{$rs_list['h_user']}' and h_who = 1 and h_isread = 0");
                        $rs3 = $db->get_one("select * from `h_kefu_status` where h_user = '{$rs_list['h_user']}'");
                        $date_1 = date("Y-m-d H:i:s"); 
                        $date_2 = $rs3['h_addTime'];
                        $time=ceil(strtotime($date_1)-strtotime($date_2));
                        
                        // 状态判断逻辑
                        $statusClass = '';
                        $status = '';
                        
                        if($time > 180) { // 3分钟 = 180秒
                            $status = '离线';
                            $statusClass = 'offline';
                        } else {
                            if($rs3['h_status'] == 1) {
                                $status = '正在会话';
                                $statusClass = 'online';
                            } else if($rs3['h_status'] == 2) {
                                $status = '隐藏窗口';
                                $statusClass = 'hidden';
                            } else {
                                $status = '在线';
                                $statusClass = 'online';
                            }
                        }
                        
                        $lastMsg = $rs1['h_content'];
                        // 检查是否是卡片消息
                        if(strpos($lastMsg, 'ComponentMessage') !== false) {
                            // 根据卡片内容确定显示文本
                            if(strpos($lastMsg, 'Hi，我是闲鱼官方认证的游戏账号交易客服') !== false) {
                                $lastMsg = '发送了开场白卡片';
                            } else if(strpos($lastMsg, '⚠️ 安全交易提醒') !== false) {
                                $lastMsg = '发送了安全提示卡片';
                            } else if(strpos($lastMsg, '标准交易流程') !== false) {
                                $lastMsg = '发送了交易流程卡片';
                            } else if(strpos($lastMsg, '遇到交易问题？') !== false) {
                                $lastMsg = '发送了纠纷处理卡片';
                            } else {
                                $lastMsg = '发送了一条系统消息';
                            }
                        }

                        // 截断过长的消息
                        if(mb_strlen($lastMsg, 'UTF-8') > 20) {
                            $lastMsg = mb_substr($lastMsg, 0, 20, 'UTF-8') . '...';
                        }
                        
                        echo '
                            <a href="talking.php?user=' . $rs_list['h_user'] . '">
                                <div class="user-list">
                                    <img src="https://q2.qlogo.cn/headimg_dl?dst_uin=3951050426&spec=100" alt="">
                                    <div class="user">
                                        <div class="name">
                                            <span>' . $rs_list['h_user'] . '</span>
                                            <span class="ison ' . $statusClass . '">
                                                <i class="status-dot"></i>' . $status . '
                                            </span>';
                                            
                                            // 添加备注显示
                                            $remark = $db->get_one("SELECT h_remark FROM `h_kefu_status` WHERE h_user = '{$rs_list['h_user']}'");
                                            if($remark && $remark['h_remark']) {
                                                echo "<span class='user-remark'>({$remark['h_remark']})</span>";
                                            }

                                            echo '
                                        </div>
                                        <div class="last-msg">' . htmlspecialchars($lastMsg) . '</div>
                                    </div>
                                    <div class="data">
                                        <div class="time">' . $rs1['h_addTime'] . '</div>
                                        ' . ($rs2['tj'] > 0 ? '<div class="num">' . $rs2['tj'] . '</div>' : '') . '
                                    </div>
                                </div>
                            </a>
                        ';
                    }
                    
                    // 如果没有用户，显示空状态
                    if (!$hasUsers) {
                        echo '
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <p>暂无聊天记录</p>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
        <div class="pagination">
            <div class="pagination-wrapper">
                <?php if($total_pages > 1): ?>
                    <?php if($page > 1): ?>
                        <a href="?page=1<?php echo $search ? '&search='.$search : ''; ?>" 
                           class="page-link">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                        <a href="?page=<?php echo $page-1; ?><?php echo $search ? '&search='.$search : ''; ?>" 
                           class="page-link">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    <?php endif; ?>

                    <span class="page-info">
                        <?php echo $page; ?>/<?php echo $total_pages; ?>
                        (共<?php echo $total; ?>条)
                    </span>

                    <?php if($page < $total_pages): ?>
                        <a href="?page=<?php echo $page+1; ?><?php echo $search ? '&search='.$search : ''; ?>" 
                           class="page-link">
                            <i class="fas fa-angle-right"></i>
                        </a>
                        <a href="?page=<?php echo $total_pages; ?><?php echo $search ? '&search='.$search : ''; ?>" 
                           class="page-link">
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
<!-- 底部导航栏 -->
    <div class="tab-bar">
        <a href="le.php" class="tab-item active">
            <i class="fas fa-home tab-icon"></i>
            <span>首页</span>
        </a>
        <a href="sq.php" class="tab-item">
            <i class="fas fa-compass tab-icon"></i>
            <span>工具栏</span>
            <span class="badge"></span>
        </a>
        <a href="user.php" class="tab-item">
            <i class="fas fa-comment-dots tab-icon"></i>
            <span>消息</span>
        </a>
        <a href="zx.php" class="tab-item">
            <i class="fas fa-user tab-icon"></i>
            <span>我的</span>
        </a>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="assets/libs/layui/layui.js"></script>
    <script type="text/javascript" src="assets/js/common.js?v=318"></script>
    <script>
    // 确保点击后能跳转
    document.addEventListener('DOMContentLoaded', function() {
        // 获取当前页面路径
        const currentPage = window.location.pathname.split('/').pop() || 'home.html';
        
        // 设置当前活动标签
        document.querySelectorAll('.tab-item').forEach(item => {
            if (item.getAttribute('href') === currentPage) {
                item.classList.add('active');
            }
            
            // 点击时添加短暂动画
            item.addEventListener('click', function() {
                this.querySelector('.tab-icon').style.transform = 'translateY(-8px)';
                setTimeout(() => {
                    if (this.classList.contains('active')) {
                        this.querySelector('.tab-icon').style.transform = 'translateY(-5px)';
                    } else {
                        this.querySelector('.tab-icon').style.transform = 'translateY(0)';
                    }
                }, 200);
            });
        });
    });
    </script>
</body>
</html>
</body>
</html>