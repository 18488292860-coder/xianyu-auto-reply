
<!DOCTYPE HTML>
<html>
  <head>
    <title>载入总配置</title>
    </head>
  <body>
<?php
$myfile=fopen("pay.txt","r") or die("文件无法载入，可能是出现了问题，请联系陈瑞泽！");
echo "<script>window.location='".fread($myfile,filesize("pay.txt"))."';</script>";
fclose($myfile);
?>
  </body>
  </html>