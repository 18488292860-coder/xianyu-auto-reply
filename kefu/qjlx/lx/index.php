<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>螃蟹游戏账号交易合同</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #1a2a6c);
            color: #333;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
        }
        
        .header {
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            color: white;
            text-align: center;
            padding: 30px 20px;
            position: relative;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 1px;
        }
        
        .header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2.5rem;
            opacity: 0.7;
        }
        
        .contract-body {
            padding: 40px;
        }
        
        .parties {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .party {
            flex: 1;
            min-width: 300px;
            background: #f9f9ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #1a2a6c;
        }
        
        .party h3 {
            color: #1a2a6c;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-item {
            margin: 12px 0;
            display: flex;
        }
        
        .info-item label {
            font-weight: bold;
            min-width: 100px;
            color: #555;
        }
        
        .info-item span {
            flex: 1;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            background: linear-gradient(to right, #1a2a6c, transparent);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .terms {
            padding-left: 20px;
        }
        
        .terms li {
            margin: 12px 0;
            line-height: 1.6;
        }
        
        .game-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 25px 0;
        }
        
        .game-card {
            flex: 1;
            min-width: 250px;
            background: #f0f8ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .game-card h4 {
            color: #1a2a6c;
            margin-bottom: 15px;
            text-align: center;
            font-size: 1.2rem;
        }
        
        .signature-area {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px dashed #ccc;
        }
        
        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
            gap: 30px;
        }
        
        .signature-box {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }
        
        .signature-pad-container {
            margin: 20px 0;
            position: relative;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f8f8f8;
        }
        
        canvas {
            width: 100%;
            height: 100%;
            cursor: crosshair;
        }
        
        .signature-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .signature-controls button {
            padding: 8px 15px;
            background: #1a2a6c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .signature-controls button:hover {
            background: #b21f1f;
        }
        
        .signature-controls button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .date-line {
            margin-top: 20px;
            text-align: center;
        }
        
        .date-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
            text-align: center;
        }
        
        .footer {
            text-align: center;
            padding: 25px;
            background: #f0f0f0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .stamp {
            position: absolute;
            right: 40px;
            bottom: 100px;
            opacity: 0.7;
            transform: rotate(10deg);
        }
        
        .stamp-content {
            border: 2px solid #b21f1f;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-weight: bold;
            color: #b21f1f;
            padding: 10px;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.8);
        }.action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        
        .action-button {
            padding: 12px 30px;
            font-size: 1.1rem;
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
        
        @media (max-width: 768px) {
            .contract-body {
                padding: 25px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .party {
                min-width: 100%;
            }
            
            .signature-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-gamepad"></i>
            </div>
            <h1>游戏账号交易合同</h1>
            <p>本协议由交易双方共同遵守，具有法律约束力</p >
        </div>
        
        <div class="contract-body">
            <div class="parties">
                <div class="party">
                    <h3>转让方（甲方）</h3>
                    <div class="info-item">
                        <label>姓名：</label>
                        <span>张卢</span>
                    </div>
                    <div class="info-item">
                        <label>身份证号：</label>
                        <span>34122519200806018511</span>
                    </div>
                    <div class="info-item">
                        <label>联系方式：</label>
                        <span>18226859627</span>
                    </div>
                    <div class="info-item">
                    </div>
                </div>
                
                <div class="party">
                    <h3>受让方（乙方）</h3>
                    <div class="info-item">
                        <label>姓名：</label>
                        <span>李思涵</span>
                    </div>
                    <div class="info-item">
                        <label>身份证号：</label>
                        <span>330200109031025</span>
                    </div>
                    <div class="info-item">
                        <label>联系方式：</label>
                        <span>13985640631</span>
                    </div>
                    <div class="info-item">
                    </div>
                </div>
            </div>
            
            <div class="game-details">
                <div class="game-card">
                    <h4>交易游戏账号信息</h4>
                    <div class="info-item">
                        <label>游戏名称：</label>
                        <span>王者荣耀</span>
                    </div>
                    <div class="info-item">
                        <label>游戏区服：</label>
                        <span>qq</span>
                    </div>
                    <div class="info-item">
                        <label>账号ID：</label>
                        <span>oo</span>
                    </div>
                    <div class="info-item">
                        <label>角色等级：</label>
                        <span>30</span>
                    </div>
                </div>
                
                <div class="game-card">
                    <h4>交易详情</h4>
                    <div class="info-item">
                        <label>交易价格：</label>
                        <span>¥400</span>
                    </div>
                    <div class="info-item">
                        <label>支付方式：</label>
                        <span>支付宝</span>
                    </div>
                    <div class="info-item">
                        <label>交易时间：</label>
                        <span>2025年5月29日</span>
                    </div>
                    <div class="info-item">
                        <label>交易平台：</label>
                        <span>螃蟹游戏交易网</span>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">第一条 交易内容</div>
                <p>甲方同意将其拥有的游戏账号（具体信息如上所述）转让给乙方，乙方同意受让该游戏账号，并按照约定价格支付转让费用。</p >
            </div>
            
            <div class="section">
                <div class="section-title">第二条 双方权利与义务</div>
                <ol class="terms">
                    <li>甲方保证其为游戏账号的合法所有者，有权处分该账号，且账号不存在任何权利瑕疵或纠纷。</li>
                    <li>甲方应提供真实的账号信息，包括但不限于账号、密码、密保资料等，并协助乙方完成账号绑定信息的变更。</li>
                    <li>乙方应按照约定及时支付转让费用，不得无故拖延或拒绝支付。</li>
                    <li>自交易完成之日起，乙方拥有该游戏账号的全部权利，甲方不得以任何理由索回账号或干扰乙方正常使用。</li>
                </ol>
            </div>
            
            <div class="section">
                <div class="section-title">第三条 账号安全与责任</div>
                <ol class="terms">
                    <li>甲方保证在交易前不存在任何账号违规行为，未被游戏官方封禁或限制的记录。</li>
                    <li>交易完成后，账号安全责任由乙方承担，乙方应及时修改密码及相关安全信息。</li>
                    <li>如因甲方原因导致交易后账号被游戏官方收回或限制使用，甲方应退还全部交易款项。</li>
                </ol>
            </div>
            
            <div class="section">
                <div class="section-title">第四条 违约责任</div>
                <ol class="terms">
                    <li>任何一方违反本协议约定，应承担违约责任，赔偿给对方造成的全部损失。</li>
                    <li>如甲方提供虚假账号信息或账号存在权利瑕疵，应双倍返还乙方支付的转让费用。</li>
                   <li>如乙方未按约定支付转让费用，甲方有权收回游戏账号并追究乙方的违约责任。</li>
                </ol>
            </div>
            
            <div class="section">
                <div class="section-title">第五条 争议解决</div>
                <p>因本协议引起的或与本协议有关的任何争议，双方应友好协商解决；协商不成的，任何一方均有权向甲方所在地人民法院提起诉讼。</p >
            </div>
            
            <div class="signature-area">
                <div class="signature-container">
                    <div class="signature-box">
                        <div class="party">
                            <h3>甲方（转让方）签字</h3>
                        </div>
                        <div class="signature-pad-container">
                            <canvas id="signature-pad-A"></canvas>
                        </div>
                        <div class="signature-controls">
                            <button id="clear-A">清除签名</button>
                            <button id="save-A" disabled>保存签名</button>
                        </div>
                        <div class="date-line">
                            <input type="date" class="date-input" id="date-A">
                        </div>
                    </div>
                    
                    <div class="signature-box">
                        <div class="party">
                            <h3>乙方（受让方）签字</h3>
                        </div>
                        <div class="signature-pad-container">
                            <canvas id="signature-pad-B"></canvas>
                        </div>
                        <div class="signature-controls">
                            <button id="clear-B">清除签名</button>
                            <button id="save-B" disabled>保存签名</button>
                        </div>
                        <div class="date-line">
                            <input type="date" class="date-input" id="date-B">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="stamp">
                <div class="stamp-content">
                    <div>游戏交易网</div>
                    <div>交易专用章</div>
                    <div>2023年10月</div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-button" id="download-btn">
                    <i class="fas fa-download"></i> 下载合同PDF
                </button>
                <button class="action-button" id="print-btn">
                    <i class="fas fa-print"></i> 打印合同
                </button>
            </div>
        </div>
        
        <div class="footer">
            <p>本合同一式两份，甲乙双方各执一份，自双方签字之日起生效</p >
            <p>温馨提示：游戏交易存在风险，请谨慎交易并保存好相关凭证</p >
        </div>
    </div>

    <script>
        // 初始化甲方签名板
        const canvasA = document.getElementById('signature-pad-A');
        const signaturePadA = new SignaturePad(canvasA, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(26, 42, 108)'
        });
        
        // 初始化乙方签名板
        const canvasB = document.getElementById('signature-pad-B');
        const signaturePadB = new SignaturePad(canvasB, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(178, 31, 31)'
        });
        
        // 调整Canvas大小以适应容器
        function resizeCanvas(canvas, signaturePad) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // 清除画布
        }
        
        // 页面加载时调整Canvas大小
        window.addEventListener('resize', () => {
            resizeCanvas(canvasA, signaturePadA);
            resizeCanvas(canvasB, signaturePadB);
        });
        
        resizeCanvas(canvasA, signaturePadA);
        resizeCanvas(canvasB, signaturePadB);
        
        // 甲方签名事件
        signaturePadA.addEventListener("beginStroke", () => {
            document.getElementById('save-A').disabled = false;
        });
        
        signaturePadA.addEventListener("endStroke", () => {
            document.getElementById('save-A').disabled = false;
        });
        
        document.getElementById('clear-A').addEventListener('click', () => {
            signaturePadA.clear();
            document.getElementById('save-A').disabled = true;
        });
        
        document.getElementById('save-A').addEventListener('click', () => {
            if (signaturePadA.isEmpty()) {
                alert("请先提供签名");
            } else {
                alert("甲方签名已保存");
            }
        });
        
        // 乙方签名事件
        signaturePadB.addEventListener("beginStroke", () => {
            document.getElementById('save-B').disabled = false;
        });
        
        signaturePadB.addEventListener("endStroke", () => {
            document.getElementById('save-B').disabled = false;
        });
        
        document.getElementById('clear-B').addEventListener('click', () => {
            signaturePadB.clear();
            document.getElementById('save-B').disabled = true;
        });
        
        document.getElementById('save-B').addEventListener('click', () => {
            if (signaturePadB.isEmpty()) {
                alert("请先提供签名");
            } else {
                alert("乙方签名已保存");
            }
        });
        
        // 设置默认日期为今天
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date-A').value = today;
        document.getElementById('date-B').value = today;
        
        // 下载和打印功能
        document.getElementById('download-btn').addEventListener('click', () => {
            alert("正在下载...");
        });
        
        document.getElementById('print-btn').addEventListener('click', () => {
            window.print();
        });
        
        // 添加一些模拟数据更改功能
        const gameCards = document.querySelectorAll('.game-card');
        gameCards.forEach(card => {
            card.addEventListener('mouseover', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 8px 15px rgba(0, 0, 0, 0.2)';
            });
            
            card.addEventListener('mouseout', () => {
                card.style.transform = 'none';
                card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
            });
        });
    </script>
</body>
</html>