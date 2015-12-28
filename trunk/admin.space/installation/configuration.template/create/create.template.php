<?php 
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$mySQL			= "INSERT INTO template (date, status) VALUES (now(), 3)";
mysql_query($mySQL);


header("Location:../../setup/index.php");
?>