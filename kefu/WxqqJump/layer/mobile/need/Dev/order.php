<html lang="zh-CN" style="">
<head>
    
<meta charset="UTF-8">
    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
<title>yao</title>
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="/css/1layui.css"/>
 <style>
    :root {
        --primary: #a0c4ff; /* 浅蓝色 */
        --secondary: #bdb2ff; /* 浅紫色 */
        --tertiary: #ffc6ff; /* 浅粉色 */
        --bg: #f0f5ff;
        --text: #1f2937;
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
        background: linear-gradient(135deg, var(--primary), var(--secondary));
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
</style></head>

<body style="">
    
<div class="container" style="">
        
<div class="header">
            
<i class="fas fa-link"></i>
            
<h1>使用指南</h1>
        </div>

        
<div class="content" style="">
            
<div class="notice-card">
                
<div class="notice-title">
                    
<i class="fas fa-info-circle"></i>
                    使用说明
                </div>
                
<div class="notice-text">
                    订单客服链接过长时，可能会影响分享图转码。我们提供了防红功能来解决这个问题。
                </div>
            </div>

            
<div class="steps" style="">
                
<div class="step-item" style="">
                    
<div class="step-number">1</div>
                    
<div class="step-content">
                        
<div class="step-title">编辑订单客服</div>
                        
<div class="step-desc"> 完成订单客服的编辑操作 </div>
                    </div>
                </div>

                
<div class="step-item">
                    
<div class="step-number">2</div>
                    
<div class="step-content">
                        
<div class="step-title">找到防红功能</div>
                        
<div class="step-desc"> 在功能栏上方找到防红短链 </div>
                    </div>
                </div>

                
<div class="step-item" style="">
                    
<div class="step-number">3</div>
                    
<div class="step-content">
                        
<div class="step-title">转换链接</div>
                        
<div class="step-desc">将长链接转换为防红链接，方便分享和使用 </div>
       </div>
                </div>

                
<div class="step-item" style="">
                    
<div class="step-number">4</div>
                    
<div class="step-content">
                        
<div class="step-title"> 生成分享图 </div>
                        
<div class="step-desc"> 把短链接输入到对应的分享图打开链接里扫码就有订单了 </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>