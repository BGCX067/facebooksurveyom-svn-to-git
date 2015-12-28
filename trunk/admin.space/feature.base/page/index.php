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

<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" >
<link href="../../../includes/style/form.css" rel="stylesheet" type="text/css" >

<style type="text/css">


</style>

</head>

<body>
<form method="post" action="save.php?id=<?php echo SanitizeData($_GET['id']) ?>" class="content_body_form form_class" style="width:750px; margin-right: auto; margin-left: auto;">
	<h2><?php echo $recROW['nav_tab_name']?></h2>
		<div class="editor_page">
		<ul>
			<li style="margin-left:0px; padding:0px; background:none"><a href="<?php echo $absoluteURL?>admin.space/website.navigation/">Website Navigation</a></li>
			<?php echo html_entity_decode(return_cats_path_nolink(SanitizeData($_GET['id']),$lang=$_SESSION['languageID'],1,1))?>
		</ul>
		</div>
		
		<p style="clear:both; padding:10px"></p>

		
		<?php
		
		$navigation_id 			= SanitizeData($_GET['id']);
		$nav_tab_id				= $navigation_id ;
		$feature_id				= SanitizeData($_GET['fid']);
				
		$mySQL	= "SELECT * FROM language WHERE status > 2 ORDER BY usort ASC";
		$recSET	= mysql_query($mySQL) or die (mysql_error());
		
		
		while ($recROW 	= mysql_fetch_assoc($recSET)) {
		
			$language_id	= $recROW['language_id'];
		
			$pageSQL		= "SELECT * FROM page WHERE nav_tab_id = '$nav_tab_id' AND language_id = '$language_id' ";
			$pageSET		= mysql_query($pageSQL) or die(mysql_error());
			$pageROW		= mysql_fetch_assoc($pageSET);
			
			$title			= html_entity_decode($pageROW['pagetitle']);
			$synopsis		= html_entity_decode($pageROW['abstract']);
			$titletag		= html_entity_decode($pageROW['titletag']);	
			$description	= html_entity_decode($pageROW['description']);	
			$keyword		= html_entity_decode($pageROW['keyword']);
			$body			= html_entity_decode($pageROW['body']);

			$default_title_text				= "Page title (".$recROW['language_name'].")";
			$default_synopsis_text			= "Type in a brief description (".$recROW['language_name'].")";
			$default_meta_title_text		= "<Meta Title> (".$recROW['language_name'].")";
			$default_meta_keyword_text		= "<Meta Keyword> (".$recROW['language_name'].")";
			$default_meta_description_text	= "<Meta Description> (".$recROW['language_name'].")";
			
			if (empty($title))			$title		= $default_title_text;
			if (empty($synopsis))		$synopsis	= $default_synopsis_text;
			if (empty($titletag))		$titletag	= $default_meta_title_text;
			if (empty($keyword))		$keyword	= $default_meta_keyword_text;
			if (empty($description))	$description= $default_meta_description_text;
			?>
			
			<div class="content_title"><a href="javascript:animatedcollapse.toggle('content_<?php echo $recROW['language_id']?>')"><?php echo $recROW['language_name']?></a></div>
			<div class="content_body" id="content_<?php echo $recROW['language_id']?>" style="display:<?php if (languageCount() > 1) echo "none"?>; background-color: #F4F4F4;">
				
				<p><input type="text" name="title<?php echo $recROW['language_id']?>" value="<?php echo $title?>" onfocus="if (this.value=='<?php echo $default_title_text?>') {this.value = '';}" onblur="if(this.value=='') {this.value = '<?php echo $default_title_text?>';}" ></p>
				<p><textarea name="abstract<?php echo $recROW['language_id']?>" cols="20" rows="2" onfocus="if (this.value=='<?php echo $default_synopsis_text?>') {this.value = '';}" onblur="if(this.value=='') {this.value = '<?php echo $default_synopsis_text?>';}" ><?php echo $synopsis?></textarea></p>
				
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
	
				<p><input type="text" name="titletag<?php echo $recROW['language_id']?>" value="<?php echo $titletag?>" onfocus="if (this.value=='<?php echo $default_meta_title_text?>') {this.value = '';}" onblur="if(this.value=='') {this.value = '<?php echo $default_meta_title_text?>';}" ></p>
				<p><input type="text" name="keyword<?php echo $recROW['language_id']?>" value="<?php echo $keyword?>" onfocus="if (this.value=='<?php echo $default_meta_keyword_text?>') {this.value = '';}" onblur="if(this.value=='') {this.value = '<?php echo $default_meta_keyword_text?>';}" ></p>
				<p><input type="text" name="description<?php echo $recROW['language_id']?>" value="<?php echo $description?>" onfocus="if (this.value=='<?php echo $default_meta_description_text?>') {this.value = '';}" onblur="if(this.value=='') {this.value = '<?php echo $default_meta_description_text?>';}" ></p>
			</div>
			
			<script type="text/javascript">	animatedcollapse.addDiv('content_<?php echo $recROW['language_id']?>', 'fade=0,speed=1000')</script>
	
	<?php }?>

	<div style="border-top-style: dotted; border-top-width: 1px; border-top-color: #C0C0C0">
	
		<button type="submit" class="buttton" style="float:left; margin:15px 0px 15px 0px"><span>Save</span></button>
				
	</div>
</form>
</body>

</html>