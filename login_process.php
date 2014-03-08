<?php
define('OSW_IN_SYSTEM', true);
require_once('inc/headerless.php');

if ($osw->Security->make_safe($_POST['process'])) {
	$user = $osw->Security->make_safe($_POST['username']);
	$pass = $osw->Security->make_safe($_POST['password']);
	$remember = $osw->Security->make_safe($_POST['remember']);
	$lastpage = $osw->Security->make_safe($_POST['lastpage']);
	if ($osw->Users->login($user, $pass, $remember)) {
		if (!$lastpage) {
			$lastpage = "index.php";
		}
	    $osw->redirect($lastpage);
	}else{
	    $osw->redirect('login.php?err=invalidcreds');
	}
}else{
    $osw->redirect('login.php?err=unable2process');
}
?>