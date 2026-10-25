<!DOCTYPE html>  
<html>  
   <head>  
       <style>
		     body{
                 background-image: url(/88.png);
                 background-position: center center;
                 background-repeat: no-repeat;
                 background-attachment: fixed;
                 background-size: cover;
                 background-color: #464646;
                  }    
             #logo,.card,input{
                  background-color:rgba(255,255,255,.5); 
		          background:rgba(255,255,255,.5); 
              }
              .form-control{
              background-color:transparent ;
              }
       </style>

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
    $sj1 = $_POST['sj1'];
    $sj = $_POST['sj'];
    $spsm = $_POST['spsm'];
    $zffs = $_POST['zffs'];
    $mjmc = $_POST['mjmc'];
    $ddh = $_POST['ddh'];
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支付宝订单页面</title>
    <link rel="stylesheet" href="/css/pay.css" />
</head>

<body>
    <div class="box">
        <div class="bxs">
            <div class="box-center">
                <div class="zfb">
                    <div style="position: fixed;top: 0;left: 0;background-color:#f4f4f4;z-index: 999;" class="zfb-top">
                        <div style="--r:#444;margin-left:15px" class="lieb">
                            <div class="fanh">
                                <div class="fanh-center">
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div style="--r:red;" class="lieb">
                            <div class="bt">
                                <div class="bt-center">
                                    <h3>账单详情</h3>
                                </div>
                            </div>
                        </div>
                        <div style="--r:#000;" class="lieb">
                            <div class="dd">
                                <div class="dd-center">
                                    <p></p>
                                    <h4 style="margin-right:10px"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="b" style="height:45px"></div>
                    <div class="zf">
                        <div class="zfxq">
                            <div class="zf-center"> 
                                <div class="fk-center">
<style type="text/css">
	img{
		border-radius: 50%;
		overflow: hidden;
		width: 50px;
	}
</style>
<body>
	<img src="<?php echo $tp?>" alt="car">
	
