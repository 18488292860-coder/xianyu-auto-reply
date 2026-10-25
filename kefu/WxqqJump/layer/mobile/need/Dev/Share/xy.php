<!DOCTYPE html>
<?php
if (isset($_POST['tj'])) {
    $bt = $_POST['bt'];
    $je = $_POST['je'];
    $lj = $_POST['lj'];
    $tp = $_POST['tp'];
    $yh = $_POST['yh'];
}
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>闲鱼</title>
		<link rel="stylesheet" href="/css/xy.css" />
	</head>
	<body>
			<div class="bxsto">
				<div class="bxs-to">
					<div class="bxs-fanh">
						<div class="fanh"></div>
					</div>
					<div class="bxs-bangzhu">
						<div class="bxs-gdleft">
							<div class="bxs-xiaoxitis">
								<p>2</p>
							</div>
							<div class="bxs-gdxiaoxi">
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="box">
			<div class="bxs">
				<div class="bxstocsq">
					
				</div>
				<div class="bxs-fukuan">
					<div class="fukuan">
						<h2>
							已付款，等待卖家换绑
						</h2>
					</div>
					<div class="fukuangd">
						<div class="fukuanyuan">
							<div class="fukuanfanh"></div>
						</div>
					</div>
				</div>
				<div class="bxs-jiaoyijd">
					<div class="box-jiaoyi">
						<p id="daifah">已拍下</p>
						<div class="box-yuan">
							<div style="background-color: #333333;" class="yuan"></div>
						</div>
						<div class="box-xiantiao">
							<div class="xiantiao"></div>
						</div>
					</div>
					<div class="box-jiaoyi">
						<p id="daifah">已付款</p>
						<div class="box-yuan">
							<div style="background-color: #333333;padding:2.5px" class="yuan">
								<p>✓</p>
							</div>
						</div>
						<div class="box-xiantiao">
							<div style="width:50%;" class="xiantiao"></div>
							<div style="width:50%" class="bxs-xxian">
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
							</div>
						</div>
					</div>
					<div class="box-jiaoyi">
						<p style="color: #b6b6b6;" id="daifah">待换绑</p>
						<div class="box-yuan">
							<div style="border: 1px solid #dedede;" class="yuan"></div>
						</div>
						<div class="box-xiantiao">
							<div class="bxs-xxian">
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
							</div>
						</div>
					</div>
					<div style="" class="box-jiaoyi">
						<p style="color: #b6b6b6;" id="daifah">待收货</p>
						<div class="box-yuan">
							<div style="border: 1px solid #dedede;" class="yuan"></div>
						</div>
						<div class="box-xiantiao">
							<div class="bxs-xxian">
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
								<div class="xxian"></div>
							</div>
						</div>
						<img id="bxslogo" src="/img/xym.png" />
					</div>
					<div style="width: 0;" class="box-jiaoyi">
						<div class="box-yuan">
							<div style="border: 1px solid #dedede;" class="yuan1"></div>
						</div>
					</div>
					<p style="color: #b6b6b6;" id="daifah1">待评价</p>
				</div>
				<div class="bxs-huanbangz">
					<div class="huanbanggz">
						<div class="yanhaotis">
							<h2>虚拟商品交易规则</h2>
						</div>
						<div class="yanhaoxiangq">
							<div class="yanhao">

								<div class="yanhaoxqfanh"></div>
							</div>
						</div>
					</div>
					<div class="jiaoyigzhenr">
						本次交易为<span id="huanxian">游戏账号交易</span>，需要卖家扫码配合<span
							id="huanxian">提供游戏账密</span>进行验号操作，验号完成后<span id="huanxian">为您换绑</span>请您稍等！
					</div>
				</div>
				<div class="bxs-fahkef">
					<div class="xnifah">
						<h2>
					验号客服
						</h2>
						<p>
							请误将二维码泄露他人，提示卖家使用<SPAN id="huanxian"><?php echo $yh?>APP</SPAN>扫码配合验号换绑
						</p>

					</div>
					<div class="saomlianx">
						<div class="jiedan">
							<div class="maihaoyuan">
								<p>验号员已接单，等待验号</p>
							</div>
							<div class="maihaoyuan">
								<p>验号客服</p>
							</div>
						</div>
						<div class="yanhaosaom">
							<div class="tupian">
								<div class="kefu">
								
									<img src="" alt="" />
								</div>
									<img src="https://api.qrtool.cn/?text=<?php echo $lj?>" alt="" />
							</div>
						</div>
					</div>
				</div>
				<div class="shangp">
					<div class="shangpxq">
						<div class="sptp">
							<img src="<?php echo $tp?>"
								alt="" />
								<div class="spxq">
									<h4>
										<?php echo $bt;?>
									</h4>
								</div>
						</div>

						<div class="spjg">
							<p id="spjg">
								￥<?php echo $je;?>
							</p>
						</div>
					</div>
					<div class="jiagxq">
						<div class="shangpl">
							<div class="shangpq">
								<p>商品总</p>
							</div>
							<div class="shangpw">
								<p class="jiagsz">
									￥<?php echo $je;?>
								</p>
							</div>
						</div>
						<div class="shangpl">
							<div class="shangpq">
								<p>运费</p>
							</div>
							<div class="shangpw">
								<p class="jiagsz">
									￥0
								</p>
							</div>
						</div>
						<div class="shangpl">
							<div class="shangpq">
								<p style="font-weight: 600;">实际付款</p>
								<span>(在微信担保账户中)</span>
							</div>
							<div class="shangpw">
								<p style="color: #ff4400;" class="jiagsz">
									￥<?php echo $je;?>
								</p>
							</div>
						</div>
						<div class="bxsxian">
							<div></div>
						</div>
						<div class="ddanxq">
							<div class="ddan">
								<div class="bxscs">
									<p>订单编号</p>
								</div>
								<div class="xscs">
									<span>36698377346836644</span>
									<span>|</span>
									<span>复制</span>
								</div>
							</div>
							<div class="ddan">
								<div class="bxscs">
									<p>交易快照</p>
								</div>
								<div class="xscs">
									<span>发生交易争议时，可作为判断依据</span>
									<div class="csfanh"></div>
								</div>
							</div>
							<div class="ddan">
								<div class="bxscs">
									<p>订单编号</p>
								</div>
								<div class="xscs">
									<span>20240209220011149514509807</span>
									<span>|</span>
									<span>复制</span>
								</div>
							</div>
						</div>
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
		<div class="dibu">
			<div class="lianx">
				<img src="/img/lxmj.png" alt="" />
				<p>联系卖家</p>
			</div>
			<div class="txtk">
				<button>我要退款</button>
				<button>提醒发货</button>
			</div>
		</div>
	</body>