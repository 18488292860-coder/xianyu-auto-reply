<?php
require_once '../include/conn.php';
require_once 'header.php';

$h_user = $_POST['user'];
$h_cont = $_POST['cont'];

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
$h_cont = str_replace("select", "", $h_cont);
$h_cont = str_replace("from", "", $h_cont);
$h_cont = str_replace("delete","",$h_cont); 
$h_cont = str_replace("update","",$h_cont); 
$h_cont = str_replace("insert","",$h_cont);
$h_cont = str_replace("<iframe", "", $h_cont);
$h_cont = str_replace("</iframe", "", $h_cont);
$h_cont = str_replace("<script", "", $h_cont);
$h_cont = str_replace("</script", "", $h_cont);
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

if(strlen($h_cont) > 0){
    $sql = "insert into h_kefu (h_user,h_who,h_content,h_isread,h_actIP,h_addTime) values ('$h_user','2','$h_cont','0','" . getUserIP() . "','" . date('Y-m-d H:i:s') . "')";
    $rs = $db->query($sql);
    if ($rs){
        echo 'ok';
    }
}
?>