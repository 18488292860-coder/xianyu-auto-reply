<?php
# 数据库操作类（mysqli 兼容实现，适配 PHP 8）
class dbmysql {
	var $querynum = 0;
	var $link;

	private static $_instance = null;

	static public function getInstance($con_db_host, $con_db_id, $con_db_pass, $con_db_name) {
		if (is_null(self::$_instance) || isset(self::$_instance)) {
			self::$_instance = new self($con_db_host, $con_db_id, $con_db_pass, $con_db_name);
		}
		return self::$_instance;
	}

	function __construct($con_db_host, $con_db_id, $con_db_pass, $con_db_name = '', $db_charset = 'utf8mb4', $pconnect = 0) {
		mysqli_report(MYSQLI_REPORT_OFF);

		$host = $con_db_host;
		if ($pconnect) {
			$host = 'p:' . $host;
		}
		$this->link = @mysqli_connect($host, $con_db_id, $con_db_pass);
		if (!$this->link) {
			$this->halt('Can not connect to MySQL server');
		}

		if ($con_db_name) {
			@mysqli_select_db($this->link, $con_db_name);
		}

		if ($db_charset != 'latin1') {
			@mysqli_set_charset($this->link, $db_charset);
		}

		@mysqli_query($this->link, "SET sql_mode=''");
	}

	function move_first($query) {
		@mysqli_data_seek($query, 0);
	}

	function select_db($dbname) {
		return mysqli_select_db($this->link, $dbname);
	}

	function fetch_array($query, $result_type = MYSQLI_ASSOC) {
		if (!$query) {
			return "";
		}
		return mysqli_fetch_array($query, $result_type);
	}

	function update($table, $bind = array(), $where = '') {
		$set = array();
		foreach ($bind as $col => $val) {
			$set[] = "`$col` = '$val'";
		}
		$sql = "UPDATE " . $table . ' SET ' . implode(',', $set) . (($where) ? " WHERE $where" : '');
		$this->query($sql);
	}

	function insert($table, $bind = array()) {
		$set = array();
		foreach ($bind as $col => $val) {
			$set[] = "`$col`";
			$vals[] = "'$val'";
		}
		$sql = "INSERT INTO " . $table . ' (' . implode(', ', $set) . ') ' . 'VALUES (' . implode(', ', $vals) . ')';
		$this->query($sql);
		return $this->insert_id();
	}

	/**
	* 执行sql语句，只得到一条记录
	*/
	function get_one($sql, $type = '') {
		$query = $this->query($sql, $type);
		$rs = $this->fetch_array($query);
		return $rs;
	}

	/**
	* 执行sql语句，得到所有记录
	*/
	function get_all($sql, $type = '') {
		$query = $this->query($sql, $type);
		if (!$query) {
			return false;
		}
		$result = array();
		while ($rs = $this->fetch_array($query)) {
			$result[] = $rs;
		}
		return $result;
	}

	function query($sql, $type = '') {
		if ($type == 'UNBUFFERED') {
			$query = @mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
		} else {
			$query = @mysqli_query($this->link, $sql);
		}
		$this->querynum++;
		return $query;
	}

	function counter($table_name, $where_str = "", $field_name = "*") {
		$where_str = trim($where_str);
		if (strtolower(substr($where_str, 0, 5)) != 'where' && $where_str) {
			$where_str = "WHERE " . $where_str;
		}
		$query = " SELECT COUNT($field_name) FROM $table_name $where_str ";
		$result = $this->query($query);
		$fetch_row = mysqli_fetch_row($result);
		return $fetch_row[0];
	}

	function affected_rows() {
		return mysqli_affected_rows($this->link);
	}

	function list_fields($con_db_name, $table) {
		$tables = array();
		$result = $this->query("SHOW COLUMNS FROM `" . $table . "` FROM `" . $con_db_name . "`");
		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}
		return $tables;
	}

	function error() {
		return (($this->link) ? mysqli_error($this->link) : '');
	}

	function errno() {
		return intval(($this->link) ? mysqli_errno($this->link) : 0);
	}

	function result($query, $row, $field = 0) {
		if (!($query instanceof mysqli_result)) {
			return false;
		}
		@mysqli_data_seek($query, $row);
		$row_data = mysqli_fetch_row($query);
		return isset($row_data[$field]) ? $row_data[$field] : false;
	}

	function num_rows($query) {
		return mysqli_num_rows($query);
	}

	function num_fields($query) {
		return mysqli_num_fields($query);
	}

	function insert_id() {
		return mysqli_insert_id($this->link);
	}

	function lastInsertId() {
		return $this->insert_id();
	}

	function fetch_row($query) {
		return mysqli_fetch_row($query);
	}

	function fetch_fields($query) {
		return mysqli_fetch_field($query);
	}

	function version() {
		return mysqli_get_server_info($this->link);
	}

	function close() {
		return mysqli_close($this->link);
	}

	function halt($message = '', $sql = '') {
		$sqlerror = $this->error();
		$sqlerrno = $this->errno();
		echo "<html><head><title>CSSInfo</title><style type='text/css'>P,BODY{FONT-FAMILY:tahoma,arial,sans-serif;FONT-SIZE:10px;}A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}TD { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 16pt; COLOR: #000000;}</style><body>\n\n";
		echo "<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>";
		echo "<br><br><b>The URL Is</b>:<br>http://" . htmlspecialchars($_SERVER['HTTP_HOST'] ?? '', ENT_QUOTES) . htmlspecialchars($_SERVER['REQUEST_URI'] ?? '', ENT_QUOTES);
		echo "<br><br><b>MySQL Server Error</b>:<br>" . htmlspecialchars($sqlerror, ENT_QUOTES) . "  ( " . intval($sqlerrno) . " )";
		echo "</td></tr></table>";
		exit;
	}
}
