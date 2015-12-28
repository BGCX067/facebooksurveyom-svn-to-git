<?php include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id	= SanitizeData($_GET['id']);
$admin_id			= $_SESSION['admin_login'];


$mySQL				= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$nav_tab_id'";
$recSET				= mysql_query($mySQL);
$recROW				= mysql_fetch_assoc($recSET);
$status				= $recROW['status'];

if($status == '3') {
					$mySQL				= "UPDATE navigation_tab SET status = '2', admin_id = 'Set Invisible - $admin_id' WHERE nav_tab_id = '$nav_tab_id'";
					mysql_query($mySQL);
					}

if($status == '2') {
					$mySQL				= "UPDATE navigation_tab SET status = '3', admin_id = 'Set Visible - $admin_id' WHERE nav_tab_id = '$nav_tab_id'";
					mysql_query($mySQL);
					}

header("Location:$absoluteURL/admin.space/website.navigation/");


?>