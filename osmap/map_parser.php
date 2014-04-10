<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');
include("config.php");
include("mysql.php");

$DbLink = new DB;

//Supress all Warnings/Errors
error_reporting(0);

$now = time();

function GetURL($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $data = curl_exec($ch);
    if (!curl_errno($ch))
    {
        curl_close($ch);
        return $data;
    }
	return "";
}

function CheckHost($host, $port, $texture)
{

	$fp = fsockopen ($host, $port, $errno, $errstr, 10);

	if(!$fp)
	{
	//Setting a "fake" update time so this host will have time
	//to get back online

	$next = time() + (30 * 60); // 30 mins, so we don't get stuck

	$osw->SQL->query("UPDATE ".C_REGIONS_TBL." set lastseen = $next " .
			" where serverIP = '" . mysql_escape_string($host) . "' AND ".
			"serverPort = '" . mysql_escape_string($port) . "' AND ".
			"regionMapTexture = '".mysql_escape_string($texture) ."'");
	}
	else
	{
	parse($host,$port, $texture);
	}
}

function parse($host,$port, $texture)
{
	global $now;

	///////////////////////////////////////////////////////////////////////
	//
	// Map Parse Engine
	//

	//
	// Read params
	//
	$next = time() + (30 * 60); // 30 mins, so we don't get stuck

	$DbLink = new DB;
	$osw->SQL->query("UPDATE ".C_REGIONS_TBL." set lastseen = ".$next." " .
			" where serverIP = '" . mysql_escape_string($host) . "' AND ".
			"serverPort = '" . mysql_escape_string($port) . "' AND ".
			"regionMapTexture = '".mysql_escape_string($texture) ."'");

	// Get the maptexture out
	$osw->SQL->query("SELECT regionMapTexture from ".C_REGIONS_TBL.
			" where serverIP = '" . mysql_escape_string($host) . "' AND ".
			"serverPort = '" . mysql_escape_string($port) . "' AND ".
			"regionMapTexture = '".mysql_escape_string($texture) ."'");

	list($UUID) = $DbLink->next_record();
	$UUID = str_replace("-", "", $UUID);

	$buildurl = $host.":".$port."/index.php?method=regionImage".$UUID;

	// Grabbing the map texure from the region
	$mapdata = GetURL($buildurl);

	$osw->SQL->query("SELECT locX, locY from ".C_REGIONS_TBL.
			" where serverIP = '" . mysql_escape_string($host) . "' AND ".
			"serverPort = '" . mysql_escape_string($port) . "' AND ".
			"regionMapTexture = '".mysql_escape_string($texture) ."'");

	list($regionX,$regionY ) = $osw->SQL->next_record();

	$regionX /= 256;
	$regionY /= 256;
	$fp = fopen("maptiles/mapimage-".$regionX."-".$regionY.".jpg", "w");
	fwrite($fp, $mapdata);
	fclose($fp);
}

// Adding a clean query to the parser

$osw->SQL->query("SELECT locX, locY FROM ".C_REGIONS_TBL."");

while(list($locX,$locY) = $osw->SQL->next_record())
{
	$osw->SQL->query("DELETE FROM ".C_REGIONS_TBL." WHERE locX = ".$locX." AND locY = ".$locY."");
	// Removing the dead regions from the opensim regions table as well
	// 
	// Uncomment this to remove it from the OpenSim regions table as well
	// $osw->SQL->query("DELETE FROM ".C_REGIONS_TBL." WHERE locX = ".$locX." AND locY = ".$locY."");
}

// Getting 1 region at a time

$query = "SELECT serverIP, serverPort, regionMapTexture FROM ".C_MAP_REGIONS_TBL." WHERE `lastcheck` < ".$now." limit 0,1";

$osw->SQL->query($query);

while(list($serverIP,$serverPort, $mapTexture) = $osw->SQL->next_record())
{
	CheckHost($serverIP, $serverPort, $mapTexture);
}
?>
