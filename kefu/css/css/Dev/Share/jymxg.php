<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>交易猫分享图修改</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"><link rel="stylesheet" href="/css/1layui.css">
<style>
    :root {
        --primary: #ff7b00; /* 橙色主色 */
        --hover: #ff9c4d; /* 橙色悬停色 */
        --bg: #fff8f0; /* 背景色改为浅橙色 */
        --text: #1f2937; /* 文本颜色保持不变或根据需要调整 */
        --border: #ffe0b2; /* 边框颜色改为浅橙色 */
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
        max-width: 500px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
        font-size: 32px;
        margin-bottom: 16px;
        display: block;
    }

    .form-content {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--text);
        font-size: 14px;
        font-weight: 500;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        transition: all 0.3s;
    }

    input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
        background: #f9fafb;
    }

    input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 123, 0, 0.1); /* 调整阴影颜色为橙色 */
    }

    input:focus + i {
        color: var(--primary);
    }

    .datetime-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .datetime-group input {
        padding-left: 12px;
    }

    button[type="submit"] {
        width: 100%;
        padding: 14px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    button[type="submit"]:hover {
        background: var(--hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 156, 77, 0.2); /* 调整阴影颜色为橙色 */
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
</style>

</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-share-alt"></i>
            <h1>交易猫分享图</h1>
        </div>

        <div class="form-content">

  <form class="" method="post"action="jym.php"target="_blank">                <div class="form-group">
                    <label></label>
                    <div class="input-wrapper">
                        <input name="bt" type="text" placeholder="请输入商品内容" >
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrapper">
                        <input name="nr" type="text" placeholder="请输入商品标题" >
                        <i class="fas fa-heading"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrapper">
                        <input name="je" type="text" placeholder="请输入订单价格" >
                        <i class="fas fa-yen-sign"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrapper">
                        <input name="lj" type="text" value="" placeholder="扫码打开链接" >
                        <i class="fas fa-link"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrapper">
                        <input name="tp" type="text" placeholder="请输入商品图片链接">
                        <i class="fas fa-image"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrapper">
                        <input name="mjmc" type="text" placeholder="请输入卖家名称">
                        <i class="fas fa-user"></i>
                    </div>

                <div class="form-group">
                    <label></label>
                                     <div class="datetime-group">
                     <input type="date" name="sj" id="currentDate" required="" min="">
                    
<input type="time" name="sj1" id="currentTime" required="">
                    </div>
                </div>

                <button type="submit" name="tj">
                    <i class="fas fa-paper-plane"></i>
                    生成分享图
                </button>
            </form>
        </div>
    </div>
</body>
</html>