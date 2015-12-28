<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$feature_id		= SanitizeData($_GET['feature_id']);
if(isset($_GET['display']) && isset($_GET['setting_id'])){
	$the_display =(int) $_GET['display'];
	if(empty($the_display)) $the_display = "";
	$the_setting_id =(int) $_GET['setting_id'];
	$mySQL = "UPDATE settings
		SET display = '$the_display'
		WHERE setting_id = '$the_setting_id'
	";
	$recSET = mysql_query($mySQL) or die();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
<title>Untitled 1</title>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" >
<link href="../../../includes/style/form.css" rel="stylesheet" type="text/css" >

<script type="text/javascript" src="../../../includes/javascript/jquery.animated.collapse.js"></script>
<script type="text/javascript" src="../../../includes/javascript/jquery.animated.collapse.code.js"></script>

</head>

<body>

<div class="navigation_structure_backend">
	<div class="title_space">
			<h1>Set configuration parameters</h1>
			<h2><a href="javascript:animatedcollapse.toggle('backend_create_nav')">Create new</a></h2>
			<p class="clear"></p>
	</div>


	<div id="backend_create_nav" style="display:none" class="hidden_box">
		<form method="post" action="create/save.php?feature_id=<?php echo $feature_id?>" class="form_class">
			<h4>Information</h4>
			<p><label>Title</label><input type="text" name="title" style="margin-left:4px;width:295px"></p>
			<p><label>Description</label><textarea name="description" cols="20" rows="2" style="margin-left:4px;height:50px"></textarea></p>
			<button type="submit" class="buttton">
				<span>Create</span>
			</button>
		</form>
	</div>

	
<form action="save.php?feature_id=<?php echo SanitizeData($_GET['feature_id'])?>" method="post" class="navigation_structure_backend">

<?php

/*************************************************************************************************************************
	GET GENERAL SETTINGS : If feature ID is blank display the general settings
**************************************************************************************************************************/
if(empty($feature_id)) { ?>
	<h3 class="setting_header"><strong>General Settings</strong></h3>
	<ul class="settings">
	<?php
	$mySQL	= "SELECT * FROM settings WHERE feature_id = '0'";
	$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
	while($recROW	= mysql_fetch_assoc($recSET)) { 
	$display_icon = '<a href="index.php?display=1&setting_id='.$recROW['setting_id'].'" title="Add to Simple Configuration"><img src="'.$absoluteURL.'multimedia/pictures/template/admin.space/layout.pictures/accept.png"></a>';
	if($recROW['display']) 	$display_icon = '<a href="index.php?display=&setting_id='.$recROW['setting_id'].'" title="Remove from Simple Configuration"><img src="'.$absoluteURL.'multimedia/pictures/template/admin.space/layout.pictures/cancel.png"></a>';


		?>
		<li><label><a href="#" title="<?php echo $recROW['description']?>"><?php echo $recROW['title']?></a></label>
		<input name="value[<?php echo $recROW['setting_id']?>]" type="text" value="<?php echo $recROW['value']?>">&nbsp;<?php echo $display_icon ?> </li>
	<?php }?> 
	</ul>
<?php }?>
	



<?php
/*************************************************************************************************************************
	GET SETTINGS PER FEATURE
**************************************************************************************************************************/
//if(empty($feature_id))	$mySQLf	= "SELECT feature_id, title FROM feature WHERE feature_id IN (SELECT feature_id FROM settings)";
if(!empty($feature_id))	{
	$mySQLf			= "SELECT feature_id, title FROM feature WHERE feature_id = '$feature_id'";
	$recSETf		= mysql_query($mySQLf) or die ("Error occured".mysql_error());
	while($recROWf	= mysql_fetch_assoc($recSETf)) {
		$feature_id		= $recROWf['feature_id'];
		?>
		<h3 class="setting_header"><strong><?php echo $recROWf['title']?> </strong></h3>
		<ul class="settings">
		<?php
		$mySQL	= "SELECT * FROM settings WHERE feature_id = '$feature_id' ORDER BY feature_id";
		$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
		while($recROW	= mysql_fetch_assoc($recSET)) { 
		?>
			<li><label><a href="#" title="<?php echo $recROW['description']?>"><?php echo $recROW['title']?></a></label>
			<input name="value[<?php echo $recROW['setting_id']?>]" type="text" value="<?php echo $recROW['value']?>"></li>
		<?php }?>
		</ul>
	<?php }?>



	<?php
	/*************************************************************************************************************************
		GET THE TEMPLATE DETAILS ITSELF
	**************************************************************************************************************************/	
	$mySQL		= "SELECT * FROM feature WHERE feature_id = '$feature_id'";
	$recSET		= mysql_query($mySQL) or die (mysql_error());
	$recROW2	= mysql_fetch_assoc($recSET);
	
	?>

	<h3 class="setting_header"><strong><?php echo $recROW2['title']?> (Base Configuration)</strong></h3>
	<ul class="settings">
	
	
	<?php
	$mySQL	= "SHOW COLUMNS FROM feature WHERE Field <> 'feature_id'";
	$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
	while($recROW	= mysql_fetch_assoc($recSET)) { 
		
		$field_name	= $recROW['Field'];
		
		?>
		
		<li><label><a href="#" title="<?php echo $field_name?>"><?php echo $field_name?></a></label>
		<input name="<?php echo $field_name?>" type="text" value="<?php echo $recROW2[$field_name]?>"></li>
		
	<?php }?> 
	</ul>


<?php }?>


<br><br><br>
<input name="Submit1" type="submit" value="Save configuration">
<?php if(!empty($feature_id))	{?>
<input name="Submit1" type="button" value="Cancel" onclick="window.location='<?php echo $absoluteURL."admin.space/installation/setup/"?>' ">
<?php }?>

</form>
</div>	

</body>

</html>
