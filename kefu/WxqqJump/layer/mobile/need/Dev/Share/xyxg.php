<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>闲鱼分享图修改</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/css/1layui.css">
    <style>
:root {
    --primary: #FFD700; /* 黄色 */
    --hover: #FFC300;  /* 稍深的黄色 */
    --bg: #fff5f5;
    --text: #1f2937;
    --border: #e5e7eb;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: linear-gradient(135deg, var(--bg) 0%, #ffffff 100%);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.container {
    width: 100%;
    max-width: 480px;
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.1); /* 修改为黄色的阴影 */
    overflow: hidden;
}

.header {
    background: linear-gradient(135deg, var(--primary), var(--hover));
    padding: 30px;
    color: white;
    text-align: center;
    position: relative;
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
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 8px;
}

.header i {
    font-size: 36px;
    margin-bottom: 16px;
    display: block;
    animation: float 3s ease-in-out infinite;
}

.form-content {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.input-wrapper {
    position: relative;
}

.input-wrapper i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    transition: all 0.3s;
}

input {
    width: 100%;
    padding: 14px 14px 14px 48px;
    border: 2px solid var(--border);
    border-radius: 16px;
    font-size: 15px;
    transition: all 0.3s;
    background: #f9fafb;
}

input:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.1); /* 修改为黄色的阴影 */
}

input:focus + i {
    color: var(--primary);
}

button {
    width: 100%;
    padding: 16px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 30px;
}

button:hover {
    background: var(--hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 215, 0, 0.2); /* 修改为黄色的阴影 */
}

@media (max-width: 480px) {
    .container {
        margin: 10px;
    }
    
    .header {
        padding: 24px;
    }
    
    .form-content {
        padding: 20px;
    }
}

/* 添加动画效果 */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}


    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-fish"></i>
            <h1>闲鱼分享图</h1>
        </div>

        <div class="form-content">
  <form class="" method="post"action="xy.php"target="_blank">                <div class="form-group">
                    <div class="input-wrapper">
                        <input name="bt" type="text" placeholder="请输入商品标题" >
                        <i class="fas fa-heading"></i>
                    </div>
                </div>

                                
<div class="form-group">
                    
<div class="input-wrapper">
                        
<input type="text" name="je" placeholder="请输入订单价格">
                        
                        <i class="fas fa-yen-sign"></i>
                    </div>
                    </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" name="yh" placeholder=" 请输入扫码方式 " required>
                        <i class="fas fa-share-square"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                       <input type="text" name="lj"value="" placeholder="输入扫码打开链接" /required>
                        <i class="fas fa-link"></i>
                    </div>
                </div>

               
                
<div class="form-group">
                    
<div class="input-wrapper">
                        
<input type="text" name="tp" placeholder="请输入商品图片链接">
                        <i class="fas fa-image"></i>
                    </div>
                </div>

                <button type="submit" name="tj">
                    <i class="fas fa-magic"></i>
                    生成分享图
                </button>
            </form>
        </div>
    </div>
</body>
</html>