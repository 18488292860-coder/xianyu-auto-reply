<?php
require_once '../include/conn.php';
require_once 'header.php';

$h_user = $_GET['user'];

// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 5242880)   // 小于 1M
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        $CONFIG_UPLOAD_FOLDER = "../upload/";
        if(!is_dir($CONFIG_UPLOAD_FOLDER))
        {
            mkdir($CONFIG_UPLOAD_FOLDER);
        }

        $new_file_name = date("His") . rand(1000,9999) . "." . $extension;

        $save_file_path = $CONFIG_UPLOAD_FOLDER;

        $save_file_path .= date("Y") . '/';
        if(!is_dir($save_file_path))
        {
            mkdir($save_file_path);
        }
	
    	$save_file_path .= date("m") . '/';
        if(!is_dir($save_file_path))
        {
            mkdir($save_file_path);
        }
        
        $save_file_path .= date("d") . '/';
        if(!is_dir($save_file_path))
        {
            mkdir($save_file_path);
        }
    
		$save_file_path .= $new_file_name;

        if (file_exists($save_file_path) == 1)
        {
            echo $new_file_name . " 文件已经存在。 ";
        }
        else
        {

            move_uploaded_file($_FILES["file"]["tmp_name"],$save_file_path);

            if(strlen($save_file_path) > 0){
                $sql = "insert into h_kefu (h_user,h_who,h_content,h_isread,h_actIP,h_addTime) values ('$h_user','2','<img src=\"$save_file_path\" width=\"100%\">','0','" . getUserIP() . "','" . date('Y-m-d H:i:s') . "')";
                $rs = $db->query($sql);
                if ($rs){
                    echo $save_file_path;
                }
            }       
        }
    }
}
else
{
    echo "非法的文件格式或图片太大（需小于5M）";
}
?>