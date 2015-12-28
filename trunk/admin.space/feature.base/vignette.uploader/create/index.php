<?php
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id		= $_GET['nav_tab_id'];
$feature_id		= $_GET['feature_id'];
$admin			= $_SESSION['admin_login'];


/*************************************************************************************************************************
	CREATE THE NEW VIGNETTE
**************************************************************************************************************************/

$sort_number	= getUsortNumber('vignette', 'ASC', 'nav_tab_id', $nav_tab_id);
$mySQL	= "INSERT INTO vignette (nav_tab_id, feature_id, title, description, status, date, admin_id, usort) VALUES ('$nav_tab_id', '$feature_id', 'title', 'description', 3, now(), '$admin', '$sort_number')";
mysql_query($mySQL) or die(mysql_error());

header("Location:$absoluteURL/admin.space/feature.base/vignette.uploader/?id=$nav_tab_id&fid=$feature_id");
?>