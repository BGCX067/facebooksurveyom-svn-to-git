<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

/*************************************************************************************************************************
	CAPTURE ALL THE VARIABLE
**************************************************************************************************************************/
$nav_tab_id			= $_GET['id'];
$feature_id			= $_GET['fid'];
$vignette_id		= 0; 				// This is defined here to not leave the variable empty which will cause the picture uploader to not appear

$mySQL	= "SELECT * FROM feature WHERE feature_id = ".$feature_id;
$recSET	= mysql_query($mySQL) or die (mysql_error());
$recROW	= mysql_fetch_assoc($recSET);

$feature_title	= $recROW['title'];


/*************************************************************************************************************************
	CHOSE THE LIST PAGE
**************************************************************************************************************************/

$list_page		= GetSetting('list_type', $feature_id);
if (empty($list_page)) $list_page = 'index.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=windows-1252" http-equiv="Content-Type" >
<title><?php echo deSanitizeData($feature_title)?></title>


<script type="text/javascript" src="../../../includes/php.module/uploader/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../../includes/php.module/uploader/js/jquery.uploadify.js"></script>
<script type="text/javascript" src="../../../includes/php.module/uploader/js/jquery.jgrowl_minimized.js"></script>

<?php include '../../../includes/php.module/uploader/js/uploader.js.php'?>

<!--  >>>  
/*************************************************************************************************************************
	This script can be used directly as all the features are already set. Am using the .php version of the file to pass
	in dynamic variables like. Multi or single upload. File types, etc.
**************************************************************************************************************************/
<script type="text/javascript">
	var featureID		= "<?php echo SanitizeData($feature_id)?>";
	var navTabID		= "<?php echo SanitizeData($nav_tab_id)?>";
</script>
<script type="text/javascript" src="../../../includes/php.module/uploader/js/uploader.js"></script>
<<< !-->

<link rel="stylesheet" href="../../../includes/php.module/uploader/css/uploadify.css" type="text/css" >
<link rel="stylesheet" href="../../../includes/php.module/uploader/css/uploadify.jGrowl.css" type="text/css" >
<link rel="stylesheet" href="../../../includes/style/admin.space.css" type="text/css" >
<link rel="stylesheet" href="../../../includes/style/form.css" type="text/css" >


<style type="text/css">
</style>


</head>

<body>


<div class="navigation_structure_backend" >
	<div class="title_space title_space2 ">
			<h1><?php echo deSanitizeData($feature_title)?></h1>
			<p class="clear"></p>
	</div>
	
	
	<div class="editor_page">
		<ul>
			<li style="margin-left:0px; background:none; padding-left:0px"><a href="<?php echo $absoluteURL?>admin.space/website.navigation/">Website Navigation</a></li>
			<?php echo html_entity_decode(return_cats_path_nolink(SanitizeData($nav_tab_id),$lang=$_SESSION['languageID'],1))?>
		</ul>
	</div>
	<p class="clear"></p>
		
	<div class="picture_uploader_holder">
		<div id="fileUploadgrow3" class="style3"><strong>Please use a compatible browser</strong></div>
		<p>
		Click on the choose button above, browse your computer and select the files.
		<?php if (getSetting('max_upload',$feature_id)>0) {?>You can upload up to <?php echo deSanitizeData(getSetting('max_upload',$feature_id))?> 
		file(s).<?php }?>
		Each file should not exceed 2MB in size. Once uploaded, click on the thumbnail 
		or icon below to set a 
		description. It is strongly advised to give a brief description for each 
		of them.</p>
	</div>

	<iframe border="0" class="picture_uploader_frame" frameborder="0" marginheight="0" marginwidth="0" name="picture_list" src="list/<?php echo $list_page?>?nav_tab_id=<?php echo $nav_tab_id?>&feature_id=<?php echo $feature_id?>"></iframe>

	
</div>




</body>

</html>