<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title id='titlebar'><?php echo $gridname; ?> - Webmap</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- You can change this to your own bootstrap file -->
<link href="<?php echo $site_address; ?>/css/<?php echo $style; ?>/bootstrap.css" rel="stylesheet">
<link href="<?php echo $site_address; ?>/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $site_address; ?>/css/normalize.css" rel="stylesheet">

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Google Maps JavaScript API Example: Simple Map</title>
	<script src="http://maps.google.com/maps?file=api&amp;v=3&amp;key=AIzaSyCHlWzqyKv-V8-Tx3Js44b5zw8zqiOAViE" type="text/javascript"></script>
	<script type="text/javascript">

	function initialize() {
	}
	</script>

</head>
<body onload="initialize()">
<style>
body {
	padding-top: 70px;
	padding-bottom: 70px;
}
</style>
<div class="container-fluid" id="content">

<div id="map_canvas" style="width: 500px; height: 300px"></div>

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