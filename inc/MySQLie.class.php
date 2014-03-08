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

	function update_queries() {
	$this->total_queries = $this->total_queries + 1;
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

	function select($what, $from, $where = false, $order_by = false, $limit = false) {
	$new_what = '';
	$new_where = '';
	$new_order_by = '';
	$new_limit = '';

		if (is_array($what)) {
			if (count($what) == 1 && $what[0] == '*') {
			$new_what = '*';
			}
			else {
				foreach ($what as $key => $value) {
					if ((count($what) - 1) == $key) {
					$new_what .= "`{$value}`";
					}
					else {
					$new_what .= "`{$value}`,";
					}
				}
			}
		}
		else {
			if ($what != '') {
				switch ($what) {
					default:
					$new_what = "`{$what}`";
					break;
					case '*':
					$new_what = '*';
					break;
				}
			}
			else {
			die(SQL_SELECT_QUERY_FAILED);
			}
		}

	$query = "SELECT {$new_what} FROM `{$this->osw->config['db_prefix']}{$from}`";

		if ($where !== false) {
			if (is_array($where)) {
				if ((count($where) % 2) == 0) {
				die(SQL_SELECT_QUERY_FAILED);
				}
				else {
				$x = 0;
					foreach ($where as $key => $value) {
					$x++;
						if (count($where) == $x) {
							if (is_array($value)) {
								if (is_numeric($value[1])) {
								$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
								}
								else {
								$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
								}
							}
							else {
							die(SQL_SELECT_QUERY_FAILED);
							}
						}
						else {
							if (($x % 2) == 0 && ($value == "AND" || $value == "OR" || $value == "XOR") === true) {
							$new_where .= " {$value} ";
							}
							else {
								if (is_array($value)) {
									if (is_numeric($value[1])) {
									$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
									}
									else {
									$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
									}
								}
								else {
								die(SQL_SELECT_QUERY_FAILED);
								}
							}
						}
					}
				}
			}
			else {
				if ($where != '') {
				$new_where = $where;
				}
				else {
				die(SQL_SELECT_QUERY_FAILED);
				}
			}
		}

		if ($new_where != '') {
		$query .= " WHERE {$new_where}";
		}

		if ($order_by !== false) {
			if (is_array($order_by)) {
				if (count($order_by) == 2) {
					if ($order_by[1] == "ASC" || $order_by[1] == "DESC") {
					$new_order_by = "`{$order_by[0]}` {$order_by[1]}";
					}
					else {
					die(SQL_SELECT_QUERY_FAILED);
					}
				}
				else {
				die(SQL_SELECT_QUERY_FAILED);
				}
			}
			else {
			die(SQL_SELECT_QUERY_FAILED);
			}
		}

		if ($new_order_by != '') {
		$query .= " ORDER BY {$new_order_by}";
		}

		if ($limit !== false) {
			if (is_array($limit)) {
				if (count($limit) == 2) {
				$new_limit = 'LIMIT ' . (int)$limit[0] . ',' . (int)$limit[1];
				}
				else {
				die(SQL_SELECT_QUERY_FAILED);
				}
			}
			else {
			die(SQL_SELECT_QUERY_FAILED);
			}
		}

		if ($new_limit != '') {
		$query .= " {$new_limit}";
		}

	$this->update_queries();
	$this->last_query[] = $query;
	$result = mysqli_query($this->connection, $query) or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
	return $result;
	}

	function delete($from, $where) {
	$new_from = '';
	$new_where = '';
		if (!is_array($from) && $from != '') {
		$new_from = "`{$this->osw->config['db_prefix']}{$from}`";
		}
		else {
		die(SQL_DELETE_QUERY_FAILED);
		}

	$query = "DELETE FROM {$new_from}";

		if (is_array($where)) {
			foreach ($where as $key => $value) {
				if (is_array($value)) {
					if (is_numeric($value[1])) {
					$new_where = "`{$key}`{$value[0]}{$value[1]}";
					}
					else {
					$new_where = "`{$key}`{$value[0]}'{$value[1]}'";
					}
				}
				else {
				die(SQL_DELETE_QUERY_FAILED);
				}

			break;
			}
		}
		else {
		die(SQL_DELETE_QUERY_FAILED);
		}

	$query .= " WHERE {$new_where}";

	$this->last_query[] = $query;
	$this->update_queries();
	mysqli_query($this->connection, $query) or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
	}

	function update($table, $set, $where) {
	$new_table = '';
	$new_set = '';
	$new_where = '';
		if (!is_array($table) && $table != '') {
		$new_table = "`{$this->osw->config['db_prefix']}{$table}`";
		}
		else {
		die(SQL_UPDATE_QUERY_FAILED);
		}

	$query = "UPDATE {$new_table}";

		if (is_array($set)) {
		$x = 0;
			foreach ($set as $key => $value) {
			$x++;
				if (count($set) == $x) {
				$new_set .= "`{$key}`='{$value}'";
				}
				else {
				$new_set .= "`{$key}`='{$value}',";
				}
			}
		}
		else {
		die(SQL_UPDATE_QUERY_FAILED);
		}

	$query .= " SET {$new_set}";

		if (is_array($where)) {
			if ((count($where) % 2) == 0) {
			die(SQL_UPDATE_QUERY_FAILED);
			}
			else {
			$x = 0;
				foreach ($where as $key => $value) {
				$x++;
					if (count($where) == $x) {
						if (is_array($value)) {
							if (is_numeric($value[1])) {
							$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
							}
							else {
							$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
							}
						}
						else {
						die(SQL_UPDATE_QUERY_FAILED);
						}
					}
					else {
						if (($x % 2) == 0 && ($value == "AND" || $value == "OR" || $value == "XOR") === true) {
						$new_where .= " {$value} ";
						}
						else {
							if (is_array($value)) {
								if (is_numeric($value[1])) {
								$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
								}
								else {
								$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
								}
							}
							else {
							die(SQL_UPDATE_QUERY_FAILED);
							}
						}
					}
				}
			}
		}
		else {
			if ($where != '') {
			$new_where = $where;
			}
			else {
			die(SQL_UPDATE_QUERY_FAILED);
			}
		}

	$query .= " WHERE {$new_where}";

	$this->last_query[] = $query;
	$this->update_queries();
	mysqli_query($this->connection, $query) or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
	}

	function insert($table, $columns, $values) {
	$new_table = '';
	$new_columns = '';
	$new_values = '';
	$column_count = count($columns);
	$value_count = count($values);

		if ($table != '') {
		$new_table = "`{$this->osw->config['db_prefix']}{$table}`";
		}
		else {
		die(SQL_INSERT_QUERY_FAILED);
		}

	$query = "INSERT INTO {$new_table}";

		if ($column_count == $value_count) {
			if (is_array($columns)) {
			$x = 0;
				foreach ($columns as $value) {
				$x++;
					if ($x == $column_count) {
					$new_columns .= "`{$value}`";
					}
					else {
					$new_columns .= "`{$value}`,";
					}
				}
			}
			else {
			die(SQL_INSERT_QUERY_FAILED);
			}

		$query .= " ({$new_columns})";

			if (is_array($values)) {
			$x = 0;
				foreach ($values as $value) {
				$x++;
					if ($x == $value_count) {
						if (is_numeric($value)) {
						$new_values .= "{$value}";
						}
						else {
						$new_values .= "'{$value}'";
						}
					}
					else {
						if (is_numeric($value)) {
						$new_values .= "{$value},";
						}
						else {
						$new_values .= "'{$value}',";
						}
					}
				}
			}
			else {
			die(SQL_INSERT_QUERY_FAILED);
			}

		$query .= " VALUES({$new_values})";

		$this->last_query[] = $query;
		$this->update_queries();
		mysqli_query($this->connection, $query) or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
		}
		else {
		die(SQL_INSERT_QUERY_FAILED);
		}
	}

	function alter($table, $action, $column, $data_type = false, $null = false) {
	$new_table = '';
	$new_action = '';
	$new_column = '';
	$new_data_type = '';
	$new_null = '';

		// Check the table
		if ($table != '') {
		$new_table = "{$this->osw->config['db_prefix']}{$table}";
		}
		else {
		die(SQL_ALTER_QUERY_FAILED);
		}

	$query = "ALTER TABLE {$new_table}";

		switch (strtolower($action)) {
			case 'drop':
			$new_action = 'DROP COLUMN';
			break;
			case 'add':
			$new_action = 'ADD';
			break;
			default:
			die(SQL_ALTER_QUERY_FAILED);
			break;
		}

	$query .= " {$new_action}";

		if ($column != '') {
		$new_column = "`{$column}`";
		}
		else {
		die(SQL_ALTER_QUERY_FAILED);
		}

	$query .= " {$new_column}";

		if (strtolower($action) == 'add') {
			if ($data_type !== false) {
				if ($null) {
				$query .= " {$data_type} NULL";
				}
				else {
				$query .= " {$data_type} NOT NULL";
				}
			}
			else {
			die(SQL_ALTER_QUERY_FAILED);
			}
		}

	$this->last_query[] = $query;
	$this->update_queries();
	mysqli_query($this->connection, $query) or die(mysqli_errno($this->connection) . ': ' . mysqli_error($this->connection));
	}

	function query($query) {
		if ($query != '') {
			$this->update_queries();
			$this->last_query[] = $query;
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
