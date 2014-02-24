<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  <div class="container-fluid">
  	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $site_address; ?>"><?php echo $logo; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
       <ul class="nav navbar-nav">
<?php
$q1 = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}menu` WHERE subof = '0' ORDER BY `sort` ASC LIMIT 0,100");
while ($r1 = $osw->SQL->fetch_array($q1)) {
	$id = $r1['id'];
	$name = $r1['name'];
	$link = $r1['link'];
	$q2 = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}menu` WHERE subof = '$id' ORDER BY `sort` ASC LIMIT 0,100");
	$n2 = $osw->SQL->num_rows($q2);
	if ($n2 == 0) {
		echo "<li><a href='". $link . "'>" . $name . "</a></li>";
	}else{
		echo "<li class='dropdown'>
		<a href='#' class=''dropdown-toggle' data-toggle='dropdown'>". $name . " <b class='caret'></b></a>
		<ul class='dropdown-menu'>";
		while ($r2 = $osw->SQL->fetch_array($q2)) {
			$name2 = $r2['name'];
			$link2 = $r2['link'];
			echo "<li><a href='".$link2."'>".$name2."</a></li>";
		}
		echo "</ul>
		</li>";
	}
}
?>

      </ul>
    </div>
  </div>
</nav>
