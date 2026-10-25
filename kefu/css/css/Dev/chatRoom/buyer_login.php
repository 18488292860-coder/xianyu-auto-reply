<?php
session_start();

// 处理退出登录
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header('Location: buyer_login.php');
    exit;
}

// 如果已经登录，根据重定向参数决定跳转
if (isset($_SESSION['buyer_logged_in']) && $_SESSION['buyer_logged_in'] === true) {
    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'user.php';
    header('Location: ' . $redirect);
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>买家登录 - 聊天室</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .login-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-buyer {
            background: linear-gradient(135deg, #42a5f5 0%, #1e88e5 100%);
        }
        .btn-buyer:hover {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="login-container rounded-xl p-8 w-full max-w-md shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">买家登录</h1>
            <p class="text-blue-100">请输入您的买家账号信息</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label for="username" class="block text-white text-sm font-medium mb-2">用户名</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       required 
                       class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                       placeholder="请输入买家用户名">
            </div>

            <div>
                <label for="password" class="block text-white text-sm font-medium mb-2">密码</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                       placeholder="请输入密码">
            </div>

            <button type="submit" 
                    id="loginBtn"
                    class="w-full btn-buyer text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span id="loginText">买家登录</span>
                <span id="loadingText" class="hidden">登录中...</span>
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="index.php" class="text-blue-200 hover:text-white transition-colors duration-200">
                ← 返回首页
            </a>
        </div>

        <!-- 错误提示 -->
        <div id="errorMessage" class="hidden mt-4 p-3 bg-red-500/20 border border-red-500/30 rounded-lg text-red-100 text-sm text-center"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const loginBtn = document.getElementById('loginBtn');
            const loginText = document.getElementById('loginText');
            const loadingText = document.getElementById('loadingText');
            const errorMessage = document.getElementById('errorMessage');
            
            if (!username || !password) {
                showError('请输入用户名和密码');
                return;
            }
            
            // 显示加载状态
            loginBtn.disabled = true;
            loginText.classList.add('hidden');
            loadingText.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            
            try {
                const formData = new FormData();
                formData.append('action', 'buyer_login');
                formData.append('username', username);
                formData.append('password', password);
                
                const response = await fetch('api/auth_api.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // 登录成功，检查是否有重定向URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const redirectUrl = urlParams.get('redirect');
                    
                    // 根据是否有重定向决定跳转地址
                    if (redirectUrl) {
                        window.location.href = decodeURIComponent(redirectUrl);
                    } else {
                        // 默认跳转到首页
                        window.location.href = 'index.php';
                    }
                } else {
                    showError(result.message || '登录失败，请检查用户名和密码');
                }
            } catch (error) {
                console.error('登录错误:', error);
                showError('网络错误，请稍后重试');
            } finally {
                // 恢复按钮状态
                loginBtn.disabled = false;
                loginText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            }
        });
        
        function showError(message) {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
        }
    </script>
</body>
</html> 