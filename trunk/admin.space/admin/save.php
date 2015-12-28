<?php 
include '../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

/*************************************************************************************************************************
	RETRIEVE password FROM ARRAY AND SAVING CORRESPONDING CHANGE AS OCCURED
**************************************************************************************************************************/

$mySQL	= "SELECT * FROM admin";
$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) {

	$i					= $recROW['admin_id'];
	$passwordgroup		= SanitizeData($_POST['password']);
	$password			= $passwordgroup[$i];
	
		$updateSQL	= "UPDATE admin SET password = '$password' WHERE admin_id = '$i'";
		mysql_query($updateSQL);

}
?>

<head>
<link href="../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>

<div class="messageBox">
	<h1>admin saved</h1>
	<p>Your changes has been saved.</p>
</div>