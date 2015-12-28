<?php
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id	= $_GET['nav_tab_id'];
$feature_id	= $_GET['fid'];

usortpageVignette();

header("Location:../?id=$nav_tab_id&fid=$feature_id");
?>