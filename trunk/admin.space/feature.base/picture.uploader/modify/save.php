<?php
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$multimedia_id	= SanitizeData($_GET['multimedia_id']);
$description	= SanitizeData($_POST['description']);
$mySQL			= "UPDATE multimedia SET description = '$description' WHERE multimedia_id = '$multimedia_id'";
mysql_query($mySQL) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-gb" http-equiv="Content-Language">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

<title>Untitled 1</title>

</head>
<body  onload="self.parent.myLytebox.end();"></body>
</html>