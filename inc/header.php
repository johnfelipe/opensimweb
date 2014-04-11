<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}

error_reporting(E_ALL);

session_start();
header('Content-Type: text/html; charset=iso-8859-1');

require_once('osw.class.php');
$osw = new osw();

date_default_timezone_set($osw->config['TimeZone']);

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
$site_banner = $osw->config['Banner'];
$site_logo = $osw->config['Logo'];
$gridmoney = $osw->config['GridMoney'];
$min_sales_2b_featured = $osw->config['min_sales_2b_featured'];

$twitter = $osw->config['Twitter'];
$facebook = $osw->config['Facebook'];

$user_style = $osw->user_info['style'];
$user_uuid = $osw->user_info['PrincipalID'];
$user_id = $user_uuid;
$os_user_info = $osw->grid->getosuser_by_uuid($user_uuid);
$user_first = $os_user_info['FirstName'];
$user_last = $os_user_info['LastName'];

if (!$user_uuid) {
	$user = "";
}else if ($user_uuid) {
	if (!$user_last) {
		$user = $user_first;
	}else{
		$user = $user_first." ".$user_last;
	}
}



if (!$user_style || $user_style == "site" || $osw->config['ForceSiteStyle'] == "true") {
	$style = $osw->config['Style'];
}else{
	$style = $user_style;
}

if ($site_logo) {
	$logo = "<img src='" . $site_logo . "' border='0'>";
}else{
	$logo = "<B>" . $gridname . "</B>";
}
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
<link href="<?php echo $site_address; ?>/css/<?php echo $style; ?>/bootstrap.css" rel="stylesheet">
<link href="<?php echo $site_address; ?>/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $site_address; ?>/css/normalize.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo $site_address; ?>/js/jquery.js"></script>

</head>
<body>
<style>
body {
	padding-top: 70px;
	padding-bottom: 70px;
}
</style>
<div class="container-fluid" id="content">
<?php
if ($site_banner) {
	echo "<img src='" . $site_banner . "' border='0'>";
}
if ($nomenu) {
}else if (!$nomenu) {
include ('menu.php');
}

if ($hide_sidebars) {
}else{
?>
<div class="row">
<div class="col-md-4">
  	<div class="row">
		<div class="col-md-6">
		<?php
		if ($user) {
			echo "<div class='panel'>
  			<div class='panel-heading'><B>Friends</B></div>
  			<div class='panel-body'>";
  			echo $osw->grid->getFriends($user_uuid);
  			echo "</div></div>";
  			echo "<div class='panel'>
  			<div class='panel-heading'><B>Groups</B></div>
  			<div class='panel-body'>";
  			echo $osw->grid->getGroups($user_uuid);
  			echo "</div></div>";
		}
		?>
		<div class='panel'>
  		 <div class="panel-heading"><B>Social Networks</B></div>
  			<div class="panel-body">
  				<?php
  				echo "<a href='http://www.twitter.com/@".$twitter."'>Follow us on Twitter</a>";
  				echo "<br>";
  				echo "<a href='http://www.facebook.com/".$facebook."'>Like us on Facebook</a>";
  				?>
	  		</div>
  		 </div>
		</div>
  </div>
</div>
<div class="col-md-8">
<?php
} // this is to be able to hide the side bars. most useful for full page layout
?>