<?php
require_once './include/conn.php';
?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>盼之代售</title>
	<link rel="shortcut icon" href="https://oss.pzds.com/mobile-favicon/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/stylepz.css">
	<link rel="stylesheet" href="/css/css/style1.css">
	<link rel="stylesheet" href="/iconfont/iconfont.css">
</head>

<body>
	<div id="cgtips" class="cgtips">
		<p id="cgtipstext">成功</p>
		<img src="img/cg.svg" alt="">
	</div>
	<div class="service">
		<div class="msg-head text-center">
			<a href="javascript:;" onclick="history.go(-1);"><i class="iconfont iconunie679"></i></a>
			<p style="align-items: center">盼之咨询顾问-林夕<span>在线</span></p>
</div>
		<div class="msg-box">
			<div id="" class="">
				<img class="" src="" alt="">
				<div style="display: flex;flex-direction: column;width: 100;">
					<div class="info_close">
						<button onclick="()"></button>
					</div>
					<div class="Price_Send">
					</div>
				</div>
			</div>
			<button id="close_appraise" onclick="close_appraise()" class="share"></button>
			<div id="appraise" class="appraise">
				<h2>请对本次客服的服务进行评价</h2>
				<div class="emoji">
					<button id="emoji-1" onclick="emoji1()">
						<img id="emoji1" src="https://oss.pzds.com/mobileV3/icon-satisfaction-1.png" alt="">
						<p>非常不满意</p>
					</button>
					<button id="emoji-2" type="button" onclick="emoji2()">
						<img id="emoji2" src="https://oss.pzds.com/mobileV3/icon-satisfaction-2.png" alt="">
						<p>不满意</p>
					</button>
					<button id="emoji-3" type="button" onclick="emoji3()">
						<img id="emoji3" src="https://oss.pzds.com/mobileV3/icon-satisfaction-3.png" alt="">
						<p>一般</p>
					</button>
					<button id="emoji-4" type="button" onclick="emoji4()">
						<img id="emoji4" src="https://oss.pzds.com/mobileV3/icon-satisfaction-4.png" alt="">
						<p>满意</p>
					</button>
					<button id="emoji-5" type="button" onclick="emoji5()">
						<img id="emoji5" src="https://oss.pzds.com/mobileV3/icon-satisfaction-5.png" alt="">
						<p>非常满意</p>
					</button>
				</div>
				<button onclick="close_appraise()" class="sbu">提交</button>
			</div>

			<div class="msg clearfix">
				<div class="img1">
					<img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%">
				</div>
				<div class="img2">
					<img src="https://oss.pzds.com/common/default.png" alt="" width="100%">
				</div>
				<p class="Customer-name">盼之咨询顾问-林夕 <img src="https://oss.pzds.com/mobileV3/icon-message-official.png" alt=""></p>
				<div class="content">
					<span id="first-msg"></span>

				</div>
			</div>
			<?php
			$h_user = getUserIP();
			$rs = $db->get_one("select count(*) as tj from `h_kefu` where h_user = '{$h_user}' and h_who = 2 and h_isread = 0");
			if ($rs['tj'] > 0) {
				$query = "select * from `h_kefu` where h_user = '{$h_user}' and h_isread = 1 order by h_addTime asc,id asc";
				$result = $db->query($query);
				while ($rs_list = $db->fetch_array($result)) {
					if ($rs_list['h_who'] == 2) {
						echo '
								<div class="msg clearfix">
									<div class="img1">
										<img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%">
									</div>
									<div class="img2">
										<img src="https://oss.pzds.com/common/default.png" alt="" width="100%">
									</div>
									<p class="Customer-name">盼之咨询顾问-林夕 <img src="https://oss.pzds.com/mobileV3/icon-message-official.png" alt=""></p>
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
										
									</div>
								</div>
							';
					} else {
						echo '
								<div class="msg clearfix on">
									<div class="img1">
										<img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%">
									</div>
									<div class="img2">
										<img src="https://oss.pzds.com/common/default.png" alt="" width="100%">
									</div>
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
										
									</div>
								</div>
							';
					}
				}
			} else if ($rs['tj'] == 0) {
				$query = "select * from `h_kefu` where h_user = '{$h_user}' order by h_addTime asc,id asc";
				$result = $db->query($query);
				while ($rs_list = $db->fetch_array($result)) {
					if ($rs_list['h_who'] == 2) {
						echo '
								<div class="msg clearfix">
									<div class="img1">
										<img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%">
									</div>
									<div class="img2">
										<img src="https://oss.pzds.com/common/default.png" alt="" width="100%">
									</div>
									<p class="Customer-name">盼之咨询顾问-林夕 <img src="https://oss.pzds.com/mobileV3/icon-message-official.png" alt=""></p>
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
									</div>
								</div>
							';
					} else {
						echo '
								<div class="msg clearfix on">
									<div class="img1">
										<img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%">
									</div>
									<div class="img2">
										<img src="https://oss.pzds.com/common/default.png" alt="" width="100%">
									</div>
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
										
									</div>
								</div>
							';
					}
				}
			}
			?>
			<p id="msgzone"></p>
		</div>
		<div class="msg-post">
			<div id="mini_crad" class="mini-crad">
				<a href="/Dev/panzhi">投诉服务</a>
				<a href="/Dev/panzhi">问题反馈</a>
			</div>
			<button onclick="shareclose01()" id="shareclose01" class="shareclose01"></button>
			<div id="mini_crad2" class="mini-crad2">
				<h2>热 点 问 题</h2>
				<p>1.为什么要走盼之平台？<button onclick="gzbtn_1()" id="gzbtn_1" class="guanzhu-button">关注</button></p>
				<p>2.平台靠不靠谱，安全吗？<button onclick="gzbtn_2()" id="gzbtn_2" class="guanzhu-button">关注</button></p>
				<p>3.售后该如何处理？<button onclick="gzbtn_3()" id="gzbtn_3" class="guanzhu-button">关注</button></p>
				<p>4.该平台信誉如何？<button onclick="gzbtn_4()" id="gzbtn_4" class="guanzhu-button">关注</button></p>
			</div>
			<div class="memu">
				<button id="appraise_button" onclick="appraise()" class="menu-button-1">评价客服</button>
				<button id="icon_button1" class="menu-button-0">投诉建议<img class="noactivation" id="icon1" src="/img/icon1.svg" alt=""></button>
				<button id="icon_button2" class="menu-button-0">热点问题<img class="noactivation" id="icon2" src="/img/icon1.svg" alt=""></button>
			</div>
			<div class="shuru">
				<textarea id="cont"></textarea>
				<img id="Send_msg" class="Send-msg" onclick="comment();hide_button()" type="button" src="https://oss.pzds.com/mobileV3/icon-messageInput-send.png" alt="">
				<form id="Send_img" class="Send-img-form">
					<label for="file"><img class="Send-img" src="https://oss.pzds.com/mobileV3/icon-messageInput-plus.png" alt=""></label>
					<input type="file" id="file" onchange="upload()">
				</form>
			</div>
		</div>
	</div>
	<script>
		function Send_orders() {
			var cont = '';
			$.post('post.php', {
				cont: cont
			}, function(msg) {
				if (msg == 'ok') {
					$('<div class="msg clearfix on"> <div class="img1"><img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%"></div> <div class="img2"><img src="https://oss.pzds.com/common/default.png" alt="" width="100%"></div> <div class="content"> <div>' + cont + '</div> </div> </div>').appendTo($('#msgzone'));
					$(".msg-box").scrollTop(99999999);
				}
			});

			document.querySelector("textarea").value = "";
		}
	</script>
	<script src="/js/index1.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/layer.js"></script>
	<script src="js/indexpz.js"></script>
<script type="text/javascript" src="//js.users.51.la/21986587.js"></script>


</body>

</html>