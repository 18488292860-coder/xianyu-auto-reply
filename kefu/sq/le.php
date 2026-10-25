<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>金条集团</title>
  <link rel="stylesheet" href="/css/1layui.css">
  <link href="//unpkg.com/layui@2.9.2/dist/css/layui.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/1layui.css">
  <link rel="stylesheet" type="text/css" href="static/LightYearv5/css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/animate.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/multitabs.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/style.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&amp;family=Gaegu&amp;display=swap" rel="stylesheet">

<style>
* {font-family: MainFont, sans-serif;}
@font-face {font-family: 'MainFont';src: url('/css/Font.woff2') format('woff2');font-weight: normal;font-style: normal;}
.nav-drawer .mdi {font-size: 1.1rem;width: 1.2em;text-align: center;margin-right: 0.5rem;}
.nav-drawer a:hover i {transform: scale(1.1);transition: transform 0.2s ease;transform: translateY(-6px);}
}
<style>
* {font-family: MainFont, sans-serif;}
@font-face {font-family: 'MainFont';src: url('/css/Font.woff2') format('woff2');font-weight: normal;font-style: normal;}
.nav-drawer .mdi {font-size: 1.1rem;width: 1.2em;text-align: center;margin-right: 0.5rem;}
.nav-drawer a:hover i {transform: scale(1.1);transition: transform 0.2s ease;transform: translateY(-6px);}
}
/* 修正后的@font-face */
@font-face {
  font-family: 'MainFont';
  src: url('/css/font.woff2') format('woff2');
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}

/* 修正后的导航样式 */
nav-drawer .mdi {
  font-size: 1.1rem;
  width: 1.2em;
  text-align: center;
  margin-right: 0.5rem;
}

/* 修正弹窗样式 */
.swal2-title {
  font-weight: normal !important;
}
.swal2-popup {
  border-radius: 15px;
}


.cute-font-local {
  font-family: 'CuteFont', sans-serif;
  color: #ff6b8b;
  letter-spacing: 1px;
}
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

.swal2-title {
    font-weight: normal!important;
}

.swal2-popup {
    border-radius: 15px;
}

.custom-icon {
    display: block;
    margin: 0 auto 10px;
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
}

body {
    font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
    transition: all 0.5s ease;
    margin: 0;
    padding: 0;
}

.theme-simple {
    background: linear-gradient(135deg, #f6f9fc 0%, #edf1f7 100%);
}

.theme-simple.welcome-section {
    background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.theme-simple.dashboard-card {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.theme-simple.action-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #ccc;
}

.theme-simple.card-title::after {
    background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
}

.theme-toggle-wrapper {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    padding: 5px;
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.theme-toggle {
    width: 45px;
    height: 45px;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.theme-simple.theme-toggle {
    background: #ffffff;
    color: #2CD8D5;
    box-shadow: 0 2px 10px rgba(44, 216, 213, 0.2);
}

.theme-dark.theme-toggle {
    background: #222;
    color: #FFD700;
    box-shadow: 0 2px 10px rgba(255, 215, 0, 0.2);
}

.theme-toggle:hover {
    transform: scale(1.1);
}

.theme-toggle i {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.theme-toggle:hover i {
    transform: rotate(360deg);
}

.dashboard-card {
    border-radius: 24px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    margin-bottom: 20px;
}

.dashboard-card:hover {
    transform: translateY(-8px) scale(1.01);
}

.action-btn {
    padding: 20px;
    border-radius: 20px;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    border: 1px solid #ccc;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    cursor: pointer;
    background: white;
    color: #000;
}

.action-btn:active {
    transform: scale(0.98);
}

.action-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.action-btn i {
    font-size: 28px;
    transition: all 0.3s ease;
    margin-bottom: 20px; /* 增大图标和文字之间的间距，从原来的10px调整为20px，可按需进一步调整 */
}

.theme-dark.action-btn {
    background: rgba(25, 25, 25, 0.9);
    border: 1px solid #555;
    color: #000;
}

.theme-dark.action-btn:hover {
    border-color: rgba(255, 215, 0, 0.5);
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.1);
}

.welcome-section {
    background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
    padding: 50px;
    border-radius: 30px;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}

.welcome-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="0.5" stroke-opacity="0.2"/></svg>') center/60px repeat;
    opacity: 0.1;
}

.welcome-section::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.15));
    transform: rotate(30deg);
    animation: shine 8s infinite linear;
}

@keyframes shine {
    0% {
        transform: rotate(30deg) translateX(-100%);
    }
    100% {
        transform: rotate(30deg) translateX(100%);
    }
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.action-btn span {
    font-size: 1rem;
    transition: all 0.3s ease;
}

.announcement-item {
    padding: 20px;
    border-radius: 16px;
    background: rgba(248, 249, 250, 0.8);
    margin-bottom: 15px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    display: flex;
    align-items: center;
}

.announcement-item:hover {
    background: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transform: translateX(8px);
}

.announcement-item.warning {
    border-left-color: #ffc107;
}

.announcement-item.info {
    border-left-color: #0dcaf0;
}
.announcement-item.danger {
    border-left-color: #dc3545;
}

.card-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 30px;
    font-size: 1.4rem;
    position: relative;
    padding-bottom: 10px;
}

.card-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
    border-radius: 3px;
}

