<?php
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id	= $_GET['nav_tab_id'];
$feature_id	= $_GET['fid'];

usortpageMultemedia();

/*************************************************************************************************************************
	CHOSE THE LIST PAGE
**************************************************************************************************************************/

$list_page		= GetSetting('list_type', $feature_id);
if (empty($list_page)) $list_page = 'index.php';




header("Location:../list/$list_page?nav_tab_id=$nav_tab_id&feature_id=$feature_id");
?>