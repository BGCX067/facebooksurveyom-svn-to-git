<?php 
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$vignette_id		= $_GET['vignette_id'];

$mySQL				= "SELECT * FROM vignette WHERE vignette_id = '$vignette_id'";
$recSET				= mysql_query($mySQL) or die (mysql_error());
$recROW				= mysql_fetch_assoc($recSET);
$nav_tab_id			= $recROW['nav_tab_id'];
$feature_id			= $recROW['feature_id'];

deleteVignette($vignette_id);

$return_path	= $absoluteURL."admin.space/feature.base/vignette.uploader/index.php?id=$nav_tab_id&fid=$feature_id";

header("Location:$return_path");

?>