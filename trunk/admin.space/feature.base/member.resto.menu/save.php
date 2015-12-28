<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();


$feature_id		= SanitizeData($_GET['fid']);

/**************************************************************************
	MEMBER, RESTO, MENU DETAILS
***********************************************************************/
if($feature_id == '34') {
						$table = 'mr_member';
						$table_id = 'member_id';
						}

if($feature_id == '35') {
						$table = 'mr_resto';
						$table_id = 'resto_id';
						}
						
if($feature_id == '36') {
						$table = 'mr_menu';
						$table_id = 'menu_id';
						}


/*************************************************************************************************************************
	QUERY THE TABLE GET THE FIELDS NAME AND SAVE THE DATA
**************************************************************************************************************************/

$id				= $_GET[$table_id];
$mySQL			= "SHOW COLUMNS FROM $table WHERE Field <> '$table_id' AND Field <> 'nav_tab_id' AND Field <> 'date'";
$recSET			= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) {

	$field_name		= $recROW['Field'];
	$value			= $_POST["$field_name"];

	$updateSQL	= "UPDATE $table SET $field_name = '$value' WHERE $table_id = '$id'";
	mysql_query($updateSQL);
}

?>


<head>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>

<div class="messageBox">
	<h1>Setting saved</h1>
	<p>Your changes has been saved.</p><br><br>
<?php if(!empty($feature_id))	{?>
<input name="Submit1" type="button" value="Website Setup" onclick="window.location='<?php echo $absoluteURL."admin.space/installation/setup/"?>' ">
<?php }?>
</div>