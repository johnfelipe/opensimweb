<?php
$page_title = "Page not found";
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');
?>
<style>
  .center {text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;}
</style>
  <div class="hero-unit center well">
    <h1>Page Not Found <small><font face="Tahoma" color="red">Error 404</font></small></h1>
    <br />
    <p>The page you requested could not be found, either contact your webmaster or try again. Use your browsers <b>Back</b> button to navigate to the page you have prevously come from</p>
    <p><b>Or you could just press this neat little button:</b></p>
    <a href="<?php echo $site_address; ?>/index.php" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
  </div>
  <br />
  <!-- By ConnerT HTML & CSS Enthusiast -->  
<?php
include('inc/footer.php');
?>