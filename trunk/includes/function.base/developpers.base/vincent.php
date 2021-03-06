<?php

// This function prevent SQL injection by escaping the variable
/*
function SanitizeData($var, $quotes = true) {
	if (is_array($var)) {   //run each array item through this function (by reference) 
		$output = array();      
	    foreach ($var as &$val) {
	        $output[] = SanitizeData($val);
	    }
	}
	else if (is_string($var)) { //clean strings
	    $var = mysql_real_escape_string($var);
	    if ($quotes) {
	        $output = "'". $var ."'";
	    }
	}
	else if (is_null($var)) {   //convert null variables to SQL NULL
	    $output = "NULL";
	}
	else if (is_bool($var)) {   //convert boolean variables to binary boolean
	    $output = ($var) ? 1 : 0;
	}
	return $output; 
}
*/



//This function Will return a drop down template
/*************************************************************************************************************************
	GET NODE STRUCTURE : GET LIST ASSOCIATED WITH NEWS, EVENTS OR OTHERS
**************************************************************************************************************************/
function GetTemplate($template_id = "",$nav_tab_id=""){
	
	global $absoluteURL;
	
	$NodeStructure	= $absoluteURL.'admin.space/website.navigation/includes/node.structure.php';
	$mySQL 			= "SELECT template_id,template_type FROM template WHERE status > 2 ORDER BY template_id ASC";
	$recSET 		= mysql_query($mySQL) or die("Mysql Error ( 29 ) ");	
	
	$output 		= "<select name=\"template_id\" onChange=\"getNodeStructure('$NodeStructure?template_id='+this.value+'&amp;nav_tab_id=$nav_tab_id')\" >";
	$output 		.= "<option value=\"0\">Select template</option>"; 
	
	while($recROW = mysql_fetch_assoc($recSET)){
		
		$id 		= $recROW['template_id'];
		$name 		= $recROW['template_type'];
		$select 	= ($template_id == $id) ? "selected" : "";
		$output 	.= "<option value=\"$id\" $select >$name</option>"; 
	}
	
	$output 		.= "</select>";
	return ($output);

}

//This function Will return a drop down position
function GetPosition($nav_position_id = ""){
	$mySQL = "SELECT nav_position_id,nav_position FROM navigation_position WHERE status > 0 ORDER BY nav_position_id ASC";
	$recSET = mysql_query($mySQL) or die("Mysql Error ( 45 ) ");	
	$output = "<select name=\"nav_position_id\">";
	while($recROW = mysql_fetch_assoc($recSET)){
		
		$id = $recROW['nav_position_id'];
		$name = $recROW['nav_position'];
		$select = ($nav_position_id == $id) ? "selected" : "";
		$output .= "<option value=\"$id\" $select >$name</option>"; 
	}
	$output .= "</select>";
	return $output;
}

//This function Will return an array of language name with id as key
function GetLanguage(){
	$mySQL = "SELECT language_id,language_name FROM language ORDER BY language_id ASC";
	$recSET = mysql_query($mySQL) or die("Mysql Error ( 61 ) ");	
	$output = array();
	while($recROW = mysql_fetch_assoc($recSET)){
		
		$id = $recROW['language_id'];
		$name = $recROW['language_name'];
		$output[$id] =  $name; 
	}

	return $output;
}

//This function will check for a login status

function CheckLogin(){
	if ($_SESSION['login'] == "yes") return 1;
	else return 0;
}
//This function will return rows of pages

function ListNavigation($position_id,$actual_level="",$parent_id = "",$level = 0){
	if(empty($actual_level)){
		
		$LevelNumber = CheckPositionLevel($position_id);
		$actual_level = $LevelNumber;
		$mySQL = "SELECT nav_tab_id,nav_tab_name,parent_id FROM navigation_tab WHERE nav_position_id = '$position_id' AND parent_id = '0'";	
	}
	else{
		$LevelNumber = $actual_level;
		$actual_level--;
		$level++;
		$mySQL = "SELECT nav_tab_id,CONCAT_WS('',REPEAT('-',$level),nav_tab_name) as nav_tab_name,parent_id FROM navigation_tab WHERE parent_id = '$parent_id'";
	}
	if(!$LevelNumber) return;
	
	$recSET = mysql_query($mySQL) or die(mysql_error("Mysql Error ( 83 )"));
	$output = "";
	while($recROW = mysql_fetch_assoc($recSET)){
		$id = $recROW['nav_tab_id'];
		$name = $recROW['nav_tab_name'];
		$output .= "<div class=\"alisting\"><a href=\"$id\">$name</a></div>";
		if ($actual_level) $output .= ListNavigation($position_id,$actual_level,$id,$level);
		
	}
	return $output;
}

