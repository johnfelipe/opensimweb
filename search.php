<?php
//error_reporting(0);
/*** *** *** *** *** ***
* @package OpenSim Search page for viewers
* @file    osviewersearch.php
* @start   May 26, 2013
* @author  Christopher Strachan
* @license http://www.opensource.org/licenses/gpl-license.php
* @version 2.1.1
* @link    http://www.littletech.net
*** *** *** *** *** ***
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*** *** *** *** *** ***
* Comments are always before the code they are commenting.
*** *** *** *** *** ***/

/*** *** *** *** *** ***
* You are welcome to modify this page all you want and rename it.
* Bootstrap included in the header of this page to make it look better.
* This page does relie heavly on bootstrap so please becareful if you remove bootstrap from this page.
* This page is mainly for the viewers like FireStorm. I did this because im sick and tired of lagency search not working and
* website search is loading a non functional search page for OSGrid and like to start contributing my skills in php to the OpenSim community.
* This was orginally designed for my own grid and have changed it to work for other grids.
* If you dont know php html or have anyone on your dev team that knows it I will be glad to help.
* Just send me a email to chrisx84@live.ca or chrisx8416@gmail.com
* Webassest modular is required for the pics to work.
* OSSearch is also required for this page to get search info from your grid.
* For this to work on your grid add the following line into your Robust.ini or Robust.HG.ini in the [LoginService] section.
*** *** *** *** *** ***
* SearchURL = "http://yourwebsiteaddresshere/ossearch.php?search=[QUERY]"
*** *** *** *** *** ***
* The [QUERY] is what is sent to the page if someone searches from the search bar at the top right of most viewers.
*** *** *** *** *** ***/

// change these to work with your databases
$osmod = "osmodules";
$osmain = "opensim";

$dbaddress = "localhost";
$dbuser = "root";
$dbpass = "l0v3sux";
$sitedb = "site";

// grid address and name
$address = "http://yourdomain.com";
$grid_name = "Your Grid";

$now = time();

// You can remove these two lines if your using a cms or have your own way to connect to the database.
$mysqli = new mysqli($dbaddress, $dbuser, $dbpass, $sitedb);
if (mysqli_connect_errno()) {
    echo "Connect failed";
    exit();
}

global $mysqli;

