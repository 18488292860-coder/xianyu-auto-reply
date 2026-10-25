<?php
require_once './include/conn.php';
$h_user = getUserIP();
$query = "SELECT * FROM `h_kefu` WHERE h_user = '{$h_user}' AND h_who = 1 ORDER BY h_addTime DESC, id DESC LIMIT 1";
$result = $db->query($query);
if ($result && $db->num_rows($result) > 0) {
    $rs_list = $db->fetch_array($result);
    if ($rs_list['h_isread'] == 1) {
        echo 'read';
    }
}
?>