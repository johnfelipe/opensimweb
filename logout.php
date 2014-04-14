<?php
define('OSW_IN_SYSTEM', true);
require_once('inc/headerless.php');
if ($osw->Users->logout_user()) {
	$osw->redirect($osw->config['logout_redirect']);
}
include ('inc/footer.php');
?>