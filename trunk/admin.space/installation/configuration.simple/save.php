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
	echo $value			= $valuegroup[$i];
	
	if($value <> '') {
						$updateSQL	= "UPDATE settings SET value = '$value' WHERE setting_id = '$i'";
						mysql_query($updateSQL);
						}
}
?>

<head>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>

<div class="messageBox">
	<h1>Setting saved</h1>
	<p>Your changes has been saved.</p>
</div>