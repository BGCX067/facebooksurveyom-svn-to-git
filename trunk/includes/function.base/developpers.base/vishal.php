<?php


/*************************************************************************************************************************
DISPLAY THE NAVIGATION BACKBONE IN THE BACKEND
**************************************************************************************************************************/
function CreateParentPages($class){
	$output = "<ul>";

	$mySQL = "SELECT nav_position_id,nav_position as name,status FROM navigation_position WHERE status > 0";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	$count = 1;
	while($recROW = mysql_fetch_assoc($recSET)){
		$id = $recROW['nav_position_id'];
		$name = ucfirst($recROW['name']);
		$level = $recROW['status'];

		$output .="<li><p class=\"navigation_title\">$name</p></li>";
		$output .= GetChildrenPages($id,$class,$level + 1,1);
		$count++;
	}

	$output	.= "</ul>";

	return $output;
}


/*************************************************************************************************************************
BUILD THE ROW FOR EACH NAVIGATION : Defines names and links
**************************************************************************************************************************/
function GetChildrenPages($parent_id,$class,$level,$start = ""){
	global $absoluteURL;

	if($level < 1) return;
	if(!empty($start)) $parent_check = "nav_position_id = '$parent_id'";
	else $parent_check = "parent_id = '$parent_id'";

	$mySQL = "SELECT settings.feature_id as fid, template.template_id as tid, nav_tab_name as name,nav_tab_id as id,navigation_tab.parent_id,navigation_tab.usort, navigation_tab.status as nav_status, template.template_type as template
	FROM navigation_tab 
	JOIN template 
	ON template.template_id = navigation_tab.template_id 
	JOIN template_feature
	ON template_feature.template_id = template.template_id
	JOIN settings
	ON settings.feature_id = template_feature.feature_id
	WHERE navigation_tab.status > 0 
	AND $parent_check 
	AND navigation_tab.archive_date = '' 
	GROUP BY id
	ORDER BY usort ASC";

	$recSET = mysql_query($mySQL) or die(mysql_error());
	$output = "";
	while($recROW = mysql_fetch_assoc($recSET)){

		$name 			= $recROW['name'];
		$template 		= SpecialTrim($recROW['template'],15);
		$newlevel 		= $level - 1 ;
		$newclass 		= $class + 1;
		$status			= $recROW['nav_status'];

		$id 			= $recROW['id'];
		$pid 			= $recROW['parent_id'];
		$tid 			= $recROW['tid'];
		$usort			= $recROW['usort'];
		$fid			= $recROW['fid'];


		if($status == '3')	$bgcolor = '';
		if($status == '2')	$bgcolor = GetSetting('InvisibleColor');
		if($status > 50)	$bgcolor = '#f9f9f9';

		$output .="	
				<li style='background-color:$bgcolor'>
					<div class=\"column1\"><p class=\"level$class\">$name</p></div>
					<div  class=\"column2 middle_column\">$template</div>
					<div class=\"column3\">".iconList($tid, $id, $pid, $usort, $fid)."		
					</div>
					<div class=\"clear\"></div>
				</li>
		
		";
		$output .=  GetChildrenPages($id,$newclass,$newlevel);
	}
	return $output;
}

