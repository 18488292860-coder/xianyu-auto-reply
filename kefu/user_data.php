<?php
require_once './include/conn.php';
 
$h_user =  getUserIP();
$query = "select * from `h_kefu` where h_user = '{$h_user}' and h_who = 2 and h_isread = 0 order by h_addTime asc,id asc limit 1";
$result = $db->query($query);
while($rs_list = $db->fetch_array($result))
{   

    if($rs_list){
        $setRead = 'update h_kefu set h_isread = 1 where id='.$rs_list['id'];
        $db->query($setRead);
        echo json_encode($rs_list['h_content']); 
    }

}
?>