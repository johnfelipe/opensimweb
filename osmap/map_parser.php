<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

//Supress all Warnings/Errors
error_reporting(0);

$now = time();

function parse($host,$port, $texture)
{
	$now = time();
	$next = $now + 1800; // 30 mins, so we don't get stuck

	$osw->SQL->query("UPDATE `{$osw->config['robust_db']}`.regions SET lastseen = '$next' WHERE serverIP = '$host' AND serverPort = '$port' AND regionMapTexture = '$texture'");

	// Get the maptexture out
	$s1 = $osw->SQL->query("SELECT regionMapTexture FROM `{$osw->config['robust_db']}`.regions WHERE serverIP = '$host' AND serverPort = '$port' AND regionMapTexture = '$texture'");

	list($UUID) = $osw->SQL->fetch_array($s1);
	$UUID = str_replace("-", "", $UUID);

	$mapdata = $site_address."/webassets/asset.php?id=".$UUID;

	$s2 = $osw->SQL->query("SELECT locX, locY from `{$osw->config['robust_db']}`.regions WHERE serverIP = '$host' AND serverPort = '$port' AND regionMapTexture = '$texture'");

	list($regionX,$regionY ) = $osw->SQL->fetch_array($s2);

	$regionX /= 256;
	$regionY /= 256;
	$fp = fopen($mapdata, "w");
	fwrite($fp, $mapdata);
	fclose($fp);
}

function CheckHost($host, $port, $texture)
{

	$fp = fsockopen ($host, $port, $errno, $errstr, 10);

	if(!$fp)
	{
	//Setting a "fake" update time so this host will have time
	//to get back online
	$now = time();
	$next = $now + 1800; // 30 mins, so we don't get stuck

	$osw->SQL->query("UPDATE `{$osw->config['robust_db']}`.regions SET lastseen = '$next' WHERE serverIP = '$host' AND serverPort = '$port' AND regionMapTexture = '$texture'");
	}
	else
	{
	parse($host,$port, $texture);
	}
}

// Getting 1 region at a time
$s4 = $osw->SQL->query("SELECT serverIP, serverPort, regionMapTexture FROM `{$osw->config['robust_db']}`.regions WHERE lastcheck < '$now' limit 0,1");
while(list($serverIP,$serverPort,$mapTexture) = $osw->SQL->fetch_array($s4))
{
	CheckHost($serverIP, $serverPort, $mapTexture);
}
?>
