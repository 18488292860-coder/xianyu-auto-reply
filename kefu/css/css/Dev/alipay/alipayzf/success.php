<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新完毕回调</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
      <link rel="stylesheet" href="/css/1layui.css"/>
 <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-start: #a0c4ff; /* 浅蓝色 */
        --primary-middle: #fbb6ce; /* 浅粉色 */
        --primary-end: #bdb2ff;    /* 浅紫色 */
        --bg-color: #f0f8ff;       /* 浅蓝色背景 */
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
        box-shadow: 0 10px 40px rgba(160, 196, 255, 0.05); /* 更新阴影颜色 */
        width: 100%;
        max-width: 420px;
        text-align: center;
    }

    .success-icon {
        font-size: 64px;
        color: #52c41a; /* 保持绿色不变或根据需要调整 */
        margin-bottom: 24px;
        animation: bounce 1s ease;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-30px);}
        60% {transform: translateY(-15px);}
    }

    .title {
        font-size: 24px;
        color: var(--text-color);
        margin-bottom: 16px;
        font-weight: 600;
    }

    .amount {
        font-size: 20px;
        color: #1677ff; /* 可以根据需要调整为渐变色 */
        margin-bottom: 32px;
        font-weight: 500;
    }

    .button-group {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        justify-content: center;
    }

    .primary-button {
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--primary-start), var(--primary-middle), var(--primary-end));
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }

    .primary-button:hover {
        background: linear-gradient(135deg, var(--primary-middle), var(--primary-end));
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(189, 178, 255, 0.2); /* 更新阴影颜色 */
    }

    .copy-button {
        padding: 12px 24px;
        background: white;
        color: var(--primary-start);
        border: 1px solid var(--primary-start);
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .copy-button:hover {
        background: #f0f7ff;
        transform: translateY(-2px);
        border-color: var(--primary-middle);
    }

    .hint-text {
        color: #666;
        font-size: 14px;
        margin-top: 16px;
    }

    /* 添加响应式调整 */
    @media (max-width: 480px) {
        .container {
            padding: 30px 20px;
        }

        .button-group {
            flex-direction: column;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1 class="title">修改成功</h1>
        <p class="amount">金额已更新 <span id="pays"></span></p>
        
        <div class="button-group">
            <a href="index.php" class="primary-button">
                <i class="fas fa-arrow-right"></i>
                查看修改结果
            </a>
            <button type="button" class="copy-button" id="copyButton">
                <i class="fas fa-copy"></i>
                复制链接
            </button>
        </div>
        
        <p class="hint-text">点击按钮即可复制链接</p>
    </div>

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyButton = document.getElementById('copyButton');
        const url = 'http://' + '<?php echo $_SERVER["HTTP_HOST"]; ?>' + '/Dev/alipay/alipayzf/index.php';
        
        copyButton.addEventListener('click', function() {
            copyLink(url);
        });
    });

    function copyLink(textToCopy) {
        if (navigator.clipboard && window.isSecureContext) {
            // 现代浏览器 API
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    showToast('链接复制成功 ✨');
                })
                .catch(() => {
                    fallbackCopyText(textToCopy);
                });
        } else {
            // 降级方案
            fallbackCopyText(textToCopy);
        }
    }

    function fallbackCopyText(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        
        // 设置样式使文本域不可见
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        textArea.style.top = '0';
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showToast('链接复制成功);
        } catch (err) {
            showToast('复制失败，请重试', true);
            console.error('复制失败:', err);
        }
        
        document.body.removeChild(textArea);
    }

    function showToast(message, isError = false) {
        Toastify({
            text: message,
            duration: 2000,
            gravity: "top",
            position: "center",
            style: {
                background: isError ? "#ff4d4f" : "#52c41a",
                borderRadius: "8px",
                padding: "12px 24px",
            }
        }).showToast();
    }
    </script>
</body>
</html>