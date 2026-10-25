<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支付宝收款码风控通知</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'PingFang SC', 'Microsoft YaHei', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fc 0%, #eef2f7 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 32, 94, 0.15);
            display: flex;
            flex-direction: column;
        }
        
        /* 头部样式 */
        .header {
            background: linear-gradient(135deg, #1a3a5c 0%, #2c5282 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .header::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -50px;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            background: white;
            padding: 5px;
        }
        
        .logo-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #fff;
        }
        
        .title {
            font-size: 32px;
            font-weight: 700;
            margin: 15px 0;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .subtitle {
            font-size: 18px;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }
        
        /* 内容区域 */
        .content-wrapper {
            display: flex;
            min-height: 500px;
        }
        
        .sidebar {
            width: 280px;
            background: linear-gradient(to bottom, #f0f7ff 0%, #e6f7ff 100%);
            padding: 30px;
            border-right: 1px solid #e1e8f0;
        }
        
        .notification-info {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
        }
        
        .info-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 16px;
        }
        
        .info-label {
            width: 100px;
            font-weight: 500;
            color: #5a6c84;
        }
        
        .info-value {
            flex: 1;
            font-weight: 500;
        }
        
        .contact-box {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            text-align: center;
        }
        
        .contact-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .crab-contact-btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b6b, #ff8e53);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            margin: 15px 0;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .crab-contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }
        
        .crab-contact-btn i {
            font-size: 24px;
        }
        
        .contact-time {
            text-align: center;
            color: #5a6c84;
            font-size: 15px;
            margin-top: 15px;
        }
        
        .main-content {
            flex: 1;
            padding: 40px;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #1a3a5c;
            padding-bottom: 15px;
            border-bottom: 2px solid #e1e8f0;
        }
        
        .section-title i {
            background: linear-gradient(135deg, #4ecdc4, #2c9bb8);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .highlight-box {
            background: linear-gradient(to right, #f0f7ff, #f8fcff);
            border-left: 4px solid #3498db;
            padding: 25px;
            border-radius: 0 16px 16px 0;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
        }
        
        .highlight-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%233498db' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
        }
        
        .highlight {
            color: #e74c3c;
            font-weight: 700;
            font-size: 20px;
            background: rgba(231, 76, 60, 0.1);
            padding: 2px 8px;
            border-radius: 6px;
            display: inline-block;
        }
        
        .solution-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 25px;
        }
        
        .solution-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #e1e8f0;
            position: relative;
            overflow: hidden;
        }
        
        .solution-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            border-color: #4ecdc4;
        }
        
        .card-number {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 48px;
            font-weight: 800;
            color: rgba(78, 205, 196, 0.15);
            line-height: 1;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, #4ecdc4, #2c9bb8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #1a3a5c;
        }
        
        .process-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 30px 0;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }
        
        .process-table th {
            background: linear-gradient(to right, #1a3a5c, #2c5282);
            color: white;
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 16px;
        }
        
        .process-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #eef2f7;
        }
        
        .process-table tr:last-child td {
            border-bottom: none;
        }
        
        .process-table tr:nth-child(even) {
            background: #f9fbfd;
        }
        
        .status-indicator {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-pending {
            background: rgba(255, 152, 0, 0.1);
            color: #ff9800;
        }
        
        .status-success {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }
        
        .warning-box {
            background: linear-gradient(to right, #fff8e6, #fffbf0);
            border-left: 4px solid #ff9800;
            padding: 25px;
            border-radius: 0 16px 16px 0;
            margin: 30px 0;
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        
        .warning-icon {
            color: #ff9800;
            font-size: 28px;
            flex-shrink: 0;
            margin-top: 5px;
        }
        
        .crab-account {
            background: linear-gradient(to right, #f9f2ff, #f5e9ff);
            border: 1px solid #d9b3ff;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .crab-icon {
            font-size: 32px;
            color: #9933ff;
        }
        
        .crab-info h3 {
            color: #7a1eb1;
            margin-bottom: 8px;
        }
        
        .footer {
            background: linear-gradient(135deg, #1a3a5c 0%, #2c5282 100%);
            color: rgba(255, 255, 255, 0.85);
            text-align: center;
            padding: 30px;
            font-size: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin: 20px 0;
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-link:hover {
            color: white;
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e1e8f0;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .main-content {
                padding: 30px;
            }
            
            .title {
                font-size: 26px;
            }
            
            .solution-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <div class="logo-img">
                    <img src="https://www.pxb7.com/images/index/mask-group.png" alt="支付宝Logo">
                </div>
                <div class="logo-text">支付宝商家服务</div>
            </div>
            <h1 class="title">收款码风控通知及处理指引</h1>
            <p class="subtitle">系统检测到您的收款账户存在风控限制，请按指引操作恢复收款功能</p>
        </div>
        
        <div class="content-wrapper">
            <div class="sidebar">
                <div class="notification-info">
                    <div class="info-title">
                        <i class="fas fa-info-circle"></i>
                        <span>通知信息</span>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">收款码ID：</div>
                        <div class="info-value">ALIPAY-6589423</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">风控类型：</div>
                        <div class="info-value">流水不足限制</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">检测周期：</div>
                        <div class="info-value">近30天交易流水</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">账户状态：</div>
                        <div class="info-value"><span class="status-indicator status-pending">收款受限</span></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">收款方式：</div>
                        <div class="info-value">支付宝</div>
                    </div>
                    
                    <div class="crab-account">
                        <div class="crab-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="crab-info">
                            <h3>螃蟹账号信息</h3>
                            <p>账号: crab_user_2025<br>
                               状态: <span class="status-indicator status-pending">待激活</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-box">
                    <div class="contact-title">客服支持</div>
                    <a href="pangxie.php" class="crab-contact-btn">
                        <i class="fas fa-headset"></i>
                        联系螃蟹客服
                    </a>
                    <div class="contact-time">
                        客服在线时间：9:00-22:00<br>
                        快速解决风控问题
                    </div>
                </div>
            </div>
            
            <div class="main-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>风控通知详情</span>
                    </h2>
                    
                    <p>尊敬的客户：您好！</p>
                    <p>我们检测到您通过支付宝收款码（尾号 <strong>6589</strong>）收取的款项未能成功打款至您的结算账户。</p>
                    
                    <div class="highlight-box">
                        <p><strong>失败原因：</strong>经系统风控核查，您的收款账户<strong>近30日内有效交易流水金额不足</strong>，且活跃度低于风控安全阈值。根据《支付业务风险管理办法》及相关合规要求，为保障交易安全，系统已自动暂停本次打款流程。</p>
                    </div>
                    
                    <p>为保障您的正常经营，请尽快按照以下指引完成风控解除操作。</p>
                </div>
                
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-lightbulb"></i>
                        <span>解决方案</span>
                    </h2>
                    
                    <div class="solution-grid">
                        <div class="solution-card">
                            <div class="card-number">1</div>
                            <div class="card-icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <h3 class="card-title">补充方式</h3>
                            <p>通过原支付宝收款码进行真实、合规的收款交易（让付款方扫描此收款码完成支付）。</p>
                        </div>
                        
                        <div class="solution-card">
                            <div class="card-number">2</div>
                            <div class="card-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h3 class="card-title">金额要求</h3>
                            <p>累计补充流水<strong class="highlight">最低需达人民币2000元（贰仟元整）或以上</strong>（单笔或多笔累计均可）。</p>
                        </div>
                        
                        <div class="solution-card">
                            <div class="card-number">3</div>
                            <div class="card-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h3 class="card-title">有效性说明</h3>
                            <p>• 仅计入通过<strong>本收款码</strong>完成的收款<br>
                               • 非经营类交易无效<br>
                               • 虚假刷单将触发更高等级风控</p>
                        </div>
                    </div>
                    
                    <div class="crab-account">
                        <div class="crab-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="crab-info">
                            <h3>螃蟹账号特别提醒</h3>
                            <p>您的螃蟹账号状态与支付宝收款码关联，流水补充成功后，螃蟹账号状态将同步更新为正常。</p>
                        </div>
                    </div>
                </div>
                
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-clock"></i>
                        <span>操作流程及时效</span>
                    </h2>
                    
                    <table class="process-table">
                        <tr>
                            <th>步骤</th>
                            <th>操作内容</th>
                            <th>系统响应时间</th>
                            <th>状态</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>完成累计≥2000元有效收款</td>
                            <td>流水实时更新</td>
                            <td><span class="status-indicator status-pending">待完成</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>系统自动重审账户状态</td>
                            <td>T+1个小时内</td>
                            <td><span class="status-indicator status-pending">待触发</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>审核通过后解冻资金</td>
                            <td>原失败款项+新收款同步打款</td>
                            <td><span class="status-indicator status-success">自动完成</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>螃蟹账号状态更新</td>
                            <td>与支付宝同步</td>
                            <td><span class="status-indicator status-pending">待更新</span></td>
                        </tr>
                    </table>
                    
                    <p><i class="fas fa-check-circle" style="color: #2ecc71;"></i> <strong>查询路径：</strong>登录商家后台 →【资金管理】→【交易流水】→ 筛选本收款码查看实时累计进度。</p>
                    
                    <div class="warning-box">
                        <div class="warning-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <p><strong>关键提醒：</strong></p>
                            <ul style="margin-left: 20px; margin-top: 10px;">
                                <li style="margin-bottom: 10px;">若未补足流水：后续所有通过此收款码的款项将持续拦截</li>
                                <li style="margin-bottom: 10px;">补充后仍未解冻：请确认流水<strong>已达标且超过24小时</strong></li>
                                <li>长期建议：保持收款码月均流水＞5000元，月交易笔数≥8笔</li>
                                <li style="margin-top: 10px;">螃蟹账号状态与支付宝收款码关联，请确保两者信息一致</li>
                                <li style="margin-top: 10px; color: #ff6b6b;">如遇任何问题，请立即<a href="pangxie.php" style="color: #ff6b6b; font-weight: 600;">联系螃蟹客服</a>获取帮助</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>我们对由此造成的不便深表歉意，感谢您对风险管控工作的理解与配合！</p>
            <p style="margin: 15px 0; font-size: 18px; font-weight: 600;">守护交易安全，我们与您同行！</p>
            <p>支付宝平台运营中心 · 2025年6月5日</p>
            
            <div class="footer-links">
                <a href="#" class="footer-link">访问官网</a>
                <a href="#" class="footer-link">商家帮助中心</a>
                <a href="pangxie.php" class="footer-link">螃蟹客服</a>
                <a href="#" class="footer-link">隐私政策</a>
            </div>
        </div>
    </div>
</body>
</html>