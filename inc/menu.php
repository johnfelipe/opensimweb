<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  <div class="container-fluid">
  	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $site_address; ?>/index.php"><?php echo $logo; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-1">

		<!-- <li><a href='<?php echo $site_address; ?>/'>Example of a single menu link</a></li> -->
    	<ul class="nav navbar-nav">

			<li><a href='<?php echo $site_address; ?>/market/index.php'>Market Square</a></li>
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
    </div>
  </div>
</nav>