.profile-img {
    width: 100px;
    height: 100px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.profile-img:hover {
    transform: rotate(5deg);
}

@media (max-width: 992px) {
   .container-fluid {
        padding: 20px;
    }
   .welcome-section {
        padding: 40px;
        margin-bottom: 30px;
    }
   .profile-img {
        width: 90px;
        height: 90px;
    }
   .quick-actions {
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }
   .theme-toggle-wrapper {
        top: 15px;
        right: 15px;
    }
}

@media (max-width: 768px) {
   .container-fluid {
        padding: 15px!important;
    }
   .welcome-section {
        padding: 30px!important;
        margin-bottom: 20px!important;
    }
   .profile-img {
        width: 80px!important;
        height: 80px!important;
    }
   .quick-actions {
        grid-template-columns: repeat(2, 1fr)!important;
        gap: 15px!important;
    }
   .theme-toggle-wrapper {
        top: 10px!important;
        right: 10px!important;
    }
   .row {
        margin-left: -10px!important;
        margin-right: -10px!important;
    }
   .col-lg-6 {
        padding-left: 10px!important;
        padding-right: 10px!important;
        margin-bottom: 20px!important;
    }
   .dashboard-card {
        margin-bottom: 0!important;
    }
   .announcement-item {
        padding: 15px!important;
        margin-bottom: 10px!important;
    }
   .welcome-section h2 {
        font-size: 1.5rem!important;
    }
   .welcome-section p {
        font-size: 1rem!important;
    } .card-title {
        font-size: 1.2rem!important;
    }
   .action-btn span {
        font-size: 0.9rem!important;
    }
   .announcement-item {
        font-size: 0.9rem!important;
    }
}

@media (max-width: 576px) {
   .quick-actions {
        grid-template-columns: 1fr;
    }
   .action-btn {
        padding: 18px;
    }
   .action-btn i {
        font-size: 26px;
    }
   .action-btn span {
        font-size: 0.85rem;
    }
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
@media (hover: none) {
   .action-btn:active {
        transform: scale(0.95);
    }
   .theme-dark.action-btn:active {
        background: rgba(35, 35, 35, 0.95);
        border-color: rgba(255, 215, 0, 0.6);
    }
   .announcement-item:active {
        transform: translateX(5px);
    }
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
            font-family: 'PingFang SC', 'Helvetica Neue', Arial, sans-serif;
        }
        
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        
        .header {
            height: 60px;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            color: #333;
        }
        
        /* 精美底部导航栏 */
        .nav-container {
            height: 80px;
            background: white;
            display: flex;
            justify-content: center;
            box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.08);
            position: relative;
        }
        
        .nav-bar {
            width: 100%;
            max-width: 500px;
            height: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: relative;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #999;
            transition: all 0.3s ease;
            flex: 1;
            height: 100%;
            position: relative;
            z-index: 1;
        }
        
        .nav-item.active {
            color: #6e8efb;
        }
        
        .nav-icon {
            font-size: 22px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-item.active .nav-icon {
            transform: translateY(-5px);
        }
        
        .nav-label {
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            opacity: 0.8;
        }
        
        .nav-item.active .nav-label {
            opacity: 1;
            font-weight: 600;
        }
        
        /* 活动指示器 */
        .nav-indicator {
            position: absolute;
            top: -10px;
            left: 0;
            width: 25%;
            height: 3px;
            background-color: #6e8efb;
            border-radius: 3px;
            transition: all 0.3s ease;
            z-index: 2;
        }
        
        /* 图标动画效果 */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        
        .nav-item.active .nav-icon {
            animation: bounce 0.5s ease;
        }
</style>

<script>

</script>
    </style>
</head>
<body class="theme-simple" style="">
    <div class="container-fluid p-4" style="">
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="https://q2.qlogo.cn/headimg_dl?dst_uin=3951050426&amp;spec=100" class="rounded-circle profile-img">
                </div>
                <div class="col">
                    <h2 class="mb-3" style="font-weight: 700;">金条                     <i class="fa-solid fa-circle-check" style="color: #ffffff; margin-left: 8px; font-size: 0.8em
                    ;"></i>
                    </h2>
                    <p class="mb-0" style="font-size: 1.1rem; opacity: 0.9;">金条Tg:@jintiao789
                </div>
            </div>
        </div>
        <div class="row mt-4" style="">
            <div class="col-lg-6" style="">
                <div class="card dashboard-card" style="">
                    <div class="card-body" style="">
                        <h4 class="card-title">
                            <i class="fas fa-bolt"></i>
                            新增功能
                        </h4>
                        <div class="quick-actions">
                            <button class="action-btn">
                                <i class="fas fa-cloud" style="color: #87CEFA;"></i>
                                <span>网页整体界面美化 </span>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-shield-halved" style="color: #673AB7;"></i>
                                <span> 防红短链 </span>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-cog" style="color: #;"></i>
                                <span>  网站设置 </span>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-shield-alt" style="color: #FFF720;"></i>
                                <span>安全防护</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
          
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</style>
</head>
<body></body>
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

    <script>
        // 添加点击交互
document.addEventListener('DOMContentLoaded', function() {
    const tabItems = document.querySelectorAll('.tab-item');
    
    tabItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // 保留默认链接跳转行为
            
            // 移除所有active类
            tabItems.forEach(tab => {
                tab.classList.remove('active');
            });
            
            // 给当前点击项添加active类
            this.classList.add('active');
            
            // 这里可以添加页面切换逻辑
            console.log('切换到: ' + this.querySelector('span').textContent);
            
            // 实际使用时取消下面注释，启用真实跳转
            // window.location.href = this.getAttribute('href');
        });
    });
});
    </script>
</body>
<script type="text/javascript" src="//js.users.51.la/21986587.js"></script>
</html>
