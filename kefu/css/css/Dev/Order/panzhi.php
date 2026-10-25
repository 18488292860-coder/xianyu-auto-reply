<!DOCTYPE html>
<html lang="zh">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <link rel="stylesheet" href="/css/1layui.css">
  <style>
    :root {
      --primary: #FF9999; /* 浅红色 */
      --hover: #FF6666;  /* 稍深的浅红色 */
      --bg: #fff5f5;
      --text: #1f2937;
      --border: #e5e7eb;
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
    }

   .container {
      width: 100%;
      max-width: 960px;
      display: flex;
      justify-content: space-between;
    }

   .card {
      width: 48%;
      background: white;
      border-radius: 24px;
      box-shadow: 0 10px 30px rgba(255, 153, 153, 0.1); /* 根据浅红色调整阴影颜色 */
      overflow: hidden;
    }

   .header {
      background: linear-gradient(135deg, var(--primary), var(--hover));
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
      margin-bottom: 8px;
    }

   .header i {
      font-size: 36px;
      margin-bottom: 16px;
      display: block;
      animation: float 3s ease-in-out infinite;
    }

   .form-content {
      padding: 30px;
    }

   .form-group {
      margin-bottom: 20px;
    }

   .input-wrapper {
      position: relative;
    }

   .input-wrapper i {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #a0aec0;
      transition: all 0.3s;
    }

    input {
      width: 100%;
      padding: 14px 14px 14px 48px;
      border: 2px solid var(--border);
      border-radius: 16px;
      font-size: 15px;
      transition: all 0.3s;
      background: #f9fafb;
    }

    input:focus {
      outline: none;
      border-color: var(--primary);
      background: white;
      box-shadow: 0 0 0 4px rgba(255, 153, 153, 0.1); /* 根据浅红色调整阴影颜色 */
    }

    input:focus + i {
      color: var(--primary);
    }

    button {
      width: 100%;
      padding: 16px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 16px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 30px;
    }

    button:hover {
      background: var(--hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 102, 102, 0.2); /* 根据稍深的浅红色调整阴影颜色 */
    }

    @media (max-width: 768px) {
     .container {
        flex-direction: column;
      }

     .card {
        width: 100%;
        margin-bottom: 20px;
      }
    }

    /* 添加动画效果 */
    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-5px);
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="header">
        <i class="fas fa-pencil-alt"></i>
        <h1>订单编辑</h1>
      </div>
      <div class="form-content">
        <form method="post" action="">
          <div class="form-group">
            <div class="input-wrapper">
              <i class="fas fa-heading"></i>
              <input type="text" placeholder="请输入商品标题 " name="title" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="input-wrapper">
              <i class="fas fa-yen-sign"></i>
              <input type="text" placeholder="请输入商品价格 " name="prices" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="input-wrapper">
              <i class="fas fa-info-circle"></i>
              <input type="text" placeholder=" 请输入商品内容 " name="info" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="input-wrapper">
              <i class="fas fa-image"></i>
              <input type="text" placeholder=" 请输入图片URL " name="image" value="">
            </div>
          </div>
          <div class="layui-btn-container">
            <button type="submit" name="save">
              <i class="fas fa-save"></i>
              提交
            </button>
          </div>
          <?php
          if (isset($_POST['save'])) {
            $title = $_POST['title'];
            $price = $_POST['prices'];
            $info = $_POST['info'];
            $image = $_POST['image'];
            // 构造原始 URL
            $link = "http://" . $_SERVER['HTTP_HOST'] . "/panzhiorder.php?". $_AID. "title=" . $title . "&price=" . $price . "&info=" . $info . "&image=" . $image;

            echo "<div class='layui-btn-container'>
                    <button onclick='window.open(\"$link\", \"_blank\")'>
                      <i class='fas fa-external-link-alt'></i> 打开链接
                    </button>
                    <button id='copyButton' onclick='copyLink(\"$link\")'>
                      <i class='fas fa-copy'></i> 复制链接
                    </button>
                  </div>";
          }
          ?>
        </form>
      </div>
    </div>
  </div>
  <!-- js部分 -->
  <script>
    function copyLink(text) {
      var tempInput = document.createElement('input');
      tempInput.value = text;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);
      alert('复制成功');
    }
  </script>
</body>

</html>