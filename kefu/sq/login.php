<?php
require_once '../include/conn.php';
if($clause == "chklogin"){
    
	if('' == $loginName){hintAndBack('请输入帐号!',1);}
	if('' == $loginPwd){hintAndBack('请输入密码!',1);}
	
	$md5Name = substr(md5(sha1(md5($loginName))),3);
	$md5Pwd = substr(md5(sha1(md5($loginPwd))),3);
	$rs = $db->get_one("SELECT * FROM `h_kefu_config` where h_admin = '$md5Name' and h_pass = '$md5Pwd'");
    // var_dump($md5Name,$md5Pwd);     
        if(!$rs)
        {
        
        	hintAndBack('帐号或密码错误!',1);
        }
        else
        {
        
            $sql = "insert into `h_kefu_login` set ";
            $sql .= "h_user = '" . $md5Name . "', ";
            $sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
            $sql .= "h_ip = '" . getUserIP() . "' ";
            $db->query($sql);
        
            setcookie("h_userName", $md5Name,NULL,'/');
            setcookie("h_passWord", $md5Pwd,NULL,'/');
            
            turnToPage("le.php");
        }
        
        exit();
}
?>

<?php
// 确保文件路径正确
$tx = '../Information/tx.txt';
$mz = '../Information/mz.txt';

// 检查文件是否存在
if (file_exists($tx)) {
    // 读取文件内容
    $tx1 = file_get_contents($tx);
}
if (file_exists($mz)) {
    // 读取文件内容
    $mz1 = file_get_contents($mz);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>金条传媒</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/layui@2.6.8/dist/css/layui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
<style>
        :root {
            --primary-color: #C5C1FF;
            --primary-light: #C5C1FF;
            --text-color: #2d3436;
            --text-secondary: #636e72;
            --bg-color: #f4f6f9;
            --bg-card: #ffffff;
            --border-color: #edf2f7;
            --error-color: #ef4444;
        }

        @font-face {
            font-family: 'MainFont';
            src: url('/css/Font.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%););
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: MainFont, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: var(--bg-card);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
            position: relative;
            margin: 20px;
        }

        .login-form {
            width: 400px;
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #C5C1FF;
            margin-bottom: 10px;
        }

        .welcome-text {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: var(--text-color);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-color);
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(76, 111, 255, 0.1);
            outline: none;
        }

        .error-message {
            font-size: 12px;
            color: var(--error-color);
            margin-top: 4px;
            display: none;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .remember-me span {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .forgot-password {
            font-size: 14px;
            color: #C5C1FF;
            text-decoration: none;
            transition: all 0.3s;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%););
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 111, 255, 0.2);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 992px) {
            .login-form {
                width: 100%;
                max-width: 400px;
            }
        }
    </style>

</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <div class="form-header">
                <title>金条后台</title>
                <div class="welcome-text">金条集团</div>
            </div>
            <form id="loginForm" method="post" action="?clause=chklogin">
                <div class="form-group">
                    <label>用户名</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-input" name="loginName" placeholder="请输入用户名">
                    </div>
                    <div class="error-message">请输入正确的用户名</div>
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-input" name="loginPwd" placeholder="请输入密码">
                    </div>
                    <div class="error-message">请输入正确的密码</div>
                </div>
                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>记住我</span>
                    </label>
                    <a class="forgot-password">忘记密码？</a>
                </div>
                <button type="submit" class="login-btn">
                    <span> 登 录</span>
                </button>
        </div>
    </div>
    </form>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/layui@2.6.8/dist/layui.js"></script>
    <script>
        layui.use(['layer'], function () {
            var layer = layui.layer;

            // 表单提交处理
            $('#loginForm').on('submit', function (e) {
                const username = $('input[name="loginName"]').val().trim();
                const password = $('input[name="loginPwd"]').val().trim();

                if (!username) {
                    layer.msg('请输入用户名', { icon: 2 });
                    return false;
                }

                if (!password) {
                    layer.msg('请输入密码', { icon: 2 });
                    return false;
                }

                const $btn = $('.login-btn');
                $btn.addClass('loading').html('<i class="fas fa-spinner"></i> 登录中...');

                return true;
            });

            // 输入框获取焦点时隐藏错误信息
            $('.form-input').on('focus', function () {
                $(this).removeClass('error');
                $(this).closest('.form-group').find('.error-message').hide();
            });

            // 第三方登录按钮点击事件
            $('.other-login-btn').on('click', function () {
                const title = $(this).attr('title');
                layer.msg(`${title}金条tg@jintiao789`);
            });

            // 忘记密码点击事件
            $('.forgot-password').on('click', function (e) {
                e.preventDefault();
                layer.open({
                    title: '提示',
                    content: '联系金条tg@jintiao789找回',
                    icon: 1
                });
            });
        });
    </script>
</body>
<script type="text/javascript" src="//js.users.51.la/21986587.js"></script>


</html>