<?php
$page_title = "Product";
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('../inc/header.php');

$prod = $osw->Security->make_safe($_GET['prod']);

$q = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_products` WHERE name = '$prod'");
$r = $osw->SQL->fetch_array($q);
$prod_id = $r['id'];
$prod_item_id = $r['item_id'];
$prod_cat = $r['cat'];
$prod_name = $r['name'];
$prod_info = $r['info'];
$prod_features = $r['features'];
$prod_img = $r['img'];
$prod_other_imgs = $r['other_imgs'];
$prod_seller = $r['seller'];
$prod_sales = $r['sales'];
$prod_price = $r['price'];
$prod_perms = $r['permissions'];
$prod_version = $r['version'];

$other_pics = "";
if ($prod_other_imgs) {
	$exploded_imgs = explode(", ", $prod_other_imgs);
	foreach ($exploded_imgs as $key => $value) {
		$other_pics .= "<a href='#' class='thumbnail'><img src='".$site_address."/webassets/assets.php?id=".$value."' border='0' data-src='holder.js/50%x50'></a><br>";
	}
}

if ($prod_features) {
	$features = "<ul>";
	$exploded_features = explode(", ", $prod_features);
	foreach ($exploded_features as $key => $value) {
		$features .= "<li>".$value."</li>";
	}
	$features .= "</ul>";
}else{
	$features = "No features where added.";
}

if (!$prod_perms) {
	$perms = "<strike>Copy</strike> <strike>Modify</strike> <strike>Transfer</strike>";
}else if ($prod_perms == "C, M, T") {
	$perms = "<i class='fa fa-check'></i>Copy <i class='fa fa-check'></i>Modify <i class='fa fa-check'></i>Transfer";
}else if ($prod_perms == "C, M") {
	$perms = "<i class='fa fa-check'></i>Copy <i class='fa fa-check'></i>Modify <strike>Transfer</strike>";
}else if ($prod_perms == "C") {
	$perms = "<i class='fa fa-check'></i>Copy <strike>Modify</strike> <strike>Transfer</strike>";
}else if ($prod_perms == "M") {
	$perms = "<strike>Copy</strike> <i class='fa fa-check'></i>Modify <strike>Transfer</strike>";
}else if ($prod_perms == "T") {
	$perms = "<strike>Copy</strike> <strike>Modify</strike> <i class='fa fa-check'></i>Transfer";
}

echo "<div class='row'>
	<div class='col-md-12'>
<div class='row'>
	<div class='col-md-8'>
	<h3>".$prod_name." <small>Version ".$prod_version."</small></h3>
		<div class='row'>
		<div class='col-md-6'>
		<a href='#' class='thumbnail'><img src='".$site_address."/webassets/assets.php?id=".$prod_img."' border='0' data-src='holder.js/150%x150'></a>
		</div>
		<div class='col-md-4'>
		".$other_pics."
		</div>
		</div>
<ul class='nav nav-tabs'>
  <li class='active'><a href='#info' data-toggle='tab'>Details</a></li>
  <li><a href='#features' data-toggle='tab'>Features</a></li>
  <li><a href='#reviews' data-toggle='tab'>Reviews</a></li>
</ul>

<div class='tab-content'>
  <div class='tab-pane active' id='info'>".$prod_info."</div>
  <div class='tab-pane' id='features'>".$features."</div>
  <div class='tab-pane' id='reviews'>Reviews coming soon</div>
</div>
	</div>
	<div class='col-md-4'>
		<form class='form-horizontal' role='form' method='post' action='cart.php'>
			<input type='hidden' name='prod_id' value='".$prod_id."'>
			<h3>".$gridmoney." ".$prod_price."</h3>
			<input type='submit' class='btn btn-primary' name='buybtn' value='Add To Cart'><br>
			<input type='submit' class='btn btn-info' name='buybtn' value='Buy Now'><br>
		</form><br>
		Permissions:<br>
		".$perms."
	</div>
</div>
	</div> <!-- col-md-9 -->
</div>
";

include ('../inc/footer.php');
?>