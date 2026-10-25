<!DOCTYPE HTML>
<html>
<head>
    <title>支付接口配置</title>
    <meta charset="UTF-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
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
        --secondary-color: #bdb2ff; /* 浅紫色 */
        --accent-color: #ffc6ff; /* 浅粉色 */
        --bg-color: #f5f5f5;
        --text-color: #1a1a1a;
        --border-color: #e5e7eb;
        --shadow-color: rgba(0, 0, 0, 0.08);
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background: var(--bg-color);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .container {
        background: white;
        width: 100%;
        max-width: 400px;
        border-radius: 16px;
        box-shadow: 0 4px 20px var(--shadow-color);
        overflow: hidden;
        animation: fadeIn 0.5s ease-out;
    }

    .header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        padding: 32px 24px;
        text-align: center;
        color: white;
        position: relative;
    }

    .header-icon {
        font-size: 48px;
        margin-bottom: 16px;
        color: rgba(255, 255, 255, 0.9);
    }

    .header h1 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .header p {
        font-size: 14px;
        opacity: 0.9;
    }

    .content {
        padding: 24px;
    }

    .input-group {
        margin-bottom: 20px;
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        transition: all 0.3s;
    }

    input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
        background: #f9fafb;
    }

    input:focus {
        outline: none;
        border-color: var(--primary-color);
        background: white;
        box-shadow: 0 0 0 3px rgba(160, 196, 255, 0.1); /* 浅蓝色阴影 */
    }

    input:focus + .input-icon {
        color: var(--primary-color);
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    button:hover {
        background: linear-gradient(135deg, var(--accent-color), var(--secondary-color), var(--primary-color));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(160, 196, 255, 0.2); /* 浅蓝色阴影 */
    }

    button i {
        font-size: 16px;
    }

    .footer {
        padding: 16px 24px;
        background: #f9fafb;
        border-top: 1px solid #f0f0f0;
        text-align: center;
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .footer i {
        color: var(--primary-color);
    }

    /* 添加响应式设计 */
    @media (max-width: 480px) {
        .container {
            margin: 16px;
        }
        
        .header {
            padding: 24px;
        }
        
        .header-icon {
            font-size: 40px;
        }
    }

    /* 添加动画效果 */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-icon">
                <i class="fas fa-cog fa-spin"></i>
            </div>
            <h1>接口配置中心</h1>
            <p>请输入您的自定义接口地址</p>
        </div>

        <div class="content">
            <form method="post">
                <div class="input-group">
                    <input type="text" name="money" placeholder="请输入接口地址" required>
                    <i class="input-icon fas fa-link"></i>
                </div>
                <button type="submit" name="sub">
                    <i class="fas fa-save"></i>
                    保存配置
                </button>
            </form>
        </div>

        <div class="footer">
            <i class="fas fa-shield-alt"></i>
            系统将自动验证接口的有效性
        </div>
    </div>

    <?php
    if(isset($_POST["sub"])){
        $files=fopen("pay.txt","w") or die("非法操作,请联系管理员！");
        $txt=$_POST["money"];
        fwrite($files,$txt);
        fclose($files);
        echo '<script>alert("配置更新成功");</script>';
    }
    ?>
</body>
</html>