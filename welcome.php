<?php
$page_title = "Welcome";
define('OSW_IN_SYSTEM', true);
require_once('inc/headerless.php');

$dir = "bgimg"; // directory aka folder where your background images aka screenshots will go

$loginuri = "http://login.greatcanadiangrid.ca:8002/"; // This is the address found in Robust.ini for Grid, Opensim.ini for Standalone.
$ip2robust = "66.23.236.230"; // IP or domain to the robust server. This is used to see if Robust.exe (or OpenSim.exe for Standalone) is online.
$port2robust = "8002"; // 8002 for Grid Robust.exe, 9000 for Standalone OpenSim.exe

if ($fp = fsockopen($ip2robust, $port2robust, $errno, $errstr, 1)) {
	$online = TRUE;
}else{
	$online = FALSE;
}
fclose($fp);

if ($online == TRUE) {
	$onoff = "Online";
	$onoffcolour = "#00EE00";
}else if ($online == FALSE) {
	$onoff = "Offline";
	$onoffcolour = "#FA1D2F";
}

$onlineq = $osw->SQL->query("SELECT * FROM griduser WHERE Online = 'TRUE'");
$online = $osw->SQL->num_rows($onlineq);

$totalq = $osw->SQL->query("SELECT * FROM useraccounts");
$totalc = $osw->SQL->num_rows($totalq);

$monthago = $now - 2592000;
$latestq = $osw->SQL->query("SELECT * FROM griduser WHERE Login > '$monthago'");
$latestc = $osw->SQL->num_rows($latestq);

$regionq = $osw->SQL->query("SELECT * FROM regions");
$regionc = $osw->SQL->num_rows($regionq);

$destecho = "";
$destq = $osw->SQL->query("SELECT * FROM $db_osmod.popularplaces ORDER BY `name` ASC LIMIT 0,10");
while ($destr = $osw->SQL->fetch_array($destq)) {
	$destname = $destr['name'];
	$dname = rawurlencode($destname);
	$destecho .= "<tr><td align='center'><a href='secondlife://$dname' target='_self' style='text-decoration: none;'><h4>$destname</h4></a></td></tr>";
}

if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while (false !== ($file = readdir($dh)))
		{
			if ($file == '.' || $file == '..') { 
			}else{
			$jbgimg .= "'" . $file . "', ";
			$cbgimg = $file;
			}
		}
	closedir($dh);
	}
}

if ($logoimg) {
	$logo = "<img src='$logoimg' border='0'>";
}else{
	$logo = "<h1>" . $grid_name . "</h1>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title id='titlebar'>Welcome to <?php echo "$grid_name"; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- You can change this to your own bootstrap file -->
<link href="http://www.littletech.net/css/bootstrap.css" rel="stylesheet">

<script>
var newBg = [<?php echo $jbgimg; ?>];
var path="<?php echo $dir; ?>/";
var i = 0;
var rotateBg = setInterval(function(){
    $('body').css('backgroundImage' ,  "url('" +path+newBg[i]+ "')");
    i++;
}, 5000);
</script>

<style>
body
{
background-image: url('<?php echo $dir . "/" . $cbgimg; ?>');
background-repeat: no-repeat;
background-size: cover;
}
.table
{
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
overflow:hidden;
border-radius: 10px;
-pie-background: linear-gradient(#ece9d8, #E5ECD8);   
box-shadow: #666 0px 2px 3px;
behavior: url(Include/PIE.htc);
overflow: hidden;
}
</style>

</head>
<body>
	<?php echo $logo; ?>
	<div class="col-xs-4 col-md-2">
		<table class="table table-striped table-bordered table-condensed">
			<tbody>
				<?php
					echo $destecho;
				?>
			</tbody>
		</table>
		<table class='table'>
			<tr>
				<td>
					LoginURI <a href='<?php echo $loginuri; ?>'><?php echo $loginuri; ?></a><br>
					<a href='http://opensimulator.org/' target='_blank'><img src='http://www.littletech.net/img/Os_b_150x20_b.png' border='0'></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-xs-8 col-md-8">
	</div>
	<div class="col-xs-4 col-md-2">
		<table class="table table-striped table-bordered table-condensed">
			<tbody>
				<tr>
					<td>
						Users in world: <?php echo $online; ?> 
					</td>
				</tr>
				<tr>
					<td>
						Active (last 30 days): <?php echo $latestc; ?>
					</td>
				</tr>
				<tr>
					<td>
						Total Regions: <?php echo $regionc; ?>
					</td>
				</tr>
				<tr>
					<td>
						Total Users: <?php echo $totalc; ?>
					</td>
				</tr>
				<tr>
					<td>
						<B><?php echo "<font color='" . $onoffcolour . "'>Grid is " . $onoff . "</font>"; ?></B>
					</td>
				</tr>
			</tbody>
		</table>
		<?php if ($twittername) { ?>
			<a class="twitter-timeline" href="https://twitter.com/<?php echo $twittername; ?>" data-widget-id="301598975952293888">
				Tweets by @<?php echo $twittername; ?>
			</a>
			<script>
				function(d,s,id) {
				var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
				if(!d.getElementById(id)){js=d.createElement(s);
				js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			</script>
		<?php } ?>
	</div>

<script type="text/JavaScript">
$(document).ready(function(){
	$('.dropdown-toggle').dropdown();
	$('#tooltip').tooltip('show');
	$(".accordion").collapse('toggle');
	$('.collapse').collapse('toggle');
	$('#modal').modal('toggle');
	$('.carousel').carousel({interval: 10000});
	$('#tabs a:first').tab('show');
});
</script>

<script src="./js/jquery.js"></script>
<script src="./js/bootstrap.js"></script>
</body>
</html>
