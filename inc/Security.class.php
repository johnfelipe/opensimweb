<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}

class Security {

var $osw;

	function Security(&$osw) {

		if (@ini_get('register_globals') == 1 || strtoupper(@ini_get('register_globals')) == 'ON') {
		die(REGISTER_GLOBALS_ON);
		}

	$this->osw  = &$osw;

		if (get_magic_quotes_gpc()) {
			// POST Method
			foreach ($_POST as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						if (is_array($value2)) {
							foreach ($value2 as $key3 => $value3) {
								if (is_array($value3)) {
									foreach ($value3 as $key4 => $value4) {
										// Can't go any deeper
										if (is_array($value4)) {
										$_POST[$key][$key2][$key3][$key4] = $value4;
										}
										else {
										$_POST[$key][$key2][$key3][$key4] = stripslashes($value4);
										}
									}
								}
								else {
								$_POST[$key][$key2][$key3] = stripslashes($value3);
								}
							}
						}
						else {
						$_POST[$key][$key2] = stripslashes($value2);
						}
					}
				}
				else {
				$_POST[$key] = stripslashes($value);
				}
			}

			// GET Method
			foreach ($_GET as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						if (is_array($value2)) {
							foreach ($value2 as $key3 => $value3) {
								if (is_array($value3)) {
									foreach ($value3 as $key4 => $value4) {
										// Can't go any deeper
										if (is_array($value4)) {
										$_GET[$key][$key2][$key3][$key4] = $value4;
										}
										else {
										$_GET[$key][$key2][$key3][$key4] = stripslashes($value4);
										}
									}
								}
								else {
								$_GET[$key][$key2][$key3] = stripslashes($value3);
								}
							}
						}
						else {
						$_GET[$key][$key2] = stripslashes($value2);
						}
					}
				}
				else {
				$_GET[$key] = stripslashes($value);
				}
			}

			// COOKIE Method
			foreach ($_COOKIE as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						if (is_array($value2)) {
							foreach ($value2 as $key3 => $value3) {
								if (is_array($value3)) {
									foreach ($value3 as $key4 => $value4) {
										// Can't go any deeper
										if (is_array($value4)) {
										$_COOKIE[$key][$key2][$key3][$key4] = $value4;
										}
										else {
										$_COOKIE[$key][$key2][$key3][$key4] = stripslashes($value4);
										}
									}
								}
								else {
								$_COOKIE[$key][$key2][$key3] = stripslashes($value3);
								}
							}
						}
						else {
						$_COOKIE[$key][$key2] = stripslashes($value2);
						}
					}
				}
				else {
				$_COOKIE[$key] = stripslashes($value);
				}
			}
		}
	}

	function make_safe($input, $html = true) {
		if (is_array($input)) {
			foreach ($input as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						if (is_array($value2)) {
							foreach ($value2 as $key3 => $value3) {
								if (is_array($value3)) {
									foreach ($value3 as $key4 => $value4) {
										if ($html === false) {
										$input[$key][$key2][$key3][$key4] = addslashes($value4);
										}
										else {
										$input[$key][$key2][$key3][$key4] = htmlentities($value4, ENT_QUOTES);
										}
									}
								}
								else {
									if ($html === false) {
									$input[$key][$key2][$key3] = addslashes($value3);
									}
									else {
									$input[$key][$key2][$key3] = htmlentities($value3, ENT_QUOTES);
									}
								}
							}
						}
						else {
							if ($html === false) {
							$input[$key][$key2] = addslashes($value2);
							}
							else {
							$input[$key][$key2] = htmlentities($value2, ENT_QUOTES);
							}
						}
					}
				}
				else {
					if ($html === false) {
					$input[$key] = addslashes($value);
					}
					else {
					$input[$key] = htmlentities($value, ENT_QUOTES);
					}
				}
			}

		return $input;
		}
		else {
			if ($html === false) {
			return addslashes($input);
			}
			else {
			return htmlentities($input, ENT_QUOTES);
			}
		}
	}
}
?>