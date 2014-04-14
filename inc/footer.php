<?php
if ($hide_sidebars) {
}else{
?>
</div> <!-- ends col-md-8 div found in header.php -->
	<div class="col-md-4">
		<?php
		echo $osw->grid->gridstatus();
		?>
	</div>
</div><!-- ends row div found in header.php -->
<?php
}
?>
<footer>
  <div class="row">
  	<div class="col-md-4">
		
	</div>
  	<div class="col-md-4">
		<center>
		<p><strong>LoginURI:</strong> <span class="textlogo"><?php echo $osw->config['loginURI']; ?></span></p>
		<p><span class="textlogo"><a href="<?php echo $site_address; ?>/tos.php">Terms of Service</a></span></p>
		<p>Web design &copy; <a href="http://zetamex.com/" target="_blank">Zetamex</a> and Built With <a href="http://getbootstrap.com" target="_blank">Bootstrap</a>. 
		     Distributed under <a href="http://creativecommons.org/licenses/by/3.0/" target="_blank">Creative&nbsp;Commons</a>.</p>
		<a href="http://opensimulator.org" target="_blank"><img class="logo" src="<?php echo $site_address; ?>/img/Os_b_150x20_b.png"></a>
		</center>
  	</div>
  	<div class="col-md-4">

  	</div>
  </div>
</footer>

</div> <!-- Ends the container div found in header.php -->

<script type="text/JavaScript">
$(document).ready(function(){
	$('.dropdown-toggle').dropdown();
	$('#tooltip').tooltip('show');
	$(".accordion").collapse('toggle');
	$('.collapse').collapse('toggle');
	$('#modal').modal('toggle');
	$('.carousel').carousel({interval: 10000});
	$('#tabs a:first').tab('show');
});
</script>

<script type="text/javascript" src="<?php echo $site_address; ?>/js/bootstrap.js"></script>
</body>
</html>