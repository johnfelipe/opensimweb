<?php
if ($hide_sidebars) {
}else{
?>
</div> <!-- ends col-md-8 div found in header.php -->

</div><!-- ends row div found in header.php -->
<?php
}
?>
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

<script src="<?php echo $site_address; ?>/js/jquery.js"></script>
<script src="<?php echo $site_address; ?>/js/bootstrap.js"></script>
</body>
</html>