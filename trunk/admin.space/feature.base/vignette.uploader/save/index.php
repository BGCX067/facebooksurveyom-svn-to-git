<?php 
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();


$vignette_id			= SanitizeData($_GET['vignette_id']);

$titlegroup				= SanitizeData($_POST['title']);
$abstractgroup			= SanitizeData($_POST['abstract']);
$titletaggroup			= SanitizeData($_POST['titletag']);
$keywordgroup			= SanitizeData($_POST['keyword']);
$descriptiongroup		= SanitizeData($_POST['description']);
$bodygroup				= SanitizeData($_POST['body']);


$mySQL	= "SELECT * FROM language WHERE status > 0 ORDER BY status DESC";
$recSET	= mysql_query($mySQL) or die (mysql_error());
while ($recROW 	= mysql_fetch_assoc($recSET)) {
$i	= $recROW['language_id'];
	
$title							= SanitizeData($_POST["title$i"]);
$abstract	 					= SanitizeData($_POST["abstract$i"]);
$titletag	 					= SanitizeData($_POST["titletag$i"]);
$keyword	 					= SanitizeData($_POST["keyword$i"]);
$description					= SanitizeData($_POST["description$i"]);
$body							= SanitizeData($_POST["body$i"]);

$title							= htmlentities($title, ENT_QUOTES);
$abstract	 					= htmlentities($abstract, ENT_QUOTES);
$titletag	 					= htmlentities($titletag, ENT_QUOTES);
$keyword	 					= htmlentities($keyword, ENT_QUOTES);
$description					= htmlentities($description, ENT_QUOTES);
$body							= htmlentities($body, ENT_QUOTES);



$admin_id			= "Modify Content - ".$_SESSION['admin_login'];


mysql_query("DELETE FROM page WHERE vignette_id = '$vignette_id' AND language_id = '$i'") or die("Error message 416 ".mysql_error());

$insertSQL		= "INSERT INTO page (vignette_id, language_id, pagetitle, titletag, keyword, description, abstract, body, status, date, admin_id)
					VALUES
					('$vignette_id', '$i', '$title', '$titletag', '$keyword', '$description', '$abstract', '$body', 'active', now(), '$admin_id')
				";
mysql_query($insertSQL) or die("Error (37)");
}


/*************************************************************************************************************************
	GET THE DATA FROM THE TABLE VIGNETTE TO PASS ON THE URL TO RETURN TO THE LIST OF VIGNETTE
**************************************************************************************************************************/
$mySQL	= "SELECT * FROM vignette WHERE vignette_id = '$vignette_id'";
$recSET	= mysql_query($mySQL) or die (mysql_error());
$recROW	= mysql_fetch_assoc($recSET);

$nav_tab_id		= $recROW['nav_tab_id'];
$feature_id		= $recROW['feature_id'];


/*************************************************************************************************************************
	SAVE THE LINK
**************************************************************************************************************************/

$link_target	= $_POST['link_target'];
$link_type		= $_POST['link_type'];
$link_external	= $_POST['link_external'];
$link_internal	= $_POST['link_internal'];

if ($link_type == 1)	$link	= $link_internal;
if ($link_type == 2)	$link	= $link_external;


$mySQL			= "UPDATE vignette SET link = '$link', target = '$link_target' WHERE vignette_id = '$vignette_id'";
mysql_query($mySQL) or die (mysql_error());


$return_url	= $absoluteURL."admin.space/feature.base/vignette.uploader/?id=$nav_tab_id&fid=$feature_id";

header("Location:$return_url");

?>