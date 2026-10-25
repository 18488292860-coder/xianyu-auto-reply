<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>螃蟹账号投诉建议 - 客户服务中心</title>
    <style>
        :root {
            --primary-color: #FFA500; /* 橙色作为主色 */
            --secondary-color: #E69500; /* 深一点的橙色 */
            --accent-color: #e74c3c;
            --light-color: #FFF8E1; /* 淡淡的黄色背景 */
            --dark-color: #5D4037; /* 深棕色文字 */
            --success-color: #2ecc71;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .logo-container {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .logo {
            height: 50px;
            width: auto;
        }
        
        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border: 1px solid #FFE0B2;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #FFCC80;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
            background-color: #FFF8E1;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 165, 0, 0.2);
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
        }
        
        .radio-option input {
            margin-right: 8px;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.2s;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-submit {
            background-color: var(--accent-color);
        }
        
        .btn-submit:hover {
            background-color: #c0392b;
        }
        
        .contact-info {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #FFE0B2;
        }
        
        .contact-info h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .contact-method {
            display: flex;
            align-items: center;
        }
        
        .contact-icon {
            font-size: 24px;
            margin-right: 15px;
            color: var(--primary-color);
        }
        
        .crab-account-note {
            text-align: center;
            margin: 15px 0;
            font-style: italic;
            color: var(--secondary-color);
            font-weight: 600;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: var(--dark-color);
            font-size: 0.9rem;
            border-top: 1px solid #FFE0B2;
        }
        
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .logo-container {
                position: static;
                transform: none;
                text-align: center;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo-container">
                <img src="https://www.pxb7.com/images/index/mask-group.png" alt="螃蟹账号Logo" class="logo">
            </div>
            <h1>投诉与建议</h1>
            <p>您的意见对我们非常重要，我们将认真处理每一条反馈</p>
        </header>
        
        <div class="crab-account-note">
            ※ 螃蟹账号投诉建议专用通道 ※
        </div>
        
        <div class="form-container">
            <form id="feedbackForm">
                <div class="form-group">
                    <label for="feedbackType">反馈类型*</label>
                    <select id="feedbackType" name="feedbackType" required>
                        <option value="">请选择反馈类型</option>
                        <option value="complaint">欺诈</option>
                        <option value="suggestion">色情</option>
                        <option value="praise">暴力</option>
                        <option value="inquiry">咨询</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="subject">主题*</label>
                    <input type="text" id="subject" name="subject" placeholder="请简要描述您的反馈主题" required>
                </div>
                
                <div class="form-group">
                    <label for="description">详细描述*</label>
                    <textarea id="description" name="description" placeholder="请详细描述您的投诉或建议，包括相关的时间、地点和人员信息..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label>您希望如何收到回复？</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="replyEmail" name="replyMethod" value="email" checked>
                            <label for="replyEmail">电子邮件</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="replyPhone" name="replyMethod" value="phone">
                            <label for="replyPhone">电话</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="replyNo" name="replyMethod" value="no">
                            <label for="replyNo">不需要回复</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="name">姓名*</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">电子邮箱*</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">联系电话</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="attachment">附件上传</label>
                    <input type="file" id="attachment" name="attachment">
                    <small>您可以上传相关图片或文档（最多5MB）</small>
                </div>
                
                <button type="submit" class="btn btn-submit">提交反馈</button>
            </form>
        </div>
        
        <div class="contact-info">
            <h2>其他联系方式</h2>
            <div class="contact-methods">
                <div class="contact-method">
                    <div class="contact-icon">📞</div>
                    <div>
                        <h3>客服电话</h3>
                        <p>400-813-975</p>
                        <p>周一至周日 9:00-18:00</p>
                    </div>
                </div>
                
                <div class="contact-method">
                    <div class="contact-icon">✉️</div>
                    <div>
                        <h3>电子邮箱</h3>
                        <p>feedback@pxb7.com</p>
                    </div>
                </div>
                
                <div class="contact-method">
                    <div class="contact-icon">🏢</div>
                    <div>
                        <h3>公司地址</h3>
                        <p>北京市朝阳区幸福路123号</p>
                        <p>邮编：100871</p>
                    </div>
                </div>
            </div>
        </div>
        
        <footer>
            <p>© 2025 螃蟹账号 版权所有 | 隐私政策 | 服务条款</p>
        </footer>
    </div>
    
    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // 这里可以添加表单验证和提交逻辑
            alert('感谢您的反馈！我们已收到您的投诉，将会尽快处理。');
            this.reset();
        });
    </script>
</body>
</html>