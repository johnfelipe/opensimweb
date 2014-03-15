<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

$t = $osw->Security->make_safe($_GET['t']);

if ($t == "onlineusercount") {
	$oucq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Online = 'True'");
	$ouc = $osw->SQL->num_rows($oucq);
	echo json_encode(array("value" => $ouc));
}
if ($t == "totalusers") {
	$tuq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser");
	$tuc = $osw->SQL->num_rows($tuq);
	echo json_encode(array("value" => $tuc));
}
?>