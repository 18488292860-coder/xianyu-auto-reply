<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>陈宣支付</title>
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
        }
        
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://images.unsplash.com/photo-1499002238440-d264edd596ec') center/cover no-repeat;
            background-color: #f0f2f5;
        }
        
        /* 玻璃质感长方形按钮容器 */
        .glass-container {
            display: flex;
            gap: 30px;
        }
        
        /* 玻璃质感按钮 */
        .glass-btn {
            position: relative;
            width: 180px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 18px;
            font-weight: 500;
            text-decoration: none;
            overflow: hidden;
            transition: all 0.5s ease;
            z-index: 1;
        }
        
        /* 玻璃按钮悬停效果 */
        .glass-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.25);
            background: rgba(255, 255, 255, 0.25);
        }
        
        /* 玻璃按钮点击效果 */
        .glass-btn:active {
            transform: translateY(0) scale(0.98);
        }
        
        /* 流光动画效果 */
        .glass-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
            z-index: -1;
        }
        
        .glass-btn:hover::before {
            left: 100%;
        }
        
        /* 按钮文字图标 */
        .btn-icon {
            margin-right: 10px;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        
        .glass-btn:hover .btn-icon {
            transform: rotate(15deg);
        }
        
        /* 不同颜色的按钮 */
        .btn-blue {
            background: rgba(64, 158, 255, 0.15);
            border: 1px solid rgba(64, 158, 255, 0.25);
        }
        
        .btn-purple {
            background: rgba(145, 85, 253, 0.15);
            border: 1px solid rgba(145, 85, 253, 0.25);
        }
        
        .btn-pink {
            background: rgba(255, 105, 180, 0.15);
            border: 1px solid rgba(255, 105, 180, 0.25);
        }
    </style>
    <!-- 引入FontAwesome图标 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
     <!-- 精美返回按钮 -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left back-icon"></i>
    </a>   </a>
        
        <!-- 紫色按钮 - 跳转到page2.html -->
        <a href="/Dev/Pay/fkxg.php" class="glass-btn btn-purple">
            <i class="fas fa-image btn-icon"></i>
            支付成功
        </a>
        
        <!-- 粉色按钮 - 跳转到page3.html -->
        <a href="/Dev/Pay/fksb.php" class="glass-btn btn-pink">
            <i class="fas fa-music btn-icon"></i>
            支付失败
        </a>
    </div>
</body>
</html>