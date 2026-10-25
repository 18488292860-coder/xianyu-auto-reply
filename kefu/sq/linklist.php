<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>链接复制</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/css/1layui.css">
<style>
    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        /* 精美返回按钮 */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            transition: all 0.3s ease;
            color: #666;
            text-decoration: none;
        }
        
        .back-button:hover {
            transform: translateX(-3px);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            color: #ff6b8b;
        }
        
        .back-icon {
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .back-button:hover .back-icon {
            transform: scale(1.2);
        }
        
        /* 内容区域 */
        .content {
            padding: 80px 20px 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    
        :root {
            --primary: #0066ff;
            --hover: #3385ff;
            --text: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: MainFont, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        @font-face {
            font-family: 'MainFont';
            src: url('/css/Font.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

               body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
            padding: 30px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: white;
            border-radius: 50% 50% 0 0;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .content {
            padding: 24px;
            display: grid;
            gap: 16px;
        }

        .avatar-button {
            display: flex;
            align-items: center;
            padding: 16px;
            background: white;
            border: 1px solid #eef2ff;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text);
        }

        .avatar-button:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
        }

        .avatar-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .avatar-button:hover .avatar-icon {
            transform: scale(1.1);
        }

        .avatar-info {
            flex-grow: 1;
        }

        .avatar-name {
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 15px;
            color: #333;
        }

        .avatar-hint {
            font-size: 13px;
            color: #666;
        }

        .copy-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .avatar-button:hover .copy-icon {
            background: #f0f7ff;
            color: var(--primary);
        }

        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            background: #333;
            color: white;
            border-radius: 50px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
        }

        .toast i {
            color: #4ade80;
        }

        @media (max-width: 480px) {
            .container {
                margin: 10px;
            }
        }
    </style>
</head>
  <!-- 精美返回按钮 -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left back-icon"></i>
    </a>
<body>
  <div class="container">
    <div class="header">
      <h1>链接中心</h1>
      <p>点击即可复制对应平台链接</p>
    </div>
    <div class="content">
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/goofish.php')">
        <div class="avatar-icon"><i class="fas fa-fish"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">闲鱼</div>
          <div class="avatar-hint">点击复制链接</div>
        </div>
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
      </div>
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/zhuanzhuan.php')">
        <div class="avatar-icon"><i class="fas fa-sync-alt"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">转转</div>
          <div class="avatar-hint">点击复制链接</div>
        </div>
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
      </div>
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/jiaoyimao.php')">
        <div class="avatar-icon"><i class="fas fa-store"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">交易猫</div>
          <div class="avatar-hint">点击复制链接</div>
        </div>
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
      </div>
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/pangxie.php')">
        <div class="avatar-icon"><i class="fab fa-gitlab"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">螃蟹</div>
          <div class="avatar-hint">点击复制链接</div>
        </div>
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
      </div>
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/panzhi.php')">
        <div class="avatar-icon"><i class="fas fa-heart"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">盼之</div>
          <div class="avatar-hint">点击复制链接</div>
        </div>
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
      </div>
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/kejinshou.php')">
        <div class="avatar-icon"><i class="fas fa-crown"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">氪金兽</div>
          <div class="avatar-hint">点击复制链接</div>
      </div>
      
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
        </div>
      <div class="avatar-button" onclick="copyText('http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/panzhi/pz.html')">
        <div class="avatar-icon"><i class="fas fa-link"></i></div>
        <div class="avatar-info">
          <div class="avatar-name">盼之官网</div>
          <div class="avatar-hint">点击复制链接</div>
        </div>
        <div class="copy-icon"><i class="fas fa-copy"></i></div>
        </div>
      
      </div>
    </div>
  </div>
  <script>
    function copyText(text) {
      const input = document.createElement('input');
      input.style.cssText = 'position:fixed;opacity:0';
      input.value = text;
      document.body.appendChild(input);
      input.select();
      document.execCommand('copy');
      document.body.removeChild(input);
      showToast();
    }

    function showToast() {
      const toast = document.createElement('div');
      toast.className = 'toast';
      toast.innerHTML = '<i class="fas fa-check-circle"></i><span>客服链接复制成功</span>';
      document.body.appendChild(toast);
      setTimeout(() => toast.remove(), 2000);
    }
  </script>
</body>

</html>