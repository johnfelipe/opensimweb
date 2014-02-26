<?php
$page_title = "Search";
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');
/*** *** *** *** *** ***
* SearchURL = "http://yourwebsiteaddresshere/ossearch.php?search=[QUERY]"
*** *** *** *** *** ***/

$search = $osw->Security->make_safe($_GET['search']);
$search = strtoupper($search);
$search = strip_tags($search);
$search = trim ($search);
$searchlink = $search;

$type = $osw->Security->make_safe($_GET['type']);
$m = $osw->Security->make_safe($_GET['m']);

if ($search) {
$placeholder = "Searching for $search";
}else if (!$search) {
$placeholder = "Search";
}

$select = "selected";

if (!$m) {
$m = "1";
}

// no idea here yet
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

$PG = "<span class='label label-success'>PG</span>";
$MATURE = "<span class='label label-default'>M</span>";
$ADULT = "<span class='label label-danger'>A</span>";
?>
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
$cq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.classifieds WHERE name LIKE '%$search%' OR description LIKE '%$search%' AND creationdate < '$now' AND expirationdate > '$now' AND classifiedflags < '$m' ORDER BY 'creationdate' DESC LIMIT 0,100");
while ($cn = $osw->SQL->fetch_array($cq)) {
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

$parq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.allparcels WHERE parcelUUID = '$parceluuid'");
$parrow = $osw->SQL->fetch_array($parq);
$regionid = $parrow['regionUUID'];
$parcelname = $parrow['parcelname'];
$loc = $parrow['landingpoint'];

$simq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.regions WHERE uuid = '$regionid'");
$simr = $osw->SQL->fetch_array($simq);
$sim = $simr['regionName'];

if (!$loc) {
	$locr = "128,128,25";
}else{
	$locr = str_replace("/", ",", $loc);
}

$FL = $osw->grid->uuid2name($creatoruuid);
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

}
if ($type == "destinations" || !$type) {
	echo "<h3>Destinations</h3>";
$popq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.popularplaces WHERE name LIKE '%$search%' AND mature < '$m' ORDER BY `dwell` DESC LIMIT 0,100");
while ($popn = $osw->SQL->fetch_array($popq)) {
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

$parq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.parcels WHERE parcelUUID = '$parcelUUID'");
$parrow = $osw->SQL->fetch_array($parq);
$reguuid = $parrow['regionUUID'];
$landing = $parrow['landingpoint'];
$desc = $parrow['description'];

$simname = $osw->grid->regionname($reguuid);
$usersonregion = $osw->grid->userspersim($reguuid);

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

}
if ($type == "events" || !$type) {
	echo "<h3>Events</h3>";
$evq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.events WHERE name LIKE '%$search%' OR description LIKE '%$search%' AND dateUTC > $now AND eventflags < '$m' ORDER BY `dateUTC` LIMIT 0,100");
while ($evnum = $osw->SQL->fetch_array($evq)) {

$creator = $evnum['creatoruuid'];
$time = $evnum['dateUTC'];
$eventid = $evnum['eventid'];
$eventname = $evnum['name'];
$eventinfo = $evnum['description'];
$event_type = $evnum['eventflags'];

$event_time = date("M d Y h:i a T",$time);

$getname = $osw->grid->uuid2name($creator);
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

}
if ($type == "groups" || !$type) {
	echo "<h3>Groups</h3>";
$grpq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.os_groups_groups WHERE Name LIKE '%$search%' AND ShowInList = '1' ORDER BY `Name` ASC LIMIT 0,100");
while ($grpn = $osw->SQL->fetch_array($grpq)) {

$GroupID = $grpn['GroupID'];
$Name = $grpn['Name'];
$Charter = $grpn['Charter'];
$InsigniaID = $grpn['InsigniaID'];
$FounderID = $grpn['FounderID'];
$OpenEnrollment = $grpn['OpenEnrollment'];
$MembershipFee = $grpn['MembershipFee'];
$MaturePublish = $grpn['MaturePublish'];

$FL = $osw->grid->uuid2name($FounderID);
$FName = $FL['FirstName'];
$LName = $FL['LastName'];

$gmq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.os_groups_membership WHERE GroupID = '$GroupID'");
$gmcount = $osw->SQL->num_rows($gmq);

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

}
if ($type == "4sale" || !$type) {
	echo "<h3>For Sale</h3>";
$forsaleq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.parcelsales WHERE parcelname LIKE '%$search%' AND mature < '$m' ORDER BY `saleprice` ASC LIMIT 0,100");
while ($forsnum = $osw->SQL->fetch_array($forsaleq)) {

$regionUUID = $forsnum['regionUUID'];
$parcelname = $forsnum['parcelname'];
$parcelUUID = $forsnum['parcelUUID'];
$area = $forsnum['area'];
$saleprice = $forsnum['saleprice'];
$landingpoint = $forsnum['landingpoint'];

$regionname = $osw->grid->regionname($regionUUID);

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

}
if ($type == "people" || !$type) {
	echo "<h3>People</h3>";
$pplq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.useraccounts WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%' ORDER BY `Created` ASC LIMIT 0,100");
while ($pplnum = $osw->SQL->fetch_array($pplq)) {

$uuid = $pplnum['PrincipalID'];
$sFirst = $pplnum['FirstName'];
$sLast = $pplnum['LastName'];

if ($sLast == "Resident") {
$profname = $sFirst;
}else{
$profname = $sFirst.".".$sLast;
}

$online = $osw->grid->online($uuid);
if ($online == "False") {
$onoff = "offlinedot.png";
}else if ($online == "True") {
$onoff = "onlinedot.png";
}

$profq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.userprofile WHERE useruuid = '$uuid' AND profileMaturePublish < '$m'");
$prow = $osw->SQL->fetch_array($profq);

$show = $prow['profileAllowPublish'];
if ($show == "0") {

$MaturePublish = $prow['profileMaturePublish'];
$abouttext = $prow['profileAboutText'];
$fakepic = $prow['profileImage'];

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

}
if ($type == "places" || !$type) {
	echo "<h3>Places</h3>";
$placeq = $osw->SQL->query("SELECT * FROM `{$osw->config['search_db']}`.parcels WHERE parcelname LIKE '%$search%' OR description LIKE '%$search%' AND public = 'true' ORDER BY `parcelUUID` ASC LIMIT 0,100");
while ($placenum = $osw->SQL->fetch_array($placeq)) {

$regionUUID = $placenum['regionUUID'];
$parcelname = $placenum['parcelname'];
$parcelUUID = $placenum['parcelUUID'];
$landingpoint = $placenum['landingpoint'];
$description = $placenum['description'];
$searchcategory = $placenum['searchcategory'];
$mature = $placenum['mature'];

$regionname = $osw->grid->regionname($regionUUID);
$usersonregion = $osw->grid->userspersim($regionUUID);

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

}
?>
</div>
</TD>
</TR>
</TABLE>
<?php
include ('inc/footer.php');
?>