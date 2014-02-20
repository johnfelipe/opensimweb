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
		if (strlen($input) <= $this->osw->config['max_password'] &&
			strlen($input) >= $this->osw->config['min_password']) {
		    return true;
		}else{
		    return false;
		}
	}

	function validate_login() {
		if ($this->osw->Session->find_session()) {
		    return true;
		}else{
		    return false;
		}
	}

	function fetch_user_info($firstname, $lastname) {
		$result = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts
		 WHERE FirstName = '$firstname' AND LastName = '$lastname'");
		$row = $this->osw->SQL->fetch_array($result);
		return $row;
	}

	function fetch_user_info_by_email($email) {
		$result = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE Email = '$email'");
		$row = $this->osw->SQL->fetch_array($result);
		return $row;
	}

	function getAuth($uuid) {
		$result = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.Auth WHERE UUID = '$uuid'");
		$row = $this->osw->SQL->fetch_array($result);
		return $row;
	}

	function generate_password_hash($psswrd) {
		$password = md5(md5($psswrd . ":" ));
		return $password;
	}

	function compare_passwords($input_password, $real_password) {
        $input_hash = $this->generate_password_hash($input_password);

		if ($input_hash == $real_password) {
		    return true;
		}
		else {
		    return false;
		}
	}

	function login()
	{
		$user = $this->osw->Security->make_safe($_GET['user']);
		$pass = $this->osw->Security->make_safe($_GET['pass']);
		$recaptcha = $this->osw->Security->make_safe($_GET['recaptcha']);
		$lastpage = $this->osw->Security->make_safe($_GET['lastpage']);
		$remember = $this->osw->Security->make_safe($_GET['remember']);


		$findme   = '@';
		$echeck = strpos($user, $findme);
		if ($echeck !== false) {
	 		$user_info = $this->fetch_user_info_by_email($user);
	 		$FirstName = $user_info['FirstName'];
	 		$LastName = $user_info['LastName'];
       	}else if ($echeck === false) {
       		$explode = explode(" ", $user);
       		$FirstName = $explode[0];
       		$LastName = $explode[1];
       		if (!$LastName) {
       			$LastName = "Resident";
       		}
	 		$user_info = $this->fetch_user_info($FirstName, $LastName);
		}

		$user_uuid = $user_info['PrincipalID'];
		$auth = $this->getAuth($user_uuid);
		$user_pass = $auth['passwordHash'];
		$user_salt = $auth['passwordSalt'];

		if ($this->compare_password($pass, $user_pass)) {

		}

	}
}
?>
