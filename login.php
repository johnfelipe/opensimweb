<?php
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');

if ($osw->user_info['username'] == '') {
	require_once('login_form.php');
}else{
	echo "You are already logged in";
}
?>