/*************************************************************************************************************************
GET ICON LIST : Defines the icon list
**************************************************************************************************************************/
function iconList($template_id, $nav_tab_id, $parent_id, $usort, $fid){
	global $absoluteURL;

	$html	= "<ul class=\"navigation_icon_list\">";

	$mySQL	= "	SELECT * FROM template_feature
				JOIN template ON template.template_id = template_feature.template_id 
				JOIN feature ON feature.feature_id = template_feature.feature_id 
				WHERE template_feature.template_id = '$template_id'
				AND template_feature.status > 0 
				ORDER BY feature.usort ASC
				";

	$recSET	= mysql_query($mySQL) or die (mysql_error());
	while ($recROW = mysql_fetch_assoc($recSET)) {
		$fid	= $recROW['feature_id'];
		$link	= $absoluteURL.GetSetting('link', $fid)."?id=$nav_tab_id&tid=$template_id&pid=$parent_id&usort=$usort&fid=$fid";
		$icon	= $absoluteURL.GetSetting('icon', $fid);
		$hover_text	= GetSetting('hover', $fid);
		
		$text	= $recROW['description'];

		$html	.= "	<li><a href=\"$link\" title=\"$hover_text\"><img alt=\"$text\" src=\"$icon\" class=\"nav_icons\" /></a></li>";
	}

	$html	.= "</ul>";


	$mySQL	= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$nav_tab_id'";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);

	if (!empty($recROW['feature_list'])) {

		$html	= "<ul class=\"navigation_icon_list\">";

		$feature_list	= explode(",", $recROW['feature_list']);

		foreach ($feature_list AS $feature_id)
		{
			$mySQL2		= "SELECT * FROM feature WHERE feature_id = '$feature_id'";
			$recSET2	= mysql_query($mySQL2) or die (mysql_error());
			$recROW2	= mysql_fetch_assoc($recSET2);
			$link		= $absoluteURL.$recROW2['link']."?id=$nav_tab_id&tid=$template_id&pid=$parent_id&usort=$usort&dir=$dir";
			$icon		= $absoluteURL."multimedia/pictures/template/admin.space/icons/".$recROW2['icon'];
			$text		= $recROW2['description'];
			$html		.= "	<li><a href=\"$link\"><img alt=\"$text\" src=\"$icon\" class=\"nav_icons\" /></a></li>";
		}

		$html	.= "</ul>";
	}

	return($html);
}

/*************************************************************************************************************************
CHECK IF A TEMPLATE HAS A FEATURE SET: if yes returns true of no returns false
**************************************************************************************************************************/
function templateFeatureCheck($template_id, $feature_id){

	$mySQL	= "SELECT * FROM template_feature WHERE template_id = '$template_id' AND feature_id = '$feature_id'";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);

	return($recROW['status']);

}




/*************************************************************************************************************************
TRIM CHARACTERS TO A SPECIFIC LENGTH AND ADD ... IF EXCEED LENGTH
**************************************************************************************************************************/

function SpecialTrim($data, $maxlength){

	if (strlen($data) > $maxlength) {

		$temp	= str_split($data, $maxlength-3);
		$data	= $temp[0]."...";

	}
	return($data);


}

/*************************************************************************************************************************
DISPLAY HISTORY BAR
**************************************************************************************************************************/
function return_cats_path($navTabId,$lang=1,$actual ="")
{
	global $absoluteURL;

	if(empty($navTabId) ) return;
	$mySQL = "SELECT navigation_tab.nav_tab_id as Id,navigation_tab.parent_id as subid,pagetitle, template.link FROM navigation_tab JOIN page ON navigation_tab.nav_tab_id = page.nav_tab_id JOIN template ON navigation_tab.template_id = template.template_id WHERE navigation_tab.nav_tab_id = '$navTabId' AND page.language_id = '$lang'";

	$recSET = mysql_query($mySQL) or die("Path error".mysql_error());
	$recROW = mysql_fetch_assoc($recSET);

	$id 	= $recROW['Id'];
	$hlink	= $recROW['link'];
	$subid 	= $recROW['subid'];
	if (!empty($actual)) $link = "<li>$recROW[pagetitle]</li>";
	else $link = "<li><a href=\"".getTabLink($id)."\">$recROW[pagetitle]</a></li>";

	if($subid!=0)
	{

		$link = return_cats_path($recROW['subid'],$lang).$link;


	}
	return $link;
}




