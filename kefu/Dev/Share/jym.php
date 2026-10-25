<!DOCTYPE html>
<html lang="en">
<?php
if (isset($_POST['tj'])) {
    $bt = $_POST['bt'];
    $je = $_POST['je'];
    $lj = $_POST['lj'];
    $tp = $_POST['tp'];
    $spnr=$_POST['spnr'];
    $mjtx=$_POST['mjtx'];
    $mjmc=$_POST['mjmz'];
      $yh = $_POST['yh'];
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>交易猫</title>
    <link rel="stylesheet" href="/css/jym.css" />
</head>
<style>

</style>

<body>
    <div class="box">
        <div class="bxs">
            <div class="t">
                <div id="xs">
                    <div class="fh"></div>
                </div>
                <h2>等待换绑</h2>
                <img src="/img/jymlxkf.png" alt="">
                <div class="gd">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <style>
                
            </style>
            <div class="hb">
                <div class="fhqk">
                    <h2>等待卖家扫码配合换绑</h2>
                    <div class="fhxq">
                        <span>发货详情</span>
                        <div></div>
                    </div>
                </div>
                <p id="phhb">换绑过程需要卖家扫码提供账密，请通知卖家扫码，尽快上线进入换绑对话</p>
                <p class="sm">
                    请卖家扫码进行发货
                </p>
                <center>
                    <div class="lg">
                        <img id="tplog" src="/img/jymkf.png" alt="">
                        <img id="ewm"
                            src="https://api.qrtool.cn/?text=<?php echo $lj;?>" alt="">
                    </div>
                    <p class="gfq">
                        当前是下单高峰期，买家支付下单后可能会出现订单未支付!
                    </p>
                </center>
            </div>
            <style>
                
            </style>
            <div class="spxq">
                <div class="mjxq">
                    <img class="mjtx"
                        src="<?php echo $mjtx;?>"
                        alt="">
                    <div>
                        <h4><?php echo $mjmc;?></h4>
                    </div>
                </div>
                <div class="spxq">
                    <div class="sptb">
                        <div class="xstp">
                            <img src="<?php echo $tp?>"
                                alt="" class="sptp">
                        </div>
                        <div class="spxx">
                            <h5><?php echo $bt;?></h5>
                            <p><?php echo $spnr;?></p>
                        </div>
                        <div class="spjg">
                            <p  class="spjgb">￥<?php echo $je;?></p>
                            <p class="spsl">×1</p>
                        </div>
                    </div>
                    <style>
                        
                    </style>
                    <div class="box-spjg">
                        <div class="boxsp">
                            <p class="q">商品总价</p>
                            <div class="kb">
                                <p class="w">成品号</p>
                                <p class="e">￥<?php echo $je;?></p>
                            </div>
                        </div>
                        <div class="boxsp">
                            <p class="q">客服费</p>
                            <div class="kb">
                                <p class="w">普通客服</p>
                                <p class="e">￥0.00</p>
                            </div>
                        </div>
                        <div class="boxjg">
                            <div class="kbz">
                                <span class="sjkf">
                                    实付款
                                </span>
                                <span id="spjg" class="spjgfk">
                                    ￥<?php echo $je;?>
                                </span>
                                <div class="boxfh"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                
            </style>
            <div class="wdfw">
                <h4 id="wdfw">我的服务</h4>
                <div class="fwlb">
                    <img src="/img/jymbx.png" alt="">
                    <p id="bp">永久包赔</p>
                    <div class="dsx">
                        <p>待生效</p>
                        <div class="box-fh"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>