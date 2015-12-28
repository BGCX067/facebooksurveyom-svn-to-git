<?php include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();


$nav_tab_id					= SanitizeData($_GET['nav_tab_id']);

$nav_tab_name		= SanitizeData($_POST['nav_tab_name']);
$template_id		= SanitizeData($_POST['template_id']);
$parentdrop			= SanitizeData($_POST['parentdrop']);
$NodeStructure			= SanitizeData($_POST['NodeStructure']);
$status				= '3';

$admin_id			= "Modify Tab - ".$_SESSION['admin_login'];

$parentdrop			= explode(".", $parentdrop);
$ext				= $parentdrop[0];
$id					= $parentdrop[1];

if ($ext == 'nav'){	
					$nav_position_id 	= $id;
				 	$parent_id 			= '0';
					}
					
					
if ($ext == 'par'){
					$parent_id 	= $id;
					$nav_position_id	= '0';
					}

if ($ext <> 'nav' AND $ext <> 'par'){	
									$nav_position_id 	= '0';
								 	$parent_id 			= $NodeStructure;
									}



$updateSQL		= "UPDATE navigation_tab SET
					nav_tab_name 	= '$nav_tab_name', 
					template_id 	= '$template_id',
					nav_position_id = '$nav_position_id',
					parent_id 		= '$parent_id',
					admin_id		= '$admin_id',
					status 			= '$status'
					WHERE 
					nav_tab_id		= '$nav_tab_id';
					";
				
mysql_query($updateSQL);	


header("Location:$absoluteURL/admin.space/website.navigation/");

				
?>