/*************************************************************************************************************************
DISPLAY HISTORY BAR  : Without links
**************************************************************************************************************************/
function return_cats_path_nolink($navTabId,$lang=1,$actual ="",$enable_link=0)
{
	global $absoluteURL;

	if(empty($navTabId) ) return;
	$mySQL = "SELECT * FROM navigation_tab JOIN template ON navigation_tab.template_id = template.template_id WHERE navigation_tab.nav_tab_id = '$navTabId'";

	$recSET = mysql_query($mySQL) or die("Path error".mysql_error());
	$recROW = mysql_fetch_assoc($recSET);

	$id 	= $recROW['nav_tab_id'];
	$hlink	= $recROW['link'];
	$subid 	= $recROW['parent_id'];
	$name 	= $recROW['nav_tab_name'];

	if ($enable_link == 1) $link = "<li><a href=\"$absoluteURL"."admin.space/feature.base/page/index.php?id=$id\">$name</a></li>";
	if ($enable_link == 0) $link = "<li>$name</li>";

	if($subid!=0)
	{

		$link = return_cats_path_nolink($subid ,$lang, '', 1).$link;


	}
	return $link;
}


/*************************************************************************************************************************
GENERATE THE DROP DOWN WITH THE TABS DISPLAYED IN A HIRARCHY : For the editor
**************************************************************************************************************************/
function CreateParentDropEditor($parent_id,$spacer,$position=""){
	$position_id = "";
	$actual_id = "";
	if($position) $position_id = (int)$parent_id;
	else $actual_id = (int)$parent_id;


	$mySQL = "SELECT nav_position_id,nav_position as name,status FROM navigation_position WHERE status > 0";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	while($recROW = mysql_fetch_assoc($recSET)){
		$select = "";
		$id = $recROW['nav_position_id'];
		$name = $recROW['name'];
		$level = $recROW['status'];
		if ($position_id == $id) $select = "selected";
		//$output .="<option value=\"nav.$id\" $select>$name</option>";
		$output .= GetParentsEditor($id,1,$spacer,$level,1,$actual_id);

	}

	return $output;
}



function GetParentsEditor($parent_id,$depth,$spacer,$level,$start = "",$actual_id = ""){
	global $absoluteURL;
	if($level < 2) return;
	if(!empty($start)) $parent_check = "nav_position_id = '$parent_id'";
	else $parent_check = "parent_id = '$parent_id'";
	$mySQL = "SELECT *, CONCAT(REPEAT('$spacer', $depth),nav_tab_name)  as name  FROM navigation_tab JOIN template ON template.template_id = navigation_tab.template_id WHERE navigation_tab.status > 0 AND $parent_check  AND archive_date = '' ORDER BY nav_tab_id ASC ";

	$recSET = mysql_query($mySQL) or die(mysql_error());
	$output = "";
	while($recROW = mysql_fetch_assoc($recSET)){
		$select = "";
		$id = (int)$recROW['nav_tab_id'];
		$name = $recROW['name'];
		$newdepth = $depth + 1;
		$newlevel = $level -1 ;

		$hlink = getTabLink($recROW['link']);

		if ((int)$actual_id == (int)$id) $select = "selected";
		$output .="<option value=\"$hlink\" $select>$name</option>";
		$output .=  GetParentsEditor($id,$newdepth,$spacer,$newlevel,"",$actual_id);
	}
	return $output;
}


/*************************************************************************************************************************
CHECK LOGIN IN THE BACKEND
**************************************************************************************************************************/
function checkAdminSpaceLogin() {

	global $absoluteURL;

	if (empty($_SESSION['admin_login'])){
		$location	= $absoluteURL."admin.space/login/";
		header("location:$location");
		exit();
	}

}


/*************************************************************************************************************************
COUNT THE NUMBER OF LANGUAGES SET ACTIVE
**************************************************************************************************************************/
function languageCount() {

	$mySQL	= "SELECT * FROM language WHERE status > 2";
	$recSET	= mysql_query($mySQL) or die (mysql_error());

	return (mysql_num_rows($recSET));

}


/*************************************************************************************************************************
HANDLE MULTI LANGUAGE
**************************************************************************************************************************/

$default_language	= "1";

