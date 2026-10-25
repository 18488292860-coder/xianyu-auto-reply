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