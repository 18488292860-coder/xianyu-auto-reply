<?php
require_once '../include/conn.php';
require_once 'header.php';
require_once 'pager.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录记录</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="login" style="background: url(/img/hs.png) no-repeat 0 0/100% 100%;">
        <div class="main">
            <div class="title">
<body>
    <div class="table-item">
        <table>
            <tr>
              <td height="25" colspan="4">登录记录</td>
            </tr>
            <tr> 
              <td>登录账号</td>
              <td>登录IP</td>
              <td>登录时间</td>
              <td>相关操作</td>
            </tr>
            <?php
			$total_count = $db->counter('h_kefu_login', 'id');
			$list_num = 30;
			$page = (int)$page;
			if($page_input){$page=$page_input;}
			$rowset = new Pager($total_count,$list_num,$page);
			$from_record = $rowset->_offset();
			$query = "select * from `h_kefu_login` order by h_addTime desc,id desc limit $from_record, $list_num";
			$result = $db->query($query);
			while($list = $db->fetch_array($result))
			{
				$rs_list[]=$list;
			}

			$page_list = $rowset->link(GetUrl(2) . "?page=");
			
			if(count($rs_list) > 0)
			{   
				foreach ($rs_list as $key=>$val)
				{	   
                   
            ?>     
                <tr>
                <td>后台管理员</td>
                <td><?php echo $val['h_ip']; ?></td>
                <td><?php echo $val['h_addTime']; ?></td>
                <td><a style="cursor:pointer;" onClick="javascript:hintandturn('确定要删除吗？数据将不可恢复！','?clause=delinfo&id=<?php echo $val['id']; ?>',true);">删除</a></td>
                </tr>
            <?php
				}
			}	
		    ?>
        </table>
        <?php if(count($rs_list) > 0) echo "<div class=\"page\" style=\"margin-top:10px;\">{$page_list}</div>";?>
    </div>
    <?php  
    if($clause == 'delinfo'){delinfo();}

    function delinfo()
    {
	global $db,$id;

	$query = "delete from `h_kefu_login` where id = $id";
	$db->query($query);
	
    echo("<script type='text/javascript'> location.href='?'; </script>");
    exit;
    }
    ?>
    <script>
        function hintandturn(str,url,torf)
        {
            if(confirm(str) && torf){
                window.location=url;
                return true;
            }else{
                return false;
            }
        }
    </script>
</body>
</html>