//if (empty($_SESSION['languageID'])) 		$_SESSION['languageID'] = $default_language;
$_SESSION['languageID'] = $default_language;
if (!isset($cancel_redirect))				$_SESSION['continueURL'] = $_SESSION['continueURL']	= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];;
$_SESSION['continueURL'] 					= makeHttpUrl($_SESSION['continueURL']);

$mySQL			= "SELECT * FROM language WHERE language_id =".$_SESSION['languageID'];
$recSET			= mysql_query($mySQL) or die ('29');
$recROW			= mysql_fetch_assoc($recSET);
$language_file 	= $docRoot."includes/language.file/".$recROW['langfile'];
$flag_file 		= $absoluteURL."/multimedia/pictures/template/template/".$recROW['flag'];

if (file_exists($language_file)) include "$language_file";



/*************************************************************************************************************************
MAKE AN HTTP URL
**************************************************************************************************************************/

function makeHttpUrl($checkurl)
{
	$findme 	= 'http://';
	$checkurl	= str_replace($findme, "", $checkurl);
	$checkurl	= str_replace("//", "/", $checkurl);
	$pos 		= strpos($checkurl, $findme);

	if ($pos === false) {
		$finalurl	= "http://".$checkurl;
	}else {
		$finalurl	=  $checkurl;
	}



	return($finalurl);
}

/*************************************************************************************************************************
SANITIZE DATA : Clear all the unwanted characters
**************************************************************************************************************************/

function SanitizeData($rawData) {

	$output	= 	$rawData;

	return($output);
}

/*************************************************************************************************************************
DESANITIZE DATA : Return all data in their original format and hopefully display frech chars
**************************************************************************************************************************/

function deSanitizeData($rawData) {

	$output	= 	$rawData;

	return($output);
}

/*************************************************************************************************************************
SORTING MULTIMEDIA FILE
**************************************************************************************************************************/
function usortpageMultemedia(){

	$admin_id	= $_SESSION['admin_login'];

	if (isset($_GET['id']) && isset($_GET['nav_tab_id']) && isset($_GET['usort']) && isset($_GET['fid'])) {

		$dir 	= $_GET['dir'];
		$id 	= (int) $_GET['id'];
		$fid 	= (int) $_GET['fid'];
		$usort 	= (int) $_GET['usort'];
		$pid 	= (int) $_GET['nav_tab_id'];
		$value	= GetSetting('Dir',$fid);

		switch ($dir) {
			case 'down':
				$sql 		= "SELECT multimedia_id,usort FROM multimedia WHERE usort > '$usort'  AND nav_tab_id = '$pid' AND feature_id = '$fid' ORDER BY usort ASC LIMIT 1";
				$set 		= mysql_query($sql) or die(mysql_error());
				if ($row 	= mysql_fetch_assoc($set)){

					$swap_id 		= $row['multimedia_id'];
					$swap_usort 	= $row['usort'];
					$sql 			= "UPDATE multimedia SET admin_id = 'Sort - $admin_id', usort = CASE multimedia_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE multimedia_id IN ($id, $swap_id)";

				}
				else {
					$usort++;
					$sql = "UPDATE multimedia SET admin_id = '$admin_id', usort = '$usort' WHERE multimedia_id = '$id'";


				}
				break;

			case 'up':
				$sql = "SELECT multimedia_id,usort FROM multimedia WHERE usort < '$usort' AND  nav_tab_id = '$pid' AND feature_id = '$fid' ORDER BY usort DESC LIMIT 1";
				$set = mysql_query($sql) or die(mysql_error());
				if ($row = mysql_fetch_assoc($set)){

					$swap_id = $row['multimedia_id'];
					$swap_usort = $row['usort'];
					$sql = "UPDATE multimedia SET admin_id = 'Sort - $admin_id', usort = CASE multimedia_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE multimedia_id IN ($id, $swap_id) ";

				}
				else {
					$usort--;
					$sql = "UPDATE multimedia SET admin_id = '$admin_id', usort = '$usort' WHERE multimedia_id = '$id'";
				}

				break;


			default:
				$swap 	= $id;
		}
		//	die($sql);
		$result 	= mysql_query($sql) or die(mysql_error());
		$return;
	}

	else return;
}



