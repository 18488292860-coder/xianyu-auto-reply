<?php
$LoginEdUserName = $_COOKIE['h_userName'];
$LoginEdPassWord = $_COOKIE['h_passWord'];

$rs88 = $db->get_one("select * from `h_kefu_config` where h_admin = '{$LoginEdUserName}' and h_pass = '{$LoginEdPassWord}' LIMIT 1");
if (!$rs88) {

    HintAndTurnTopFrame("欢迎使用少情后台", "/");
    exit();
}

$rs99 = $db->get_one("select * from `h_kefu_login` where h_user = '{$LoginEdUserName}' and h_ip = '" . getUserIP() . "'");
if (!$rs99) {

    HintAndTurnTopFrame("您未登录成功，请您重新登录！", "/");
    exit();

}
?>