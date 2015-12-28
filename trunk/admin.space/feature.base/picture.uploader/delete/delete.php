<?php 
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$multimedia_id		= $_GET['multimedia_id'];

$mySQL				= "SELECT * FROM multimedia WHERE multimedia_id = '$multimedia_id'";
$recSET				= mysql_query($mySQL) or die (mysql_error());
$recROW				= mysql_fetch_assoc($recSET);
$nav_tab_id			= $recROW['nav_tab_id'];
$feature_id			= $recROW['feature_id'];

deleteMultimedia($multimedia_id);


/*************************************************************************************************************************
	CHOSE THE LIST PAGE
**************************************************************************************************************************/

$list_page		= GetSetting('list_type', $feature_id);
if (empty($list_page)) $list_page = 'index.php';


$return_path	= $absoluteURL."admin.space/feature.base/picture.uploader/list/$list_page?nav_tab_id=$nav_tab_id&feature_id=$feature_id";

header("Location:$return_path");

?>