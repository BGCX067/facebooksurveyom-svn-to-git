<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

/*************************************************************************************************************************
	RETRIEVE VALUE FROM ARRAY AND SAVING CORRESPONDING CHANGE AS OCCURED
**************************************************************************************************************************/

$mySQL	= "SELECT * FROM settings";
$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) {

	$i				= $recROW['setting_id'];
	$valuegroup		= SanitizeData($_POST['value']);
	$value			= $valuegroup[$i];
	
	if($value <> '') {
						$updateSQL	= "UPDATE settings SET value = '$value' WHERE setting_id = '$i'";
						mysql_query($updateSQL);
						}
}


$feature_id		= $_GET['feature_id'];
echo $mySQL			= "SHOW COLUMNS FROM feature WHERE Field <> 'feature_id'";
$recSET			= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) {

	$field_name		= $recROW['Field'];
	$value			= $_POST["$field_name"];

	echo $updateSQL	= "UPDATE feature SET $field_name = '$value' WHERE feature_id = '$feature_id'";
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
<?php if(!empty($feature_id))	{?>
<input name="Submit1" type="button" value="Website Setup" onclick="window.location='<?php echo $absoluteURL."admin.space/installation/setup/"?>' ">
<?php }?>
</div>