//This function will return rows of announcement

function ListAnnouncement($announce_name,$page_id = ""){

	// Calculating the pagination
	switch($announce_name){
		case "event":
		$field = "event_id as id, eventtitle as title, CONCAT(SUBSTRING(description,1,75),'...') as description ";
		$table = "event";
		break;
		
		case "news":
		$field = "news_id as id, newstitle as title, CONCAT(SUBSTRING(description,1,75),'...') as description ";
		$table = "news";
		break;
		default:
		return;
	}
	
	$mySQL = "SELECT $field FROM $table";
	if (!empty($page_id)) $mySQL .= " WHERE page_id = $page_id ";
	$recSET = mysql_query($mySQL) or die(mysql_error("Mysql Error ( 115 )"));
	$output = "";
	while($recROW = mysql_fetch_assoc($recSET)){
		$id = $recROW['id'];
		$name = $recROW['title'];
		$output .= "<div class=\"alisting\"><a href=\"$id\">$name</a></div>";
		
	}
	return $output;
}

function CheckPositionLevel($position_id){
	$mySQL = "SELECT status FROM navigation_position WHERE nav_position_id = '$position_id' LIMIT 1";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	$recROW = mysql_fetch_assoc($recSET);
	return $recROW['status'];
}
function GetParents($parent_id,$depth,$spacer,$level,$start = "",$actual_id = ""){
	if($level < 2) return;
	if(!empty($start)) $parent_check = "nav_position_id = '$parent_id'";
	else $parent_check = "parent_id = '$parent_id'";
	$mySQL = "SELECT CONCAT(REPEAT('$spacer', $depth),nav_tab_name)  as name,nav_tab_id as id,parent_id FROM navigation_tab WHERE status > 2 AND $parent_check  AND archive_date = '' ORDER BY nav_tab_id ASC ";

	$recSET = mysql_query($mySQL) or die(mysql_error());
	$output = "";
	while($recROW = mysql_fetch_assoc($recSET)){
		$select = "";
		$id = (int)$recROW['id'];
		$name = $recROW['name'];
		$newdepth = $depth + 1;
		$newlevel = $level - 1 ;

		if ((int)$actual_id == (int)$id) $select = "selected";
		$output .="<option value=\"par.$id\" $select>$name</option>";
		$output .=  GetParents($id,$newdepth,$spacer,$newlevel,"",$actual_id);
	}
	return $output;
}
function CreateParentDrop($parent_id,$spacer,$position=""){
	$output = "<select name=\"parentdrop\">";
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
		$output .="<option value=\"nav.$id\" $select>$name</option>";
			$output .= GetParents($id,1,$spacer,$level,1,$actual_id);

	}
	$output .="</select>";
	
	return $output;
}


function usortpage(){

$admin_id	= $_SESSION['admin_login'];

if ($_GET['id'] && isset($_GET['pid']) && isset($_GET['usort']) && isset($_GET['fid'])) {
   // make GET vars easier to handle
   $dir = $_GET['dir'];
   // cast as int and couple with switch for sql injection prevention for $id
   $id = (int) $_GET['id'];
   $usort = (int) $_GET['usort'];
   $pid = (int) $_GET['pid'];
   $fid = (int) $_GET['fid'];

$value	= GetSetting('Dir',$fid);

   switch ($value) {
      // if we're going up, swap is 1 less than id
      case 'down': 
         // make sure that there's a row above to swap

        //Check if there is a higher sort order
        $sql = "SELECT nav_tab_id,usort FROM navigation_tab WHERE usort > '$usort'  AND parent_id = '$pid' ORDER BY usort ASC LIMIT 1";

        $set = mysql_query($sql) or die(mysql_error());
        if ($row = mysql_fetch_assoc($set)){
         
          $swap_id = $row['nav_tab_id'];
          $swap_usort = $row['usort'];
            $sql = "UPDATE navigation_tab SET admin_id = 'Sort - $admin_id', usort = CASE nav_tab_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE nav_tab_id IN ($id, $swap_id)";
            /*
            CASE Id
            WHEN '$id' THEN UPDATE 
            as t1, info as t2 SET t1.usort = '$swap_usort' WHERE usort WHEN $usort THEN $swap WHEN $swap THEN $usort END WHERE usort IN ($usort, $swap)";
*/
        }
        else {
          $usort++;
          $sql = "UPDATE navigation_tab SET admin_id = '$admin_id', usort = '$usort' WHERE nav_tab_id = '$id'";
           

        }
         break;
      // if we're going down, swap is 1 more than id
      case 'up':
 
        //Check if there is a lower sort order
        $sql = "SELECT nav_tab_id,usort FROM navigation_tab WHERE usort < '$usort' AND  parent_id = '$pid' ORDER BY usort DESC LIMIT 1";
        $set = mysql_query($sql) or die(mysql_error());
        if ($row = mysql_fetch_assoc($set)){
         
          $swap_id = $row['nav_tab_id'];
          $swap_usort = $row['usort'];
            $sql = "UPDATE navigation_tab SET admin_id = 'Sort - $admin_id', usort = CASE nav_tab_id WHEN $id THEN $swap_usort WHEN $swap_id THEN $usort END WHERE nav_tab_id IN ($id, $swap_id) ";
       
        }
        else {
          $usort--;
          $sql = "UPDATE navigation_tab SET admin_id = '$admin_id', usort = '$usort' WHERE nav_tab_id = '$id'";
           

        }        
        
        break;
      // default value (sql injection prevention for $dir)
      default:
         $swap = $id;
   } // end switch $dir

//die($sql);
   // swap the rows. Basic idea is to make $id=$swap and $swap=$id 
    $result = mysql_query($sql) or die(mysql_error());
	$return;
}

else return;
}

