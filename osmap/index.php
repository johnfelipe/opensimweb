<?php
// Modified by Christopher Strachan to work with opensimweb
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');
include ('config.php');

if((isset($_GET['size']) and $_GET['size'])and($ALLOW_ZOOM==TRUE)){
  if(($_GET['size'] == 32) or ($_GET['size'] == 64) or ($_GET['size'] == 128) or
     ($_GET['size'] == 192) or ($_GET['size'] == 256))
  {
    $size=$_GET['size'];
  }
} else {
  $size=128; 
}

if($size==32){
  $minuszoom=0; $pluszoom=64; $infosize=10;
}else if($size==64){
  $minuszoom=32; $pluszoom=128; $infosize=10;
}else if($size==128){
  $minuszoom=64; $pluszoom=192; $infosize=20;
}else if($size==192){
  $minuszoom=128; $pluszoom=256; $infosize=30;
}else if($size==256){
  $minuszoom=192; $pluszoom=0; $infosize=40;
}
?>

<HEAD><TITLE><?php echo SYSNAME; ?> WorldMap</TITLE>
<STYLE type=text/css media=all>@import url(map.css);</STYLE>

<SCRIPT src="prototype.js" type=text/javascript></SCRIPT>
<SCRIPT src="effects.js" type=text/javascript></SCRIPT>
<SCRIPT src="mapapi.js" type=text/javascript></SCRIPT>


<SCRIPT type=text/javascript>

function loadmap() 
{
  mapInstance = new ZoomSize(<?php echo $size; ?>);
  mapInstance = new WORLDMap(document.getElementById('map-container'), {hasZoomControls: false, hasPanningControls: true});
  mapInstance.centerAndZoomAtWORLDCoord(new XYPoint(<?php echo $mapstartX; ?>,<?php echo $mapstartY; ?>),1);
<?php
$tbl1 = $osw->SQL->query("SELECT regionName,locX,locY,owner_uuid,uuid FROM `{$osw->config['sim_db']}`.Regions Order by locX");
while(list($regionName,$locX,$locY,$owner,$ruuid) = $osw->SQL->fetch_array($tbl1)){

$tbl2 = $osw->SQL->query("SELECT firstname,lastname FROM `{$osw->config['robust_db']}`.UserAccounts WHERE PrincipalID='$owner'");
list($firstN,$lastN) = $osw->SQL->fetch_array($tbl2);

$tbl3 = $osw->SQL->query("SELECT * FROM `{$osw->config['sim_db']}`.RegionSettings WHERE regionUUID = '$ruuid'");
$rdbr = $osw->SQL->fetch_array($tbl3);
$mapuuid = $rdbr['map_tile_ID'];

$locX /= 256;
$locY /= 256;

$MarkerCoordX=$locX+0.00;
$MarkerCoordY=$locY+0.00;


if($display_marker=="tl")
{
	$MarkerCoordX=($MarkerCoordX)-0.40;
	$MarkerCoordY=($MarkerCoordY)+0.40;
}
else if($display_marker=="tr")
{
	$MarkerCoordX=($MarkerCoordX)+0.40;
	$MarkerCoordY=($MarkerCoordY)+0.40;
}
else if($display_marker=="dl")
{
	$MarkerCoordX=($MarkerCoordX)-0.40;
	$MarkerCoordY=($MarkerCoordY)-0.40;
}
else if($display_marker=="dr")
{
	$MarkerCoordX=($MarkerCoordX)+0.40;
	$MarkerCoordY=($MarkerCoordY)-0.40;
}
?>


    <?php
	$filename = $site_address."/webassets/asset.php?id=".$mapuuid;
	if (file_exists($filename)) 
	{
	echo 'var tmp_region_image = new Img("'.$filename.'",'.$size.','.$size.');';
	}
	else
	{
	echo 'var tmp_region_image = new Img("maptiles/no-mapimage.jpg",'.$size.','.$size.');';
	}
	?>
	var region_loc = new Icon(tmp_region_image);
	var all_images = [region_loc, region_loc, region_loc, region_loc, region_loc, region_loc];
	var marker = new Marker(all_images, new XYPoint(<?=$locX?>,<?=$locY?>));
	mapInstance.addMarker(marker);
	
	var map_marker_img = new Img("images/info.gif",<?=$infosize?>,<?=$infosize?>);
	var map_marker_icon = new Icon(map_marker_img);
	var mapWindow = new MapWindow("Region Name: <?php echo $regionName; ?><br><br>Coordinates: <?php echo $locX; ?>,<?php echo $locY; ?><br><br>Owner: <?php echo $firstN; ?> <?php echo $lastN; ?>",{closeOnMove: true});
	var all_images = [map_marker_icon, map_marker_icon, map_marker_icon, map_marker_icon, map_marker_icon, map_marker_icon];
	var marker = new Marker(all_images, new XYPoint(<?php echo $MarkerCoordX; ?>,<?php echo $MarkerCoordY; ?>));
	mapInstance.addMarker(marker, mapWindow);
<?php
}
?>

}

function setZoom(size) {
  window.location.href="../map/?size="+size+"";
}


</SCRIPT>

<META content="MSHTML 6.00.2900.5512" name=GENERATOR></HEAD>
<BODY onload=loadmap()>

<DIV id=map-container style="z-index: 0;"></DIV>
<DIV id=map-nav>
<DIV id=map-nav-up style="z-index: 1;"><A href="javascript: mapInstance.panUp();">
<IMG alt=Up src="images/pan_up.gif"></A></DIV>
<DIV id=map-nav-down style="z-index: 1;"><A href="javascript: mapInstance.panDown();">
<IMG alt=Down src="images/pan_down.gif"></A></DIV>
<DIV id=map-nav-left style="z-index: 1;"><A href="javascript: mapInstance.panLeft();">
<IMG alt=Left src="images/pan_left.gif"></A></DIV>
<DIV id=map-nav-right style="z-index: 1;"><A href="javascript: mapInstance.panRight();">
<IMG alt=Right src="images/pan_right.gif"></A></DIV>
<DIV id=map-nav-center style="z-index: 1;"><A href="javascript: mapInstance.panOrRecenterToWORLDCoord(new XYPoint(<?php echo $mapstartX; ?>,<?php echo $mapstartY; ?>), true);">
<IMG alt=Center src="images/center.gif"></A></DIV>

<!-- START ZOOM PANEL-->
<?php if($ALLOW_ZOOM==TRUE){ ?>
<DIV id=map-zoom-plus>
<?php if($pluszoom==0){?>
<IMG alt="Zoom In" src="images/zoom_in_grey.gif">
<? } else{?>
<A href="javascript: setZoom(<?php echo $pluszoom; ?>);">
<IMG alt="Zoom In" src="images/zoom_in.gif"></A>
<?php } ?>
</DIV>
<DIV id=map-zoom-minus>
<? if($minuszoom==0){?>
<IMG alt="Zoom In" src="images/zoom_out_grey.gif">
<?php } else{ ?>
<A href="javascript: setZoom(<?php echo $minuszoom; ?>);">
<IMG alt="Zoom Out" src="images/zoom_out.gif"></A>
<?php } ?>
</DIV>

<!-- END ZOOM PANEL-->
</DIV>
</BODY>
