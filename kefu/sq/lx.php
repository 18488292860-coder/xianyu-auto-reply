<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>金条</title>
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
            --primary: #1677ff;
            --bg: #f0f5ff;
            --text: #1f2937;
            --secondary: #64748b;
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
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, var(--primary), #4096ff);
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
            margin-bottom: 10px;
        }

        .header i {
            font-size: 36px;
            margin-bottom: 15px;
            display: block;
        }

        .content {
            padding: 30px;
        }

        .notice-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            position: relative;
        }

        .notice-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            color: var(--primary);
            font-weight: 600;
            font-size: 18px;
        }

        .notice-title i {
            font-size: 20px;
        }

        .notice-text {
            color: var(--secondary);
            font-size: 15px;
            line-height: 1.8;
        }

        .steps {
            margin-top: 24px;
            display: grid;
            gap: 16px;
        }

        .step-item {
            display: flex;
            gap: 12px;
            padding: 16px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .step-number {
            width: 28px;
            height: 28px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }

        .step-content {
            flex-grow: 1;
        }

        .step-title {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
        }

        .step-desc {
            color: var(--secondary);
            font-size: 14px;
        }

        @media (max-width: 640px) {
            .container {
                margin: 10px;
                border-radius: 16px;
            }
            
            .header {
                padding: 24px;
            }
            
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- 精美返回按钮 -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left back-icon"></i>
    </a>
    
    <div class="container">
        <div class="header">
        <i class=""></i>
            <h1>金条联系方式</h1>
        </div>

        <div class="content">
            <div class="notice-card">
                <div class="notice-title">
                    <i class="fas fa-info-circle"></i>
                    联系说明
                </div>
                <div class="notice-text">
           金条专注小学生</div>
            </div>

            <div class="steps">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <div class="step-title">海鸥</div>
                        <div class="step-desc">@610626347</a></div>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <div class="step-title"> tg</div>
                        <div class="step-desc">@jintiao789</a></div>
                    </div>
                </div>
                    <div class="steps">
                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <div class="step-title">金条:业务交流</div>
                        <div class="step-desc">TG:@jintiao789</a></div>
                    </div>
                </div>      
                
                
                
                
                
                
                
                
                
                
            </div>
        </div>
    </div>
</body>
</html>