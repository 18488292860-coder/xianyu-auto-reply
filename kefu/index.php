<?php 
Define('PM_CALL',true);
Define('INC_CALL',true);
include dirname(__FILE__).('/include/dbConfig.php');
header('Location:'. htmlspecialchars_decode('../sq/login.php').'');

?>