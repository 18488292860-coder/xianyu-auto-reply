<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>找回包赔交易警示 - 螃蟹游戏平台</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #e6e6e6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 15px;
            border: 1px solid rgba(255, 60, 60, 0.3);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
            animation: pulse 3s infinite;
        }
        
        .header h1 {
            color: #ff4d4d;
            font-size: 2.8rem;
            margin-bottom: 10px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        
        .header p {
            font-size: 1.2rem;
            color: #ff9999;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .warning-card {
            background: rgba(30, 30, 46, 0.8);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 80, 80, 0.4);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }
        
        .warning-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff0000, #ff6666);
        }
        
        .warning-card h2 {
            color: #ff6666;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 1.8rem;
        }
        
        .warning-card h2 i {
            margin-right: 15px;
            font-size: 2rem;
        }
        
        .warning-card p {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .highlight {
            color: #ff9999;
            font-weight: bold;
            background: rgba(255, 0, 0, 0.1);
            padding: 2px 8px;
            border-radius: 5px;
            display: inline-block;
        }
        
        .critical {
            color: #ff4d4d;
            font-weight: 800;
            font-size: 1.3rem;
            text-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
        }
        
        .penalty-box {
            background: rgba(255, 0, 0, 0.15);
            border-left: 5px solid #ff4d4d;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .consequences {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .consequence-item {
            background: rgba(50, 50, 70, 0.6);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }
        
        .consequence-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 50, 50, 0.2);
        }
        
        .consequence-item i {
            font-size: 2.5rem;
            color: #ff6666;
            margin-bottom: 15px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 25px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            font-size: 1.1rem;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #ff0000, #ff5252);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            margin: 20px 0;
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.4);
            transition: all 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 0, 0, 0.6);
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 20px rgba(255, 0, 0, 0.2); }
            50% { box-shadow: 0 0 30px rgba(255, 0, 0, 0.4); }
            100% { box-shadow: 0 0 20px rgba(255, 0, 0, 0.2); }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2.2rem; }
            .warning-card { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-exclamation-triangle"></i> 重要交易警示通知</h1>
            <p>尊敬的游戏卖家，请仔细阅读以下关于找回包赔交易的警示信息</p >
        </div>
        
        <div class="warning-card">
            <h2><i class="fas fa-info-circle"></i> 交易状态说明</h2>
            <p>很抱歉卖家，由于当前交易订单已在系统后台记录受理中，买家方面已办理完成所有手续，<span class="highlight">当前交易是不能取消了的</span>。</p >
            <p>如您强行取消了本次交易将会导致我们系统自动进行<span class="critical">冻结处理您所出售的游戏账号</span>以及买家的全部资金。</p >
        </div>
        
        <div class="warning-card">
            <h2><i class="fas fa-shield-alt"></i> 平台安全政策</h2>
            <p>您好，这是本平台与公安网监连同制定的防骗交易流程，请您按照流程完成交易。</p >
            <p>若您拒绝办理，系统将视为恶意终止交易存在诈骗嫌疑而<span class="critical">冻结资金与您在我们螃蟹游戏平台出售的个人游戏账户</span>，我们平台会配合相关工作！</p >
        </div>
        
        <div class="warning-card">
            <h2><i class="fas fa-gavel"></i> 违约后果警示</h2>
            <p>亲，本平台是个信誉平台。由于交易已经进行，现在放弃交易是属于违规违约操作的。</p >
            <p>如果您交易进行中将对您的螃蟹账号注册的微信用户记录<span class="highlight">不良行为记录</span>，您将违约处罚<span class="critical">违约金20000.00元违约赔偿</span>！</p >
            <p>我们将联系网警联系您当地派出所联系您本人，与您和您的家人协商配合处理！</p >
            
            <div class="penalty-box">
                <p><i class="fas fa-exclamation-circle"></i> 重要提示：如您无法办理完成本次找回包赔业务事项，将使您的<span class="critical">个人征信不良</span>，导致：</p >
            </div>
            
            <div class="consequences">
                <div class="consequence-item">
                    <i class="fas fa-user-graduate"></i>
                    <p>无法上好的大学</p >
                </div>
                <div class="consequence-item">
                    <i class="fas fa-medal"></i>
                    <p>无法当兵</p >
                </div>
                <div class="consequence-item">
                    <i class="fas fa-home"></i>
                    <p>无法贷款买车买房</p >
                </div>
                <div class="consequence-item">
                    <i class="fas fa-plane"></i>
                    <p>无法乘坐高铁和飞机</p >
                </div>
            </div>
        </div>
        
        <div class="warning-card">
            <h2><i class="fas fa-comments"></i> 平台建议</h2>
            <p>为了您的个人信用和合法权益不受损害，我们强烈建议您：</p >
            <ul style="padding-left: 30px; margin: 20px 0;">
                <li>立即完成当前交易流程</li>
                <li>不要尝试取消已受理的交易</li>
                <li>遵守平台交易规则和流程</li>
                <li>保护您的个人信用记录</li>
            </ul>
            <div style="text-align: center; margin: 25px 0;">
                <button class="btn">立即完成找回包赔流程</button>
            </div>
        </div>
        
        <div class="footer">
            <p>螃蟹游戏平台 · 保障交易安全 · 维护买卖双方权益</p >
            <p>请珍惜您的信用记录，遵守平台规则，共同营造安全可靠的交易环境</p >
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-headset"></i>
                    <span>客服热线: 400-629-392</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>客服邮箱: support@pangxie.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>服务时间: 24/7</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 添加简单的交互效果
        document.addEventListener('DOMContentLoaded', function() {
            const criticalElements = document.querySelectorAll('.critical');
            
            // 关键信息闪烁提醒
            setInterval(() => {
                criticalElements.forEach(el => {
                    el.style.opacity = el.style.opacity === '0.7' ? '1' : '0.7';
                });
            }, 1000);
            
            // 按钮点击效果
            const btn = document.querySelector('.btn');
            if(btn) {
                btn.addEventListener('click', function() {
                    alert('请联系螃蟹客服...');
                    // 实际应用中这里会跳转到相应页面
                });
            }
        });
    </script>
</body>
</html>