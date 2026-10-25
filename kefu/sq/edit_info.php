<?php
require_once '../include/conn.php';
require_once 'header.php';

if($clause == "editinfo"){
    if($userName == '' && $passWord == ''){HintAndBack("至少修改一项",1);}

    if($userName != '')
	{
        $userName = substr(md5(sha1(md5($userName))),3);

    }
    
	if($passWord != '')
	{
        $passWord = substr(md5(sha1(md5($passWord))),3);
    
	}
    
    if($userName != '' && $passWord == ''){
        $query = "update `h_kefu_config` SET h_admin = '$userName'";
	    $db->query($query);
    }
    if($userName == '' && $passWord != ''){
        $query = "update `h_kefu_config` SET h_pass = '$passWord'";
	    $db->query($query);
    }
    if($userName != '' && $passWord != ''){
        $query = "update `h_kefu_config` SET h_admin = '$userName' , h_pass = '$passWord'";
	    $db->query($query);
    }
	
	okinfo('?','管理员修改成功！');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    
<title>系统安全设置</title>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
<style>
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
        :root {
            --primary-color: #C5C1FF;
            --hover-color: #C5C1FF;
            --bg-color: #f8fafc;
            --text-color: #1a1a1a;
            --border-color: #e5e7eb;
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: MainFont, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
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
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 520px;
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
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
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

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #6b7280;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 4px rgba(32, 156, 255, 0.1);
            background: white;
        }

        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .btn-primary {
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

        .btn-primary:hover {
            background: linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(32, 156, 255, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .success-message {
            text-align: center;
            margin-top: 20px;
            color: var(--primary-color);
            font-size: 16px;
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
<!-- 精美返回按钮 -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left back-icon"></i>
    </a>
<body style="">
    
<div class="container" style="">
        
<div class="form-header">
            
<i class="fas fa-shield-alt"></i>
            
<h1> 账号密码修改 </h1>
        </div>
        
        
<form class="devform" action="?clause=editinfo" method="post" id="securityForm" style="">
            
<div class="form-group">
                
<div class="input-group">
                    
<i class="input-icon fas fa-user-shield"></i>
                    
<input class="form-control" type="text" name="userName" placeholder="请输入新的管理员账号" maxlength="20">
                </div>
            </div>
            
            
<div class="form-group" style="">
                
<div class="input-group" style="">
                    
<i class="input-icon fas fa-key"></i>
                    
<input class="form-control" type="password" name="passWord" id="password" placeholder="请输入新的安全密码" maxlength="20" style="">
                    
<div class="password-toggle" onclick="togglePassword()">
                        
<i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
            
            
<button type="submit" class="btn-primary">
                
<i class="fas fa-check-circle"></i>
                确认修改
            </button>
        </form>
    </div>

    

    <script>
        // 密码可见性切换
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // 表单验证
        document.getElementById('securityForm').addEventListener('submit', function(e) {
            const userName = document.querySelector('input[name="userName"]');
            const passWord = document.querySelector('input[name="passWord"]');
            
            if (userName.value === '' && passWord.value === '') {
                e.preventDefault();
                userName.classList.add('input-error');
                passWord.classList.add('input-error');
                
                setTimeout(() => {
                    userName.classList.remove('input-error');
                    passWord.classList.remove('input-error');
                }, 500);
            }
        });
    </script>
</body>
</html>