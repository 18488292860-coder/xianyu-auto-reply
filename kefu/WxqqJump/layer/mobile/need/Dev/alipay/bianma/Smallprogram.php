

<!doctype html>
<html lang="zh-cn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>闲鱼淘宝内跳</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: MainFont, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        :root {
            --primary-color: #C5C1FF;
            --hover-color: #C5C1FF;
            --bg-color: #f8fafc;
            --text-color: #1a1a1a;
            --border-color: #e5e7eb;
        }

        @font-face {
            font-family: 'MainFont';
            src: url('/css/Font.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        body {
            background: var(--bg-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-color);
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-header i {
            font-size: 56px;
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .form-header h1 {
            font-size: 28px;
            color: var(--text-color);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--text-color);
            font-weight: 500;
            font-size: 15px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            color: #6b7280;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        input[type="text"] {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        input[type="text"]:focus {
            border-color: var(--primary-color);
            outline: none;
            background: white;
        }

        input[type="text"]:focus+i {
            color: var(--primary-color);
        }

        input[type="submit"],
        button[type="submit"] {
            width: 100%;
            padding: 16px;
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        input[type="submit"]:hover,
        button[type="submit"]:hover {
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
            transform: translateY(-2px);
        }

        input[type="submit"]:active,
        button[type="submit"]:active {
            transform: translateY(0);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        ::placeholder {
            color: #9ca3af;
            opacity: 1;
        }

        html {
            scroll-behavior: smooth;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            .form-header i {
                font-size: 48px;
            }

            .form-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container glass-effect">
        <div class="form-header">
            <i class="fab fa-alipay"></i>
            <h1> 支付宝小程序 </h1>
        </div>

        <form id="linkForm">
            <div class="form-group">
                <div class="input-wrapper">
                    <input type="text" 
                           id="content" 
                           name="content" 
                           placeholder="请输入需要生成的链接"
                           required>
                    <i class="fas fa-link"></i>
                </div>
            </div>

            <button type="submit" class="submit-btn">生成</button>
        </form>
    </div>

    <script>
        document.getElementById('linkForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const content = document.getElementById('content').value.trim();
            if (!content) {
                alert('请输入链接');
                return;
            }

            const url = ` alipays://platformapi/startapp?appId=2014021200003129&page=&url=${encodeURIComponent(content)}`;

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function () {
                    alert(`链接已复制到剪贴板`);
                }).catch(function (error) {
                    alert('复制失败，请手动复制链接');
                });
            } else {
                const tempInput = document.createElement('input');
                tempInput.value = url;
                document.body.appendChild(tempInput);
                tempInput.select();
                try {
                    document.execCommand('copy');
                    alert(`链接已复制到剪贴板`);
                } catch (error) {
                    alert('复制失败，请手动复制链接');
                } finally {
                    document.body.removeChild(tempInput);
                }
            }
        });
    </script>
</body>

</html>