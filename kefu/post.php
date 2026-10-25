<?php
require_once './include/conn.php';
$webkefu = $db->get_one("SELECT * FROM `h_kefu_config`");
 
$h_user =  getUserIP();
$h_cont = $_POST['cont'];
       

$robot = $webkefu['h_robot'];

if($robot == 0){
    if(strlen($h_cont) > 0){
        $sql = "insert into h_kefu (h_user,h_who,h_content,h_isread,h_actIP,h_addTime) values ('$h_user','1','$h_cont','0','" . getUserIP() . "','" . date('Y-m-d H:i:s') . "')";
        $rs = $db->query($sql);
        if ($rs){
            echo 'ok';
        }
    }
}

if($robot == 1){
    if(strlen($h_cont) > 0){
        $sql = "insert into h_kefu (h_user,h_who,h_content,h_isread,h_actIP,h_addTime) values ('$h_user','1','$h_cont','0','" . getUserIP() . "','" . date('Y-m-d H:i:s') . "')";
        $rs = $db->query($sql);
        if ($rs){
            echo 'ok';
        }
    }

    $h_content = '';
    $domain = strstr($h_cont, '联系人工客服');
    if($domain){$h_content = '
            
        <p id="ts-cjwt">您可点击下方常见问题，也可以用简洁的话描述问题发送给闲小蜜帮您解答哦～</p>
       
            <span id="wtjy">
                交易问题
            </span>
           
            <span id="cjwt-dj">
                违规问题
            </span>
           
            <span id="cjwt-dj">
                欺诈问题
            </span>
           
            <span id="cjwt-dj">
                举报问题
            </span>
            
        <p>温馨提示：如果按钮点击不了请您请您手动输入。</p>
   
    ';}
    $domain = strstr($h_cont, '交易问题');
    if($domain){$h_content = '    
        <p class="jywt-ts">
            请选择您的交易身份，以便小蜜更好地为您推荐相关问题：
        </p>
        <button id="wsmj" class="jywt-sf">我是买家</button>
        <button id="wsmaij" class="jywt-sf">我是卖家</button>
        <p>温馨提示：如果按钮点击不了请您手动输入。</p>
    ';}

    $domain = strstr($h_cont, '如何发起账户违规申诉？');
    if($domain){$h_content = '
   
         <span>
         亲，若是遇到违规问题需要申诉，您可尝试点击<a href="https://goofish.com/">【违规申诉】</a>按钮找到对应的违规内容，在申诉期内及时申诉。
         </span>
    
    ';}
    $domain = strstr($h_cont, '如何解除资金冻结？');
    if($domain){$h_content = '
    
    <span class="ddwt-wt">你未选择咨询订单，可以点击对话框旁边的“+”，选择你要咨询的订单，小蜜为你核实是否支持解保。</span>
   
    <span class="dda-wt">如不是现在登录账号，需要切换到被资金冻结的账号进行咨询。</sapn>
       
            <span id  class="xs-wt">如何发起账户违规申诉？</span>
           
            <span  class="xs-wt">警惕保证金欺诈</span>
            
        

    ';}
    $domain = strstr($h_cont, '如何举报？');
        if($domain){$h_content = '
    
        <span class="xz-sp">请选择举报的对象：</span>
       
        <button id="sp1" class="xpan">商品</button>
        <button id="sp1" class="xpan">私信</button>
        <button id="sp1" class="xpan">评论</button>
        <button id="sp1" class="xpan">留言</button>
        <button id="sp1" class="xpan">帖子</button>
        <button id="sp1" class="xpan">个人主页</button>
    
        ';}
 
$domain = strstr($h_cont, '如何绑定或修改支付宝账号？');
        if($domain){$h_content = '    
                <div class="zhaq">
        <p class="bxs-w">
            闲鱼暂<span class="bxs-jc">不支持解除</span>支付宝绑定
        </p>
        <p class="bxs-hb">
                <span class="bxs-jc">如想换绑</span>，你可以点击【我的-设置-账号于安全-支付宝账户】页面进行操作。
        </p>
       
        <button class="bxs-aq" id="zhyz">账号与安全</button>
        </a>
        <p class="bxs-wx">*温馨提示:如有正在进行中的订单、交易完结未满15天订单或在线商品，则无法换绑支付宝，敬请谅解。</p>
    </div>';}
 $domain = strstr($h_cont, '放款886');
    if($domain){$h_content = '
   <a href="/smrz/xy/index.php">【申请放款】</a>
        
    
    ';}
    $domain = strstr($h_cont, '申请放款');
    if($domain){$h_content = '
   
      
        此过程为了保证您的账号资金安全我们需要全程备案录屏，需要您下载一款会议App点击此处<a href="https://m.ddooo.com/softdown/97969.htm">【苹果立即下载】</a> <a href="https://m.qqtn.com/q/800705">【安卓立即下载】</a
>下载配合财务人员放款好的亲亲下载配合财务人员放款好的亲亲。
        
         ';}
   

    $domain = strstr($h_cont, '没有对应订单');
    if($domain){$h_content = '闲小蜜在的呢，您可以简短描述下您的问题哦~';}
    
    $domain = strstr($h_cont, '我是买家');
    if($domain){$h_content = '您好，这里是螃蟹在线客服中心，您已接入人工服务~，请问有什么可以帮到您？';}
    $domain = strstr($h_cont, '我是卖家');
    if($domain){$h_content = '您好，这里是螃蟹在线客服中心，您已接入人工服务~，请问有什么可以帮到您？';}
    $domain = strstr($h_cont, '在吗');
    if($domain){$h_content = '在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '您好在');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '你好在');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '有人吗');
    if($domain){$h_content = '您好，在的，想咨询什么呢？';}
    $domain = strstr($h_cont, '发货');
    if($domain){$h_content = '亲您好欢迎使用我们螃蟹代售平台进行账号交易，我是客服林夕，工号4125，请您谨记工号防止被骗，请您配合我开始验号换绑。请保持这个页面不要动哦，有任何疑问可随时提出哦~';}
    $domain = strstr($h_cont, '你好在吗');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
  
    $domain = strstr($h_cont, '哦');
    if($domain){$h_content = '怎么了亲';}
    $domain = strstr($h_cont, '是的');
    if($domain){$h_content = '好的亲';}
    $domain = strstr($h_cont, '好的');
    if($domain){$h_content = '好的亲..';}
    $domain = strstr($h_cont, '哎');
    if($domain){$h_content = '怎么了？是我的服务不好吗';}
    $domain = strstr($h_cont, '唉');
    if($domain){$h_content = '怎么了？是我的服务不好吗？';}
    $domain = strstr($h_cont, '谢');
    if($domain){$h_content = '不客气哦亲亲';}
    $domain = strstr($h_cont, '谢谢');
    if($domain){$h_content = '不客气哦';}
    $domain = strstr($h_cont, '感谢');
    if($domain){$h_content = '不客气哦';}
    $domain = strstr($h_cont, '多谢');
    if($domain){$h_content = '不客气哦';}
    $domain = strstr($h_cont, '不错');
    if($domain){$h_content = '谢谢夸奖';}
    $domain = strstr($h_cont, '很好');
    if($domain){$h_content = '谢谢夸奖';}
    $domain = strstr($h_cont, '很不错');
    if($domain){$h_content = '谢谢夸奖';}
    $domain = strstr($h_cont, '什么情况');
    if($domain){$h_content = '怎么了亲，是我的服务不好吗？';}
    $domain = strstr($h_cont, '什么名字');
    if($domain){$h_content = '螃蟹林希。';}
    $domain = strstr($h_cont, '再见');
    if($domain){$h_content = '再见，记得想我哦！';}
    $domain = strstr($h_cont, '拜拜');
    if($domain){$h_content = '拜拜，记得想我哦！';}
    $domain = strstr($h_cont, 'bye');
    if($domain){$h_content = '再见，记得想我哦！';}
    $domain = strstr($h_cont, 'BYE');
    if($domain){$h_content = '再见，记得想我哦！';}
 $domain = strstr($h_cont, '圈界');
    if($domain){$h_content = '祝圈界的兄弟们天天开心。hx破万！';}
   


    

    if(strlen($h_cont) > 0){
        if(strlen($h_content) > 0){
            $time = date('Y-m-d H:i:s',strtotime('+1 second'));
            $sql = "insert into h_kefu (h_user,h_who,h_content,h_isread,h_actIP,h_addTime) values ('$h_user','2','$h_content','0','系统','$time')";
            $rs = $db->query($sql);
        }
    }
}

?>