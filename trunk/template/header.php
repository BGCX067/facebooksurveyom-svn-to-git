<?php
    $mySQL  = "SELECT DISTINCT session_id FROM facebook";
    $recSET = mysql_query($mySQL);
    $count  = mysql_num_rows($recSET);
?>
    <div class="header">
        <a href="http://apps.facebook.com/uomsurvey/" class="logo">Facebook app developped by <strong>Vishal Sahody</strong></a>
        <div class="counterbox"><strong><?php echo $count?></strong> people took this survey</div>
        <div class="message">
        </div>
    </div>