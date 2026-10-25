<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>找回包赔保险服务 - 螃蟹游戏平台</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto Sans SC', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 150, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff9a00, #ff6600);
        }
        
        .logo {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ffcc00;
            text-shadow: 0 0 10px rgba(255, 204, 0, 0.5);
        }
        
        h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .subtitle {
            font-size: 1.3rem;
            max-width: 800px;
            margin: 0 auto 25px;
            color: #e6f0ff;
        }
        
        .badge {
            display: inline-block;
            background: linear-gradient(90deg, #ff6600, #ff9a00);
            color: white;
            padding: 8px 25px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1.1rem;
            margin-top: 15px;
            box-shadow: 0 4px 10px rgba(255, 102, 0, 0.3);
        }
        
        .content-wrapper {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        
        .main-content {
            flex: 3;
            min-width: 300px;
        }
        
        .sidebar {
            flex: 1;
            min-width: 250px;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #2a5298;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 150, 0.15);
        }
        
        .card.important {
            border-left-color: #ff6600;
        }
        
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 1.8rem;
        }
        
        .card.important .card-icon {
            background: linear-gradient(135deg, #ff6600, #ff9a00);
        }
        
        .card-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2a5298;
        }
        
        .card.important .card-title {
            color: #ff6600;
        }
        
        .rule-list {
            list-style: none;
            padding: 0;
        }
        
        .rule-item {
            padding: 20px;
            margin-bottom: 20px;
            background: #f9fbff;
            border-radius: 10px;
            border-left: 3px solid #4a7bff;
            position: relative;
        }
        
        .rule-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: #4a7bff;
            border-radius: 0 3px 3px 0;
        }
        
        .rule-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .rule-number {
            width: 30px;
            height: 30px;
            background: #4a7bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
        }
        
        .rule-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2a5298;
        }
        
        .rule-details {
            padding-left: 45px;
        }
        
        .detail-item {
            margin-bottom: 15px;
            display: flex;
        }
        
        .detail-item i {
            color: #4a7bff;
            margin-right: 10px;
            min-width: 20px;
            margin-top: 5px;
        }
        
        .highlight {
            color: #ff6600;
            font-weight: 700;
        }
        .price-box {
            background: linear-gradient(135deg, #e6f0ff, #d4e4ff);
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border: 1px dashed #4a7bff;
        }
        
        .step-container {
            display: flex;
            gap: 20px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .step-card {
            flex: 1;
            min-width: 250px;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            border-top: 5px solid #4a7bff;
            position: relative;
        }
        
        .step-card::after {
            content: "";
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 5px;
            background: #4a7bff;
            border-radius: 0 0 5px 5px;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: #4a7bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .step-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2a5298;
        }
        
        .faq-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 3px solid #ffcc00;
        }
        
        .question {
            font-weight: 700;
            margin-bottom: 10px;
            color: #2a5298;
            display: flex;
            align-items: flex-start;
        }
        
        .question i {
            color: #ffcc00;
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .benefits-box {
            background: linear-gradient(135deg, #fff8e6, #fff0cc);
            border-radius: 15px;
            padding: 25px;
            border: 2px solid #ffcc00;
        }
        
        .benefits-title {
            text-align: center;
            font-size: 1.6rem;
            color: #e6a000;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
        }
        
        .benefit-item i {
            width: 40px;
            height: 40px;
            background: #ffcc00;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }
        
        .cta-button {
            display: block;
            width: 100%;
            background: linear-gradient(90deg, #ff6600, #ff9a00);
            color: white;
            text-align: center;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.3rem;
            margin-top: 25px;
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
            transition: all 0.3s;
            text-decoration: none; /* 确保链接没有下划线 */
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.6);
        }
        
        footer {
            text-align: center;
            padding: 30px;
            background: #2a5298;
            color: white;
            border-radius: 15px;
            margin-top: 30px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .footer-links a {
            color: #ffcc00;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
            text-decoration: underline;
        }
        
        .link-notice {
            text-align: center;
            padding: 15px;
            background: rgba(255, 204, 0, 0.1);
            border-radius: 10px;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #666;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>螃蟹找回包赔保险服务</h1>
            <p class="subtitle">全面保障交易安全，提升卖家信誉，让您无忧出售游戏账号</p >
            <div class="badge">
                <i class="fas fa-lock"></i> 100%交易保障 | <i class="fas fa-bolt"></i> 快速退还保证金
            </div>
        </header>
        
        <div class="content-wrapper">
            <div class="main-content">
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h2 class="card-title">保险服务核心规则</h2>
                    </div>
                    
                    <ul class="rule-list">
                        <li class="rule-item">
                            <div class="rule-header">
                                <div class="rule-number">1</div>
                                <h3 class="rule-title">分层预存，责任自证</h3>
                            </div>
                            <div class="rule-details">
                                <div class="detail-item">
                                    <i class="fas fa-caret-right"></i>
                                    <div>
                                        <span class="highlight">高价账号（≥1000元）</span>：卖家需预存 <span class="highlight">"300元保证金"</span>，主动自证账号安全性！
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-caret-right"></i>
                                    <div>
                                        <span class="highlight">普价账号（＜1000元）</span>：卖家仅需预存 <span class="highlight">200元保证金</span>，低成本提升交易竞争力！
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-caret-right"></i>
                                    <div>
                                        <span class="highlight">资金安全</span>：交易完成后 <span class="highlight">1-5分钟自动解冻退还保证金</span>，仅冻结期间临时占用，0资金损失！
                                    </div>
                                </div>
                                
                                <div class="price-box">
                                    <i class="fas fa-lightbulb"></i> 保证金越高，买家信任度越高，成交率提升显著！
                                </div>
                            </div>
                        </li>
                        
                        <li class="rule-item">
                            <div class="rule-header">
                                <div class="rule-number">2</div>
                                <h3 class="rule-title">卖家信用绑定</h3>
                            </div>
                            <div class="rule-details">
                                <div class="detail-item">
                                    <i class="fas fa-caret-right"></i>
                                    <div>
                                        预存保证金即承诺：若账号被卖家或关联方恶意找回，<span class="highlight">保证金全额赔付买家</span>，并冻结卖家螃蟹账户！
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <h2 class="card-title">找回包赔操作流程</h2>
                    </div>
                    
                    <div class="step-container">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Step 1｜材料备案</h3>
                            <p>上传：账号历史实名信息 + 3个月内充值记录 + 设备登录IP证明</p >
                            <div class="detail-item" style="margin-top: 15px; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: #4CAF50;"></i>
                                <div>通过审核后方可安排入款</div>
                            </div>
                        </div>
                        
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Step 2｜交易保障</h3>
                            <p>账号售出后：</p >
                            <div class="detail-item">
                                <i class="fas fa-thumbs-up" style="color: #4CAF50;"></i>
                                <div><span class="highlight">买家无争议</span>：1-5分钟解冻保证金，原路退回卖家账户</div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-exclamation-triangle" style="color: #ff6600;"></i>
                                <div><span class="highlight">账号被找回</span>：买家提交证据后，保证金直接抵扣赔付，卖家需补足差额或封号处理！</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card important">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h2 class="card-title">卖家高频问题解答</h2>
                    </div>
                    
                    <div class="faq-item">
                        <div class="question">
                            <i class="fas fa-q"></i>
                            <div>Q1：保证金退回后，买家还能索赔吗？</div>
                        </div>
                        <p><span class="highlight">"不能！"</span> 保证金解冻即代表交易完结，但卖家需确保账号已完全转移，后期找回仍追究法律责任。</p >
                    </div>
                    
                    <div class="faq-item">
                        <div class="question">
                            <i class="fas fa-q"></i>
                            <div>Q2：如何界定"卖家恶意找回"？</div>
                        </div>
                        <p><span class="highlight">"满足任一条件即触发："</span></p >
                        <div class="detail-item">
                            <i class="fas fa-1"></i>
                            <div>账号重新绑定卖家实名信息</div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-2"></i>
                            <div>卖家IP/设备登录账号并修改密码</div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-3"></i>
                            <div>客服核实卖家存在主动索回行为</div>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="question">
                            <i class="fas fa-q"></i>
                            <div>Q3：赔付金额超过保证金怎么办？</div>
                        </div>
                        <p>平台将优先扣划保证金，不足部分从卖家账户余额或后续收入中扣除，<span class="highlight">并降低信用评级！</span></p >
                    </div>
                </div>
            </div>
            
            <div class="sidebar">
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon" style="background: linear-gradient(135deg, #ffcc00, #ffaa00);">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h2 class="card-title" style="color: #e6a000;">卖家必读权益</h2>
                    </div>
                    
                    <div class="benefits-box">
                        <h3 class="benefits-title">专属卖家特权</h3>
                        
                        <div class="benefit-item">
                            <i class="fas fa-chart-line"></i>
                            <div><span class="highlight">投保账号可获得优先展示流量</span>，成交率提升50%+</div>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-gift"></i>
                            <div><span class="highlight">0纠纷订单可兑换店铺推广券</span>，降低平台服务费</div>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-shield"></i>
                            <div><span class="highlight">专属客服通道</span>，优先处理投保卖家问题</div>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-badge-percent"></i>
                            <div><span class="highlight">高投保率卖家享受佣金折扣</span>，最高可达30%</div>
                        </div>
                        
                        <!-- 嵌入网站链接的按钮 -->
                        <a href="#" class="cta-button">
    <i class="fas fa-play-circle"></i> 立即开通找回包赔
</a>
                        
                        <div class="link-notice">
                            <i class="fas fa-external-link-alt"></i> 点击按钮将跳转到找回包赔服务页面
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon" style="background: linear-gradient(135deg, #4CAF50, #2E7D32);">
                            <i class="fas fa-percent"></i>
                        </div>
                        <h2 class="card-title" style="color: #2E7D32;">投保优惠</h2>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-tag" style="color: #4CAF50;"></i>
                        <div>首单投保 <span class="highlight">减免50%保证金</span></div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-coins" style="color: #4CAF50;"></i>
                        <div>连续3单0纠纷 <span class="highlight">返还100%保证金</span></div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-star" style="color: #4CAF50;"></i>
                        <div>五星卖家 <span class="highlight">保证金减免30%</span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer>
            <p>螃蟹游戏平台 · 找回包赔保险服务</p >
            <p>全面保障交易安全，提升卖家信誉，打造值得信赖的游戏交易平台</p >
            <div class="footer-links">
                <a href="#"><i class="fas fa-file-contract"></i> 服务协议</a >
                <a href="#"><i class="fas fa-headset"></i> 客服中心</a >
                <a href="#"><i class="fas fa-shield-alt"></i> 安全保障</a >
                <a href="#"><i class="fas fa-comments"></i> 意见反馈</a >
            </div>
        </footer>
    </div>
</body>
</html>