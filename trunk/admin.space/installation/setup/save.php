<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

/*************************************************************************************************************************
	LOOP THROUGH THE LIST OF active TEMPALTES AND GET THE LIST
**************************************************************************************************************************/

$mySQLt	= "SELECT * FROM template ORDER BY template_type ASC";
$recSETt	= mysql_query($mySQLt) or die (mysql_error());
while ($recROWt = mysql_fetch_assoc($recSETt)) {

	/*************************************************************************************************************************
		FOR EACH TEMPLATE GET THE LIST OF FEATURES
	**************************************************************************************************************************/
	$template_id	= $recROWt['template_id'];
	$mySQL			= "SELECT * FROM feature ORDER BY usort ASC";
	$recSET			= mysql_query($mySQL) or die (mysql_error());
	while ($recROW 	= mysql_fetch_assoc($recSET)) {
		
		/*************************************************************************************************************************
			CHECK IF THERE HAS BEEN AN ENTRY IN THE template_feature TABLE IF NOT INSERT ONE
		**************************************************************************************************************************/		
	
		$feature_id	= $recROW['feature_id'];
		$name		= "t$template_id"."f$feature_id";
		$checkbox	= SanitizeData($_POST["$name"]);		
		$mySQLc		= "SELECT * FROM template_feature WHERE template_id = '$template_id' AND feature_id = '$feature_id'";
		$recSETc	= mysql_query($mySQLc) or die (mysql_error());
		
		if (mysql_num_rows($recSETc) == 0) 	mysql_query("INSERT INTO template_feature (template_id, feature_id) VALUES ('$template_id', '$feature_id')");
		
		
		/*************************************************************************************************************************
			CHECK THE STATUS OF THE FEATURE. IF CHECKBOX IS ON SET STATUS TO 1 OTHERWISE SET STATUS TO 0
		**************************************************************************************************************************/
		
		if ($checkbox == "on")	$status	= 1;
		if ($checkbox <> "on")	$status	= 0;
		
		mysql_query("UPDATE template_feature SET status = '$status' WHERE template_id ='$template_id' AND feature_id ='$feature_id'");
	
	}

}


?>

<head>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>

<div class="messageBox">
	<h1>Setting saved</h1>
	<p>Your changes has been saved.</p>
</div>