/*************************************************************************************************************************
SORTING VIGNETTE MULTIMEDIA FILE
**************************************************************************************************************************/
function usortpageVignetteMultemedia(){

	$admin_id	= $_SESSION['admin_login'];

	if (isset($_GET['id']) && isset($_GET['vignette_id']) && isset($_GET['usort']) && isset($_GET['fid'])) {

		$dir 	= $_GET['dir'];
		$id 	= (int) $_GET['id'];
		$fid 	= (int) $_GET['fid'];
		$usort 	= (int) $_GET['usort'];
		$pid 	= (int) $_GET['vignette_id'];
		$value	= GetSetting('Dir',$fid);

		switch ($dir) {
			case 'down':
				$sql 		= "SELECT multimedia_id,usort FROM multimedia WHERE usort > '$usort'  AND vignette_id = '$pid' AND feature_id = '$fid' ORDER BY usort ASC LIMIT 1";
				$set 		= mysql_query($sql) or die(mysql_error());
				if ($row 	= mysql_fetch_assoc($set)){

					$swap_id 		= $row['multimedia_id'];
					$swap_usort 	= $row['usort'];
					$sql 			= "UPDATE multimedia SET admin_id = 'Sort - $admin_id', usort = CASE multimedia_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE multimedia_id IN ($id, $swap_id)";

				}
				else {
					$usort++;
					$sql = "UPDATE multimedia SET admin_id = '$admin_id', usort = '$usort' WHERE multimedia_id = '$id'";


				}
				break;

			case 'up':
				$sql = "SELECT multimedia_id,usort FROM multimedia WHERE usort < '$usort' AND  vignette_id = '$pid' AND feature_id = '$fid' ORDER BY usort DESC LIMIT 1";
				$set = mysql_query($sql) or die(mysql_error());
				if ($row = mysql_fetch_assoc($set)){

					$swap_id = $row['multimedia_id'];
					$swap_usort = $row['usort'];
					$sql = "UPDATE multimedia SET admin_id = 'Sort - $admin_id', usort = CASE multimedia_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE multimedia_id IN ($id, $swap_id) ";

				}
				else {
					$usort--;
					$sql = "UPDATE multimedia SET admin_id = '$admin_id', usort = '$usort' WHERE multimedia_id = '$id'";
				}

				break;


			default:
				$swap 	= $id;
		}
		//	die($sql);
		$result 	= mysql_query($sql) or die(mysql_error());
		$return;
	}

	else return;
}

/*************************************************************************************************************************
	SORT THE VIGNETTES
**************************************************************************************************************************/

function usortpageVignette(){

	$admin_id	= $_SESSION['admin_login'];

	if (isset($_GET['id']) && isset($_GET['nav_tab_id']) && isset($_GET['usort']) && isset($_GET['fid'])) {

		$dir 	= $_GET['dir'];
		$id 	= (int) $_GET['id'];
		$fid 	= (int) $_GET['fid'];
		$usort 	= (int) $_GET['usort'];
		$pid 	= (int) $_GET['nav_tab_id'];

		switch ($dir) {
			case 'down':
				$sql 		= "SELECT vignette_id,usort FROM vignette WHERE usort > '$usort'  AND nav_tab_id = '$pid' AND feature_id = '$fid' ORDER BY usort ASC LIMIT 1";
				$set 		= mysql_query($sql) or die(mysql_error());
				if ($row 	= mysql_fetch_assoc($set)){

					$swap_id 		= $row['vignette_id'];
					$swap_usort 	= $row['usort'];
					$sql 			= "UPDATE vignette SET admin_id = 'Sort - $admin_id', usort = CASE vignette_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE vignette_id IN ($id, $swap_id)";

				}
				else {
					$usort++;
					$sql = "UPDATE vignette SET admin_id = '$admin_id', usort = '$usort' WHERE vignette_id = '$id'";


				}
				break;

			case 'up':
				$sql = "SELECT vignette_id,usort FROM vignette WHERE usort < '$usort' AND  nav_tab_id = '$pid' AND feature_id = '$fid' ORDER BY usort DESC LIMIT 1";
				$set = mysql_query($sql) or die(mysql_error());
				if ($row = mysql_fetch_assoc($set)){

					$swap_id = $row['vignette_id'];
					$swap_usort = $row['usort'];
					$sql = "UPDATE vignette SET admin_id = 'Sort - $admin_id', usort = CASE vignette_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE vignette_id IN ($id, $swap_id) ";

				}
				else {
					$usort--;
					$sql = "UPDATE vignette SET admin_id = '$admin_id', usort = '$usort' WHERE vignette_id = '$id'";
				}

				break;


			default:
				$swap 	= $id;
		}
		//	die($sql);
		$result 	= mysql_query($sql) or die(mysql_error());
		$return;
	}

	else return;
}

