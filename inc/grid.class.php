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

	function newuuid() {
	$uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		mt_rand( 0, 0x0fff ) | 0x4000,
		mt_rand( 0, 0x3fff ) | 0x8000,
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
	return $uuid;
	}

	function getosuser($FirstName, $LastName) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE FirstName = '$FirstName' AND LastName = '$LastName'");
	$r = $this->osw->SQL->fetch_array($q);
	return $r;
	}

	function getosuser_by_uuid($uuid) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE PrincipalID = '$uuid'");
	$r = $this->osw->SQL->fetch_array($q);
	return $r;
	}

	function uuid2name($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE PrincipalID = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	return $r;
	}

	function regioninfo($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.Regions WHERE uuid = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	return $r;
	}

	function regionname($UUID) {
	$r = $this->regioninfo($UUID);
	$r3 = $r['regionName'];
	return $r3;
	}

	function regionip($UUID) {
	$r = $this->regioninfo($UUID);
	$r4 = $r['serverIP'];
	return $r4;
	}

	function online($UUID) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.GridUser WHERE UserID = '$UUID'");
	$r = $this->osw->SQL->fetch_array($q);
	$online = $r['Online'];
	return $online;
	}

	function userspersim($sim) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.Presence WHERE RegionID = '$sim'");
	$c = $this->osw->SQL->num_rows($q);
	return $c;
	}

	function isAdmin($uuid) {
		if ($uuid) {
			$site_admin_level = $this->osw->config['site_admin_level'];
			$r = $this->getosuser_by_uuid($uuid);
			$level = $r['UserLevel'];
			if ($level == $site_admin_level || $level >= $site_admin_level) {
				return true;
			}else if ($level <= $site_admin_level) {
				return false;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function getFriends($uuid) {
		echo "<div class='table-responsive'>
		<table class='table table-hover table-condensed'>
		<thead>
		<tr>
		<th><small><B>NAME</B></small></th>
		<th><small><B>STATUS</B></small></th>
		</tr>
		</thead>
		<tbody>
		";
		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.Friends WHERE PrincipalID = '$uuid'");
		while ($r = $this->osw->SQL->fetch_array($q)) {
			$FriendID = $r['Friend'];
			$q2 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts WHERE PrincipalID = '$FriendID'");
			$q3 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.GridUser WHERE UserID = '$FriendID'");
			$r2 = $this->osw->SQL->fetch_array($q2);
			$r3 = $this->osw->SQL->fetch_array($q3);
			$FriendFirst = $r2['FirstName'];
			$FriendLast = $r2['LastName'];
			$Online = $r3['Online'];

			if ($FriendLast == "Resident") {
				$FriendLast = "";
			}

			if ($Online == "True") {
				$fon == "online";
			}else if ($Online == "False") {
				$fon = "offline";
			}
			echo "<tr>
			<td>".$FriendFirst." ".$FriendLast."</td>
			<td>".$fon."</td>
			</tr>
			";
		}
		echo "</tbody>
		</table>
		</div>";
	}

	function getGroups($uuid) {
		echo "<div class='table-responsive'>
		<table class='table table-hover table-condensed'>
		<thead>
		<tr>
		<th><small><B>NAME</B></small></th>
		<th><small><B>MEMBERS</B></small></th>
		</tr>
		</thead>
		<tbody>
		";
		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.os_groups_membership WHERE PrincipalID = '$uuid'");
		while ($r = $this->osw->SQL->fetch_array($q)) {
			$GroupID = $r['GroupID'];
			$q2 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.os_groups_groups WHERE GroupID = '$GroupID'");
			$q3 = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.os_groups_membership WHERE GroupID = '$GroupID'");
			$r2 = $this->osw->SQL->fetch_array($q2);
			$r3 = $this->osw->SQL->num_rows($q3);
			$Name = $r2['Name'];
			echo "<tr>
			<td>".$Name."</td>
			<td>".$r3."</td>
			</tr>
			";
		}
		echo "</tbody>
		</table>
		</div>";
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

	function gridonline() {
		$loginuri = $this->osw->config['loginURI'];
		$urlrep = str_replace("http://", "", $loginuri);
		$explode = explode(":", $urlrep);
		$ip2robust = $explode[0];
		$port2robust = $explode[1];
		$fp = @fsockopen($ip2robust, $port2robust, $errno, $errstr, 1);
		if ($fp) {
			$return = true;
			fclose($fp);
		}else{
			$return = false;
		}
		return $return;
	}

	function gridstatus() {
		$onlineq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.GridUser WHERE Online = 'TRUE'");
		$online = $this->osw->SQL->num_rows($onlineq);

		$totalq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.UserAccounts");
		$totaluser = $this->osw->SQL->num_rows($totalq);

		$monthago = $now - 2592000;
		$latestq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.GridUser WHERE Login > '$monthago'");
		$latest = $this->osw->SQL->num_rows($latestq);

		$regionq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['robust_db']}`.regions");
		$regions = $this->osw->SQL->num_rows($regionq);

		if ($this->gridonline()) {
			$gonline = "<font color='Green'>Online</font>";
		}else{
			$gonline = "<font color='Red'>Offline</font>";
		}

		$gridstatus = "<span class='nowrap'><strong>Users in World:</strong> ".$online."</span><br>
				<span class='nowrap'><strong>Regions:</strong> ".$regions."</span><br>
				<span class='nowrap'><strong>Total Users:</strong> ".$totaluser."</span><br>
				<span class='nowrap'><strong>Active Users (Last 30 Days):</strong> ".$latest."</span>
				<span class='nowrap'><strong>Grid is ".$gonline." </strong></span>";
	return $gridstatus;
	}

	function senddata($Host, $PostData) {
		$Port = 80;
		$Method = "POST";
		if (strtolower(substr($Host, 0, 5)) == "https") {
			$Port = 443;
		}
		$Host = explode("//", $Host, 2);
		if (count($Host) < 2) {
			$Host[1] = $Host[0];
		}
		$Host = explode("/", $Host[1], 2);
		if ($Port == 443) {
			$SSLAdd = "ssl://";
		}
		$Host[0] = explode(":", $Host[0]);
		if (count($Host[0]) > 1) {
			$Port = $Host[0][1];
			$Host[0] = $Host[0][0];
		}else{
			$Host[0] = $Host[0][0];
		}
		$Socket = @fsockopen($SSLAdd.$Host[0], $Port, $Dummy1, $Dummy2, 1);
		if ($Socket) {
  			fputs($Socket, "$Method /$Host[1] HTTP/1.1\r\n".
				 "Host: $Host[0]\r\n".
				 "Content-type: application/x-www-form-urlencoded\r\n".
				 "User-Agent: Opera/9.01 (Windows NT 5.1; U; en)\r\n".
				 "Accept-Language: de-DE,de;q=0.9,en;q=0.8\r\n".
				 "Accept-Charset: iso-8859-1, utf-8, utf-16, *;q=0.1\r\n".
				 "Content-length: ".strlen($PostData)."\r\n".
				 "Connection: close\r\n".
				 "\r\n".
				 $PostData);
  			$Tme = time();
  			while(!feof($Socket) && $Tme + 30 > time()) {
  				$Res = $Res.fgets($Socket, 256);
  			}
			fclose($Socket);
		}
		$Res = explode("\r\n\r\n", $Res, 2);
 		return $Res[1];
	}
}
?>