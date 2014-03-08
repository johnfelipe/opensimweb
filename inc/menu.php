<!-- top menu -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
  	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $site_address; ?>/index.php"><?php echo $logo; ?>
		<?php
		$gridonline = $osw->grid->gridonline();
		if ($gridonline == TRUE) {
			echo "<img src='".$site_address."/img/onlinedot.png' border='0'>";
		}else if ($gridonline == FALSE || !$gridonline) {
			echo "<img src='".$site_address."/img/offlinedot.png' border='0'>";
		}
		?>
		</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-1">

		<!-- <li><a href='<?php echo $site_address; ?>/'>Example of a single menu link</a></li> -->
    	<ul class="nav navbar-nav">

			<li><a href='<?php echo $site_address; ?>/market/index.php'>Market</a></li>
			<li><a href='<?php echo $site_address; ?>/search.php'>Search</a></li>

			<li class='dropdown'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Land Rentals <b class='caret'></b></a>
				<ul class='dropdown-menu'>
					<li><a href='<?php echo $site_address; ?>/'>Private Land</a></li>
					<li><a href='<?php echo $site_address; ?>/'>Mainland</a></li>
					<li><a href='<?php echo $site_address; ?>/'>Self Hosted</a></li>
				</ul>
			</li>

			<li class='dropdown'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Grid <b class='caret'></b></a>
				<ul class='dropdown-menu'>
					<li><a href='<?php echo $site_address; ?>/news.php'>News</a></li>
					<li><a href='<?php echo $site_address; ?>/map.php'>Map</a></li>
					<li><a href='<?php echo $site_address; ?>/viewers.php'>Viewers</a></li>
				</ul>
			</li>

			<li class='dropdown'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Community <b class='caret'></b></a>
				<ul class='dropdown-menu'>
					<li><a href='<?php echo $site_address; ?>/forum/'>Forum</a></li>
				</ul>
			</li>

		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php if ($user) { ?>
			<li><a href='<?php echo $site_address; ?>/profile.php?u=<?php echo $user_first.".".$user_last;?>'><?php echo $user; ?></a><li>
			<?php }else{ ?>
			<li><a href='<?php echo $site_address; ?>/login.php'>Login</a></li>
			<?php } ?>
		</ul>
    </div>
  </div>
</nav>

<!-- bottom menu -->
<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
  <div class="container-fluid">
  	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-2">
    	<ul class="nav navbar-nav">

			<li><a href='<?php echo $site_address; ?>/market/index.php'>Market</a></li>
			<li><a href='<?php echo $site_address; ?>/search.php'>Search</a></li>
		</ul>
    </div>
  </div>
</nav>
