<?php 
include '../../../includes/configuration/master.configuration.php';
include $docRoot.'includes/php.module/fckeditor/fckeditor.php';	
checkAdminSpaceLogin();

$navigation_id 	= SanitizeData($_GET['id']);
$mySQL			= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$navigation_id'";
$recSET			= mysql_query($mySQL) or die (mysql_error());
$recROW			= mysql_fetch_assoc($recSET);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
<title>Untitled 1</title>

<script type="text/javascript" src="../../../includes/javascript/jquery.animated.collapse.js"></script>
<script type="text/javascript" src="../../../includes/javascript/jquery.animated.collapse.code.js"></script>

<script type="text/javascript" src="display.hide.js"></script>

<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" >
<link href="../../../includes/style/form.css" rel="stylesheet" type="text/css" >

<style type="text/css">


</style>

</head>

<body>
<form name="link_type" method="post" action="save.php?id=<?php echo SanitizeData($_GET['id']) ?>" class="content_body_form form_class" style="width:750px; margin-right: auto; margin-left: auto;">
	<h2><?php echo $recROW['nav_tab_name']?></h2>
		<div class="editor_page">
		<ul>
			<li style="margin-left:0px; padding:0px; background:none"><a href="<?php echo $absoluteURL?>admin.space/website.navigation/">Website Navigation</a></li>
			<?php echo html_entity_decode(return_cats_path_nolink(SanitizeData($_GET['id']),$lang=$_SESSION['languageID'],1,1))?>
		</ul>
		</div>
		
		<p style="clear:both; padding:10px"></p>
		
	<?php 
	$mySQL	= "SELECT * FROM link WHERE nav_tab_id = ".$_GET['id'];
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);
	
	if (empty($recROW['url']))		$link = "http://www.";
	if (!empty($recROW['url']))		$link = $recROW['url'];
	
	?>

		<div class="vignette_uploader_link_box" style="border:none">
		&nbsp;<select name="link_type" onchange="javascript:displayhide()" style="margin-left:-5px;font-size:10pt">
			<option value="1">Internal Link</option>
			<option value="2">External link</option>
			<option value="0" selected>Choose link type</option>
		</select>
		<select name="link_internal" style="display:none;font-size:10pt">
			<?php echo $internal_url	= CreateParentDropEditor(0,".. ");?>
		
		</select>
		<input type="text" name="link_external" style="display:;font-size:10pt" value="<?php echo $link?>">
	</div>


	<div>
	
		<button type="submit" class="buttton" style="float:left; margin:15px 0px 15px 0px"><span>Save</span></button>
				
	</div>
</form>
</body>

</html>