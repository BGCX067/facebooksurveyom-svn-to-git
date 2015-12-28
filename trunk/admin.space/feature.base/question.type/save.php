<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id				= SanitizeData($_GET['id']);
$question_type			= SanitizeData($_POST['question_type']);



$mySQL	= "SELECT * FROM question_type WHERE nav_tab_id = '$nav_tab_id'";
$recSET	= mysql_query($mySQL) or die (mysql_error());
$count  = mysql_numrows($recSET);

if ($count == 0)    $mySQL = "INSERT INTO question_type (nav_tab_id, question_type, status, date) VALUE ('$nav_tab_id', '$question_type', 3, now())";
if ($count > 0)     $mySQL = "UPDATE question_type SET question_type ='$question_type' WHERE nav_tab_id ='$nav_tab_id'";
mysql_query($mySQL);

header("Location:$absoluteURL"."admin.space/website.navigation/");
?>