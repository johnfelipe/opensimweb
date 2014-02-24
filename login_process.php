<?php
session_start();
define('OSW_IN_SYSTEM', true);
require_once('inc/osw.class.php');

// Start the main class
$osw = new osw(SYS_CURRENT_LANG);

if (isset($_POST['process'])) {
	// Try to login the user
	if ($osw->Users->login()) {
	    $osw->redirect($osw->config['login_redirect']);
	}
	else {
	    $osw->redirect('login.php');
	}
}
else {
    $osw->redirect('login.php');
}