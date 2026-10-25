
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>交易信息</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            overflow: hidden; /* 禁止页面滚动 */
        }

        .header {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .back-button {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
        }

        .header svg {
            width: 20px; /* 减小箭头大小 */
            height: 20px;
            fill: #333; /* 返回箭头颜色 */
        }

        .header-title {
            position: absolute; /* 绝对定位 */
            left: 50%; /* 水平居中 */
            transform: translateX(-50%); /* 调整位置 */
            font-size: 18px;
            color: #333;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100% - 60px); /* 减去头部的高度以确保内容在可视区域内垂直居中 */
            padding-top: 0; /* 移除顶部内边距 */
            box-sizing: border-box; /* 确保padding和border包含在元素的总宽度和高度内 */
        }

        .image-container {
            text-align: center; /* 图片和文字水平居中 */
            margin-top: -40px; /* 上移图片，可以根据需求调整 */
            position: relative; /* 相对定位以便进行更精确的控制 */
            top: -40px; /* 进一步上移图片，可根据需要调整 */
        }

        .center-image {
            max-width: 30%; /* 调整中间图片的大小，这里设置为更小 */
            height: auto;
        }

        .text {
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- 返回按钮 -->
        <button class="back-button" onclick="window.location.href='./chatRoom/chat.php'">
            <svg width="26" height="26" viewBox="0 0 32 32"><path d="M21.781 7.844l-9.063 8.594 9.063 8.594q0.25 0.25 0.25 0.609t-0.25 0.578q-0.25 0.25-0.578 0.25t-0.578-0.25l-9.625-9.125q-0.156-0.125-0.203-0.297t-0.047-0.359q0-0.156 0.047-0.328t0.203-0.297l9.625-9.125q0.25-0.25 0.578-0.25t0.578 0.25q0.25 0.219 0.25 0.578t-0.25 0.578z" fill="#000000"></path></svg>
            <!--
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            -->
        </button>
        <div class="header-title">交易信息</div>
    </div>
    <div class="container">
        <div class="image-container">
            <!-- 中心图片 -->
            <img src="/img/yh.jpg" alt="1无交易信息" class="center-image">
            <div class="text">买家已拍下 订单待发货~</div>
        </div>
    </div>
</body>
</html>