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

	function generate_password_salt() {
		$randomuuid = $this->osw->grid->newuuid();
		$strrep = str_replace("-", "", $randomuuid);
		return md5($strrep);
	}

	function generate_password_hash($psswrd, $code) {
		return md5(md5($psswrd) . ":" . $code)
	}

	function compare_passwords($input_password, $real_password, $code) {
        $input_hash = $this->generate_password_hash($input_password, $code);

		if ($input_hash == $real_password) {
		    return true;
		}else{
		    return false;
		}
	}

	// $code = $this->osw->site->randcode('10');

	function login($user, $pass, $remember) {
		$explode = explode(" ", $user);
		$firstname = $explode[0];
		$lastname = $explode[1];
		if (!$lastname) {
			$lastname = "Resident";
		}

		$q1 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE FirstName = '$firstname' AND LastName = '$lastname'");
		$r1 = $this->osw->SQL->fetch_array($q1);
		$userUUID = $r1['PrincipalID'];
		$userLevel = $r1['UserLevel'];

		$q2 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.Auth WHERE UUID = '$userUUID'");
		$r2 = $this->osw->SQL->fetch_array($q2);
		$user_pass = $r2['passwordHash'];
		$user_code = $r2['passwordSalt'];

		$q3 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.GridUser WHERE UserID = '$userUUID'");
		$user_info = $this->osw->SQL->fetch_array($q3);
		$user_info['level'] = $userLevel;
		$user_info['username'] = $firstname." ".$lastname;

		$time = time();

		if ($this->validate_password($pass)) {
			if ($this->compare_passwords($pass, $user_pass, $user_code)) {
				if ($remember == 1) {
					$this->osw->Sessions->create_session($userUUID, "true");
				}else{
					$this->osw->Sessions->create_session($userUUID, "false");
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function logout_user() {
	    $session_names = array('id', 'time', 'code');
	    $ses_uuid = $_SESSION[$this->osw->config['cookie_prefix'] . 'id'];
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

	function check_user_exist($first, $last) {
		if (!$first) {
			return false;
		}
		if (!$last) {
			$last = "Resident";
		}
		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE FirstName = '$first' AND LastName = '$last'");
		$r = $this->osw->SQL->fetch_array($q);
		if ($r['PrincipalID']) {
			return true;
		}else{
			return false;
		}
	}

	function uuid_to_username($user_uuid) {
        $user_uuid = (is_numeric($user_uuid) && $user_uuid > 0) ? $user_uuid : 0;
        $result = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE PrincipalID = '$user_uuid'");
        $row = $this->osw->SQL->fetch_array($result);
        $first = $row['FirstName'];
        $last = $row['LastName'];
        $return = $first." ".$last;
        return $return;
	}

	function register_user() {
		$first = $_POST['firstname'];
		$last = $_POST['lastname'];
		$pass = $_POST['password'];
		$cpass = $_POST['password_c'];
		$email = $_POST['email'];
		require_once('recaptchalib.php');
		$privatekey = $this->osw->config['ReCaptcha_Private_Key'];
		$resp = recaptcha_check_answer ($privatekey,
                            $_SERVER["REMOTE_ADDR"],
                            $_POST["recaptcha_challenge_field"],
                            $_POST["recaptcha_response_field"]);
		if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			return false;
			die ("The reCAPTCHA wasn't entered correctly. Go back and try it again. (reCAPTCHA said: " . $resp->error . ")");
		}else{
			// Your code here to handle a successful verification
			if ($this->check_user_exist($first, $last)) {
				// If avatar name already exist in the database we fail the registration. Dont need two Asshat Jockstrap's running around.
				return false;
			}else{
				if ($pass == $cpass) { // this makes sure that both password feilds are the same
					if ($this->validate_password($pass)) { // this makes sure the password entered is a valid length.
						// now we can start processing the registration.
						$randomuuid = $this->osw->grid->newuuid();
						$salt = $this->generate_password_salt();
						$hashedpass = $this->generate_password_hash($pass, $salt);
						$time = time();
						$pos = $this->osw->config['Default_Pos'];
						$simname = $this->osw->config['Default_Sim'];
						if ($simname) {
							$simnametouuidq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.Regions WHERE regionName = '$simname'");
							$simnametouuidr = $this->osw->SQL->fetch_array($simnametouuidq);
							$simuuid = $simnametouuidr['uuid'];
						}else{
							$simuuid = "00000000-0000-0000-0000-000000000000";
						}
						$insert1 = $this->osw->SQL->query("INSERT INTO `{$this->osw->config['robust_db']}`.UserAccounts (PrincipalID, FirstName, LastName, Email, Created, UserLevel) VALUES ('$randomuuid', '$first', '$last', '$email', '$time', '0')");
						$insert2 = $this->osw->SQL->query("INSERT INTO `{$this->osw->config['robust_db']}`.Auth (UUID, passwordHash, passwordSalt) VALUES ('$randomuuid', '$hashedpass', '$salt')");
						$insert3 = $this->osw->SQL->query("INSERT INTO `{$this->osw->config['robust_db']}`.GridUser (UserID, HomeRegionID, HomePosition, LastRegionID, LastPosition) VALUES ('$randomuuid', '$simuuid', '$pos', '$simuuid', '$pos')");
						if ($insert1 && $insert2 && $insert3) {
							if ($_POST['avi'] == "m" && $this->osw->config['Default_Male'] != "") {
								$avi = $this->osw->config['Default_Male'];
							}else if ($_POST['avi'] == "f" && $this->osw->config['Default_Female'] != "") {
								$avi = $this->osw->config['Default_Female'];
							}else if ($this->osw->config['Default_Female'] == "" && $this->osw->config['Default_Male'] == ""){
								$avi = "";
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
		}
	}
}
?>
