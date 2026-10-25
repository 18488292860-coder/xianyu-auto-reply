<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>螃蟹分享图修改</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<link rel="stylesheet" href="/css/1layui.css">
	<style>
    :root {
        --primary: #ff9900; /* 橙色 */
        --hover: #ffcc00;   /* 黄色 */
        --bg: #fff9e6;      /* 浅黄色背景以配合橙色和黄色 */
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

    .box {
        width: 100%;
        max-width: 480px;
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(255, 153, 0, 0.1); /* 更新阴影颜色 */
        overflow: hidden;
    }

    .t {
        background: linear-gradient(135deg, var(--primary), var(--hover));
        padding: 40px 30px;
        color: white;
        text-align: center;
        position: relative;
    }

    .t::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        right: 0;
        height: 20px;
        background: white;
        border-radius: 50% 50% 0 0;
    }

    .t h3 {
        font-size: 26px !important;
        font-weight: 600;
        margin: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .t i {
        font-size: 40px;
        margin-bottom: 16px;
        display: block;
        animation: float 3s ease-in-out infinite;
        color: white; /* 确保图标颜色可见 */
    }

    .nr {
        padding: 30px;
    }

    .lb {
        margin-bottom: 20px;
    }

    .right {
        position: relative;
    }

    .right i {
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

    input::placeholder {
        color: #94a3b8;
    }

    input:hover {
        border-color: #d0d7de;
        background: #fafbfc;
    }

    input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 153, 0, 0.1); /* 更新阴影颜色 */
    }

    input:focus + i {
        color: var(--primary);
    }

    input[type="date"],
    input[type="time"] {
        padding-left: 14px;
        width: calc(50% - 6px);
        display: inline-block;
    }

    input[type="date"] {
        margin-right: 12px;
    }

    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        opacity: 0.6;
        cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator:hover,
    input[type="time"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }

    button {
        width: 100% !important;
        padding: 16px;
        background: var(--primary) !important;
        color: white;
        border: none;
        border-radius: 16px !important;
        font-size: 16px !important;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
        transform: none !important;
        left: 0 !important;
        position: relative !important;
        box-shadow: 0 1px 2px rgba(255, 153, 0, 0.1);
    }

    button:hover {
        background: var(--hover) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(255, 204, 0, 0.2); /* 更新阴影颜色 */
    }

    .input-tip {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
        padding-left: 16px;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @media (max-width: 480px) {
        .box {
            margin: 10px;
        }
        
        .t {
            padding: 30px 20px;
        }
        
        .nr {
            padding: 20px;
        }
    }

    /* 添加输入框组标签 */
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        color: #4b5563;
        font-weight: 500;
    }

    /* 优化卡片样式 */
    .box {
        box-shadow: 0 10px 25px rgba(255, 153, 0, 0.08);
    }
</style>
	</head>
	<body>
		<div class="box">
			<div class="t">
<i class="fab fa-gitlab"></i>				<h3>螃蟹分享图</h3>
			</div>

			<div class="nr">
  <form class="" method="post"action="px.php"target="_blank">					<div class="lbxq">
						<div class="lb">
							<div class="right">
								<input name="bt" type="text" placeholder="请输入商品内容" required>
								<i class="fas fa-shopping-cart"></i>
							</div>
						</div>

						<div class="lb">
							<div class="right">
								<input name="nr" type="text" placeholder="请输入商品标题" required>
								<i class="fas fa-heading"></i>
							</div>
						</div>

						<div class="lb">
							<div class="right">
								<input type="text" name="je" placeholder="请输入订单价格" required>
								<i class="fas fa-yen-sign"></i>
							</div>
						</div>

						<div class="lb">
							<div class="right">
								<input type="text" name="lj" value="" placeholder="扫码打开链接" required>
								<i class="fas fa-qrcode"></i>
							</div>
						</div>

						<div class="lb">
							<div class="right">
								<input type="text" name="tp" placeholder="请输入商品图片链接" required>
								<i class="fas fa-image"></i>
							</div>
							
						</div>

						<div class="lb">
							<div class="right">
								<input type="text" name="mjmc" placeholder="请输入卖家名称" required>
								<i class="fas fa-user"></i>
							</div>
						</div>

						<div class="lb">
							<div class="right">
								<input type="date" name="sj" required>
								<input type="time" name="sj1" required>
							</div>
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