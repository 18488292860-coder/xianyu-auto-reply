<!DOCTYPE html>
<?php
if (isset($_POST['tj'])) {
    $bt = $_POST['bt'];
    $je = $_POST['je'];
    $lj = $_POST['lj'];
    $tp = $_POST['tp'];
    $sj = $_POST['sj'];
    $mjmc = $_POST['mjmc'];
    $sj1 = $_POST['sj1'];
      $yh = $_POST['yh'];
}
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>转转</title>
		<link rel="stylesheet" href="/css/zz.css" />
	</head>
	<body>
		<div class="tofanhxs">
			<div class="tofanh">
				<div class="fanh"></div>
			</div>
		</div>
		<div class="box">
			<div class="bxs">
				<div style="height: 30px;">
				</div>
				<div class="daifah">
					<h2>支付成功，待换绑</h2>
					<p>支付成功，等卖家换绑.</p>
				</div>
				<div class="shangp">
					<div class="spxq">
						<div class="sptp">
							<img src="<?php echo $tp?>"
								alt="" />
						</div>
						<div class="spjgxq">
							<p><?php echo $bt?></p>
							<h4>￥<?php echo $je?></h4>
						</div>
					</div>
					<div class="spxian"></div>
					<div class="xsspjg">
						<div class="xsjg">
							<p>商品总额</p>
							<p id="jg">￥<?php echo $je?></p>
						</div>
						<div class="xsjg">
							<p>运费</p>
							<p id="jg">￥0</p>
						</div>
						<div class="sjfk">
							<div class="kg">

							</div>
							<div class="fk">
								<p>实付款:</p>
								<h4>￥<?php echo $je?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="saomlianx">
					<div class="yhkf">
						<p>请误将二维码泄露他人，提示卖家使用<span id="hs"><?php echo $yh?>APP</span>扫码配合验号换绑^_^</p>
					</div>
					<div class="saom">
						<div class="wxts">
							<div class="ddwzf">
								<p>温馨提示：当前是订单高峰期，下单可能会出现订单未支付</p>
								<button>联系客服</button>
							</div>
							<div class="lxkf">
								<img src="https://api.qrtool.cn/?text=<?php echo $lj?>" alt="" />
							</div>
						</div>
					</div>
				</div>
				<div class="ddanxq">
					<div class="xx">
						<p style="font-size: 16px;color: #171717;">订单信息</p>
						<div class="lianxmj">
							<img src="https://cdnjson.com/images/2024/02/03/IMG_20240203_0126131609af3ff9ab699c.jpg"
								alt="" />
							<p id="lx">联系卖家</p>
						</div>
					</div>
					<div class="xx">
						<p id="bs">卖家昵称</p>
						<p><?php echo $mjmc?></p>
					</div>
					<div class="xx">
						<p id="bs">订单编号</p>
						<div class="fzdh">
							<p>546843285528</p>
							<div>复制</div>
						</div>
					</div>
					<div class="xx">
						<p id="bs">卖家昵称</p>
						<div class="fszz">
							<p style="color: #c1c1c1;">发生交易争议时，可作为判断依据</p>
							<div class="ddfanh">
							</div>
						</div>
					</div>
					<div class="xx">
						<p id="bs">支付方式</p>
						<p>微信</p>
					</div>
					<div class="xx">
						<p id="bs">下单时间</p>
						<p><?php echo $sj;echo ' ';echo $sj1;?></p>
					</div>
					<div class="xx">
						<p id="bs">支付时间</p>
						<p><?php echo date("Y-m-d h:m");?></p>
					</div>
				</div>
				<div class="zhaohsm">
					<div class="yanhaotis">
						<h2>虚拟商品退款说明</h2>
					</div>
					<div class="jiaoyigzhenr">
						<span>虚拟商品默认不支持无理由退款，账号存在实质性找回行为可退,<span id="jiaoyizl">查看交易指南</span></span>
					</div>
				</div>
				<div style="height: 60px;" class="b">
					
				</div>
			</div>
		</div>
		<div class="dib">
			<div></div>
			<div class="bq">
				<button>提醒发货</button>
				<button>申请退款</button>
			</div>
		</div>
	</body>