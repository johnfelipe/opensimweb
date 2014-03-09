<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class Users
{

var $osw;
	
	function Users(&$osw)
	{
		$this->osw = &$osw;
	}

	function validate_password($input) {
		if (strlen($input) <= $this->osw->config['max_password'] && strlen($input) >= $this->osw->config['min_password']) {
		    return true;
		}else{
		    return false;
		}
	}

	function validate_login() {
		if ($this->osw->Sessions->find_session()) {
		    return true;
		}else{
		    return false;
		}
	}

	function generate_password_hash($psswrd, $code) {
		return sha1(md5($password . $code) . $code);
	}

	function compare_passwords($input_password, $real_password) {
        $input_hash = $this->generate_password_hash($input_password);

		if ($input_hash == $real_password) {
		    return true;
		}else{
		    return false;
		}
	}

	// $code = $this->osw->site->randcode('10');

	function login($user, $pass, $remember) {
		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}users` WHERE username = '$user'");
		$user_info = $this->osw->SQL->fetch_array($q);
		$user_id = $user_info['id'];
		$user_pass = $user_info['password'];

		$time = time();

		if ($this->validate_password($pass)) {
			if ($this->compare_passwords($pass, $user_pass)) {
				if ($user_info['blocked'] == 'no') {
					if ($user_info['active'] == 'yes') {
						if ($remember == 1) {
							$this->osw->Sessions->create_session($user_id, "true");
						}else{
							$this->osw->Sessions->create_session($user_id, "false");
						}
						$this->osw->SQL->query("UPDATE `{$this->osw->config['db_prefix']}users` SET online = 'yes', last_action = '$time' WHERE username = '$user'");
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function logout_user() {
	    $session_names = array('id', 'time', 'code');
	    $ses_code = $_SESSION[$this->osw->config['cookie_prefix'] . 'code'];
		if (isset($ses_code)) {
            $this->osw->SQL->query("DELETE FROM `{$this->osw->config['db_prefix']}sessions` WHERE code = '$ses_code'");
		}
        $_SESSION = array();

		if (isset($_COOKIE[session_name()])) {
		    setcookie(session_name(), '', time() - 42000, '/');
		}

		if (isset($_COOKIE[$this->osw->config['cookie_prefix'] . 'id'])) {
			foreach ($session_names as $value) {
			    setcookie($this->osw->config['cookie_prefix'] . $value, 0, time() - 3600, $this->osw->config['cookie_path'], $this->osw->config['cookie_domain']);
			}
		}

	    $this->osw->redirect($this->osw->config['logout_redirect']);
	}

	function check_user_exist($user) {
		if (!$user) {
			return false;
		}

		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}users` WHERE username = '$user'");
		$r = $this->osw->SQL->fetch_array($q);
		if ($r['id']) {
			return true;
		}else{
			return false;
		}
	}

	function id_to_username($user_id) {
        $user_id = (is_numeric($user_id) && $user_id > 0) ? $user_id : 0;
        $result = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}users` WHERE id = '$user_id'");
        $row = $this->osw->SQL->fetch_array($result);
        return $row['username'];
	}
}
?>