/*************************************************************************************************************************
	GET THE USORT NUMBER FOR A NEW RECORD. $parent_field and $parent_id is used if the sorting is done within a group.
**************************************************************************************************************************/
function getUsortNumber($table_name, $order_position, $parent_field = '', $parent_id = '')
{
	if (!empty($parent_field)) $mySQL	= "SELECT * FROM $table_name WHERE $parent_field = $parent_id ORDER BY usort $order_position";
	if (empty($parent_field)) $mySQL	= "SELECT * FROM $table_name ORDER BY usort $order_position";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);
	
	if ($order_position == "ASC")	$sort_number	= $recROW['usort'] - 1;
	if ($order_position == "DESC")	$sort_number	= $recROW['usort'] + 1;
	
	return($sort_number);
}


/*************************************************************************************************************************
	GET THE PICTURES FOR A MULTIMEDIA. picture_size can be: original, large, medium, small. root can be yes or no. 
	If set to yes root path will be returned.
**************************************************************************************************************************/
function getMultimediaPicture($multimedia_id, $picture_size, $root='')
{
	global $absoluteURL;
	global $docRoot;
		
	$mySQL		= "SELECT * FROM multimedia WHERE multimedia_id = '$multimedia_id' AND status > 0";
	$recSET		= mysql_query($mySQL) or die (mysql_error());
	$recROW		= mysql_fetch_assoc($recSET);
	
	$setting	= "target_".$picture_size;
	
	if ($root == 'yes')	$output	= $docRoot.GetSetting($setting,$recROW['feature_id']).$multimedia_id.$recROW['extension'];
	if ($root <> 'yes')	$output	= $absoluteURL.GetSetting($setting,$recROW['feature_id']).$multimedia_id.$recROW['extension'];
	
	return($output);
		

}


/*************************************************************************************************************************
	GET THE PICTURES FOR A MULTIMEDIA. picture_size can be: original, large, medium, small. root can be yes or no. 
**************************************************************************************************************************/
function getVignetteMultimediaPicture($vignette_id, $feature_id, $picture_size, $root='')
{
	
	$mySQL		= "SELECT * FROM multimedia WHERE vignette_id = '$vignette_id' AND feature_id = '$feature_id' AND status > 0 ORDER BY usort ASC";
	$recSET		= mysql_query($mySQL) or die (mysql_error());
	$recROW		= mysql_fetch_assoc($recSET);
	
	$multimedia_id	= $recROW['multimedia_id'];
	
	
	$output	= getMultimediaPicture($multimedia_id, $picture_size, $root);
	
	return($output);
		

}




/*************************************************************************************************************************
	IMAGE RESIZE 
**************************************************************************************************************************/


