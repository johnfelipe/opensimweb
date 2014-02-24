<?php
if (!defined('OSW_IN_SYSTEM')) {
	exit;
}

class Sessions {

var $osw;

	function Sessions(&$osw) {
		$this->osw = &$osw;
	}

	function create_session($id, $remember = false) {
		$time = time();

		$code = $this->site->randcode('5');

		$this->osw->SQL->query("INSERT INTO `{$this->osw->config['db_prefix']}sessions` (id, code, time) VALUES ('$id', '$code', '$time')");
		$this->osw->SQL->query("UPDATE `{$this->osw->config['db_prefix']}users` SET code = '$code' WHERE id = '$id'");

		if ($remember == true) {
			setcookie($this->osw->config['cookie_prefix'] . 'id', $id, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['SiteAddress']);
			setcookie($this->osw->config['cookie_prefix'] . 'time', $time, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['SiteAddress']);
			setcookie($this->osw->config['cookie_prefix'] . 'code', $code, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['SiteAddress']);
		}

		$_SESSION[$this->osw->config['cookie_prefix'] . 'id'] = $id;
		$_SESSION[$this->osw->config['cookie_prefix'] . 'time'] = $time;
		$_SESSION[$this->osw->config['cookie_prefix'] . 'code'] = $code;
	}
}

?>