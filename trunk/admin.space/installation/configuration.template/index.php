<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$template_id		= SanitizeData($_GET['template_id']);

$mySQL		= "SELECT * FROM template WHERE template_id = '$template_id'";
$recSET		= mysql_query($mySQL) or die (mysql_error());
$recROW2	= mysql_fetch_assoc($recSET);


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
			<p class="clear"></p>
	</div>


	<div id="backend_create_nav" style="display:none" class="hidden_box">
		<form method="post" action="../configuration/create/save.php?feature_id=<?php echo $feature_id?>" class="form_class">
			<h4>Information</h4>
			<p><label>Title</label><input type="text" name="title" style="margin-left:4px;width:295px"></p>
			<p><label>Description</label><textarea name="description" cols="20" rows="2" style="margin-left:4px;height:50px"></textarea></p>
			<button type="submit" class="buttton">
				<span>Create</span>
			</button>
		</form>
	</div>

	
<form action="save.php?template_id=<?php echo SanitizeData($_GET['template_id'])?>" method="post" class="navigation_structure_backend">

<?php

/*************************************************************************************************************************
	GET GENERAL SETTINGS : If feature ID is blank display the general settings
**************************************************************************************************************************/
?>
<h3 class="setting_header"><strong><?php echo $recROW2['template_type']?></strong></h3>
<ul class="settings">

<?php
$mySQL	= "SHOW COLUMNS FROM template WHERE Field <> 'template_id'";
$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) { 
	
	$field_name	= $recROW['Field'];
	
	?>
	
	<li><label><a href="#" title="<?php echo $field_name?>"><?php echo $field_name?></a></label>
	<input name="<?php echo $field_name?>" type="text" value="<?php echo $recROW2[$field_name]?>"></li>
	
<?php }?> 
</ul>




<br><br><br>
<input name="Submit1" type="submit" value="Save configuration">
<input name="Submit1" type="button" value="Cancel" onclick="window.location='<?php echo $absoluteURL."admin.space/installation/setup/"?>' ">

</form>
</div>	

</body>

</html>
