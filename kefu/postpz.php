<?php
require_once './include/conn.php';
$webkefu = $db->get_one("SELECT * FROM `h_kefu_config`");
 
$h_user =  getUserIP();
$h_cont = $_POST['cont'];

$h_cont = str_replace(" ", "", $h_cont);
$h_cont = str_replace("_", "", $h_cont);
$h_cont = str_replace("*", "", $h_cont);
$h_cont = str_replace("?", "", $h_cont);       
$h_cont = str_replace("\'", "", $h_cont);	  
$h_cont = str_replace("$", "", $h_cont);            
$h_cont = str_replace("(", "", $h_cont);     
$h_cont = str_replace(")", "", $h_cont);
$h_cont = str_replace("xss","",$h_cont);
$h_cont = str_replace("or","",$h_cont);
$h_cont = str_replace("%20","",$h_cont); 
$h_cont = str_replace("http","",$h_cont);//限制网址起
$h_cont = str_replace(":","",$h_cont); 
$h_cont = str_replace("/","",$h_cont); 
$h_cont = str_replace("//","",$h_cont); 
$h_cont = str_replace("www","",$h_cont);
$h_cont = str_replace(".","",$h_cont); 
$h_cont = str_replace("=","",$h_cont); 
$h_cont = str_replace("&","",$h_cont); 
$h_cont = str_replace("-","",$h_cont);
$h_cont = str_replace("com","",$h_cont); 
$h_cont = str_replace("cn","",$h_cont); 
$h_cont = str_replace("net","",$h_cont);
$h_cont = str_replace("top","",$h_cont);
$h_cont = str_replace("site","",$h_cont);//限制网站止
$h_cont = str_replace("select", "", $h_cont);
$h_cont = str_replace("from", "", $h_cont);
$h_cont = str_replace("delete","",$h_cont); 
$h_cont = str_replace("update","",$h_cont); 
$h_cont = str_replace("insert","",$h_cont);
$h_cont = str_replace("truncate","",$h_cont);
$h_cont = str_replace("table","",$h_cont);
$h_cont = str_replace("<iframe", "", $h_cont);
$h_cont = str_replace("</iframe", "", $h_cont);
$h_cont = str_replace("<script", "", $h_cont);
$h_cont = str_replace("</script", "", $h_cont);
$h_cont = str_replace("<div", "", $h_cont);
$h_cont = str_replace("</div", "", $h_cont);
$h_cont = str_replace("<a", "", $h_cont);
$h_cont = str_replace("</a", "", $h_cont);
$h_cont = str_replace(">>", "", $h_cont);
$h_cont = str_replace("javascript", "", $h_cont);
$h_cont = str_replace("window", "", $h_cont);
$h_cont = str_replace("location", "", $h_cont);
$h_cont = str_replace("aspx", "", $h_cont);
$h_cont = str_replace("ASPX", "", $h_cont);
$h_cont = str_replace("php", "", $h_cont);
$h_cont = str_replace("meta", "", $h_cont);
$h_cont = str_replace("content", "", $h_cont);
$h_cont = str_replace("request", "", $h_cont);
$h_cont = str_replace("chr", "", $h_cont);
$h_cont = str_replace("url", "", $h_cont);
$h_cont = str_replace("js", "", $h_cont);
$h_cont = str_replace("去你妈","***",$h_cont);  
$h_cont = str_replace("去你麻","***",$h_cont); 
$h_cont = str_replace("傻比","**",$h_cont);  
$h_cont = str_replace("傻逼","**",$h_cont);  
$h_cont = str_replace("麻痹","**",$h_cont);
$h_cont = str_replace("妈比","**",$h_cont);
$h_cont = str_replace("麻逼","**",$h_cont);
$h_cont = str_replace("妈逼","**",$h_cont); 
$h_cont = str_replace("妈痹","**",$h_cont);
$h_cont = str_replace("你妈","**",$h_cont);
$h_cont = str_replace("你马","**",$h_cont);
$h_cont = str_replace("尼妈","**",$h_cont); 
$h_cont = str_replace("尼马","**",$h_cont);       
$h_cont = str_replace("全家","**",$h_cont); 
$h_cont = str_replace("日你","**",$h_cont); 
$h_cont = str_replace("比养","**",$h_cont);
$h_cont = str_replace("逼养","**",$h_cont);
$h_cont = str_replace("畜生","**",$h_cont);
$h_cont = str_replace("傻","*",$h_cont); 
$h_cont = str_replace("屌","*",$h_cont);  
$h_cont = str_replace("妈","*",$h_cont);  
$h_cont = str_replace("操","*",$h_cont); 
$h_cont = str_replace("死","*",$h_cont); 
$h_cont = str_replace("奶","*",$h_cont);          

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

    $h_content = '没听懂您的意思噢~';

    $domain = strstr($h_cont, '游戏商品如何发布');
    if($domain){$h_content = '您好，如果您想出售游戏账号、出租游戏账号、游戏道具等游戏类型商品，请在转转App底部中间点击卖闲置-发闲置，填写商品信息，然后在页面下方选择对应的商品分类及参数信息。<div data-v-62298420="" class="msg-more"><div data-v-62298420="" class="msg-more-mask"></div><span data-v-62298420="" class="msg-more-text" onclick="ck1();">查看全部</span></div>';}
    
        $domain = strstr($h_cont, '游戏服务费收费标准');
    if($domain){$h_content = '您好，转转游戏交易类型，服务费收取标准请参考下图：<div data-v-62298420="" class="msg-more"><div data-v-62298420="" class="msg-more-mask"></div><span data-v-62298420="" class="msg-more-text" onclick="ck2();">查看全部</span></div>';}
    $domain = strstr($h_cont, '如何转接人工客服');
    if($domain){$h_content = '把聊天框拉到最顶部点击联系客服即可。';}
        $domain = strstr($h_cont, '如何取消订单');
    if($domain){$h_content = '亲，很抱歉正在进行中的订单是无法取消的，可以联系人工客服处理。把聊天框拉到最顶部点击联系客服即可。';}
        $domain = strstr($h_cont, '购买的账号被找回怎么办');
    if($domain){$h_content = '可以先与卖家沟通，可以申请转转平台介入进行调解。';}
    $domain = strstr($h_cont, '在');
    if($domain){$h_content = '在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '你好');
    if($domain){$h_content = '您好，想咨询什么呢？';}
    $domain = strstr($h_cont, '您好');
    if($domain){$h_content = '您好，想咨询什么呢？';}
    $domain = strstr($h_cont, '在吗');
    if($domain){$h_content = '在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '您好在');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '你好在');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '有人吗');
    if($domain){$h_content = '您好，在的，想咨询什么呢？';}
    $domain = strstr($h_cont, '您好在吗');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
    $domain = strstr($h_cont, '你好在吗');
    if($domain){$h_content = '您好，在的亲，想咨询什么呢？';}
  
    $domain = strstr($h_cont, '哦');
    if($domain){$h_content = '恩';}
    $domain = strstr($h_cont, '是的');
    if($domain){$h_content = '恩';}
    $domain = strstr($h_cont, '好的');
    if($domain){$h_content = '恩';}
    $domain = strstr($h_cont, '哎');
    if($domain){$h_content = '怎么了？是我的服务不好吗';}
    $domain = strstr($h_cont, '唉');
    if($domain){$h_content = '怎么了？是我的服务不好吗？';}
    $domain = strstr($h_cont, '谢');
    if($domain){$h_content = '不客气哦';}
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
    if($domain){$h_content = '怎么了亲，我是小蜜呀，是我的服务不好吗？';}
    $domain = strstr($h_cont, '什么名字');
    if($domain){$h_content = '我是智能客服噢，很高兴跟您聊天。';}
    $domain = strstr($h_cont, '再见');
    if($domain){$h_content = '再见，记得想我哦！';}
    $domain = strstr($h_cont, '拜拜');
    if($domain){$h_content = '拜拜，记得想我哦！';}
    $domain = strstr($h_cont, 'bye');
    if($domain){$h_content = '再见，记得想我哦！';}
    $domain = strstr($h_cont, 'BYE');
    if($domain){$h_content = '再见，记得想我哦！';}



    if(strlen($h_cont) > 0){
        if(strlen($h_content) > 0){
            $time = date('Y-m-d H:i:s',strtotime('+1 second'));
            $sql = "insert into h_kefu (h_user,h_who,h_content,h_isread,h_actIP,h_addTime) values ('$h_user','2','$h_content','0','系统','$time')";
            $rs = $db->query($sql);
        }
    }
}

?>