<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class SQL
{

var $osw;
	
	function SQL(&$osw)
	{
		$this->osw = &$osw;

		require_once('db_info.php');
		$this->db_type = $db_type;
		$this->osw->config['db_prefix'] = $db_prefix;

		//if (!define('SYSTEM_INSTALLED')) {
			//die(SYSTEM_NOT_INSTALLED);
		//}

		require_once('MySQLie.class.php');

		switch($db_type) {
			default:
			case 'MySQLi':
			$this->current_layer = new MySQLie($db_host, 
				$db_user, 
				$db_pass, 
				$db_name, 
				$this->osw, 
				$db_port);
			break;
		}

	}

	function result($q,$i,$d)
	{
	return $this->current_layer->result($q,$i,$d);
	}

	function update_queries() {
	$this->current_layer->update_queries();
	}

	function affected_rows() {
	return $this->current_layer->affected_rows();
	}

	function fetch_row($result) {
	return $this->current_layer->fetch_row($result);
	}

	function fetch_assoc($result) {
	return $this->current_layer->fetch_assoc($result);
	}

	function fetch_array($result) {
	return $this->current_layer->fetch_array($result);
	}

	function free_result($result) {
	return $this->current_layer->free_result($result);
	}

	function get_client_info() {
	return $this->current_layer->get_client_info();
	}

	function insert_id() {
	return $this->current_layer->insert_id();
	}

	function num_fields($result) {
	return $this->current_layer->num_fields($result);
	}

	function num_rows($result) {
	return $this->current_layer->num_rows($result);
	}

	function transaction($status = 'BEGIN') {
	return $this->current_layer->transaction($status);
	}

	function select($what, $from, $where = false, $order_by = false, $limit = false) {
	return $this->current_layer->select($what, $from, $where, $order_by, $limit);
	}

	function delete($from, $where) {
	return $this->current_layer->delete($from, $where);
	}

	function update($table, $set, $where) {
	return $this->current_layer->update($table, $set, $where);
	}

	function insert($table, $columns, $values) {
	return $this->current_layer->insert($table, $columns, $values);
	}

	function alter($table, $action, $column, $data_type = false, $null = false) {
	return $this->current_layer->alter($table, $action, $column, $data_type, $null);
	}

	function query($query) {
	return $this->current_layer->query($query);
	}

	function close() {
	return $this->current_layer->close();
	}
}
?>
