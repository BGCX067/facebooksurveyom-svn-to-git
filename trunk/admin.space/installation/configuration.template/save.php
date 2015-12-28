<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

/*************************************************************************************************************************
	QUERY THE TABLE GET THE FIELDS NAME AND SAVE THE DATA
**************************************************************************************************************************/

$template_id	= $_GET['template_id'];
$mySQL			= "SHOW COLUMNS FROM template WHERE Field <> 'template_id'";
$recSET			= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) {

	$field_name		= $recROW['Field'];
	echo $value			= $_POST["$field_name"];

	echo $updateSQL	= "UPDATE template SET $field_name = '$value' WHERE template_id = '$template_id'";
	mysql_query($updateSQL);
}
?>

<head>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>

<div class="messageBox">
	<h1>Setting saved</h1>
	<p>Your changes has been saved.</p><br><br>
<input name="Submit1" type="button" value="Website Setup" onclick="window.location='<?php echo $absoluteURL."admin.space/installation/setup/"?>' ">
</div>