<!DOCTYPE html>

   

<html lang="zh" style="">
<head>
    
<meta charset="UTF-8">
    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
<title>支付宝订单详情修改</title>
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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
            --primary: #C5C1FF;
            --primary-light: #C5C1FF;
            --blue-gradient: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
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
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            position: relative;
        }

        .header {
            background: var(--blue-gradient);
            padding: 40px 30px;
            color: white;
            text-align: center;
        }

        .header::after {
            content: '';
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to bottom right, transparent 49%, white 51%);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .header p {
            font-size: 15px;
            opacity: 0.9;
        }

        .form-content {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            transition: all 0.3s;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8fafc;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        input:focus+i {
            color: var(--primary);
        }

		input[type="date"],
		input[type="time"] {
			width: 100%;
			padding: 14px;
			color: #4b5563;
			-webkit-appearance: none;
			appearance: none;
		}

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .datetime-group input {
            padding-left: 16px;
        }

        button {
            width: 100%;
            padding: 16px;
            background: var(--blue-gradient);
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

        button:hover {
            transform: translateY(-2px);
        }

        button i {
            font-size: 18px;
        }

        /* 选择头像的下拉菜单美化 */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper select {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L4 3H0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 12px 12px;
            cursor: pointer;
            appearance: none;
        }

        .select-wrapper select:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .select-wrapper select:focus+i {
            color: var(--primary);
        }

        .select-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            transition: all 0.3s;
            font-size: 16px;
        }

        /* 添加动画效果 */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .header i {
            font-size: 32px;
            margin-bottom: 15px;
            display: block;
            animation: float 3s ease-in-out infinite;
        }

        /* 输入框动画 */
        .input-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .input-wrapper:focus-within::after {
            transform: scaleX(1);
        }

        @media (max-width: 480px) {
            .container {
                margin: 10px;
            }

            .header {
                padding: 30px 20px;
            }

            .form-content {
                padding: 20px;
            }
        }
    </style>
</head>

<!-- 精美返回按钮 -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left back-icon"></i>
    </a>
<body style="">
    
<div class="container" style="">
        
<div class="header">
            
<i class="fas fa-shield-alt"></i>
            
<h1> 支付失败图 </h1>
        </div>

        
<div class="form-content" style="">
            
<form method="post" action="shibai.php" target="_blank" style="">
                
<div class="form-group">
                    
<div class="datetime-group">
                    
<input type="date" name="sj" id="currentDate" required="" min="">
                    
<input type="time" name="sj1" id="currentTime" required="">
                    </div>
                </div>

                
<div class="form-group">
                    
<div class="input-wrapper">
                        
<input type="text" placeholder="请输入付款金额" name="je" value="">
                        
<i class="fas fa-coins"></i>
                    </div>
                </div>

              <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" placeholder=" 请输入鱼的真实姓名 " name="mjmc" required>
                        <i class="fas fa-comment-dots"></i>
          
                    </div>
                </div>
     

                
             
<button type="submit" name="tj">
                    
<i class="fas fa-paper-plane"></i>
                    提交订单
                </button>
            </form>
        </div>
    </div>
 <script>
		function initDateTime() {
			const now = new Date();

			const dateInput = document.getElementById('currentDate');
			dateInput.value = now.toISOString().split('T')[0];
			dateInput.min = dateInput.value;

			const timeInput = document.getElementById('currentTime');
			const hours = String(now.getHours()).padStart(2, '0');
			const minutes = String(now.getMinutes()).padStart(2, '0');
			timeInput.value = `${hours}:${minutes}`;
		}

        function updatePlatformInfo() {
            const platformSelect = document.getElementById('platform');
            const avatarUrlInput = document.getElementById('avatarUrl');
            const platformNameInput = document.getElementById('platformName');

            const platforms = {
                '': {
                    name: '',
                    avatarUrl: `//`
               
                }
            };

            const selectedPlatform = platformSelect.value;
            platformNameInput.value = platforms[selectedPlatform].name;
            avatarUrlInput.value = platforms[selectedPlatform].avatarUrl;
        }

        document.addEventListener('DOMContentLoaded', () => {
            initDateTime();
            updatePlatformInfo();
            document.getElementById('platform').addEventListener('change', updatePlatformInfo);
        });

	</script>


</body></html>
