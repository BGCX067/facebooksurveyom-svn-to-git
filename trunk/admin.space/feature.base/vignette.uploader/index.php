<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id			= $_GET['id'];
$feature_id			= $_GET['fid'];

$mySQL				= "SELECT * FROM feature WHERE feature_id = '$feature_id'";
$recSET				= mysql_query($mySQL) or die (mysql_error());
$recROW				= mysql_fetch_assoc($recSET);

$feature_title		= $recROW['title'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=windows-1252" http-equiv="Content-Type" >
<title>&lt;?php echo deSanitizeData($feature_title)?&gt;</title>


<script type="text/javascript" src="../../../includes/javascript/lytebox.js"></script>

<link rel="stylesheet" href="../../../includes/style/lytebox.css" type="text/css" >
<link rel="stylesheet" href="../../../includes/style/admin.space.css" type="text/css" >
<link rel="stylesheet" href="../../../includes/style/form.css" type="text/css" >


<style type="text/css">
</style>


</head>

<body>

<?php

/*************************************************************************************************************************
	CHECK THE MAX NUMBER OF VIGNETTE CREATE. IF REACHED LIMIT THEN DISABLE THE CREATE NEW LINK
**************************************************************************************************************************/	
if (getSetting('max_upload_vignette',$feature_id) > 0) {
	$mySQL	= "SELECT * FROM vignette WHERE nav_tab_id = '$nav_tab_id' AND feature_id = '$feature_id' AND status > 0";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	
	if (mysql_num_rows($recSET) >= getSetting('max_upload_vignette',$feature_id)) $allow_create = 'no';
}
?>

<div class="navigation_structure_backend" >
	<div class="title_space">
			<h1><?php echo deSanitizeData($feature_title)?></h1>
			<?php if ($allow_create <> 'no') {?>
			<h2><a href="create/?nav_tab_id=<?php echo deSanitizeData($_GET['id'])?>&feature_id=<?php echo deSanitizeData($_GET['fid'])?>">Create new</a></h2>
			<?php }?>
			<p class="clear"></p>
	</div>
	
	
	<div class="editor_page">
		<ul>
			<li style="margin-left:0px; background:none; padding-left:0px"><a href="<?php echo $absoluteURL?>admin.space/website.navigation/">
			Website Navigation</a></li>
			<?php echo html_entity_decode(return_cats_path_nolink(SanitizeData($_GET['id']),$lang=$_SESSION['languageID'],1))?>
		</ul>
	</div>
	<p class="clear"></p>
	
	<p style="height:10px; padding:0px; margin:0px"></p>
	<?php

	$mySQL	= "SELECT * FROM vignette WHERE nav_tab_id = '$nav_tab_id' AND feature_id = '$feature_id' AND status = 3 ORDER BY usort ASC";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	while ($recROW = mysql_fetch_assoc($recSET)) {
		
		$vignette_id	= $recROW['vignette_id'];
		$usort			= $recROW['usort'];
		$mySQL2			= "SELECT * FROM page WHERE vignette_id = '$vignette_id' AND language_id = '$default_language'";
		$recSET2		= mysql_query($mySQL2) or die (mysql_error());
		$recROW2		= mysql_fetch_assoc($recSET2);		
		
		
		
		?>
		
		<div class="vignette_container">
			<a href="data/?feature_id=<?php echo $feature_id?>&nav_tab_id=<?php echo $nav_tab_id?>&vignette_id=<?php echo $vignette_id?>" rel="lyteframe" rev="width: 680px; height: 350px; scrolling: no;" class="picture" style="background-image:url('<?php echo getVignetteMultimediaPicture($vignette_id, $feature_id, 'medium')?>')"></a>
			<div>
				<h5><?php echo ucfirst(SpecialTrim(strip_tags (html_entity_decode(deSanitizeData($recROW2['pagetitle']))),12)) ?></h5>
				<p><?php echo ucfirst(SpecialTrim(strip_tags (html_entity_decode(deSanitizeData($recROW2['body']))),18)) ?></p>
				<ul>
					<li><a href="<?php echo deSanitizeData($absoluteURL)."admin.space/feature.base/vignette.uploader/delete/?vignette_id=$vignette_id"?>" rel="lyteframe" rev="width: 430px; height: 130px; scrolling: no;"><img src="<?php echo deSanitizeData($absoluteURL)?>multimedia/pictures/template/admin.space/icons/x.gif"></a></li>
					<li><a href="<?php echo deSanitizeData($absoluteURL)."admin.space/feature.base/vignette.uploader/sort/?nav_tab_id=$nav_tab_id&fid=$feature_id&usort=$usort&dir=up&id=$vignette_id"?>"><img src="<?php echo deSanitizeData($absoluteURL)?>multimedia/pictures/template/admin.space/icons/arrow-left.gif"></a></li>
					<li><a href="<?php echo deSanitizeData($absoluteURL)."admin.space/feature.base/vignette.uploader/sort/?nav_tab_id=$nav_tab_id&fid=$feature_id&usort=$usort&dir=down&id=$vignette_id"?>"><img src="<?php echo deSanitizeData($absoluteURL)?>multimedia/pictures/template/admin.space/icons/arrow-right.gif"></a></li>
				</ul>
			</div>
		</div>	
	
	<?php }?>
	
</div>




</body>

</html>