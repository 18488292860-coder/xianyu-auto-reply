<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>金条工具</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Pacifico|Cherry+Bomb+One|Baloo+2|Luckiest+Guy&display=swap" rel="stylesheet">
<style>
* {font-family: MainFont, sans-serif;}
@font-face {font-family: 'MainFont';src: url('/css/Font.woff2') format('woff2');font-weight: normal;font-style: normal;}
.nav-drawer .mdi {font-size: 1.1rem;width: 1.2em;text-align: center;margin-right: 0.5rem;}
.nav-drawer a:hover i {transform: scale(1.1);transition: transform 0.2s ease;transform: translateY(-6px);}
        .cute-font-simple {
  font-family: 'Comic Sans MS', 'Marker Felt', 'Segoe Print', cursive;
  color: #ff6b8b;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
  letter-spacing: 0.5px;
}
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Microsoft YaHei', sans-serif;
        }
        
        body {
            min-height: 100vh;
            background-color: #fff5f7;
            color: #555;
        }
        
        .container {
            max-width: 100%;
            padding: 20px;
            margin: 0 auto;
        }
        
        /* 头部样式 */
        .header {
            text-align: center;
            padding: 25px 0;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(255, 105, 140, 0.3);
            color: white;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .contact-btn {
            display: inline-block;
            background: white;
            color: #ff6b8b;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            margin-top: 15px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        /* 四列工具栏 */
        .tool-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease-out 0.2s both;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .tool-item {
            background: white;
            border-radius: 15px;
            padding: 20px 10px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 3px 10px rgba(255, 105, 140, 0.1);
            text-decoration: none;
            color: #666;
            border: 1px solid #ffecef;
        }
        
        .tool-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(255, 105, 140, 0.2);
        }
        
        .tool-icon {
            font-size: 1.8rem;
            color: #ff8fab;
            margin-bottom: 12px;
            transition: all 0.3s;
        }
        
        .tool-item:hover .tool-icon {
            transform: scale(1.15);
            color: #ff6b8b;
        }
        
        .tool-name {
            font-size: 14px;
            font-weight: 500;
        }
        
        /* 小红点通知 */
        .tool-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 10px;
            height: 10px;
            background-color: #ff4757;
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
    <div class="container">
        <div class="header">
            <h1>金条礼品卡回收</h1>
            <p>回收各大礼品卡沃尔玛85卡包8 E卡</p>
            <p>永辉等统统回8 微信群引导 京东卡</p>
            <a href="https://t.me/jintiao789" class="contact-btn">点击联系金条</a>
        </div>
        
        <h2 style="color:#ff6b8b; margin:0 10px 20px; font-size:1.3rem;">功能列表</h2>
        
        <div class="tool-grid">
            <a href="linklist.php" class="tool-item">
                <i class="fas fa-gift tool-icon"></i>
                <div class="tool-name">客服列表</div>
            </a>
            <a href="http://46.3.112.202" class="tool-item">
                <i class="fas fa-shield-alt tool-icon"></i>
                <div class="tool-name">防红短链</div>
                <span class="tool-badge"></span>
            </a>
            <a href="hxzc.php" class="tool-item">
                <i class="fas fa-cog tool-icon"></i>
                <div class="tool-name">分享图生成</div>
            </a>
            <a href="ls.php" class="tool-item">
                <i class="fas fa-lock tool-icon"></i>
                <div class="tool-name">工具合集-待完善</div>
            </a>
            <a href="/Dev/alipay/bianma/alipay.php" class="tool-item">
                <i class="fas fa-wallet tool-icon"></i>
                <div class="tool-name">多功能链接生成</div>
            </a>
            <a href="lx.php" class="tool-item">
                <i class="fas fa-history tool-icon"></i>
                <div class="tool-name">联系联金条</div>
            </a>
            <a href="zf.php" class="tool-item">
                <i class="fas fa-percentage tool-icon"></i>
                <div class="tool-name">付款图生成</div>
            </a>
            <a href="/Dev/alipay/bianma/goofishnt.php" class="tool-item">
                <i class="fas fa-book tool-icon"></i>
                <div class="tool-name">闲鱼内跳-配防红</div>
            </a>
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
    <script>
        // 动态效果 - 工具项逐个显示
        document.addEventListener('DOMContentLoaded', function() {
            const tools = document.querySelectorAll('.tool-item');
            tools.forEach((tool, index) => {
                tool.style.animationDelay = `${index * 0.1}s`;
            });
            
            // 确保所有链接都能跳转
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    if(this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
<script type="text/javascript" src="https://js.users.51.la/21986587.js"></script>
</body>
</html>