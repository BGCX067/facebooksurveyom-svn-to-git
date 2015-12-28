<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$fromdate1		= $_SESSION['fromdate1'];
$todate1		= $_SESSION['todate1'];

$sep1			= "\"";
$sep2			= "\",\"";
$end			= "\n";
$blank			= " ";

$filename = "csv/".$fromdate1."to".$todate1.".csv";
if (file_exists($filename)) unlink($filename);
$handle = fopen($filename, 'a');
$row_count	= 0;  

function getAnswer($question_id, $session_id, $level) {
    $answerSQL  = "SELECT * FROM facebook WHERE session_id = '$session_id' AND nav_tab_id = '$question_id'";
    $asnwerSET  = mysql_query($answerSQL) or die(mysql_error());
    $answerROW  = mysql_fetch_assoc($asnwerSET);
    $result     = $answerROW['answer'];
    
    if(empty($result)) $result = 99;
    
    if ($level == 2) {
        $topParent  = getTopParentID($question_id);

        $answerSQL  = "SELECT * FROM facebook WHERE session_id = '$session_id' AND nav_tab_id = '$topParent'";
        $asnwerSET  = mysql_query($answerSQL) or die(mysql_error());
        $answerROW  = mysql_fetch_assoc($asnwerSET);
        $result2     = $answerROW['answer']; 
        
        if ($result2 <> 1) $result = 88;               
    } 
    
    return($result);            
}



$mySQL          = "SELECT * FROM navigation_tab JOIN question_type ON navigation_tab.nav_tab_id = question_type.nav_tab_id WHERE navigation_tab.status = 3 AND template_id = '20' ORDER BY usort ASC";
$recSET         = mysql_query($mySQL) or die(mysql_error());
$column_total   = mysql_numrows($recSET);

//include 'field.list.php';
//$csvline    = $csvline.$sep1.$end;
//fwrite($handle, $csvline);



$respondentSQL  = "SELECT * FROM facebook GROUP BY session_id";
$respondentSET  = mysql_query($respondentSQL);
$rows_total     = mysql_numrows($respondentSET);

while ($respondentROW	= mysql_fetch_assoc($respondentSET)) {
	
    $session_id     = $respondentROW['session_id'];

    $questionSQL    = "SELECT * FROM navigation_tab JOIN question_type ON navigation_tab.nav_tab_id = question_type.nav_tab_id WHERE parent_id = 0 AND navigation_tab.status = 3 AND template_id = '20' ORDER BY usort ASC";
    $questionSET    = mysql_query($questionSQL);
    
    $i_count        = 0;
    
    while ($questionROW = mysql_fetch_assoc($questionSET)) {
        
        $i_count++;                
        $question_id    = $questionROW['nav_tab_id'];
        $question_type  = $questionROW['question_type'];
        
        if ($question_type == '1') {
            $value          = getAnswer($question_id, $session_id, 1);
            
            if ($i_count == 1) $csvline = $sep1.$value;
            if ($i_count <> 1) $csvline = $csvline.$sep2.$value;
        }
        
        if ($question_type == '4') {
            $mySQL  = "SELECT * FROM navigation_tab WHERE parent_id = '$question_id' ORDER BY usort ASC";
            $recSET = mysql_query($mySQL);
            while ($recROW = mysql_fetch_assoc($recSET)) {
                $i_count++;
                $question_id2   = $recROW['nav_tab_id'];
                $value          = getAnswer($question_id2, $session_id, 1);

                if ($i_count == 1) $csvline = $sep1.$value;
                if ($i_count <> 1) $csvline = $csvline.$sep2.$value;
            }
        }
        
        if (ChildHasChild($question_id) > 0) {
            
            $new_parent      =  ChildHasChild($question_id);
            
            $questionSQL2    = "SELECT * FROM navigation_tab JOIN question_type ON navigation_tab.nav_tab_id = question_type.nav_tab_id WHERE parent_id = '$new_parent' AND navigation_tab.status = 3 AND template_id = '20' ORDER BY usort ASC";
            $questionSET2    = mysql_query($questionSQL2);
            
            while ($questionROW2 = mysql_fetch_assoc($questionSET2)) {                

                $question_id    = $questionROW2['nav_tab_id'];
                $question_type  = $questionROW2['question_type'];

                if ($question_type == '1') {
                    $value          = getAnswer($question_id, $session_id, 2);                  
                    $csvline        = $csvline.$sep2.$value;
                }
                
                if ($question_type == '4') {
                    $mySQL  = "SELECT * FROM navigation_tab WHERE parent_id = '$question_id' ORDER BY usort ASC";
                    $recSET = mysql_query($mySQL);
                    while ($recROW = mysql_fetch_assoc($recSET)) {
                        $i_count++;
                        $question_id2   = $recROW['nav_tab_id'];
                        $value          = getAnswer($question_id2, $session_id, 2);
                        $csvline        = $csvline.$sep2.$value;
                    }
                }                
            }                 
        }
                                                     
    }
    
    $row_count	= $row_count + 1;
    $csvline	= $csvline.$sep1.$end;
    fwrite($handle, $csvline);
}
?>


<div align="center">
&nbsp;<p>&nbsp;</p>


<table border="0" width="66%" id="table14" cellspacing="0" cellpadding="0" height="210">
		<tr>
			<td bgcolor="#F7F7F7" style="border-style: solid; border-width: 1px" bordercolor="#C0C0C0">
			<p align="center" style="margin-top: 0; margin-bottom: 0"><b>
			<font face="Arial"><a href="<?php echo $filename?>">
			<?php echo $fromdate1."to".$todate1.".csv"?></a></font></b></p>
			<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p align="center" style="margin-top: 0; margin-bottom: 0">
			<font face="Arial" style="font-size: 8pt">from <?php echo $fromdate1?> to <?php echo $todate1?></font></p>
			<p align="center" style="margin-top: 0; margin-bottom: 0">
			<font face="Arial" size="1">to save the file please right click and 'save link as'</font></td>
		</tr>
	</table></div>
