<?php 
include '../../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$multimedia_id		= $_GET['multimedia_id'];

$mySQL				= "SELECT * FROM multimedia WHERE multimedia_id = '$multimedia_id'";
$recSET				= mysql_query($mySQL) or die (mysql_error());
$recROW				= mysql_fetch_assoc($recSET);
$nav_tab_id			= $recROW['nav_tab_id'];
$feature_id			= $recROW['feature_id'];
$vignette_id		= $recROW['vignette_id'];

deleteMultimedia($multimedia_id);


$return_path	= $absoluteURL."admin.space/feature.base/vignette.uploader/data/list/index.php?nav_tab_id=$nav_tab_id&feature_id=$feature_id&vignette_id=$vignette_id";

header("Location:$return_path");

?>