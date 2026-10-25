<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>金条个人中心</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
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
}

.tab-item.active {
    color: #07C160;
}

.tab-icon {
    font-size: 22px;
    margin-bottom: 3px;
}

/* 活动指示器 */
.tab-item.active .tab-icon {
    transform: translateY(-5px);
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
        }
        
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        /* 个人中心卡片 */
        .profile-card {
            width: 380px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-10px);
        }
        
        /* 顶部背景 */
        .profile-bg {
            height: 120px;
            background: linear-gradient(135deg, #C5C1FF 56%, #FFBAC3 100%);
            position: relative;
        }
        
        /* 头像区域 */
        .avatar-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .avatar i {
            font-size: 40px;
            color: #667eea;
        }
        
        /* 用户信息 */
        .user-info {
            text-align: center;
            padding: 0 30px 30px;
        }
        
        .user-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        
        .user-email {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }
        
        /* 功能按钮 */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 0 30px 30px;
        }
        
        .action-btn {
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .action-btn:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        
        .action-btn i {
            font-size: 18px;
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }
        
        .change-password i {
            color: #4e73df;
        }
        
        .logout i {
            color: #e74a3b;
        }
        
        /* 底部装饰 */
        .profile-footer {
            height: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
       
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
    transform: translateY(-5px);
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

</script>
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-bg"></div>
        
        <div class="avatar-container">
            <div class="avatar">
               <!-- 修改avatar部分，替换掉FontAwesome图标 -->
<div class="avatar">
  <!-- 使用img标签显示头像图片 -->
  <img src="https://q2.qlogo.cn/headimg_dl?dst_uin=3951050426&spec=640" alt="用户头像" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
</div>
              
            </div>
        </div>
        
        <div class="user-info">
            <div class="user-name">金条</div>
            <div class="user-email">Tg:@jintiao789</div>
        </div>
        
        <div class="action-buttons">
            <!-- 修改密码按钮 - 跳转到change-password.html -->
            <a href="edit_info.php" class="action-btn change-password">
                <i class="fas fa-key"></i>
                <span>修改密码</span>
            </a>
            
            <!-- 退出登录按钮 - 跳转到logout.html -->
            <a href="login.php" class="action-btn logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>退出登录</span>
            </a>
        </div>
    </div>
        <div class="profile-footer"></div>
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


</body>
</html>