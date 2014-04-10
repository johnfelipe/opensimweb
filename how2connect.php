<?php
$page_title = "How to connect";
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');
?>
<h2>How to connect to the grid</h2>
<div class="row">
	<div class="col-md-4">
		<p>
			You will need a opensim compatible viewer. <a href="http://opensimulator.org/wiki/Connecting">http://opensimulator.org/wiki/Connecting</a> has a great list of viewers that work with opensim and a simple tutorial.
		</p>

		<p>
			The loginURI for this grid is <a href="<?php echo $osw->config['loginURI']; ?>"><?php echo $osw->config['loginURI']; ?></a>
		</p>

	</div>
</div>
<?php
include ('inc/footer.php');
?>