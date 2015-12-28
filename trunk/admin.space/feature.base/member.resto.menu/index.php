<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$feature_id		= SanitizeData($_GET['fid']);

/**************************************************************************
	MEMBER, RESTO, MENU DETAILS
***********************************************************************/
if($feature_id == '34') {
						$table = 'mr_member';
						$table_id = 'member_id';
						}

if($feature_id == '35') {
						$table = 'mr_resto';
						$table_id = 'resto_id';
						}
						
if($feature_id == '36') {
						$table = 'mr_menu';
						$table_id = 'menu_id';
						}



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
			<h1>Member details</h1>
			<p class="clear"></p>
	</div>

<?php
/*************************************************************************************************************************
	CHECKS IF MEMBER ALREADY HAS A RECORD IN THE MEMBER TABLE. IF NOT CREATE ONE
**************************************************************************************************************************/
$id		= $_GET['id'];
$mySQL	= "SELECT * FROM $table WHERE nav_tab_id = ".SanitizeData($_GET['id']);
$recSET	= mysql_query($mySQL) or die('Cannot find member in member table');

if (mysql_num_rows($recSET) < 1) {
	$mySQL		= "INSERT INTO $table (nav_tab_id, date) VALUES ($id, now())";
	mysql_query($mySQL);
	$id	= mysql_insert_id();
} else {
	$recROW 	= mysql_fetch_assoc($recSET);
	$id	= $recROW[$table_id];
}
?>
	
<form action="save.php?<?php echo $table_id?>=<?php echo $id?>&fid=<?php echo $feature_id?>" method="post" class="navigation_structure_backend">

<?php
/*************************************************************************************************************************
	LOOP THROUGH THE MEMBER TABLE AND DISPLAY THE FIELDS
**************************************************************************************************************************/
?>

<ul class="settings">

<?php
$mySQL		= "SELECT * FROM $table WHERE $table_id = '$id'";
$recSET		= mysql_query($mySQL) or die (mysql_error());
$recROW2	= mysql_fetch_assoc($recSET);

$mySQL	= "SHOW COLUMNS FROM $table WHERE Field <> '$table_id' AND Field <> 'nav_tab_id' AND Field <> 'date'";
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
<input name="Submit1" type="button" value="Cancel" onclick="window.location='<?php echo $absoluteURL."admin.space/website.navigation/"?>' ">

</form>
</div>	

</body>

</html>
