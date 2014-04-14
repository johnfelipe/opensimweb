<?php
$page_title = "Market";
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('../inc/header.php');

$cat = $osw->Security->make_safe($_GET['cat']);
$search = $osw->Security->make_safe($_GET['search']);
$sort = $osw->Security->make_safe($_GET['sort']);
$order = $osw->Security->make_safe($_GET['order']);
$display = $osw->Security->make_safe($_GET['display']);
$page = $osw->Security->make_safe($_GET['page']);

if (!$display) {
$totaloffset = "25";
}else{
$totaloffset = $display;
}

if (!$page || $page = "0" || $page == "1") {
$page == "1";
$offset = "0";
}else if ($page == "2") {
$offset = $totaloffset;
}else if ($page >= "2") {
$offset = $totaloffset * $page;
}

if (!$order) {
$order = "id";
}

if ($sort == "0") {
$sortby = "ASC";
$ascbtn = "active";
$descbtn = "";
}else if (!$sort || $sort == "1") {
$sortby = "DESC";
$ascbtn = "";
$descbtn = "active";
}

if (!$cat || $cat == "all") {
	$cat = "none";
	$catwhere = "";
	$isCat = false;
}else{
	$cat = $cat;
	$catwhere = "cat = '$cat'";
	$isCat = true;
}

if (!$search) {
	$searchwhere = "";
}else{
	$searchwhere = "name LIKE '%$search%' OR seller LIKE '%$search%' OR info LIKE '%$search%'";
}
?>
  		<div class="row">

  			<div class="col-md-2">
				<div class='panel'>
					<div class="panel-body">
						<B>Category</B><br>
						<ul class="nav nav-pills nav-stacked" style="max-width: 250px;">
							<?php
							if ($isCat) {
								echo "<li><a href='index.php?cat=all&search=".$search."'>Back to ".$cat."</a></li>";
							}
							$catq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_category` WHERE childof = '$cat' ORDER BY `name` ASC LIMIT 0,50");
							while ($catr = $osw->SQL->fetch_array($catq)){
								$catname = $catr['name'];
								$uppercap = ucfirst($catname);
								$prodcountq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_products` WHERE cat = '$catname'");
								$prodcountc = $osw->SQL->num_rows($prodcountq);
								if ($catname == $cat) {
									$catactive = "class='active'";
								}else if ($catname != $cat) {
									$catactive = "";
								}
								echo "<li $catactive><a href='index.php?cat=".$catname."'><B>".$uppercap."</B> (".$prodcountc.")</a></li>";
							}
  							?>
  						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class='panel'>
					<div class="panel-body">
						<form method='get' action='index.php' class="form-inline" role="form">
							 <div class="form-group">
							<?php
							echo "<select name='cat' class='form-control'>";
							$catq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_category` WHERE childof = 'none' ORDER BY `name` ASC LIMIT 0,50");
							while ($catr = $osw->SQL->fetch_array($catq)){
								$catname = $catr['name'];
								$uppercap = ucfirst($catname);
								if ($catname == $cat) {
									$catselected = "SELECTED";
								}
								echo "<option value='".$catname."' ".$catselected.">".$uppercap."</option>";
							}
							echo "</select>";
  							?>
	  						</div>
	  						<div class="form-group">
	  							<input type="text" name="search" value="<?php echo $search; ?>" class="form-control" placeholder="Search">
	  						</div>
	  						<button type="submit" class="btn btn-default">Search</button>
						</form>
<div class="container">
	<div class="row">
<?php
if ($catwhere && $searchwhere) {
	$where = "WHERE $catwhere AND $searchwhere";
}else if ($catwhere && !$searchwhere) {
	$where = "WHERE $catwhere";
}else if (!$catwhere && $searchwhere) {
	$where = "WHERE $searchwhere";
}else if (!$catwhere && !$searchwhere) {
	$where = "WHERE sales > '$min_sales_2b_featured'";
}
$q = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}market_products` $where ORDER BY $order $sortby LIMIT $offset,$totaloffset");
while ($r = $osw->SQL->fetch_array($q)) {
$prod_cat = $r['cat'];
$prod_name = $r['name'];
$prod_img = $r['img'];
$prod_seller = $r['seller'];
$prod_price = $r['price'];
echo "
<div class='col-md-4'>
	<div class='panel panel-info'>
		<div class='panel-body'>
			<a href='product.php?prod=".$prod_name."'><img src='".$site_address."/webassets/assets.php?id=".$prod_img."' border='0'><br>".$prod_name."</a><br>
			<span class='bg-info lead pull-right'>".$gridmoney." ".$prod_price."</span>
			<small><a href='index.php?cat=&search=".$prod_seller."'>".$prod_seller."</a></small>
		</div>
	</div>
</div>";
}
?>
	</div>
</div>
<?php
$tbl_name = "`{$osw->config['db_prefix']}market_products` $where";
$pager = "index.php?cat=$cat&search=$search&sort=$sort&order=$order&display=$display";
echo $osw->pagination->paging($tbl_name, $pager, $totaloffset);
?>
					</div>
				</div>
			</div>

		</div>
<?php
include ('../inc/footer.php');
?>