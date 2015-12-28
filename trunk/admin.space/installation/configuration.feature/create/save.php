<?php 
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$feature_id		= SanitizeData($_GET['feature_id']);
$title			= SanitizeData($_POST['title']);
$description	= SanitizeData($_POST['description']);


if(empty($feature_id))	$mySQL	= "INSERT INTO settings (title, description) VALUES ('$title', '$description')";
if(!empty($feature_id))	$mySQL	= "INSERT INTO settings (title, description, feature_id) VALUES ('$title', '$description', '$feature_id')";
mysql_query($mySQL) or die(mysql_error());

header("Location:../index.php?feature_id=$feature_id");
?>