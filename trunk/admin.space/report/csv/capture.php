<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$fromdate	= date("Y-m-d H:i:s", mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']));
$todate		= date("Y-m-d H:i:s", mktime(23, 59, 29, $_POST['monthto'], $_POST['dayto'], $_POST['yearto']));
$fromdate1	= date("Y-m-d", mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']));
$todate1	= date("Y-m-d", mktime(23, 59, 29, $_POST['monthto'], $_POST['dayto'], $_POST['yearto']));


$_SESSION['fromdate1'] 	= $fromdate1;
$_SESSION['todate1'] 	= $todate1;


header("location:output.php");
?>