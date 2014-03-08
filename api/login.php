<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

$user = $osw->Security->make_safe($_POST['username']);
$pass = $osw->Security->make_safe($_POST['password']);

if ($osw->Users->login($user, $pass, "false")) {
	echo "true";
}else{
	echo "false";
}
?>