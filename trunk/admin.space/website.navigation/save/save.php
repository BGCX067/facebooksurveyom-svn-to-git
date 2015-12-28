<?php include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_name		= SanitizeData($_POST['nav_tab_name']);
$template_id		= SanitizeData($_POST['template_id']);
$parentdrop			= SanitizeData($_POST['parentdrop']);
$NodeStructure		= SanitizeData($_POST['NodeStructure']);
$status				= '3';

$admin_id			= "Insert Tab - ".$_SESSION['admin_login'];


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



$insertSQL		= "INSERT INTO navigation_tab (nav_tab_name, template_id, nav_position_id, parent_id, status, date, admin_id)
					VALUES
											('$nav_tab_name', '$template_id', '$nav_position_id', '$parent_id', '$status', now(), '$admin_id')
					";
				
mysql_query($insertSQL);	
$nav_tab_id			= mysql_insert_id();

$updateSQL			= "UPDATE navigation_tab SET admin_id = '$admin_id', usort = '$nav_tab_id' WHERE nav_tab_id = '$nav_tab_id'";
mysql_query($updateSQL);

header("Location:../index.php");

				
?>