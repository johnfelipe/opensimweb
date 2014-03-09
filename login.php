<?php
$page_title = "Login";
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');

$lastpage = $osw->Security->make_safe($_GET['lp']);
$err = $osw->Security->make_safe($_GET['err']);

if ($osw->user_info['username'] == '') {
	require_once('login_form.php');
}else{
	echo "<div class='alert alert-success'>You are already logged in</div>";
}
include ('inc/footer.php');
?>