function imageresize($filename_x, $output_x, $width_x, $height_x, $format_x)
{
	
	list($width, $height) = getimagesize($filename_x);	
	
	$filename 	= $filename_x;
	$output		= $output_x;
	$new_width 	= $width_x;
	$new_height = $height_x;
	$format		= $format_x;
	
	$image_p 	= imagecreatetruecolor($new_width, $new_height);
	
	if ($format == "jpg") $image = imagecreatefromjpeg($filename);
	if ($format == "gif") $image = imagecreatefromgif($filename);
	if ($format == "png") $image = imagecreatefrompng($filename);
	
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	if ($format == "jpg") imagejpeg($image_p, $output, 90);
	if ($format == "gif") imagegif($image_p, $output, 90);
	if ($format == "png") imagepng($image_p, $output, 90);
}



function processImage($source, $destination, $newheight, $newwidth, $extension)
{
	$source 		= str_replace('//', '/', $source);
	$destination	= str_replace('//', '/', $destination);
	
	//echo $source;
	
	if (file_exists($source)) {
		
		$format_x	= strtolower(str_replace('.', '', $extension));

		list($width, $height) = getimagesize($source);	
		
		$height_x	= $height;
		$width_x	= $width;
		
		if ($height > $newheight AND $newheight > 0){
			$height_x	= $newheight;
			$width_x 	= $width / ($height / $height_x) ;
		
		}

		if ($width > $newwidth AND $newwidth > 0){
			$width_x	= $newwidth;
			$height_x 	= $height / ($width / $width_x) ;
		
		}

		imageresize($source, $destination, $width_x, $height_x, $format_x);
	}
}

/*************************************************************************************************************************
	DELETE MULTIMEDIA
**************************************************************************************************************************/
function deleteMultimedia($multimedia_id) 
{	
	
	$original_image		= getMultimediaPicture($multimedia_id, 'original', 'yes');
	$large_image		= getMultimediaPicture($multimedia_id, 'large', 'yes');
	$extra_large_image	= getMultimediaPicture($multimedia_id, 'extra_large', 'yes');
	$medium_image		= getMultimediaPicture($multimedia_id, 'medium', 'yes');
	$small_image		= getMultimediaPicture($multimedia_id, 'small', 'yes');
	
	if(file_exists($original_image))unlink($original_image);
	if(file_exists($large_image))unlink($large_image);
	if(file_exists($extra_large_image))unlink($extra_large_image);
	if(file_exists($medium_image))unlink($medium_image);
	if(file_exists($small_image))unlink($small_image);
	
	$mySQL			= "UPDATE multimedia SET status = 0 WHERE multimedia_id = '$multimedia_id'";
	mysql_query($mySQL);
}


/*************************************************************************************************************************
	DELETE A VIGNETTE AND RELATED MULTIMEDIA ATTACHED
**************************************************************************************************************************/
function deleteVignette($vignette_id) 
{	
	$mySQL2			= "SELECT * FROM multimedia WHERE vignette_id = '$vignette_id' AND status > 0";
	$recSET2		= mysql_query($mySQL2) or die (mysql_error());
	
	while ($recROW2 = mysql_fetch_assoc($recSET2)) {
	
		$multimedia_id		= $recROW2['multimedia_id'];
		deleteMultimedia($multimedia_id);
	}
	
	$mySQL			= "UPDATE vignette SET status = 0 WHERE vignette_id = '$vignette_id'";
	mysql_query($mySQL);

}

/*************************************************************************************************************************
	RETURN LINK FOR A TEMPLATE
**************************************************************************************************************************/
function templateLink ($template_id)
{
	$mySQL	= "SELECT * FROM template WHERE template_id = '$template_id'";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);
	
	return($recROW['link']);
}

/*************************************************************************************************************************
	RETURN THE FIRST PARENT id
**************************************************************************************************************************/
function getTopParentID($id)
{
	$mySQL		= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$id'";
	$recSET		= mysql_query($mySQL);
	$recROW		= mysql_fetch_assoc($recSET);
	
	$nav_tab_id	= $recROW['nav_tab_id'];
	$parent_id	= $recROW['parent_id'];

	if ($parent_id == 0) return $nav_tab_id;
	if ($parent_id <> 0) $output = getTopParentID($parent_id);
	
	return $output;
}

