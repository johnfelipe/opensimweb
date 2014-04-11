<?php
$page_title = "Welcome";
$nomenu = true;
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');

$dir = "bgimg"; // directory aka folder where your background images aka screenshots will go

if ($osw->grid->gridonline()) {
	$onoff = "Online";
	$onoffcolour = "#00EE00";
}else{
	$onoff = "Offline";
	$onoffcolour = "#FA1D2F";
}

$onlineq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Online = 'TRUE'");
$online = $osw->SQL->num_rows($onlineq);

$totalq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.UserAccounts");
$totalc = $osw->SQL->num_rows($totalq);

$monthago = $now - 2592000;
$latestq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Login > '$monthago'");
$latestc = $osw->SQL->num_rows($latestq);

$regionq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.regions");
$regionc = $osw->SQL->num_rows($regionq);

$destecho = "";
$destq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.popularplaces ORDER BY `name` ASC LIMIT 0,10");
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
	$logo = "<img src='" . $osw->config['Logo'] . "' border='0'>";
}else{
	$logo = "<h1>" . $osw->config['GridName'] . "</h1>";
}
?>
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
	<div class="col-xs-4 col-md-2">
		<div class="well">
			<?php echo $logo; ?>
		</div>
		<table class="table table-striped table-bordered table-condensed well">
			<tbody>
				<tr>
					<td>
						<?php echo $desc; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<table class='table well'>
			<tr>
				<td>
					LoginURI <a href='<?php echo $osw->config['loginURI']; ?>'><?php echo $osw->config['loginURI']; ?></a><br>
					<a href='http://opensimulator.org/' target='_blank'><img src='<?php echo $site_address; ?>/img/Os_b_150x20_b.png' border='0'></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-xs-8 col-md-8">
	</div>
	<div class="col-xs-4 col-md-2">
		<table class="table table-striped table-bordered table-condensed well">
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
		<?php
		echo $osw->site->getNews('0', 'well');
		if ($osw->config['Twitter']) {
		?>
			<a class="twitter-timeline" href="https://twitter.com/<?php echo $osw->config['Twitter']; ?>" data-widget-id="301598975952293888">Tweets by @<?php echo $osw->config['Twitter']; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<?php } ?>
	</div>
<?php
include('inc/footer.php');
?>
