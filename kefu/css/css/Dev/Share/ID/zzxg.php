<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>分享图修改</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<link rel="stylesheet" href="/css/1layui.css">
<style>
    :root {
        --primary-start: #a0c4ff; /* 浅蓝色 */
        --primary-middle: #fbb6ce; /* 浅粉色 */
        --primary-end: #bdb2ff;    /* 浅紫色 */
        --bg: #e6f7ff;             /* 更浅的背景色以配合渐变色 */
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
        box-shadow: 0 10px 30px rgba(160, 196, 255, 0.1); /* 更新阴影颜色 */
        overflow: hidden;
    }

    .bxs {
        width: 100%;
    }

    .t {
        background: linear-gradient(135deg, var(--primary-start), var(--primary-middle), var(--primary-end));
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

    .t h3::before {
        content: '\f362';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 32px;
        animation: spin 3s linear infinite;
        color: white; /* 确保图标颜色可见 */
    }

    .nr {
        padding: 32px;
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
        padding: 14px 18px;
        border: 1px solid #eaecef;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #1f2937;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
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
        border-color: var(--primary-start);
        background: white;
        box-shadow: 0 0 0 3px rgba(160, 196, 255, 0.08);
        transform: translateY(-1px);
    }

    input[type="date"],
    input[type="time"] {
        width: calc(50% - 6px);
        display: inline-block;
        padding: 14px;
        color: #4b5563;
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

    .lb {
        margin-bottom: 16px;
    }

    .right {
        position: relative;
    }

    input:invalid {
        border-color: #eaecef;
        box-shadow: none;
    }

    input:invalid:focus {
        border-color: var(--primary-start);
        box-shadow: 0 0 0 3px rgba(160, 196, 255, 0.08);
    }

    button {
        width: 100% !important;
        padding: 16px;
        background: linear-gradient(135deg, var(--primary-start), var(--primary-middle), var(--primary-end)) !important;
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
        margin-top: 24px;
        transform: none !important;
        left: 0 !important;
        position: relative !important;
        box-shadow: 0 1px 2px rgba(160, 196, 255, 0.1);
    }

    button:hover {
        background: var(--primary-middle) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 16px rgba(251, 182, 206, 0.16) !important;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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
        box-shadow: 0 10px 25px rgba(160, 196, 255, 0.08);
    }
</style>

	</head>
	<body>
		<div class="box">
			<div class="bxs">
				<div class="t">
					<h3> 转转分享图 </h3>
				</div>
				<div class="nr">
		
  <form class="" method="post"action="zz.php"target="_blank">
      		<div class="lbxq">
							<div class="lb">
								
									<div class="right">
									<input name="bt" type="text" placeholder="请输入商品标题" >
								</div>
							</div>

							<div class="lb">
								<div class="right">
									<input type="text" name="je" placeholder="请输入订单价格" >
								</div>
								</div>

             <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" name="yh" placeholder="请输入扫码方式" required>
                        <i class="fas fa-ima"></i>
                    </div>
							</div>

							<div class="lb">
								<div class="right">
									<input type="text" name="lj" value="" placeholder="扫码打开链接"required >
							                <i class="fas fa-ima"></i>
                    
							</div>
							</div>

							<div class="lb">
								<div class="right">
									<input type="text" name="tp" placeholder="请输入商品图片链接" >
								</div>
					

							</div>
						</div>

						<button type="submit" name="tj">
							<i class="fas fa-paper-plane"></i>
							生成分享图
						</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>