/*************************************************************************************************************************
	BUILD SEO LINKS FROM NAVIGATION TAB ID
**************************************************************************************************************************/
function getTabLink ($nav_tab_id)
{
	global $absoluteURL;
	
	$language_id	= $_SESSION['languageID'];
	
	$mySQL	= "SELECT * FROM navigation_tab JOIN template ON navigation_tab.template_id = template.template_id JOIN page ON page.nav_tab_id = navigation_tab.nav_tab_id WHERE navigation_tab.nav_tab_id = '$nav_tab_id' AND page.language_id ='$language_id'";
	$recSET	= mysql_query($mySQL) or die (mysql_error());
	$recROW	= mysql_fetch_assoc($recSET);
	
	$pagename		= getSeoName($recROW['pagetitle']);
	
	$normal_link	= $absoluteURL.$recROW['link']."?".GetSetting('mod_rewrite_variable1')."=".$nav_tab_id;
	$seo_link		= $absoluteURL.$recROW['seo_link']."$nav_tab_id/".$pagename.".html";
	
	if (GetSetting('mod_rewrite') == 'on') $link = $seo_link;
	if (GetSetting('mod_rewrite') <> 'on') $link = $normal_link;
	
	return($link);

}
function getSeoName ($raw)
{

$ent = array(
    '&#65533;' => 's',
    '&#65533;' => 'S',
    '&#65533;' => 'z',
    '&#65533;' => 'Z',
    '&#65533;' => 'y',
    '&#65533;' => 'Y',
    '&#65533;' => 'a',
    '&#65533;' => 'A',
    '&#65533;' => 'i',
    '&#65533;' => 'I',
    '&#65533;' => 'e',
    '&#65533;' => 'E',
    '&#65533;' => 'u',

); 

	$output		= html_entity_decode($raw);
	$output		= strip_tags($output);
	$output		= strtr($output, $ent);
	$output		= str_replace(' ', '_', $output);
	$output		= str_replace('&', 'and', $output);
	$output		= str_replace('-', '_', $output);
	
	$output		= str_replace('__', '_', $output);
	$output		= str_replace('___', '_', $output);
	$output		= str_replace('____', '_', $output);
	$output		= str_replace('_', '-', $output);
	$output		= str_replace('--', '-', $output);
	$output		= strtolower($output);

	
	return($output);
}

/*************************************************************************************************************************
    Questionnaire: CHECK IF ONE OF THE CHILD TABS HAS A CHILD
**************************************************************************************************************************/
function ChildHasChild($parent_id) {
    
    $mySQL      = "SELECT * FROM navigation_tab WHERE parent_id = '$parent_id' AND template_id = '21'";
    $recSET     = mysql_query($mySQL) or die (mysql_error());
    $counter    = 0;
    while ($recROW = mysql_fetch_assoc($recSET)) {
        $parent_id2  =  $recROW['nav_tab_id'];
        $mySQL2      = "SELECT * FROM navigation_tab WHERE parent_id = '$parent_id2'AND template_id ='20'";
        $recSET2     = mysql_query($mySQL2) or die (mysql_error());
        $counter    = $counter + mysql_num_rows($recSET2);
        if (mysql_num_rows($recSET2) > 0) $LIwhichHasChild = $parent_id2;
    }
    
    //return $counter;    
    return $LIwhichHasChild;    
}

/*************************************************************************************************************************
    Questionnaire: CHECK IF THE CURRENT TAB HAS A QUESTION ATTACHED
**************************************************************************************************************************/
function ParentHasChild($parent_id) {
    
    $counter        = 0;
    $parent_id2     = $recROW['nav_tab_id'];
    $mySQL2         = "SELECT * FROM navigation_tab WHERE parent_id = '$parent_id'AND template_id ='20'";
    $recSET2        = mysql_query($mySQL2) or die (mysql_error());
    $counter        = $counter + mysql_num_rows($recSET2);

    return $counter;    
}

?>