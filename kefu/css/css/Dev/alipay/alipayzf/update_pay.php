<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自定义修改支付金额</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="/css/1layui.css"/>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-color: #a0c4ff; /* 浅蓝色 */
        --hover-color: #bdb2ff;   /* 浅紫色 */
        --bg-color: #f0f8ff;      /* 浅蓝色背景 */
        --text-color: #1a1a1a;
        --border-color: #e5e7eb;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background: var(--bg-color);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        color: var(--text-color);
    }

    .container {
        background: white;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(160, 196, 255, 0.1); /* 更新阴影颜色 */
        width: 100%;
        max-width: 420px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .form-header i {
        font-size: 56px;
        background: linear-gradient(135deg, var(--primary-color), var(--hover-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .form-header h1 {
        font-size: 28px;
        color: var(--text-color);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: var(--text-color);
        font-weight: 500;
        font-size: 15px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper i {
        position: absolute;
        left: 16px;
        color: #6b7280;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    input[type="text"] {
        width: 100%;
        padding: 16px 16px 16px 48px;
        border: 2px solid var(--border-color);
        border-radius: 16px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    input[type="text"]:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 4px rgba(160, 196, 255, 0.1); /* 更新阴影颜色 */
        background: white;
    }

    input[type="text"]:focus + i {
        color: var(--primary-color);
    }

    input[type="submit"] {
        width: 100%;
        padding: 16px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    input[type="submit"]:hover {
        background: var(--hover-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(189, 178, 255, 0.2); /* 更新阴影颜色 */
    }

    input[type="submit"]:active {
        transform: translateY(0);
        box-shadow: none;
    }

    /* 添加玻璃态效果 */
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* 添加输入框占位符样式 */
    ::placeholder {
        color: #9ca3af;
        opacity: 1;
    }

    /* 添加平滑滚动 */
    html {
        scroll-behavior: smooth;
    }

    /* 添加响应式调整 */
    @media (max-width: 480px) {
        .container {
            padding: 30px 20px;
        }

        .form-header i {
            font-size: 48px;
        }

        .form-header h1 {
            font-size: 24px;
        }
    }
</style>
</head>
<body>
    <div class="container glass-effect">
        <div class="form-header">
            <i class="fas fa-money-bill-wave"></i>
            <h1>修改支付金额</h1>
        </div>
        
        <form action="update_pays.php" method="post">
            <div class="form-group">
                <div class="input-wrapper">
                    <input type="text" 
                           id="newAmount" 
                           name="newAmount" 
                           placeholder="请输入新的支付金额"
                           required>
                    <i class="fas fa-yen-sign"></i>
                </div>
            </div>
            
            <input type="submit" value="确认修改">
        </form>
    </div>
</body>
</html>