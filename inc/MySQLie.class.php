<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class MySQLie {

var $osw;

	function MySQLie($server_name, $username, $password, $name, &$osw, $port = false) {
	$this->osw = &$osw;
    $this->server_name = $server_name;
    $this->username = $username;
    $this->password = $password;
    $this->name = $name;
    $this->port = $port;
	$this->connection = ($this->port !== false) ? mysqli_connect($this->server_name, $this->username, $this->password, $this->name, $this->port) : mysqli_connect($this->server_name, $this->username, $this->password, $this->name);

		if (mysqli_connect_errno()) {
		die(mysqli_connect_error());
		}
	}

	function result($q,$i,$d) {
	return mysql_result($q,$i,$d);
	}

	function affected_rows() {
	return mysqli_affected_rows($this->connection);
	}

	function fetch_row($result) {
	return mysqli_fetch_row($result);	
	}

	function fetch_assoc($result) {
	return mysqli_fetch_assoc($result);
	}

	function fetch_array($result) {
	return mysqli_fetch_array($result, MYSQLI_BOTH);
	}

	function free_result($result) {
		if ($this->last_query == $result) {
		$this->last_query = '';
		}

	return mysqli_free_result($result);
	}

	function get_client_info() {
	return mysqli_get_client_info();
	}

	function insert_id() {
	return mysqli_insert_id($this->connection);
	}

	function num_fields($result) {
	return mysqli_num_fields($result);
	}

	function num_rows($result) {
	return mysqli_num_rows($result);
	}

	function transaction($status = 'BEGIN') {
		switch (strtoupper($status)) {
			default:
			return true;
			break;
			case 'START':
			case 'START TRANSACTION':
			case 'BEGIN':
			return mysqli_query($this->connection, 'START TRANSACTION');
			break;
			case 'COMMIT':
			return mysqli_query($this->connection, 'COMMIT');
			break;
			case 'ROLLBACK':
			return mysqli_query($this->connection, 'ROLLBACK');
			break;
		}
	}

	function query($query) {
		if ($query != '') {
			$result = mysqli_query($this->connection, $query) or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
			return $result;
		}else{
			$result = mysqli_query($this->connection, '') or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
			return $result;
		}
	}

	function close() {
	return mysqli_close($this->connection);
	}
}
?>
