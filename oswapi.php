<?php
define('OSW_IN_SYSTEM', true);
require_once('inc/headerless.php');

$t = $osw->Security->make_safe($_GET['t']);
$u = $osw->Security->make_safe($_GET['u']);
$uuid = $osw->Security->make_safe($_GET['uuid']);

if ($t == "getpic") {
	echo $site_address."/webassets/asset.php?id=".$uuid;
	// to use this just add your OSW site domain followed by /oswapi.php?t=getpic&uuid=UUID to a <img html tag
	// Then replace UUID with the UUID of the texture you like to show up as a website image.
}

if ($t == "usercounts") {
$onlineq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Online = 'TRUE'");
$online = $osw->SQL->num_rows($onlineq);

$totalq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.UserAccounts");
$totalc = $osw->SQL->num_rows($totalq);

$monthago = $now - 2592000;
$latestq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE Login > '$monthago'");
$latestc = $osw->SQL->num_rows($latestq);

$regionq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.regions");
$regionc = $osw->SQL->num_rows($regionq);
$array =  array("ONLINE"=>$online,"TOTALUSERS"=>$totalc,"RECENTJOINS"=>$latestc,"REGIONS"=>$regionc);
echo json_encode($array);
}

if ($t == "destinations") {
	$destecho = array("");
	$destq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.popularplaces ORDER BY `name` ASC LIMIT 0,10");
	while ($destr = $osw->SQL->fetch_array($destq)) {
		$destname = $destr['name'];
		$destecho .= array($destname);
	}
	echo json_encode($destecho);
}

if ($t == "profile") {
	$userexplode = explode(".", $u);
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
	$array = array("UUID"=>$uuid,"PIC"=>$flpic,"ABOUT"=>$fakeaboutme,"RLPIC"=>$rlpic,"RLABOUT"=>$realaboutme,"PARTNER"=>$partner,"URL"=>$url);
	echo json_encode($array);
}

if ($t == "examples") {
	// These are examples of how to get the info above using REST API.

	// Lets first get the usual user and region counts.
	// Remember to change localhost to your domain where your copy of OSW is at.
	$body = file_get_contents("http://localhost/oswapi.php?t=usercounts");
	$contents = utf8_encode($body); // i figure it be best just in case to encode into something we humans can understand.
	$json = json_decode($contents); // this decodes all that json into readable strings.
	// now lets break that json down into strings for better use.
	$online = $json['ONLINE'];
	$totaluser = $json['TOTALUSERS'];
	$recentjoins = $json['RECENTJOINS'];
	$regions = $json['REGIONS'];
	// Then just echo or print those strings.

	// That was easy, lets do some looping with destinations guide.
	$destbody = file_get_contents("http://localhost/oswapi.php?t=destinations");
	$destcontents = utf8_encode($destbody);
	$destjson = json_decode($destcontents);
	foreach ($destjson as $key) {
		// This still needs some work but this is how you loop multiple input of the same source / string
	}

	// Ok that was abit confusing. MOVING ON!
	// profile API works simular to usercounts but requires 1 extra feild in the address.
	// The address for profiles is...
	// http://localhost/oswapi.php?t=profile&u=FirstName.LastName
	// See the FirstName.LastName ? Replace that with a existing user.
	// Example: http://localhost/oswapi.php?t=profile&u=Christina.Vortex
	// This is a great way to convert someones name to their uuid key.
	// I will write some RESTful php api for LSL soon.
}
?>