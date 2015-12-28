<?php 
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$usort			= getUsortNumber(feature, 'ASC');

$mySQL			= "INSERT INTO feature (date, status, usort) VALUES (now(), 3, $usort)";
mysql_query($mySQL);

$feature_id		= mysql_insert_id();
$mySQL			= "INSERT INTO settings (title, feature_id, date) VALUES ('link', '$feature_id	', now())";

mysql_query($mySQL) or die(mysql_error());
$mySQL			= "INSERT INTO settings (title, feature_id, date) VALUES ('icon', '$feature_id	', now())";
mysql_query($mySQL) or die(mysql_error());



header("Location:../../setup/index.php?feature_id=$feature_id");
?>