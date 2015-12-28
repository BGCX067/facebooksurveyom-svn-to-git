<?php
include '../../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Untitled 1</title>

<link rel="stylesheet" href="../../../../../includes/style/admin.space.css" type="text/css" >
<link rel="stylesheet" href="../../../../../includes/style/lytebox.css" type="text/css" >
<script type="text/javascript" src="../../../../../includes/javascript/lytebox.js"></script>

</head>

<body>

<?php
$vignette_id	= $_GET['vignette_id'];
$feature_id	= $_GET['feature_id'];
$mySQL		= "SELECT * FROM multimedia WHERE vignette_id = '$vignette_id' AND feature_id = '$feature_id' AND status = 3 ORDER BY usort ASC";
$recSET		= mysql_query($mySQL) or die (mysql_error());

while ($recROW = mysql_fetch_assoc($recSET)) {

	$usort			= $recROW['usort'];
	$multimedia_id	= $recROW['multimedia_id'];
	$image_path		= getMultimediaPicture($multimedia_id, 'small');
	
	?>

	<div class="picture_uploader_tumb_container">
		<a class="picture" href="#" style="background-image:url('<?php echo deSanitizeData($image_path)?>')"></a>
		<ul>
			<li><a href="<?php echo deSanitizeData($absoluteURL)."admin.space/feature.base/vignette.uploader/data/delete/?multimedia_id=$multimedia_id"?>"><img src="<?php echo deSanitizeData($absoluteURL)?>multimedia/pictures/template/admin.space/icons/x.gif"></a></li>
			<li><a href="<?php echo deSanitizeData($absoluteURL)."admin.space/feature.base/vignette.uploader/data/sort/?vignette_id=$vignette_id&fid=$feature_id&usort=$usort&dir=up&id=$multimedia_id"?>"><img src="<?php echo deSanitizeData($absoluteURL)?>multimedia/pictures/template/admin.space/icons/arrow-left.gif"></a></li>
			<li><a href="<?php echo deSanitizeData($absoluteURL)."admin.space/feature.base/vignette.uploader/data/sort/?vignette_id=$vignette_id&fid=$feature_id&usort=$usort&dir=down&id=$multimedia_id"?>"><img src="<?php echo deSanitizeData($absoluteURL)?>multimedia/pictures/template/admin.space/icons/arrow-right.gif"></a></li>
		</ul>
	</div>
<?php }?>


<p class="clear"></p>
<!--  >>>  <div class="newStyle1">
<div class="thumb"></div>
	<div class="newStyle2">
	<p><?php echo $recROW['multimedia_name']?></p>
	<p style="color:#CCCCCC; margin-bottom:20px">(<?php echo $recROW['size']?> KB)</p>
	</div>
	<a href="http://www.yahoo.com" rel="lyteframe" title="Search Google" rev="width: 500px; height: 200px; scrolling: no;">
	delete</a> 
	| 
	<a href="http://pavel.kuzub.com/wp-content/themes/pavel/images/pavelheader.jpg" rel="lytebox" >edit</a>
</div>
  <<< !-->



</body>

</html>
