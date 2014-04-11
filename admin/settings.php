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
echo $osw->site->displayalert('<strong>SAVED!</strong> Settings saved');
}
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#site" data-toggle="tab">Site</a></li>
  <li><a href="#news" data-toggle="tab">News</a></li>
  <li><a href="#pages" data-toggle="tab">Pages</a></li>
  <li><a href="#regions" data-toggle="tab">Regions</a></li>
  <li><a href="#users" data-toggle="tab">Users</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="site"><?php include('site.php'); ?></div>
  <div class="tab-pane" id="news"><?php include('news.php'); ?></div>
  <div class="tab-pane" id="pages"><?php include('pages.php'); ?></div>
  <div class="tab-pane" id="regions"><?php include('regions.php'); ?></div>
  <div class="tab-pane" id="users"><?php include('users.php'); ?></div>
</div>
<?php
include ('../inc/footer.php');
?>