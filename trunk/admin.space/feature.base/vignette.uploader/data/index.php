<?php
include '../../../../includes/configuration/master.configuration.php';
include $docRoot.'includes/php.module/fckeditor/fckeditor.php';	
checkAdminSpaceLogin();

$nav_tab_id		= $_GET['nav_tab_id'];
$vignette_id	= $_GET['vignette_id'];
$feature_id		= $_GET['feature_id'];

$admin			= $_SESSION['admin_login'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>

<script type="text/javascript" src="display.hide.js"></script>
<script type="text/javascript" src="../../../../includes/javascript/jquery.animated.collapse.js"></script>
<script type="text/javascript" src="../../../../includes/javascript/jquery.animated.collapse.code.js"></script>
<script type="text/javascript" src="../../../../includes/javascript/call.navigation.template.js"></script>

<script type="text/javascript" src="../../../../includes/php.module/uploader/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../../../includes/php.module/uploader/js/jquery.uploadify.js"></script>
<script type="text/javascript" src="../../../../includes/php.module/uploader/js/jquery.jgrowl_minimized.js"></script>


<?php include $docRoot.'includes/php.module/uploader/js/uploader.js.php'?>

<link rel="stylesheet" href="../../../../includes/php.module/uploader/css/uploadify.css" type="text/css" >
<link rel="stylesheet" href="../../../../includes/php.module/uploader/css/uploadify.jGrowl.css" type="text/css" >

<link href="../../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" >
<link href="../../../../includes/style/form.css" rel="stylesheet" type="text/css" >

<style type="text/css">
.fileUploadQueueItem {
	width: 200px;
}

.vignette_uploader_link_box {
	background-color: #f7f7f7;
	border: 1px solid #c0c0c0;
	padding: 15px 20px 15px 20px;
	margin-top:20px;
}
.vignette_uploader_link_box select, .vignette_uploader_link_box input {
	font-size: 9pt;
	font-family: Arial, Helvetica, sans-serif;
	width: 280px;
	margin: 0px 0px 5px 0px;
}
.vignette_uploader_link_box input {
	width: 275px;
}
.vignette_uploader_link_box h5 {
	margin:0px 0px 5px 0px;
	font-size:14pt;
	font-family:Verdana;
	font-weight:normal;
}
</style>

</head>

<body>
<form name="vignette_data" target="body" method="post" action="../save/?vignette_id=<?php echo $vignette_id?>&nav_tab_id=<?php echo $nav_tab_id?>&feature_id=<?php echo $feature_id?>">
<div class="vignette_uploader_1">
	<div class="vignette_uploader_2">
		<h2>Picture Uploader</h2>
		<div class="picture_uploader_holder">
			<div id="fileUploadgrow3" class="style3"><strong>Please use a compatible browser</strong></div>
			<p>
			<?php if (getSetting('max_upload',$feature_id)>0) {?>You can upload up to <?php echo deSanitizeData(getSetting('max_upload',$feature_id))?> picture(s).<?php }?>
			Each picture should not exceed 2MB in size.
			</p>
		</div>
	<iframe border="0" frameborder="0" marginheight="0" marginwidth="0" name="picture_list" src="list/index.php?vignette_id=<?php echo $vignette_id?>&feature_id=<?php echo $feature_id?>" class="vignette_uploader_4"></iframe>
	
	</div>
	<div class="vignette_uploader_3">
	
	
		<?php
						
		$mySQL	= "SELECT * FROM language WHERE status > 2 ORDER BY usort ASC";
		$recSET	= mysql_query($mySQL) or die (mysql_error());
		
		
		while ($recROW 	= mysql_fetch_assoc($recSET)) {
		
			$language_id	= $recROW['language_id'];
		
			$pageSQL		= "SELECT * FROM page WHERE vignette_id = '$vignette_id' AND language_id = '$language_id' ";
			$pageSET		= mysql_query($pageSQL) or die(mysql_error());
			$pageROW		= mysql_fetch_assoc($pageSET);
			
			$title			= html_entity_decode($pageROW['pagetitle']);
			$body			= html_entity_decode($pageROW['body']);

			?>
			
			<div class="content_title"><a href="javascript:animatedcollapse.toggle('content_<?php echo $recROW['language_id']?>')"><?php echo $recROW['language_name']?></a></div>
			<div class="content_body" id="content_<?php echo $recROW['language_id']?>" style="display:none; background-color: white">
				
				<p><input type="text" name="title<?php echo $recROW['language_id']?>" value="<?php echo $title?>"></p>				
				<div class="editor_holder">		
					<?php
						$sBasePath 								= $absoluteURL.'includes/php.module/fckeditor/' ;
						$body_text 								= 'body'.$recROW['language_id'] ;
						$oFCKeditor 							= new FCKeditor("$body_text") ;
						$oFCKeditor->BasePath					= $sBasePath ;
						$oFCKeditor->Value						= $body ;
						$oFCKeditor->ToolbarSet 				= GetSetting('toolbar_set', $feature_id);
						$oFCKeditor->Height 					= GetSetting('height', $feature_id);
						//$oFCKeditor->Config['EditorAreaCSS']	= $docRoot.'includes/style/editableregion.css';
						$oFCKeditor->Create() ;
					?>
				</div>
	
			</div>
			
			<script type="text/javascript">	animatedcollapse.addDiv('content_<?php echo $recROW['language_id']?>', 'fade=0,speed=1000')</script>
	
	<?php }?>
	
	<?php 
	$mySQL	= "SELECT * FROM vignette WHERE vignette_id = '$vignette_id'";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);
	
	if (empty($recROW['link']))		$link = "http://www.";
	if (!empty($recROW['link']))	$link = $recROW['link'];
	
	?>
	
	<div class="vignette_uploader_link_box">
		<h5>Hyperlink setting</h5>
		<select name="link_target">
			<option value="_top" <?php if ($recROW['target'] == "_top") echo 'selected'?>>Same Window</option>
			<option value="_blank" <?php if ($recROW['target'] == "_blank") echo 'selected'?>>New Window</option>
		</select>
		<select name="link_type" onchange="javascript:displayhide()">
			<option value="1">Internal Link</option>
			<option value="2" selected>External link</option>
		</select>
		<select name="link_internal" style="display:none">
			<?php echo $internal_url	= CreateParentDropEditor(0,".. ");?>
		
		</select>
		<input type="text" name="link_external" style="display:" value="<?php echo $link?>">
	</div>
	</div>
	<p style="float:right">
	<button  onclick="self.parent.myLytebox.end();"><span>Cancel</span></button>
	<button type="submit"><span>Save and close</span></button>
	</p>

</div>
</form>
</body>

</html>
