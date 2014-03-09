<?php
$page_title = "Grid Map";
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');
?>
<div class="row-fluid">
   <iframe src='<?php echo $site_address; ?>/osmap/index.php' name='gridmap' width="100%" height="600px" scrolling='no' seamless>
    If you can see this instead of the map then you really need to get a new computer that can handle a better browser like Google Chrome.
   </iframe>
</div>

<?php
include ('inc/footer.php');
?>