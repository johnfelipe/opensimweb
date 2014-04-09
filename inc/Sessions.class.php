<?php
if (!defined('OSW_IN_SYSTEM')) {
	exit;
}

class Sessions {

var $osw;

	function Sessions(&$osw) {
		$this->osw = &$osw;
	}

	function clear_old_sessions() {
        $time_minus_defined = time() - $this->osw->config['cookie_length'];
        $this->osw->SQL->query("DELETE FROM `{$this->osw->config['db_prefix']}sessions` WHERE time < '$time_minus_defined'");
	}

	function create_session($id, $remember) {
		$time = time();
		$sha1_time = sha1($time);

		$code = $this->osw->site->randcode('10');

		$sesscheckq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}sessions` WHERE id = '$id'");
		$sesschecker = $this->osw->SQL->num_rows($sesscheckq);
		if ($sesschecker) {
			$this->osw->SQL->query("UPDATE `{$this->osw->config['db_prefix']}sessions` SET code = '$code', time = '$time' WHERE id = '$id'");
		}else{
			$this->osw->SQL->query("INSERT INTO `{$this->osw->config['db_prefix']}sessions` (id, code, time) VALUES ('$id','$code','$time')");
		}
		
		if ($remember == "true") {
			setcookie($this->osw->config['cookie_prefix'] . 'id', $id, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['cookie_domain']);
			setcookie($this->osw->config['cookie_prefix'] . 'time', $sha1_time, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['cookie_domain']);
			setcookie($this->osw->config['cookie_prefix'] . 'code', $code, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['cookie_domain']);
		}

		$_SESSION[$this->osw->config['cookie_prefix'] . 'id'] = $id;
		$_SESSION[$this->osw->config['cookie_prefix'] . 'time'] = $sha1_time;
		$_SESSION[$this->osw->config['cookie_prefix'] . 'code'] = $code;
	}

	function fetch_session($information) {
		$uid = $information[0];
		$utime = $information[1];
		$ucode = $information[2];
        $session_infoq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}sessions` WHERE code = '$ucode'");
        $session_info = $this->osw->SQL->fetch_array($session_infoq);
        $sess_time = sha1($session_info['time']);
		if ($session_info['id']) {
			if ($sess_time == $utime) {
			    return true;
			}else{
			    return false;
			}
		}else{
		   return false;
		}
	}

	function validate_session($information) {
		if (is_array($information)) {
			$uid = $information[0];
			$utime = $information[1];
			$ucode = $information[2];

			if ($this->fetch_session($information)) {
                    $new_time = time();
                    $sha1_time = sha1($new_time);

                    if (isset($_COOKIE[$this->osw->config['cookie_prefix'] . 'time'])) {
                        setcookie($this->osw->config['cookie_prefix'] . 'time', $sha1_time, $time + $this->osw->config['cookie_length'], $this->osw->config['cookie_path'], $this->osw->config['cookie_domain']);
                    }

                    $_SESSION[$this->osw->config['cookie_prefix'] . 'time'] = $sha1_time;

                    $this->osw->SQL->query("UPDATE `{$this->osw->config['db_prefix']}sessions` SET time = '$new_time' WHERE id = '$uid'");

					$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE PrincipalID = '$uid'");
                	$r = $this->osw->SQL->fetch_array($q);
                    foreach ($r as $key => $value) {
						$this->osw->user_info[$key] = stripslashes($value);
					}

				    return true;
			}else{
				return false;
			}
		}else{
		    return false;
		}
	}

	function find_session() {
		if (isset($_COOKIE[$this->osw->config['cookie_prefix'] . 'id']) && is_numeric($_COOKIE[$this->osw->config['cookie_prefix'] . 'id'])) {
            $information = array(
                $_COOKIE[$this->osw->config['cookie_prefix'] . 'id'],
                $_COOKIE[$this->osw->config['cookie_prefix'] . 'time'],
                $_COOKIE[$this->osw->config['cookie_prefix'] . 'code']
            );
            return $this->validate_session($information);
		}else if (isset($_SESSION[$this->osw->config['cookie_prefix'] . 'id']) && is_numeric($_SESSION[$this->osw->config['cookie_prefix'] . 'id'])) {
            $information = array(
                $_SESSION[$this->osw->config['cookie_prefix'] . 'id'],
                $_SESSION[$this->osw->config['cookie_prefix'] . 'time'],
                $_SESSION[$this->osw->config['cookie_prefix'] . 'code']
            );
            return $this->validate_session($information);
		}else{
            return $this->validate_session('');
		}
	}
}
?>