function GetParentId($nav_tab_id){
	$mySQL = "SELECT parent_id FROM navigation_tab WHERE nav_tab_id = $nav_tab_id";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	$recROW = mysql_fetch_assoc($recSET);
	$parent_id = $recROW['parent_id'];
	return $parent_id;
}

function InheritPicture($nav_tab_id,$picture_type,$language,$option = 0){
	$default_picture = "test.jpg";
	$mySQL = "SELECT CONCAT_WS('.',multimedia_name,extension) as picture FROM multimedia WHERE nav_tab_id = $nav_tab_id AND picture_type=$picture_type AND language_id = $language";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	if ($recROW = mysql_fetch_assoc($recSET)){
		$picture = $recROW['picture'];
	}
	else{
		$nav_tab_id = GetParentId($nav_tab_id);
		if(!$nav_tab_id) return $default_picture;
		$picture = InheritPicture($nav_tab_id,$picture_type,$language);
	}
	return $picture;
}

function GetNavMenu($parent_id,$lang,$level = 1,$menuid = "",$id_name = "id"){
global $TheIndexPage;
global $ThePage;
global $TheContactForm;
global $TheRegistration;
global $ThePicture;
global $TheVideo;
global $TheAudio;
global $TheEventList;

	$TheMenuId = "";
	$parent_check = "parent_id = '$parent_id'";
	if($level == 1){
		$parent_check = "nav_position_id = '$parent_id'";
		if(!empty($menuid))	$TheMenuId = " id=\"$menuid\" ";

	}
		

	$mySQL = "SELECT nav_tab_name as name, navigation_tab.nav_tab_id as id,parent_id, template_id FROM navigation_tab LEFT JOIN page ON navigation_tab.nav_tab_id = page.nav_tab_id WHERE navigation_tab.status = 3  AND $parent_check ORDER BY usort ASC ";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	$count = mysql_num_rows($recSET);
	if(!$count) return;
	$output = "
	<ul$TheMenuId>";
	while($recROW = mysql_fetch_assoc($recSET)){
		$select = "";
		$id = (int)$recROW['id'];
		$name = $recROW['name'];
		$newlevel = $level + 1 ;
		$template_id = $recROW['template_id'];

		if($template_id == '1') $link = $ThePage;
		if($template_id == '2') $link = $TheContactForm;
		if($template_id == '3') $link = $TheRegistration;
		if($template_id == '4') $link = $ThePicture;
		if($template_id == '5') $link = $TheVideo;
		if($template_id == '6') $link = $TheAudio;
		if($template_id == '10') $link = $TheEventList;
		
		

		if ((int)$actual_id == (int)$id) $select = "selected";
		
		$output .="<li><a href=\"$link?$id_name=$id&lang=$lang\">$name</a>";

	if(!CheckTemplate($id,"Event list") ){
			$output .=  GetNavMenu($id,$lang,$newlevel,"",$id_name)."</li>";
		}

	}
	$output .= "
	</ul>";
	return $output;
}



