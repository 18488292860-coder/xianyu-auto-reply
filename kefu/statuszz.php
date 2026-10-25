<?php
require_once './include/conn.php';

function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_browser = Array(
    "mqqbrowser","opera mobi","juc","iuc",
    "fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","iphone","ipaq","ipod",
    "iemobile", "windows ce",
    "240×320","480×640","acer","android","anywhereyougo.com","asus","audio","blackberry","blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo","lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony","symbian","tablet","tianyu","wap","xda","xde","zte"
    );
    $is_mobile = false;
    foreach ($mobile_browser as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}
if(is_mobile()){
    $h_online = '手机';
}else{
    $h_online = '电脑';
}
 
$h_user =  getUserIP();
$h_status = $_POST['status'];
$h_city = file_get_contents("http://whois.pconline.com.cn/ip.jsp?ip={$h_user}");
$h_city = iconv("gb2312", "utf-8//IGNORE",$h_city);
$h_city = trim($h_city);
 
if(strlen($h_status) > 0){
    $rs = $db->get_one("select * from `h_kefu_status` where h_user = '{$h_user}'");
    if(!$rs){
        $sql = "insert into h_kefu_status (h_user,h_status,h_actIP,h_address,h_online,h_addTime) values ('$h_user','$h_status','" . getUserIP() . "','$h_city','$h_online','" . date('Y-m-d H:i:s') . "')";
        $db->query($sql);
    }else{
        $sql = "update `h_kefu_status` set ";
        $sql .= "h_status = {$h_status}, ";
        $sql .= "h_online = '" . $h_online . "' ";
        $sql .= "where h_user = '" . $h_user . "' ";
        $db->query($sql);
    }
}else{
    $sql = "update `h_kefu_status` set ";
    $sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "' ";
    $sql .= "where h_user = '" . $h_user . "' ";
    $db->query($sql);
}


if($_POST['login'] == 1){
    $rs2 = $db->get_one("select * from `h_kefu_status` where h_user = '{$h_user}'");
    if(!$rs2){
        $sql = "insert into h_kefu_status (h_user,h_logins,h_actIP,h_addTime) values ('$h_user','1','" . getUserIP() . "','" . date('Y-m-d H:i:s') . "')";
        $db->query($sql);
    }else{
        $sql = "update `h_kefu_status` set ";
        $sql .= "h_logins = h_logins + 1 ";
        $sql .= "where h_user = '" . $h_user . "' ";
        $db->query($sql);
    }
    

    echo json_encode(array($rs2['h_logins'],$content));
}
?>