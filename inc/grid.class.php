<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class grid
{

var $osw;
	
	function grid(&$osw)
	{
		$this->osw = &$osw;
	}

	function getosuser($FirstName, $LastName) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.useraccounts WHERE FirstName = '$FirstName' AND LastName = '$LastName'");
	$r = $this->osw->SQL->fetch_array($q);
	return $r;
	}

	function uuid2name($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.useraccounts WHERE PrincipalID = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	return $r;
	}

	function regionname($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.regions WHERE uuid = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	$r3 = $r['regionName'];
	return $r3;
	}

	function regionip($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.regions WHERE uuid = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	$r4 = $r['serverIP'];
	return $r4;
	}

	function online($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.griduser WHERE UserID = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	$online = $r['Online'];
	return $online;
	}

	function userspersim($sim) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.presence WHERE RegionID = '$sim'");
	$c = $this->osw->SQL->num_rows($q);
	return $c;
	}

	function oscat($catid) {
		switch ($catid) {
		case "0":
			$r = "Any";
			break;
		case "18":
			$r = "Discussion";
			break;
		case "19":
			$r = "Sports";
			break;
		case "20":
			$r = "Live Music";
			break;
		case "22":
			$r = "Commercial";
			break;
		case "23":
			$r = "Nightlife/Entertainment";
			break;
		case "24":
			$r = "Games/Contests";
			break;
		case "25":
			$r = "Pageants";
			break;
		case "26":
			$r = "Education";
			break;
		case "27":
			$r = "Arts and Culture";
			break;
		case "28":
			$r = "Charity/Support Groups";
			break;
		case "29":
			$r = "Miscellaneous";
			break;
		}
	return $r;
	}
}
?>