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
		if ($osw->grid->gridonline()) {
			echo "<img src='".$site_address."/img/onlinedot.png' border='0'>";
		}else{
			echo "<img src='".$site_address."/img/offlinedot.png' border='0'>";
		}
		?>
		</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-1">

		<!-- <li><a href='<?php echo $site_address; ?>/'>Example of a single menu link</a></li> -->
    	<ul class="nav navbar-nav">

    		<?php
    		$mq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}mainmenu` WHERE childof = '0' ORDER BY `sortby` ASC LIMIT 0,100");
    		while($mr = $osw->SQL->fetch_array($mq)) {
    			$mid = $mr['id'];
    			$mname = $mr['name'];
    			$murl = $mr['url'];
    			$msq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}mainmenu` WHERE childof = '$mid' ORDER BY `sortby` ASC LIMIT 0,100");
    			$msc = $osw->SQL->num_rows($msq);
    			if ($msc) {
    				echo "<li class='dropdown'>
    						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$mname." <b class='caret'></b></a>
    							<ul class='dropdown-menu'>";
    							while ($msr = $osw->SQL->fetch_array($msq)) {
    								$msid = $msr['id'];
    								$msname = $msr['name'];
    								$msurl = $msr['url'];
    								echo "<li><a href='".$site_address."/".$msurl."'>".$msname."</a></li>";
    							}
    							echo "</ul>
									</li>";
    			}else{
    				echo "<li><a href='".$site_address."/".$murl."'>".$mname."</a></li>";
    			}
    		}
    		?>
		</ul>
		<!-- This shouldnt be in a menu since its part of the system. -->
		<ul class="nav navbar-nav navbar-right">
			<?php
      if ($user_uuid) {
        $userproflink = str_replace(" ", ".", $user);
      ?>
			<li class="dropdown">
				<a href='#' class="dropdown-toggle" data-toggle="dropdown"><?php echo $user; ?> <b class='caret'></b></a>
				<ul class="dropdown-menu">
					<li><a href='<?php echo $site_address; ?>/profile.php?u=<?php echo $userproflink;?>'>Profile</a></li>
          <li class="divider"></li>
          <?php
          if ($osw->grid->isAdmin($user_uuid)) {
          ?>
          <li><a href='<?php echo $site_address; ?>/admin/settings.php'>Settings</a></li>
          <?php
          }else{
          }
          ?>
				</ul>
			<li>
			<?php }else{ ?>
			<li><a href='<?php echo $site_address; ?>/login.php?lp=<?php echo $thispage; ?>'>Login</a></li>
			<li><a href='<?php echo $site_address; ?>/register.php'>Register</a></li>
			<?php } ?>
		</ul>
    </div>
  </div>
</nav>
