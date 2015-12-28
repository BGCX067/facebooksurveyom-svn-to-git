<?php
//echo "<pre>";
//var_dump($_SESSION);
//echo "</pre>"; 
$mySQL  = "SELECT * FROM navigation_tab JOIN question_type ON navigation_tab.nav_tab_id = question_type.nav_tab_id WHERE parent_id = 0 AND navigation_tab.status = 3 AND template_id = '20' ORDER BY usort ASC";
$recSET = mysql_query($mySQL) or die(mysql_error());
while ($recROW = mysql_fetch_assoc($recSET)) {
    
    $labelright         = $recROW['labelright'];
    $labelleft          = $recROW['labelleft'];
    $question_buffer    = $question_buffer."<h3 id='question_".$recROW['nav_tab_id']."'>".$recROW['nav_tab_name']."</h3>";
    
    //check if there is an answer to this question if yes then loop and display the questions
    $parent_id          = $recROW['nav_tab_id'];
    $question_type      = $recROW['question_type'];
    
    $checkAnswerSQL     = "SELECT * FROM navigation_tab WHERE parent_id = '$parent_id' AND template_id = '21' ORDER BY usort ASC";
    $checkAnswerSET     = mysql_query($checkAnswerSQL);
    if (mysql_num_rows($checkAnswerSET) > 0) {
        
        $class      = '';
        $scriptLI   = '';  
               
        $class  ="questionType_$question_type";
        if(ChildHasChild($parent_id) > 0)   $class  = $class." childhaschild";
        
        $question_buffer = $question_buffer."<ul class='".$class."'>";
        
        $spss_value = 0;
        
        while ($checkAnswerROW = mysql_fetch_assoc($checkAnswerSET)) {
            
            $spss_value = $spss_value + 1;
            
            $checked_status     = '';
            $checked_statusx    = '';
            $checked_status1    = '';
            $checked_status2    = '';
            $checked_status3    = '';
            $checked_status4    = '';
            $checked_status5    = '';
            
            $answer_parent      = $checkAnswerROW['parent_id'];
            $answer_itself      = $checkAnswerROW['nav_tab_id'];  
            
            if ($_SESSION["a$answer_parent"] == $spss_value) $checked_status = 'checked';
            if ($_SESSION["a$answer_itself"] == $spss_value) $checked_statusx = 'checked';
            if ($_SESSION["a$answer_itself"] == '1') $checked_status1 = 'checked';                
            if ($_SESSION["a$answer_itself"] == '2') $checked_status2 = 'checked';                
            if ($_SESSION["a$answer_itself"] == '3') $checked_status3 = 'checked';                
            if ($_SESSION["a$answer_itself"] == '4') $checked_status4 = 'checked';                
            if ($_SESSION["a$answer_itself"] == '5') $checked_status5 = 'checked';          
            
            $scriptLI = '';
            if(ChildHasChild($parent_id) > 0)                       $scriptLI   = "onclick=\"javascript:boxHide('sub-answerLI".ChildHasChild($parent_id)."')\""; 
            if(ParentHasChild($checkAnswerROW['nav_tab_id']) > 0)   $scriptLI   = "onclick=\"javascript:boxDisplay('sub-answerLI".$checkAnswerROW['nav_tab_id']."')\"";
            
            //decide which type of question it is and how to display the input box. Will it be radio or checkbox or textarea
            if ($question_type == '1') $inputBOX = "<input $checked_status type='radio'      id='answer_id".$checkAnswerROW['nav_tab_id']."' name='answer_name_".$parent_id."' value='".$spss_value."' $scriptLI/>"; 
            if ($question_type == '2') $inputBOX = "<input $checked_statusx type='checkbox'   id='answer_id".$checkAnswerROW['nav_tab_id']."' name='answer_name_".$checkAnswerROW['nav_tab_id']."' value='".$spss_value."' />"; 
            if ($question_type == '3') $inputBOX = "<textarea id='answer_id".$checkAnswerROW['nav_tab_id']."' name='answer_name_".$parent_id."' cols='30' rows='5'>$session_value</textarea>"; 
            if ($question_type == '4') $inputBOX = "<div class='rating-option' id='".$checkAnswerROW['nav_tab_id']."'>
                                                    <span class='low-label'>$labelleft</span>
                                                    <input $checked_status1 type='radio' id='option_id1' name='answer_name_".$checkAnswerROW['nav_tab_id']."' value='1'/>
                                                    <input $checked_status2 type='radio' id='option_id2' name='answer_name_".$checkAnswerROW['nav_tab_id']."' value='2'/>
                                                    <input $checked_status3 type='radio' id='option_id3' name='answer_name_".$checkAnswerROW['nav_tab_id']."' value='3'/>
                                                    <input $checked_status4 type='radio' id='option_id4' name='answer_name_".$checkAnswerROW['nav_tab_id']."' value='4'/>
                                                    <input $checked_status5 type='radio' id='option_id5' name='answer_name_".$checkAnswerROW['nav_tab_id']."' value='5'/>
                                                    <span class='high-label'>$labelright</span>
                                                    </div>"; 
            
            $liClass    = '';
            
            if(ParentHasChild($checkAnswerROW['nav_tab_id']) > 0) {
                $liClass    = "LIisParent";
            }   
            
            $labelText          = "<label $scriptLI id='label_".$checkAnswerROW['nav_tab_id']."' for='answer_id".$checkAnswerROW['nav_tab_id']."'>".$checkAnswerROW['nav_tab_name']."</label>";
            if ($question_type <> '4') $labelText   = $labelText."<br>";
            if ($question_type <> '4') $listLine    = "<li class='$liClass' id='answerLI".$checkAnswerROW['nav_tab_id']."'>".$inputBOX.$labelText."</li>";
            if ($question_type == '4') $listLine    = "<li class='rating $liClass' id='answerLI".$checkAnswerROW['nav_tab_id']."'>".$labelText.$inputBOX."</li>";
            
            $question_buffer    = $question_buffer.$listLine;
            
            //check if this answer has questions attached 
            include $docRoot.'questions_sub.php';
          
        }
    }
        
        $question_buffer = $question_buffer."</ul>";
}

echo $question_buffer;


?>
