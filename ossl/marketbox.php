<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

$type = $osw->Security->make_safe($_GET['type']);
$grid = $osw->Security->make_safe($_GET['grid']);
$owner = $osw->Security->make_safe($_GET['owner']);
$ownerkey = $osw->Security->make_safe($_GET['ownerkey']);
$sim = $osw->Security->make_safe($_GET['sim']);
$itemname = $osw->Security->make_safe($_GET['itemname']);
$itemtype = $osw->Security->make_safe($_GET['itemtype']);
$primkey = $osw->Security->make_safe($_GET['primkey']);
$pos = $osw->Security->make_safe($_GET['pos']);

$owner = str_replace("%20", " ", $owner);
$sim = str_replace("%20", " ", $sim);

$pos = str_replace("&lt;", "", $pos);
$pos = str_replace("&gt;", "", $pos);

if (!$grid || $grid != $gridnick)
{
exit;
}

$qq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_drop_box` WHERE primkey = '$primkey' AND ownerkey = '$ownerkey'");
$qn = $osw->SQL->num_rows($qq);

if ($type == "rez")
{
	if ($qn) {
	$qu = $osw->SQL->query("UPDATE `{$osw->config['db_prefix']}market_drop_box` SET sim = '$sim', pos = '$pos' WHERE primkey = '$primkey' AND grid = '$grid'");
	}else{
	$qi = $osw->SQL->query("INSERT INTO `{$osw->config['db_prefix']}market_drop_box` (owner, ownerkey, primkey, sim, pos) VALUE ('$owner', '$ownerkey', '$primkey', '$sim', '$pos')");
	}

	if ($qu) {
	echo "alreadyrezzed";
	}else if ($qi) {
	echo "rezzed";
	}else{
	echo "fail";
	}
}

if ($type == "insertitems")
{
$qr = $osw->SQL->fetch_array($qq);
$id = $qr['id'];

$q = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_drop_box_items` WHERE primkey = '$primkey' AND itemname = '$itemname' AND itemtype = '$itemtype'");
$n = $osw->SQL->num_rows($q);
	if ($n) {
	echo "alreadysaved";
	}else{
	$i = $osw->SQL->query("INSERT INTO `{$osw->config['db_prefix']}market_drop_box_items` (owner, ownerkey, boxid, primkey, itemname, itemtype) VALUES ('$owner', '$ownerkey', '$id', '$primkey', '$itemname', '$itemtype')");
		if ($i) {
		echo "saved";
		}else{
		echo "fail";
		}
	}
}
?>