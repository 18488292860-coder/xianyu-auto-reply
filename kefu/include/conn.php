<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR | E_PARSE);	
ini_set('display_errors',0);
set_time_limit(0);

//版本相关设置，防不同版本而出错
PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
session_cache_limiter('private, must-revalidate'); 
ini_set('session.auto_start',0); 
if(PHP_VERSION < '4.1.0') {
	$_GET         = &$HTTP_GET_VARS;
	$_POST        = &$HTTP_POST_VARS;
	$_COOKIE      = &$HTTP_COOKIE_VARS;
	$_SERVER      = &$HTTP_SERVER_VARS;
	$_ENV         = &$HTTP_ENV_VARS;
	$_FILES       = &$HTTP_POST_FILES;
}

//建立数据库连接
// $db_settings = parse_ini_file('dbConfig.php');
require_once 'dbConfig.php';
extract($db_settings);
require_once 'mysql.php';
$db =dbmysql::getInstance($con_db_host,$con_db_id,$con_db_pass,$con_db_name);


//系统通用函数库 及 防注入等非法操作
define('ROOTPATH', substr(dirname(__FILE__), 0, -7));
define('MAGIC_QUOTES_GPC', false);
isset($_REQUEST['GLOBALS']) && exit('Access Error');

require_once 'function_utility.php';
require_once 'function_db.php';

foreach(array('_COOKIE', '_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_key[0] != '_' && $$_key = daddslashes($_value);
	}
}

