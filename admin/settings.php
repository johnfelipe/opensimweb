<?php
$page_title = "Settings";
define('OSW_IN_SYSTEM', true);
require_once('../inc/header.php');

$cat = $osw->Security->make_safe($_GET['cat']);

$savesettings = $osw->Security->make_safe($_POST['savesettings']);
$oswsettings = $osw->Security->make_safe($_POST['oswsettings']);

if ($savesettings) {

	foreach ($oswsettings as $key => $value) {
	$osw->SQL->query("UPDATE `{$osw->config['db_prefix']}settings` SET value = '$value' WHERE name = '$key'");
	}
echo "<div class='alert alert-success alert-dismissable'>
  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
  <strong>SAVED!</strong> Settings saved.
</div>";
}
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#site" data-toggle="tab">Site</a></li>
  <li><a href="#opensim" data-toggle="tab">Opensim</a></li>
  <li><a href="#news" data-toggle="tab">News</a></li>
  <li><a href="#pages" data-toggle="tab">Pages</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="site">

<form class="form-horizontal" role="form" method="post" action="">
<?php
$sq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}settings` ORDER BY `id` ASC LIMIT 0,100");
while ($sr = $osw->SQL->fetch_array($sq)) {
	$sid = $sr['id'];
	$sname = $sr['name'];
	$svalue = $sr['value'];
	$info = $sr['info'];

	if ($info) {
		$sinfo = "<small>".$info."</small>";
	}else{
		$sinfo = "";
	}

	if ($sname == "activation_type") {
		$inputa = "";
		$inputa .= "<select name='oswsettings[activation_type]' class='form-control'>
		<option value='0'";
		if ($svalue == "0" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">None</option>
		<option value='1'";
		if ($svalue == "1" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">User</option>
		<option value='2'";
		if ($svalue == "2" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">Admin</option>
		</select>";
		$input = $inputa;
	}else if ($sname == "redirect_type") {
		$inputa = "";
		$inputa .= "<select name='oswsettings[redirect_type]' class='form-control'>
		<option value='1'";
		if ($svalue == "1" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">PHP</option>
		<option value='2'";
		if ($svalue == "2" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">HTML</option>
		<option value='3'";
		if ($svalue == "3" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">JavaScript</option>
		</select>";
		$input = $inputa;
	}else if ($sname == "security_image") {
		$inputa = "";
		$inputa .= "<select name='oswsettings[security_image]' class='form-control'>
		<option value='no'";
		if ($svalue == "no" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">No</option>
		<option value='yes'";
		if ($svalue == "yes" ) {
			$inputa .= "SELECTED";
		}else{
		}
		$inputa .= ">Yes</option>
		</select>";
		$input = $inputa;
	}else{
		$input = "<input type='text' class='form-control' id='".$sname."' placeholder='".$sname."' name='oswsettings[".$sname."]' value='".$svalue."'>";
	}
	echo "
   <div class='form-group'>
    <label for='".$sname."' class='col-sm-2 control-label'>".$sname."</label>
    <div class='col-sm-4'>
      ".$input."
    </div>
    <div class='col-sm-4'>
      ".$sinfo."
    </div>
  </div>
  ";
}
?>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-primary" name="savesettings" value="Save">
    </div>
  </div>

</form>

  </div>
  <div class="tab-pane" id="opensim">Still in development</div>
  <div class="tab-pane" id="news">Still in development</div>
  <div class="tab-pane" id="pages">Still in development</div>
</div>
<?php
include ('../inc/footer.php');
?>