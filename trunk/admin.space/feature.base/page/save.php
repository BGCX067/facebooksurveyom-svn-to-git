<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id				= SanitizeData($_GET['id']);

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
	
$default_title_text				= "Page title (".$recROW['language_name'].")";
$default_synopsis_text			= "Type in a brief description (".$recROW['language_name'].")";
$default_meta_title_text		= "<Meta Title> (".$recROW['language_name'].")";
$default_meta_keyword_text		= "<Meta Keyword> (".$recROW['language_name'].")";
$default_meta_description_text	= "<Meta Description> (".$recROW['language_name'].")";

$title							= SanitizeData($_POST["title$i"]);
$abstract	 					= SanitizeData($_POST["abstract$i"]);
$titletag	 					= SanitizeData($_POST["titletag$i"]);
$keyword	 					= SanitizeData($_POST["keyword$i"]);
$description					= SanitizeData($_POST["description$i"]);
$body							= SanitizeData($_POST["body$i"]);

if ($title 			== $default_title_text) 			$title			= "";
if ($abstract		== $default_synopsis_text) 			$abstract		= "";
if ($titletag	 	== $default_meta_title_text) 		$titletag		= "";
if ($keyword		== $default_meta_keyword_text) 		$keyword		= "";
if ($description	== $default_meta_description_text) 	$description	= "";
	
	
$title							= htmlentities($title, ENT_QUOTES);
$abstract	 					= htmlentities($abstract, ENT_QUOTES);
$titletag	 					= htmlentities($titletag, ENT_QUOTES);
$keyword	 					= htmlentities($keyword, ENT_QUOTES);
$description					= htmlentities($description, ENT_QUOTES);
$body							= htmlentities($body, ENT_QUOTES);



$admin_id			= "Modify Content - ".$_SESSION['admin_login'];


delete_page_content($nav_tab_id,$i);

$insertSQL		= "INSERT INTO page (nav_tab_id, language_id, pagetitle, titletag, keyword, description, abstract, body, status, date, admin_id)
					VALUES
					('$nav_tab_id', '$i', '$title', '$titletag', '$keyword', '$description', '$abstract', '$body', 'active', now(), '$admin_id')
				";
mysql_query($insertSQL) or die("Error (37)");
}
header("Location:$absoluteURL"."admin.space/website.navigation/");
?>