<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}

error_reporting(E_ALL ^ E_NOTICE);

session_start();
header('Content-Type: text/html; charset=iso-8859-1');

require_once('osw.class.php');
$osw = new osw();

$ip = $_SERVER['REMOTE_ADDR'];
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
$ip2webassets = $osw->config['webassetURI'];
$site_address = $osw->config['SiteAddress'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title id='titlebar'><?php echo $gridname . " - " . $page_title; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- You can change this to your own bootstrap file -->
<link href="<?php echo $site_address; ?>/css/bootstrap.css" rel="stylesheet">

</head>
<body>
<?php
if ($nomenu == True) {
}else{
include ('menu.php');
}
?>
