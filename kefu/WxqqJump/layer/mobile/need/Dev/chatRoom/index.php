<?php
// 聊天室管理系统 - 默认重定向到管理后台
session_start();

// 检查是否有管理员登录，如果有直接跳转
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: user.php');
    exit;
}

// 如果没有登录，显示重定向页面
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天室管理系统</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo {
            font-size: 4em;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        h1 {
            color: #333;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .description {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .redirect-info {
            background: #e8f5e8;
            border: 1px solid #28a745;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .redirect-info h3 {
            color: #155724;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        
        .redirect-info p {
            color: #155724;
            margin-bottom: 10px;
        }
        
        .countdown {
            font-size: 1.5em;
            font-weight: bold;
            color: #667eea;
        }
        
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn.secondary {
            background: #6c757d;
        }
        
        .btn.secondary:hover {
            background: #5a6268;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }
        
        .feature {
            text-align: center;
        }
        
        .feature-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .feature-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .feature-desc {
            font-size: 0.9em;
            color: #666;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🏠</div>
        <h1>聊天室管理系统</h1>
        <div class="description">
            欢迎使用智能聊天室管理系统，为您提供完整的聊天室解决方案
        </div>
        
        <div class="redirect-info">
            <h3>🚀 自动跳转中...</h3>
            <p>系统将在 <span class="countdown" id="countdown">3</span> 秒后自动跳转到管理后台</p>
            <p>如果没有自动跳转，请点击下方按钮</p>
        </div>
        
        <div class="buttons">
            <a href="user.php" class="btn">
                🛠️ 进入管理后台
            </a>
            <a href="welcome.php" class="btn secondary">
                👥 用户登录页面
            </a>
        </div>
        
        <div class="features">
            <div class="feature">
                <div class="feature-icon">🔍</div>
                <div class="feature-title">设备识别</div>
                <div class="feature-desc">智能设备指纹识别</div>
            </div>
            <div class="feature">
                <div class="feature-icon">💬</div>
                <div class="feature-title">多房间</div>
                <div class="feature-desc">支持多个聊天室</div>
            </div>
            <div class="feature">
                <div class="feature-icon">📊</div>
                <div class="feature-title">实时统计</div>
                <div class="feature-desc">用户活跃度分析</div>
            </div>
        </div>
    </div>

    <script>
        // 倒计时自动跳转
        let countdown = 3;
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = 'user.php';
            }
        }, 1000);
        
        // 页面加载动画
        document.addEventListener('DOMContentLoaded', function() {
            console.log('聊天室管理系统已加载');
        });
        
        // 如果用户点击页面任意位置，立即跳转
        document.addEventListener('click', function() {
            clearInterval(timer);
            window.location.href = 'user.php';
        });
    </script>
</body>
</html> 