// your welcome to cut and paste these functions into your own system and modify them.

	function getosuser($FirstName, $LastName) {
	global $mysqli;
	global $osmain;
	$q = $mysqli->query("SELECT * FROM $osmain.useraccounts WHERE FirstName = '$FirstName' AND LastName = '$LastName'");
	$r = $q->fetch_array(MYSQLI_BOTH);
	$q->free();
	return $r;
	}

	function uuid2name($uuid) {
	global $mysqli;
	global $osmain;
	$q2 = $mysqli->query("SELECT * FROM $osmain.useraccounts WHERE PrincipalID = '$uuid'");
	$r2 = $q2->fetch_array(MYSQLI_BOTH);
	$q2->free();
	return $r2;
	}

	function regionname($ruuid) {
	global $mysqli;
	global $osmain;
	$getregionq = $mysqli->query("SELECT * FROM $osmain.regions WHERE uuid = '$ruuid'");
	$regionrow = $getregionq->fetch_array(MYSQLI_BOTH);
	$r3 = $regionrow['regionName'];
	$getregionq->free();
	return $r3;
	}

	function regionip($UUID) {
	global $mysqli;
	global $osmain;
	$getregionq2 = $mysqli->query("SELECT * FROM $osmain.regions WHERE uuid = '$UUID'");
	$regionrow2 = $getregionq2->fetch_array(MYSQLI_BOTH);
	$r4 = $regionrow2['serverIP'];
	$getregionq2->free();
	return $r4;
	}

	function online($uuid) {
	global $mysqli;
	global $osmain;
	$oq = $mysqli->query("SELECT * FROM $osmain.griduser WHERE UserID = '$uuid'");
	$or = $oq->fetch_array(MYSQLI_BOTH);
	$online = $or['Online'];
	$oq->free();
	return $online;
	}

	function userspersim($sim) {
	global $mysqli;
	global $osmain;
	$simq = $mysqli->query("SELECT * FROM $osmain.presence WHERE RegionID = '$sim'");
	$count = $simq->num_rows;
	$simq->close();
	return $count;
	}

	function time2date($time) {
	$dt = new DateTime("@$time");
	$r = $dt->format('M d Y g:ia T');
	return $r;
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

// only mess with this function if you know wtf your doing.
// screwing this up could (WILL) result in a hackable websearch page.
function sqlprotection ($s) {
global $mysqli;
$s = htmlspecialchars(stripslashes($s));
$s = rawurlencode($s);
$s = str_replace(array("1=1", ";", "-", "script", "SELECT", "INSERT", "UPDATE", "DELETE", "UNION", "OR"), array("", "", "", "", "", "", "", "", "", ""), $s);
return $s;
}

if (isset($_GET['search'])) {
	$search = sqlprotection($_GET['search']);
	$search = strtoupper($search);
	$search = strip_tags($search);
	$search = trim ($search);
	$searchlink = $search;
}else{
	$search = "";
	$searchlink = "everything";
}
if (isset($_GET['type'])) {
	$type = $_GET['type'];
}else{
	$type = "";
}
if (isset($_GET['m'])) {
	$m = $_GET['m'];
}else{
	$m = "";
}

if ($search) {
$placeholder = "Searching for $search";
}else if (!$search) {
$placeholder = "Search";
}

$select = "selected";

if (!$m) {
$m = "1";
}

$eventcat = "<select name='eventcat'>
<option value=''></option>
<option value=''></option>
<option value=''></option>
<option value=''></option>
<option value=''></option>
<option value=''></option>
<option value=''></option>
<option value=''></option>
</select>";

$searchtitle = strtolower($search);
$ptitle = "Searching for $searchtitle";

$PG = "<span class='label label-success'>PG</span>";
$MATURE = "<span class='label label-default'>M</span>";
$ADULT = "<span class='label label-danger'>A</span>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title id='titlebar'><?php echo "$grid_name $ptitle"; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- Optional bootstrap style -->
<link href="http://www.littletech.net/css/opensim/bootstrap.css" rel="stylesheet">
<link href="http://www.littletech.net/css/opensim/bootstrap-theme.css" rel="stylesheet">

</head>
<body>

<form class="form-inline" method="get" action="" role="form">
<div class="form-group">
    <input type="text" name="search" class="form-control" id="appendedInputButtons" placeholder="<?php echo $placeholder; ?>">
    <select name="type" class="form-control">
	<option value="" <?php if (!$type) { echo ""; } ?>>Everything</option>
	<option value="classifieds" <?php if ($type == "classifieds") { echo "$select"; } ?>>Classifieds</option>
	<option value="destinations" <?php if ($type == "destinations") { echo "$select"; } ?>>Destinations</option>
	<option value="events" <?php if ($type == "events") { echo "$select"; } ?>>Events</option>
	<option value="groups" <?php if ($type == "groups") { echo "$select"; } ?>>Groups</option>
	<option value="4sale" <?php if ($type == "4sale") { echo "$select"; } ?>>Land & Rentals</option>
	<option value="people" <?php if ($type == "people") { echo "$select"; } ?>>People</option>
	<option value="places" <?php if ($type == "places") { echo "$select"; } ?>>Places</option>
    </select>
</div>

<div class="form-group">
<label class="radio inline">
  <input type="radio" id="inlineCheckbox1" name="m" value="1" <?php if ($m == "1") { echo "CHECKED"; } ?>><?php echo $PG; ?>
</label>
<label class="radio inline">
  <input type="radio" id="inlineCheckbox2" name="m" value="2" <?php if ($m == "2") { echo "CHECKED"; } ?>><?php echo $MATURE; ?>
</label>
<label class="radio inline">
  <input type="radio" id="inlineCheckbox3" name="m" value="3" <?php if ($m == "3") { echo "CHECKED"; } ?>><?php echo $ADULT; ?>
</label>
</div>

<div class="form-group">
<button type="submit" class="btn btn-success">Search</button>
</div>

</form>

<TABLE>
<TR VALIGN="top" style="valign: top;">
<TD ALIGN="left" STYLE="width:150px;">
  <ul class="nav nav-pills nav-stacked">
<li <?php if (!$type) { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=&m=$m"; ?>">Everything</a></li>


<li <?php if ($type == "classifieds") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=classifieds&m=$m"; ?>">Classifieds</a></li>


<li <?php if ($type == "destinations") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=destinations&m=$m"; ?>">Destinations</a></li>


<li <?php if ($type == "events") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=events&m=$m"; ?>">Events</a></li>
<?php if ($type == "events") { echo $eventcat; } ?>

<li <?php if ($type == "groups") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=groups&m=$m"; ?>">Groups</a></li>
<?php
if ($type == "groups") {
echo "Group Test";
}
?>

<li <?php if ($type == "4sale") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=4sale&m=$m"; ?>">Land & Rentals</a></li>


<li <?php if ($type == "people") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=people&m=$m"; ?>">People</a></li>


<li <?php if ($type == "places") { echo "class='active'"; } ?>><a href="<?php echo "ossearch.php?search=$searchlink&type=places&m=$m"; ?>">Places</a></li>
<?php
if ($type == "places") {
echo "Test";
}
?>
  </ul>
</TD>
<TD ALIGN="left" STYLE='max-width:600px'>
<div class="panel-group" id="accordion" style="width:600px; height: auto;">
<?php
if ($type == "classifieds" || !$type) {
	echo "<h3>Classifieds</h3>";
$cq = $mysqli->query("SELECT * FROM $osmod.classifieds WHERE name LIKE '%$search%' OR description LIKE '%$search%' AND creationdate < '$now' AND expirationdate > '$now' AND classifiedflags < '$m' ORDER BY 'creationdate' DESC LIMIT 0,100");
while ($cn = $cq->fetch_array(MYSQLI_BOTH)) {
$creatoruuid = $cn['creatoruuid'];
$creationdate = $cn['creationdate'];
$expirationdate = $cn['expirationdate'];
$category = $cn['category'];
$name = $cn['name'];
$parceluuid = $cn['parceluuid'];
$description = $cn['description'];
$snapshotuuid = $cn['snapshotuuid'];
$simname = $cn['simname'];
$classifiedflags = $cn['classifiedflags'];

$creationdate = date("M d Y h:i a T",$creationdate);
$expirationdate = date("M d Y h:i a T",$expirationdate);

$parq = $mysqli->query("SELECT * FROM $osmod.allparcels WHERE parcelUUID = '$parceluuid'");
$parrow = $parq->fetch_array(MYSQLI_BOTH);
$regionid = $parrow['regionUUID'];
$parcelname = $parrow['parcelname'];
$loc = $parrow['landingpoint'];
$parq->free();

$simq = $mysqli->query("SELECT * FROM $osmain.regions WHERE uuid = '$regionid'");
$simr = $simq->fetch_array(MYSQLI_BOTH);
$sim = $simr['regionName'];
$simq->free();

if (!$loc) {
	$locr = "128,128,25";
}else{
	$locr = str_replace("/", ",", $loc);
}

$FL = uuid2name($creatoruuid);
$FName = $FL['FirstName'];
$LName = $FL['LastName'];

if ($classifiedflags == 0) {
$classifiedflags = "$PG";
}else if ($classifiedflags == 1) {
$classifiedflags = "$MATURE";
}else if ($classifiedflags == 2) {
$classifiedflags = "$ADULT";
}

if (!$snapshotuuid || $snapshotuuid == "00000000-0000-0000-0000-000000000000") {
$pic = "<img src='$address/webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-right' width='75' height='75'>";
}else{
$pic = "<img src='$address/webassets/asset.php?id=$snapshotuuid&format=PNG' class='pull-right' width='75' height='75'>";
}

echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#$parceluuid'>
        <B>$name</B>
      </a>
      </h4>
    </div>
    <div id='$parceluuid' class='panel-collapse collapse'>
      <div class='panel-body'>
$pic
<p>
<a href='secondlife://$sim/$loc/'>$parcelname, $sim ($locr)</a><br>
$description
<br>
<small>Created: $creationdate by $FName $LName</small>
</p>
      </div>
    </div>
  </div>
";
}
$cq->free();
}
if ($type == "destinations" || !$type) {
	echo "<h3>Destinations</h3>";
$popq = $mysqli->query("SELECT * FROM $osmod.popularplaces WHERE name LIKE '%$search%' AND mature < '$m' ORDER BY `dwell` DESC LIMIT 0,100");
while ($popn = $popq->fetch_array(MYSQLI_BOTH)) {
$parcelUUID = $popn['parcelUUID'];
$name = $popn['name'];
$mature = $popn['mature'];

if ($mature == 0) {
$mature = "$PG";
}else if ($mature == 1) {
$mature = "$MATURE";
}else if ($mature == 2) {
$mature = "$ADULT";
}

$parq = $mysqli->query("SELECT * FROM $osmod.parcels WHERE parcelUUID = '$parcelUUID'");
$parrow = $parq->fetch_array(MYSQLI_BOTH);
$reguuid = $parrow['regionUUID'];
$landing = $parrow['landingpoint'];
$desc = $parrow['description'];
$parq->free();
$simname = regionname($reguuid);
$usersonregion = userspersim($reguuid);

echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#Dest$parcelUUID'>
	<B>$name</B>
      </a>
      </h4>
    </div>
    <div id='Dest$parcelUUID' class='panel-collapse collapse'>
      <div class='panel-body'>
$desc<br>
<B>Mature Rating:</B> $mature<br>
<B>Avatars on region:</B> $usersonregion
<br><a href='secondlife://$simname/$landing/'>Teleport</a>
     </div>
    </div>
  </div>";

}
$popq->free();
}
if ($type == "events" || !$type) {
	echo "<h3>Events</h3>";
$evq = $mysqli->query("SELECT * FROM $osmod.events WHERE name LIKE '%$search%' OR description LIKE '%$search%' AND dateUTC > $now AND eventflags < '$m' ORDER BY `dateUTC` LIMIT 0,100");
while ($evnum = $evq->fetch_array(MYSQLI_BOTH)) {

$creator = $evnum['creatoruuid'];
$time = $evnum['dateUTC'];
$eventid = $evnum['eventid'];
$eventname = $evnum['name'];
$eventinfo = $evnum['description'];
$event_type = $evnum['eventflags'];

$event_time = date("M d Y h:i a T",$time);

$getname = uuid2name($creator);
$first = $getname['FirstName'];
$last = $getname['LastName'];
$event_host = "$first $last";

if ($event_type == 0) {
$event_type = "$PG";
}else if ($event_type == 1) {
$event_type = "$MATURE";
}else if ($event_type == 2) {
$event_type = "$ADULT";
}

if ($time >= $now) {
echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#$eventid'>
<B>$eventname - $event_time</B>
      </a>
	</h4>
    </div>
    <div id='$eventid' class='panel-collapse collapse'>
      <div class='panel-body'>
$eventinfo<br>
      </div>
    </div>
  </div>
";
}else if ($time <= $now) {
// dont display anything
}

}
$evq->free();
}
if ($type == "groups" || !$type) {
	echo "<h3>Groups</h3>";
$grpq = $mysqli->query("SELECT * FROM $osmain.os_groups_groups WHERE Name LIKE '%$search%' AND ShowInList = '1' ORDER BY `Name` ASC LIMIT 0,100");
while ($grpn = $grpq->fetch_array(MYSQLI_BOTH)) {

$GroupID = $grpn['GroupID'];
$Name = $grpn['Name'];
$Charter = $grpn['Charter'];
$InsigniaID = $grpn['InsigniaID'];
$FounderID = $grpn['FounderID'];
$OpenEnrollment = $grpn['OpenEnrollment'];
$MembershipFee = $grpn['MembershipFee'];
$MaturePublish = $grpn['MaturePublish'];

$FL = uuid2name($FounderID);
$FName = $FL['FirstName'];
$LName = $FL['LastName'];

$gmq = $mysqli->query("SELECT * FROM $osmain.os_groups_membership WHERE GroupID = '$GroupID'");
$gmcount = $gmq->num_rows;
$gmq->close();

if ($InsigniaID == "00000000-0000-0000-0000-000000000000" || !$InsigniaID) {
$pic = "<img src='$address/webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-right' width='75' height='75'>";
}else{
$pic = "<img src='$address/webassets/asset.php?id=$InsigniaID&format=PNG' class='pull-right' width='75' height='75'>";
}

if ($OpenEnrollment == "1") {
$join = "<a href='' class='btn btn-success'>JOIN</a>";
}else if ($OpenEnrollment == "0") {
$join = "Closed to invites only.";
}

if ($MaturePublish == 0) {
$MaturePublish = "$PG";
}else if ($MaturePublish == 1) {
$MaturePublish = "$MATURE";
}else if ($MaturePublish == 2) {
$MaturePublish = "$ADULT";
}

echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#$GroupID'>
<B>$Name</B>
      </a>
	</h4>
    </div>
    <div id='$GroupID' class='panel-collapse collapse'>
      <div class='panel-body'>
$pic
$MaturePublish
$Charter
<br>
Total Members: $gmcount
<br>
Enrollment: $join
<br>
<small>Created by $FName $LName</small>
      </div>
    </div>
  </div>
";
}
$grpq->free();
}
if ($type == "4sale" || !$type) {
	echo "<h3>For Sale</h3>";
$forsaleq = $mysqli->query("SELECT * FROM $osmod.parcelsales WHERE parcelname LIKE '%$search%' AND mature < '$m' ORDER BY `saleprice` ASC LIMIT 0,100");
while ($forsnum = $forsaleq->fetch_array(MYSQLI_BOTH)) {

$regionUUID = $forsnum['regionUUID'];
$parcelname = $forsnum['parcelname'];
$parcelUUID = $forsnum['parcelUUID'];
$area = $forsnum['area'];
$saleprice = $forsnum['saleprice'];
$landingpoint = $forsnum['landingpoint'];

$regionname = regionname($regionUUID);

echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#forsale$parcelUUID'>
<B>$parcelname</B>
      </a>
	</h4>
    </div>
    <div id='forsale$parcelUUID' class='accordion-body collapse'>
      <div class='panel-body'>
<p>
<B>Area:</B> $area<br>
<B>Price:</B> V$ $saleprice<br>
<B>Region:</B> $regionname<br>
<a href=''>Teleport</a>
</p>
      </div>
    </div>
  </div>
";
}
$forsaleq->free();
}
if ($type == "people" || !$type) {
	echo "<h3>Places</h3>";
$pplq = $mysqli->query("SELECT * FROM $osmain.useraccounts WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%' ORDER BY `Created` ASC LIMIT 0,100");
while ($pplnum = $pplq->fetch_array(MYSQLI_BOTH)) {

$uuid = $pplnum['PrincipalID'];
$sFirst = $pplnum['FirstName'];
$sLast = $pplnum['LastName'];

if ($sLast == "Resident") {
$profname = $sFirst;
}else{
$profname = $sFirst.".".$sLast;
}

$online = online($uuid);
if ($online == "False") {
$onoff = "offlinedot.png";
}else if ($online == "True") {
$onoff = "onlinedot.png";
}

$profq = $mysqli->query("SELECT * FROM $osmod.userprofile WHERE useruuid = '$uuid' AND profileMaturePublish < '$m'");
$prow = $profq->fetch_array(MYSQLI_BOTH);

$show = $prow['profileAllowPublish'];
if ($show == "0") {

$MaturePublish = $prow['profileMaturePublish'];
$abouttext = $prow['profileAboutText'];
$fakepic = $prow['profileImage'];

$profq->free();

if ($abouttext) {
$abouttext = htmlspecialchars_decode($abouttext, ENT_QUOTES);
$abouttext = html_entity_decode($abouttext);
$abouttext = substr($abouttext, 0, 125);
$fakelife = "<p>
$abouttext
</p>";
}else if (!$abouttext) {
$fakelife = "";
}

if ($MaturePublish == 0) {
$MaturePublish = "$PG";
}else if ($MaturePublish == 1) {
$MaturePublish = "$MATURE";
}else if ($MaturePublish == 2) {
$MaturePublish = "$ADULT";
}

if ($fakepic == "00000000-0000-0000-0000-000000000000" || !$fakepic) {
$pic = "<img src='$address/webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-right' width='75' height='75'>";
}else{
$pic = "<img src='$address/webassets/asset.php?id=$fakepic&format=PNG' class='pull-right' width='75' height='75'>";
}

echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#people$uuid'>
<B>$sFirst $sLast</B> <img src='$address/img/$onoff' border='0'>
      </a>
	</h4>
    </div>
    <div id='people$uuid' class='panel-collapse collapse'>
      <div class='panel-body'>
$pic
$fakelife
      </div>
    </div>
  </div>
";

}else if ($show == "1" || !$show){
}

}
$pplq->free();
}
if ($type == "places" || !$type) {
	echo "<h3>Places</h3>";
$placeq = $mysqli->query("SELECT * FROM $osmod.parcels WHERE parcelname LIKE '%$search%' OR description LIKE '%$search%' AND public = 'true' ORDER BY `parcelUUID` ASC LIMIT 0,100");
while ($placenum = $placeq->fetch_array(MYSQLI_BOTH)) {

$regionUUID = $placenum['regionUUID'];
$parcelname = $placenum['parcelname'];
$parcelUUID = $placenum['parcelUUID'];
$landingpoint = $placenum['landingpoint'];
$description = $placenum['description'];
$searchcategory = $placenum['searchcategory'];
$mature = $placenum['mature'];

$regionname = regionname($regionUUID);
$usersonregion = userspersim($regionUUID);

if ($mature == "PG") {
$mr = "1";
$mat = "$PG";
}
if ($mature == "Mature") {
$mr = "2";
$mat = "$MATURE";
}
if ($mature == "Adult") {
$mr = "3";
$mat = "$ADULT";
}

if ($mr <= $m) {
echo "  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#places$parcelUUID'>
<B>$parcelname</B>
      </a>
	</h4>
    </div>
    <div id='places$parcelUUID' class='panel-collapse collapse'>
      <div class='panel-body'>
<p>
$pic
$description<br>
<B>Mature Rating:</B> $mat<br>
<B>Avatars on region:</B> $usersonregion
<br>
<a href='secondlife://$regionname/$landingpoint/'>Teleport</a>
</p>
      </div>
    </div>
  </div>
";
}else{
}

}
$placeq->free();
}
?>
</div>
</TD>
</TR>
</TABLE>

<script type="text/JavaScript">
$(document).ready(function(){
	$('.dropdown-toggle').dropdown();
	$('#tooltip').tooltip('show');
	$(".accordion").collapse('toggle');
	$('.collapse').collapse('toggle');
	$('#modal').modal('toggle');
	$('.carousel').carousel({interval: 10000});
	$('#tabs a:first').tab('show');
});
</script>

<script src="http://www.littletech.net/js/jquery.js"></script>
<script src="http://www.littletech.net/js/bootstrap.js"></script>
</body>
</html>
<?php
$mysqli->close();
?>