function CheckTemplate($page_id,$template,$option =""){
	$mySQL = "SELECT nav_tab_id FROM navigation_tab WHERE nav_tab_id = '$page_id' AND template_id IN (SELECT template_id FROM template WHERE template_type LIKE '$template')";
	if(!empty($option)) $mySQL = "SELECT nav_tab_id FROM navigation_tab WHERE template_id IN (SELECT template_id FROM template WHERE template_type LIKE '$template')";
	$recSET = mysql_query($mySQL) or die(mysql_error());
	$count = mysql_num_rows($recSET);
	if(empty($option)) return $count;
	else {
		$recROW = mysql_fetch_assoc($recSET);
		return $recROW['nav_tab_id'];
	}
}


function SideNavLeft($parent_id,$lang,$level = 1,$menuid = ""){
global $TheIndexPage;
global $ThePage;
global $TheContactForm;
global $TheRegistration;
global $ThePicture;
global $TheVideo;
global $TheAudio;
global $TheEventList;

	$TheMenuId = "";
	$parent_check = "parent_id = '$parent_id'";
	if($level == 1){
		$parent_check = "nav_position_id = '$parent_id'";
		if(!empty($menuid))	$TheMenuId = " id=\"$menuid\" ";

	}
		

	$mySQL = "SELECT nav_tab_name as name, navigation_tab.nav_tab_id as id,parent_id, template_id FROM navigation_tab LEFT JOIN page ON navigation_tab.nav_tab_id = page.nav_tab_id WHERE navigation_tab.status = 3  AND $parent_check ORDER BY usort ASC ";
	//$mySQL = "SELECT pagetitle as name,nav_tab_id as id FROM page WHERE language_id = $lang AND nav_tab_id IN (SELECT nav_tab_id FROM navigation_tab WHERE status = 3 AND $parent_check ORDER BY usort ASC) ";
	//die($mySQL);
	$recSET = mysql_query($mySQL) or die(mysql_error());
	$count = mysql_num_rows($recSET);
	if(!$count) return;
	while($recROW = mysql_fetch_assoc($recSET)){
		$select = "";
		$id = (int)$recROW['id'];
		$name = $recROW['name'];
		$newlevel = $level + 1 ;
		$template_id = $recROW['template_id'];

		if($template_id == '1') $link = $ThePage;
		if($template_id == '2') $link = $TheContactForm;
		if($template_id == '3') $link = $TheRegistration;
		if($template_id == '4') $link = $ThePicture;
		if($template_id == '5') $link = $TheVideo;
		if($template_id == '6') $link = $TheAudio;
		if($template_id == '10') $link = $TheEventList;
		
		

		if ((int)$actual_id == (int)$id) $select = "selected";
		$output .="<div class=\"leftnav\"><a href=\"$link?id=$id&lang=$lang\">$name</a></div>";
		$output .=  GetNavMenu($id,$lang,$newlevel);
	}
		return $output;
}


function delete_page_content($nav_tab_id,$lang){
	$mySQL = "DELETE FROM page WHERE nav_tab_id = '$nav_tab_id' AND language_id = '$lang'";
	$recSET = mysql_query($mySQL) or die("Error message 416 ".mysql_error());
}


/*************************************************************************************************************************
	CLEAR SQL INJECTION
**************************************************************************************************************************/

function sqlInject($data)
{
	
	//$data	= str_replace(chr(13).chr(10), '<br><br>', $data);
	
	return($data);
	
}


/*******************************************************************
   DELETE ALL CHILDREN
********************************************************************/
function DeleteAllChildren($parent_id){
 $ids = GetChildrenArray($parent_id);
 $admin_id	= "Delete Nav - ".$_SESSION['admin_login'];
 $mySQL = "UPDATE navigation_tab SET status = 0, admin_id = '$admin_id' WHERE nav_tab_id IN ($ids)";
 $recSET = mysql_query($mySQL) or die(mysql_error());
}


/*******************************************************************
   RETURN ALL CHILDREN
********************************************************************/
function GetChildrenArray($parent_id){
 $output_array = array($parent_id);
 GetChildrenValues($parent_id,$output_array);
 $output = implode(',',$output_array);
 return $output;
 
}

function GetChildrenValues($parent_id,&$output_array){
 
 $mySQL = "SELECT nav_tab_id as id FROM navigation_tab WHERE parent_id = '$parent_id'";

 $recSET = mysql_query($mySQL) or die(mysql_error());
 $output = "";
 while($recROW = mysql_fetch_assoc($recSET)){
  $id = $recROW['id'];
  array_push($output_array,$id);
  GetChildrenValues($id,$output_array);
 }
 return ;
}
?>