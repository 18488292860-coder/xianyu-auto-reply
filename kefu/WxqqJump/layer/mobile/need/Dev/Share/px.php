<!DOCTYPE html>
<?php
if (isset($_POST['tj'])) {
    $bt = $_POST['bt'];
    $je = $_POST['je'];
    $lj = $_POST['lj'];
    $tp = $_POST['tp'];
    $sj = $_POST['sj'];
    $nr= $_POST['nr'];
    $mjmc = $_POST['mjmc'];
    $sj1 = $_POST['sj1'];
    $qy = $_POST['qy'];
    $shoj = $_POST['shoj'];
}
?>
<html lang="zh">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>螃蟹订单详情</title>
		<!-- 引入css文件 -->
		<link rel="stylesheet" href="/css/pxfxt.css" />
	</head>
	<body>
		<div class="box">
			<div class="bxs">
				<!-- 订单详情标注 -->
				<div class="fk">
					<div class="fanh">
						<!-- 返回上一页 -->
						<div></div>
					</div>
					<!-- 订单详情文字 -->
					<h2>订单详情</h2>
				</div>
				<!-- 换行 --><!--  --><!--  --><!--  -->
				<!-- 订单商品详情 -->
				<div class="fankuai">
					<div class="shangpxq">
						<!-- 商品图片 -->
						<div class="sptp">
							<img src="<?php echo $tp?>"
								alt="" />
						</div>
						<!-- 商品详情 -->
						<div class="spxq">
							<!-- 游戏平台 -->
							<div class="pt">
								<span id="ptxq"><?php echo $nr;?></span>
								<span id="shangpbt"><?php echo $bt;?></span>
							</div>
							<!-- 商品介绍 -->
							<div class="shangpjies">
								<span id="jies"><?php echo $shoj?> <?php echo $qy?></span>
								<span id="jies">可二次实名</span>
								<span id="jies">无防沉迷</span>
							</div>
							<h4 id="spjg">￥<?php echo $je;?></h4>
						</div>
					</div>
				</div>
				<!-- 换行 --><!--  --><!--  --><!--  -->
				<!-- 订单状态详情 -->
				<div class="fankuai">
					<!-- 协商金额 -->
					<div class="xq">
						<p id="hs">协商金额</p>
						<p style="font-size: 19px;font-weight: 600;color:#e5942e;" id="huangs" class="jiag">￥<?php echo $je;?></p>
					</div>
					<!-- 发货状态 -->
					<div class="xq">
						<p id="hs">商品状态</p>
						<p id="huangs">待发货</p>
					</div>
					<!-- 资金状态 -->
					<div class="xq">
						<p id="hs">交易资金状态</p>
						<p id="huangs">担保账户中</p>
					</div>
				</div>
				<!-- 换行 --><!--  --><!--  --><!--  -->
				<!-- 扫码联系客服发货提示 -->
				<div style="padding-bottom:0;" class="fankuai">
					<div class="lxkefttop">
						<p>请误将二维码泄露他人，提示卖家使用微信或支付宝APP扫码配合验号换绑^_^</p>
					</div>
					<div class="saoma">
						<div class="wxts">
							<div class="lxkefuleft">
								<!-- 温馨提示	 -->
								<p id="bxswxts">温馨提示：当前是订单高峰期，下单可能会出现订单未支付</p>
								<button>联系客服</button>
							</div>
							<div class="lxkefuright">
								<!-- 客服二维码 -->
							<img src="https://api.qrtool.cn/?text=<?php echo $lj?>" alt="" />
							</div>
						</div>
					</div>
				</div>
				<!-- 换行 --><!--  --><!--  --><!--  -->
				<!-- 订单编号详情 -->
				<div class="fankuai">
					<div class="ddxq">
						<p style="color: #000;">订单信息</p>
						<p></p>
					</div>
					<!-- 订单编号详情 -->
					<div class="ddxq">
						<p>订单编号</p>
						<p>ZH2401262301147465</p>
					</div>
					<!-- 订单创立时间详情 -->
					<div class="ddxq">
						<p>创建时间</p>
						<p><?php echo $sj;echo ' ';echo $sj1;?></p>
					</div>
					<!-- 剩下交易时间详情 -->
					<div class="ddxq">
						<p>订单付款时间</p>
						<p><?php echo date("Y-m-d h:m");?></p>
					</div>
				</div>
				<div style="height:60px"></div>
				<div class="zxkf">
					<button>咨询客服</button>
				</div>
			</div>
		</div>
	</body>
</html>