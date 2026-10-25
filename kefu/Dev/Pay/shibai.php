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

	 <h1><p class="e"><?php echo $je;?></h1>
</body>
                                </div>
                                
                                <div class="fk-center">
   <?php echo $mjmc;?>         </div>
                              
                                <div class="fk-center">
                                    <p class="e">支付失败</p>
                               
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
                                        <p>支付原因</p>
                                    </div>
                                    <div class="lieb-right">
                                        <div style="margin-right:3px;" class="fs-left">
                                            <p class="e">财务订单YT107打款</p>
                                        </div>
                                        <div class="fs-right">
                                            <div class="fh-fs">
                                              <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>     <div class="lb">
                                    <div class="lb-left">
                                        <p>支付失败原因</p>
                                    </div>
                                    <div class="lieb-right">
                                        <p class="e">账户流水不足或账户长期未收款</p>
                                    </div>
                                </div>
                               
                                    <div class="lb">
                                        <div class="lb-left">
                                            <p>订单号 </p>
                                        </div>
                                        <div  style="marign-left:40px" class="lieb-right">
                                            <p>Y2005109012222618014</p>
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
                                </div>
                            </div>
                        </div>
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