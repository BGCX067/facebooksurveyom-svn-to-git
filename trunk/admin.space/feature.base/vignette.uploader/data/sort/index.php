<?php
include '../../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id		= $_GET['nav_tab_id'];
$feature_id		= $_GET['fid'];
$vignette_id	= $_GET['vignette_id'];

usortpageVignetteMultemedia();

$return_path	= $absoluteURL."admin.space/feature.base/vignette.uploader/data/list/index.php?nav_tab_id=$nav_tab_id&feature_id=$feature_id&vignette_id=$vignette_id";

header("Location:$return_path");
?>