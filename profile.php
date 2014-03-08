<?php
$page_title = "Profile of ";
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');

$u = $osw->Security->make_safe($_GET['u']);

if ($u) {
	$uexplode = explode(".", $u);
	$firstname = $uexplode[0];
	$lastname = $uexplode[1];
	if (!$lastname) {
		$lastname = "Resident";
	}
}

$uq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.useraccounts WHERE FirstName = '$firstname' AND LastName = '$lastname'");
$ur = $osw->SQL->fetch_array($uq);
$uuid = $ur['PrincipalID'];
$reztime = $ur['Created'];
$usertitle = $ur['UserTitle'];

$rezday = date('F d, Y', $reztime);

$q = $osw->SQL->query("SELECT * FROM `{$osw->config['profile_db']}`.userprofile WHERE useruuid = '$uuid'");
$r = $osw->SQL->fetch_array($q);

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

if ($lastname == "Resident") {
	$displayname = $firstname;
}else{
	$displayname = $firstname . " " . $lastname;
}

if ($partner) {
	$partnerq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.useraccounts WHERE PrincipalID = '$partner'");
	$partnerr = $osw->SQL->fetch_array($partnerq);
	$partnerFirstName = $partnerr['FirstName'];
	$partnerLastName = $partnerr['LastName'];
	if ($partnerLastName == "Resident") {
		$pname = $partnerFirstName;
	}else{
		$pname = $partnerFirstName . "." . $partnerLastName;
	}
	$partnername = "<a href='osprofile.php?u=" . $pname . "'>" . $pname . "</a>";
}else{
	$partnername = "None";
}

if (!$flpic || $flpic == "00000000-0000-0000-0000-000000000000") {
$picflpic = "<img src='$ip2webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-left' width='75' height='75'>";
}else{
$picflpic = "<img src='$ip2webassets/asset.php?id=$flpic&format=PNG' class='pull-left' width='75' height='75'>";
}

if (!$rlpic || $rlpic == "00000000-0000-0000-0000-000000000000") {
$picrlpic = "<img src='$ip2webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-left' width='75' height='75'>";
}else{
$picrlpic = "<img src='$ip2webassets/asset.php?id=$rlpic&format=PNG' class='pull-left' width='75' height='75'>";
}

$about = "<B>Title</B><br>" . $usertitle . "<hr><B>Biography</B><br>" . $fakeaboutme . "<hr><B>Partner</B><br>" . $partnername . "<hr><B>" . $grid_name . " Birthday</B><br>" . $rezday;

	$displaypicks = "";
	$pickq = $osw->SQL->query("SELECT * FROM `{$osw->config['profile_db']}`.userpicks WHERE creatoruuid = '$uuid' ORDER BY 'sortorder' ASC LIMIT 0,100");
	while ($pickr = $osw->SQL->fetch_array($pickq)) {
		$pickuuid = $pickr['pickuuid'];
		$toppick = $pickr['toppick'];
		$parceluuid = $pickr['parceluuid'];
		$pickname = $pickr['name'];
		$pickinfo = $pickr['description'];
		$pickpic = $pickr['snapshotuuid'];
		if (!$pickpic || $pickpic == "00000000-0000-0000-0000-000000000000") {
			$pickpic = "<img src='$ip2webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-left' width='75' height='75'>";
		}else{
			$pickpic = "<img src='$ip2webassets/asset.php?id=$pickpic&format=PNG' class='pull-left' width='75' height='75'>";
		}
		$displaypicks .= $pickpic . "<br><a href=''><B>$pickname</B></a><br>$pickinfo<hr>";
	}

	$displaygroups = "";
	$groupmq = $osw->SQL->query("SELECT * FROM `{$osw->config['group_db']}`.os_groups_membership WHERE PrincipalID = '$uuid' AND ListInProfile = '1' LIMIT 0,100");
	while ($groupmr = $osw->SQL->fetch_array($groupmq)) {
		$gid = $groupmr['GroupID'];
		$groupgq = $osw->SQL->query("SELECT * FROM `{$osw->config['group_db']}`.os_groups_groups WHERE GroupID = '$gid'");
		$groupgr = $osw->SQL->fetch_array($groupgq);
		$groupname = $groupgr['Name'];
		$groupinfo = $groupgr['Charter'];
		$grouppic = $groupgr['InsigniaID'];
		if (!$grouppic || $grouppic == "00000000-0000-0000-0000-000000000000") {
			$grouppic = "<img src='$ip2webassets/asset.php?id=243e3d7b-66ac-47f0-aca9-74bb932c2404&format=PNG' class='pull-left' width='75' height='75'>";
		}else{
			$grouppic = "<img src='$ip2webassets/asset.php?id=$grouppic&format=PNG' class='pull-left' width='75' height='75'>";
		}
		$displaygroups .= $grouppic . "<br><a href=''><B>$groupname</B></a><br>$groupinfo<hr>";
	}
?>
<style>
#header
{
background-color: #111111;
color: #c4c4c4;
font-size: 18px;
}
.table
{
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
overflow:hidden;
border-radius: 10px;
-pie-background: linear-gradient(#ece9d8, #E5ECD8);   
box-shadow: #666 0px 2px 3px;
behavior: url(Include/PIE.htc);
overflow: hidden;
}
</style>

<div class="container">

	<div class="row" id="header">
		<div class="col-md-2">
			<?php echo $picflpic; ?>
		</div>
  		<div class="col-md-10">
  			<B><?php echo $displayname; ?></B><br>
  			<small><?php echo $u; ?></small><br>
  			<a href='' class='btn btn-success btn-xs'>Add Friend</a>
  		</div>
	</div>
	<div class="row" id="menu">
		<ul class="nav nav-pills nav-justified">
  			<li class="active"><a href="#feed" data-toggle="tab">Feed</a></li>
  			<li><a href="#about" data-toggle="tab">About</a></li>
  			<li><a href="#picks" data-toggle="tab">Picks</a></li>
  			<li><a href="#groups" data-toggle="tab">Groups</a></li>
		</ul>
	</div>
	<div class="row" id="body">
		<div class="tab-content">
  			<div class="tab-pane active" id="feed">
  				For future development. Feed is mostly a placeholder for now.
  			</div>
  			<div class="tab-pane" id="about">
  				<?php echo $about; ?>
  			</div>
  			<div class="tab-pane" id="picks">
  				<?php echo $displaypicks; ?>
  			</div>
  			<div class="tab-pane" id="groups">
  				<?php echo $displaygroups; ?>
  			</div>
		</div>
	</div>

</div>

<?php
include('inc/footer.php');
?>