
<?php
require_once '../include/conn.php';
require_once 'header.php';
$h_user = $_GET['user'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>分享图生成</title>
  <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
<link rel="stylesheet" href="/css/1layui.css"/>
  <link href="//unpkg.com/layui@2.9.2/dist/css/layui.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/1layui.css">
  <link rel="stylesheet" type="text/css" href="static/LightYearv5/css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/animate.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/multitabs.min.css">
<link rel="stylesheet" type="text/css" href="static/LightYearv5/css/style.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Gaegu&display=swap" rel="stylesheet">

<style>
* {font-family: MainFont, sans-serif;}
@font-face {font-family: 'MainFont';src: url('/css/Font.woff2') format('woff2');font-weight: normal;font-style: normal;}
.nav-drawer .mdi {font-size: 1.1rem;width: 1.2em;text-align: center;margin-right: 0.5rem;}
.nav-drawer a:hover i {transform: scale(1.1);transition: transform 0.2s ease;transform: translateY(-6px);}
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        /* 精美返回按钮 */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            transition: all 0.3s ease;
            color: #666;
            text-decoration: none;
        }
        
        .back-button:hover {
            transform: translateX(-3px);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            color: #ff6b8b;
        }
        
        .back-icon {
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .back-button:hover .back-icon {
            transform: scale(1.2);
        }
        
        /* 内容区域 */
        .content {
            padding: 80px 20px 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
</head>
<body>
<div class="layui-bg-gray" style="padding: 16px;">
  <div class="layui-row layui-col-space15">
     <!-- 精美返回按钮 -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left back-icon"></i>
    </a> 
    
    
     <div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header">普通分享图</div>
        <div class="layui-card-body">
          <div class="layui-btn-container">
          
  <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/xyxg.php" target="_blank">
  <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">闲鱼</button></a>

                <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/jymxg.php" target="_blank">
  <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">交易猫</button></a>
                <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/zzxg.php" target="_blank">
  <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">转转</button></a>
               <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/pxxg.php" target="_blank">
  <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">螃蟹</button></a>
   <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/pzxg.php" target="_blank">
        <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">盼之</button></a>
</div>
        </div>
      </div>
    </div>
    
    
     <div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header">ID分享图</div>
        <div class="layui-card-body">
                    <div class="layui-btn-container">
                        <a href="/Dev/Share/ID/xyxg.php" target="_blank">
                            <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">闲鱼</button>
                        </a>
                        <a href="/Dev/Share/ID/zzxg.php" target="_blank">
                            <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">转转</button>
                        </a>
                        
</div>
        </div>
      </div>
    </div>
    
     <div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header">实物分享图</div>
        <div class="layui-card-body">
          <div class="layui-btn-container">
                  <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/shiwu/xyxg.php" target="_blank">
  <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">闲鱼</button></a>
                  <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/Dev/Share/shiwu/zzxg.php" target="_blank">
  <button type="button" class="layui-btn layui-btn-primary layui-btn-radius">转转</button></a>
</div>
        </div>
      </div>
    </div>
    
     
</div>
</div>
     <!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="//unpkg.com/layui@2.9.7/dist/layui.js"></script> 
<script>
layui.use(function(){
  var layer = layui.layer;
  var util = layui.util;
  // 批量事件
  util.on('lay-on', {
    alert: function(){
      layer.alert('对话框内容');
    },
    confirm: function(){
      layer.confirm('一个询问框的示例？', {
        btn: ['确定', '关闭'] //按钮
      }, function(){
        layer.msg('第一个回调', {icon: 1});
      }, function(){
        layer.msg('第二个回调', {
          time: 20000, // 20s 后自动关闭
          btn: ['明白了', '知道了']
        });
      });
    },
    msg: function(){
      layer.msg('一段提示信息');
    },
    page: function(){
      // 页面层
      layer.open({
        type: 1,
        area: ['420px', '240px'], // 宽高
        content: '<div style="padding: 11px;">任意 HTML 内容</div>'
      });
    },
    iframe: function(){
      // iframe 层
      layer.open({
        type: 2,
        title: '闲鱼',
        shadeClose: true,
        shade: 0.8,
        area: ['380px', '80%'],
        content: '/lzesp/index.php' // iframe 的 url
      });
    },
    ifram: function(){
      // iframe 层
      layer.open({
        type: 2,
        title: '转转',
        shadeClose: true,
        shade: 0.8,
        area: ['380px', '80%'],
        content: '/lzesp/index3.php' // iframe 的 url
      });
    },
    yh: function(){
      // iframe 层
      layer.open({
        type: 2,
        title: '盼之',
        shadeClose: true,
        shade: 0.8,
        area: ['380px', '80%'],
        content: '/lzesp/index1.php' // iframe 的 url
      });
    },
    ifra: function(){
      // iframe 层
      layer.open({
        type: 2,
        title: '交易猫',
        shadeClose: true,
        shade: 0.8,
        area: ['380px', '80%'],
        content: '/lzesp/index2.php' // iframe 的 url
      });
    },

    load: function(){
      var index = layer.load(0, {shade: false});
      setTimeout(function(){
        layer.close(index); // 关闭 loading
      }, 5000);
    },
    tips: function(){
      layer.tips('一个 tips 层', this, {
        tips: 1
      });
    },
    prompt: function(){
      layer.prompt({title: '密令输入框', formType: 1}, function(pass, index){
        layer.close(index);
        layer.prompt({title: '文本输入框', formType: 2}, function(text, index){
          layer.close(index);
          alert('您输入的密令：'+ pass +'；文本：'+ text);
        });
      });
    },
    photots: function(){
      layer.photos({
        photos: {
          "title": "Photos Demo",
          "start": 0,
          "data": [
            {
              "alt": "layer",
              "pid": 1,
              "src": "https://unpkg.com/outeres@0.1.1/demo/layer.png",
            },
            {
              "alt": "壁纸",
              "pid": 3,
              "src": "https://unpkg.com/outeres@0.1.1/demo/000.jpg",
            },
            {
              "alt": "浩瀚宇宙",
              "pid": 5,
              "src": "https://unpkg.com/outeres@0.1.1/demo/outer-space.jpg",
            }
          ]
        }
      });
    }
  });
});
</script>

</body>
</html>