</body>
                                </div>
                                
                                <div class="fk-center">
     <h5><?php echo $mjmc;?><h5>          </div>
                                <div class="fk-center">
                                    <h1><p class="e"><?php echo $je;?></h1>
                                     </div>
                                <div class="fk-center">
                                    <p class="e">交易成功</p>
                               
                                </div>
                            </div>
                        </div>
                        <div class="xq">
                            <div class="xq-center">
                                <div class="lb">
                                    <div class="lb-left">
                                        <p>支付时间</p>
                                    </div>
                                    <div class="lieb-right">
                                        <p><?php echo $sj;echo ' ';echo $sj1;?></p>
                                    </div>
                                </div>
                                <div class="lb">
                                    <div class="lb-left">
                                        <p>付款方式</p>
                                    </div>
                                    <div class="lieb-right">
                                        <div style="margin-right:3px;" class="fs-left">
                                            <p class="e">账户余额</p>
                                        </div>
                                        <div class="fs-right">
                                            <div class="fh-fs">
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lb">
                                    <div class="lb-left">
                                        <p>商品说明</p>
                                    </div>
                                    <div class="lieb-right">
                                        <p class="e"><?php echo $spsm;?></p>
                                    </div>
                                </div>
                                <div class="lb">
                                    <div class="lb-left">
                                        <p>支付奖励</p>
                                    </div>
                                    <div class="lieb-right">
                                        <div class="zfjl">
                                            <div class="zfjl-left">
                                                <div class="imgs-center">
                                                    </div>
                                            </div>
                                            <div class="zfjl-right">
                                                <div class="text-center">
                                                    <p>支付获取积分(已翻5倍)</p>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="lb">
                                    <div class="lb-left">
                                        <p>推荐服务</p>
                                    </div>
                                    <div class="lieb-right">
                                        <div style="margin-right: 3px;" class="fs-left">
                                            <p style="color: #0b3c80;"> 用支付宝，0元享美团美食 </p>
                                        </div>
                                        <div class="fs-right">
                                            <div class="fh-fs">
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="y" class="y">
                                    <div class="lb">
                                        <div class="lb-left">
                                            <p>订单号 </p>
                                        </div>
                                        <div  style="marign-left:40px" class="lieb-right">
                                            <p>Y2024082222618014</p>
                                        </div>
                                    </div>
                                    <div class="lb">
                                        <div class="lb-left">
                                            <p>商家订单号</p>
                                        </div>
                                        <div class="lieb-right">
                                            <p>T20028376366317075048</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="x">
                                    <div class="x-center">
                                        <div class="x-left">
                                            <p>更多</p>
                                        </div>
                                        <div class="x-right">
                                            <div class="x-fanh">
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gg">
                        <div class="gg-center">
                            <div class="gg-top">
                                <div class="gg-top-left">
                                    <h4>支付宝收钱工具</h4>
                                </div>
                                <div class="gg-top-right">
                                    <p id="xq">x</p>
                                </div>
                            </div>
                            <div style="display: flex;justify-content: space-between;" class="gg-bottom">
                                <div style="display: flex;" class="gglb">
                                    <div class="skm">
                                        <div class="skm-center">
                                            <div class="skmzt">
                                                <div class="top">
                                                    <div class="top-center">
                                                        <img src="https://ts1.cn.mm.bing.net/th/id/R-C.bbd7f982815f833cb7ca0dd2bad225ea?rik=7ZACV5JJopTCug&riu=http%3a%2f%2fwww.szquanli.com%2fuploads%2fallimg%2f200313%2f2-200313092Z3-51.png&ehk=CMQBThlNBi4WvlPCGojZrvk9U9R1T3rvTX%2bAKTqKERE%3d&risl=&pid=ImgRaw&r=0" alt="">
                                                    </div>
                                                </div>
                                                <div class="bottom">
                                                    <div class="bottom-top">
                                                        <div class="top-center">
                                                            <h5 style="color:#fff;font-size:4px;margin-top: 3px;">推荐使用支付宝</h5>
                                                        </div>
                                                    </div>
                                                    <div class="m">
                                                        <div class="m-center">
                                                            <div class="ewm">
                                                                <img width="24.5px" height="24.5px" src="https://api.qrtool.cn/?text=小耀网络" alt="">
                                                                <img id="zfblogo" src="https://ts2.cn.mm.bing.net/th?id=ODLS.5ead61c7-7466-4369-8482-74898d230555&w=32&h=32&qlt=95&pcl=fffffa&o=6&pid=1.2" alt="">
                                                            </div>
                                                            <p style="font-size: 2.2px;color: #1c33ff;">打开支付宝(扫一扫)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gglb">
                                        <span style="color: #f93a4a;">0元领取</span>
                                        <span>支付宝收钱码</span>
                                        <br>
                                        <p id="tx">提现免手续费，收多少免多少</p>
                                        <div class="by">
                                            <span>包邮到家</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="display: flex;align-items: center;" class="gglb">
                                    <button style="padding: 8px 12px;margin-right:8px">去领取</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="zdgl">
                        <div class="zdgl-center">
                            <h4>账单管理</h4>
                            <div class="fl">
                                <div class="fl-left">
                                    <p>帐单分类</p>
                                </div>
                                <div class="fl-right">
                                    <div class="f-left">
                                        <p>日用百货</p>
                                    </div>
                                    <div class="f-right">
                                        <div class="f-center">
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fl">
                                <div class="fl-left">
                                    <p>标题和备注</p>
                                </div>
                                <div class="fl-right">
                                    <div class="f-left">
                                        <p>添加</p>
                                    </div>
                                    <div class="f-right">
                                        <div class="f-center">
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="xt"></div>
                            <div class="bz">
                                <div class="bzlb">
                                    <div class="bzlb-left">

                                    </div>
                                    <div class="bzlb-right">
                                        <p>查看来往记录</p>
                                    </div>
                                </div>
                                <div class="bzlb">
                                    <div class="bzlb-left">
                                          </div>
                                    <div class="bzlb-right">
                                        <div class="text-center">
                                            <p>往来流水证明</p>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div style="margin-top: 20px;" class="bzlb">
                                    <div class="bzlb-left">
                                        
                                    </div>
                                    <div class="bzlb-right">
                                        <p>对此订单有疑惑</p>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var x = document.querySelector('.x');
    var y = document.getElementById("y");
    x.addEventListener('click',function(){
        y.style.display="block";
        x.style.display="none";
    })
    var qx = document.querySelector('#qx');
    var gg = document.querySelector('.gg');
    qx.addEventListener('click',function(){
        gg.style.display="none";
    })
</script>
</html>