<?php
define('QUADODO_IN_SYSTEM', true);
require_once('includes/headerless.php');

$t = $qls->Security->make_safe($_GET['t']);
$u = $qls->Security->make_safe($_GET['u']);

if ($t == "usercounts") {
$onlineq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Online = 'TRUE'");
$online = $osw->SQL->num_rows($onlineq);

$totalq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.UserAccounts");
$totalc = $osw->SQL->num_rows($totalq);

$monthago = $now - 2592000;
$latestq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Login > '$monthago'");
$latestc = $osw->SQL->num_rows($latestq);

$regionq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.Regions");
$regionc = $osw->SQL->num_rows($regionq);
echo $online."~".$totalc."~".$latestc."~".$regionc;
}

if ($t == "destinations") {
	$destecho = array("");
	$destq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.popularplaces ORDER BY `name` ASC LIMIT 0,10");
	while ($destr = $osw->SQL->fetch_array($destq)) {
		$destname = $destr['name'];
		$destecho .= $destname."~";
	}
	echo $destecho;
}

if ($t == "profile") {
	$userexplode = explode("%20", $u);
	$first = $userexplode[0];
	$last = $userexplode[1];
	if (!$last) {
		$last = "Resident";
	}
	$uq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.useraccounts WHERE FirstName = '$first' AND LastName = '$last'");
	$ur = $osw->SQL->fetch_array($uq);
	$uuid = $ur['PrincipalID'];
	$profq = $osw->SQL->query("SELECT * FROM `{$osw->config['profile_db']}`.userprofile WHERE useruuid = '$uuid'");
	$r = $osw->SQL->fetch_array($profq);

	$partner = $r['profilePartner'];
	$url = $r['profileURL'];
	$want2mask = $r['profileWantToMask'];
	$want2text = $r['profileWantToText'];
	$skillsmask = $r['profileSkillsMask'];
	$skillstext = $r['profileSkillsText'];
	$lang = $r['profileLanguages'];
	$flpic = $r['profileImage'];
	$fakeaboutme = $r['profileAboutText'];
	$rlpic = $r['profileFirstImage'];
	$realaboutme = $r['profileFirstText'];
	$uname = $first." ".$last;
	$array = $uuid."~".$flpic."~".$fakeaboutme."~".$rlpic."~".$realaboutme."~".$partner."~".$url."~".$uname;
}

// For examples for this API system please see oswapilsl.lsl included with OSW
?>