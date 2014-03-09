<?php
$page_title = "News";
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');
$id = $osw->Security->make_safe($_GET['id']);

if (!$id) {
	$id = "0";
}
?>
<div class="row">
	<div class="col-md-4">
  		<h3><?php echo $osw->config['GridName']; ?> News</h3>
  		<?php echo $osw->site->getNews($id, ''); ?>
	</div>
</div>
<?php
include ('inc/footer.php');
?>