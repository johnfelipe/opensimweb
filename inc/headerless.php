<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}

error_reporting(E_ALL);

session_start();
header('Content-Type: text/html; charset=iso-8859-1');

require_once('osw.class.php');
$osw = new osw();

$ip = $_SERVER['REMOTE_ADDR'];
$thispage = $_SERVER['PHP_SELF'];

$now = time();
$fiveago = $now - 300;

$u = $osw->Security->make_safe($_GET['u']);

if ($u) {
	$uexplode = explode(".", $u);
	$firstname = $uexplode[0];
	$lastname = $uexplode[1];
	if (!$lastname) {
		$lastname = "Resident";
	}
	$page_title = $page_title . "" . $firstname . " " . $lastname;
}

$gridname = $osw->config['GridName'];
$gridnick = $osw->config['GridNick'];
$site_address = $osw->config['SiteAddress'];
?>
