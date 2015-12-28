<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();


$nav_tab_id			= SanitizeData($_GET['id']);

/*************************************************************************************************************************
	SAVE THE LINK
**************************************************************************************************************************/

$link_target	= $_POST['link_target'];
$link_type		= $_POST['link_type'];
$link_external	= $_POST['link_external'];
$link_internal	= $_POST['link_internal'];

if ($link_type == 1)	echo $link	= $link_internal;
if ($link_type == 2)	echo $link	= $link_external;

/*************************************************************************************************************************
	DELETE RECORD FROM TABLE AND ADD A NEW ONE
**************************************************************************************************************************/

$mySQL			= "DELETE FROM link WHERE nav_tab_id = '$nav_tab_id'";
mysql_query($mySQL) or die(mysql_error());

/*************************************************************************************************************************
	....to develop Need to capture the target navigation tab
**************************************************************************************************************************/


$mySQL			= "INSERT INTO link (nav_tab_id, url) VALUES ('$nav_tab_id', '$link')";
mysql_query($mySQL) or die (mysql_error());



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