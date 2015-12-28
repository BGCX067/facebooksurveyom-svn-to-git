<?php 
            //check if this answer has questions attached
            $answer_as_parent = $checkAnswerROW['nav_tab_id'];
            $mySQL2  = "SELECT * FROM navigation_tab JOIN question_type ON navigation_tab.nav_tab_id = question_type.nav_tab_id WHERE parent_id = '$answer_as_parent' AND navigation_tab.status = 3 AND template_id = '20' ORDER BY usort ASC";
            $recSET2 = mysql_query($mySQL2) or die(mysql_error());
            if ($_SESSION["a$answer_parent"] !== $checkAnswerROW['nav_tab_id']) $hideStyle  = "style='display:none'"; 
            if ($_SESSION["a$answer_parent"] == $checkAnswerROW['nav_tab_id']) $hideStyle  = ''; 
            if (mysql_num_rows($recSET2) > 0) {
            $question_buffer    = $question_buffer."<li  id='sub-answerLI".$checkAnswerROW['nav_tab_id']."' class='LIhasChild' $hideStyle><div>";
                  
                while ($recROW2 = mysql_fetch_assoc($recSET2)) {
                    
                    
                        $labelright2        = $recROW2['labelright'];
                        $labelleft2         = $recROW2['labelleft'];

                        $question_buffer    = $question_buffer."<h4 id='question_".$recROW2['nav_tab_id']."'>".$recROW2['nav_tab_name']."</h4>";
        
                        //check if there is an answer to this question if yes then loop and display the questions
                        $parent_id2          = $recROW2['nav_tab_id'];
                        $question_type2      = $recROW2['question_type'];
                        
                        $checkAnswerSQL2     = "SELECT * FROM navigation_tab WHERE parent_id = '$parent_id2' AND template_id = '21' ORDER BY usort ASC";
                        $checkAnswerSET2     = mysql_query($checkAnswerSQL2);
                        if (mysql_num_rows($checkAnswerSET2) > 0) {
                            
                            $spss_value2 = 0;
                            $question_buffer = $question_buffer."<ul class='questionType".$question_type2."'>";
                            
                            while ($checkAnswerROW2 = mysql_fetch_assoc($checkAnswerSET2)) {
                                
                                            
                            $spss_value2 = $spss_value2 + 1;
                            
                            $checked_status     = '';
                            $checked_statusm    = '';
                            $checked_status1    = '';
                            $checked_status2    = '';
                            $checked_status3    = '';
                            $checked_status4    = '';
                            $checked_status5    = '';
                            
                            $answer_parent      = $checkAnswerROW2['parent_id'];
                            $answer_itself      = $checkAnswerROW2['nav_tab_id'];
                            
                            if ($_SESSION["a$answer_parent"] == $spss_value2) $checked_status = 'checked';
                            if ($_SESSION["a$answer_itself"] == $spss_value2) $checked_statusm = 'checked';
                            if ($_SESSION["a$answer_itself"] == '1') $checked_status1 = 'checked';                
                            if ($_SESSION["a$answer_itself"] == '2') $checked_status2 = 'checked';                
                            if ($_SESSION["a$answer_itself"] == '3') $checked_status3 = 'checked';                
                            if ($_SESSION["a$answer_itself"] == '4') $checked_status4 = 'checked';                
                            if ($_SESSION["a$answer_itself"] == '5') $checked_status5 = 'checked';                

                            
                            //decide which type of question it is and how to display the input box. Will it be radio or checkbox or textarea
                            if ($question_type2 == '1') $inputBOX2 = "<input $checked_status type='radio'      id='answer_id".$checkAnswerROW2['nav_tab_id']."' name='answer_name_".$parent_id2."' value='".$spss_value2."' />"; 
                            if ($question_type2 == '2') $inputBOX2 = "<input $checked_statusm type='checkbox'   id='answer_id".$checkAnswerROW2['nav_tab_id']."' name='answer_name_".$checkAnswerROW2['nav_tab_id']."' value='".$spss_value2."' />"; 
                            if ($question_type2 == '3') $inputBOX2 = "<textarea id='answer_id".$checkAnswerROW2['nav_tab_id']."' name='answer_name_".$parent_id2."' cols='30' rows='5'></textarea>"; 
                            if ($question_type2 == '4') $inputBOX2 = "<div class='rating-option' id='".$checkAnswerROW2['nav_tab_id']."'>
                                                <span class='low-label'>$labelleft2</span>
                                                <input $checked_status1 type='radio' id='option_id1' name='answer_name_".$checkAnswerROW2['nav_tab_id']."' value='1'/>
                                                <input $checked_status2 type='radio' id='option_id2' name='answer_name_".$checkAnswerROW2['nav_tab_id']."' value='2'/>
                                                <input $checked_status3 type='radio' id='option_id3' name='answer_name_".$checkAnswerROW2['nav_tab_id']."' value='3'/>
                                                <input $checked_status4 type='radio' id='option_id4' name='answer_name_".$checkAnswerROW2['nav_tab_id']."' value='4'/>
                                                <input $checked_status5 type='radio' id='option_id5' name='answer_name_".$checkAnswerROW2['nav_tab_id']."' value='5'/>
                                                <span class='high-label'>$labelright2</span>
                                                </div>";
                                                                          
                            $labelText2         = "<label id='label_".$checkAnswerROW2['nav_tab_id']."' for='answer_id".$checkAnswerROW2['nav_tab_id']."'>".$checkAnswerROW2['nav_tab_name']."</label>";
                            if ($question_type2 <> '4') $labelText2   = $labelText2."<br>";
                            if ($question_type2 <> '4') $listLine2    = "<li class='$liClass' id='answerLI".$checkAnswerROW2['nav_tab_id']."'>".$inputBOX2.$labelText2."</li>";
                            if ($question_type2 == '4') $listLine2    = "<li class='rating $liClass' id='answerLI".$checkAnswerROW2['nav_tab_id']."'>".$labelText2.$inputBOX2."</li>";

                            
                            $question_buffer    = $question_buffer.$listLine2;
                            
                            }
                            
                            $question_buffer = $question_buffer."</ul>";
                        }
                }
                $question_buffer = $question_buffer."</div></li>";
            }   
?>