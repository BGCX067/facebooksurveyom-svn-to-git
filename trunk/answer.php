<?php 
include_once "archive/fbmain.php";
$config['baseurl']  =   "http://facebooksurvey.mauritiusresto.com/";
include 'includes/configuration/master.configuration.php'
?>

<?php
$session_id = session_id();
$mySQL      =  "DELETE FROM facebook WHERE session_id = '$session_id'";
mysql_query($mySQL) or die(mysql_error());


$mySQL      = "SELECT * FROM navigation_tab";
$recSET     = mysql_query($mySQL);
while ($recROW = mysql_fetch_assoc($recSET)) {

    $nav_tab_id     = $recROW['nav_tab_id'];
    $question_id    = $nav_tab_id;

    $answer_name    = "answer_name_".$recROW['nav_tab_id'];
    $answer_value   = $_POST["$answer_name"];

    $ip_address     = $_SERVER['REMOTE_ADDR'];
    $browser_data   = $_SERVER['HTTP_USER_AGENT'];
                

    $insertSQL      = "INSERT INTO facebook (session_id, nav_tab_id, answer, ip_address, browser_data, status, date) 
                                    VALUE ('$session_id','$question_id','$answer_value','$ip_address','$browser_data','3',now())";

    $_SESSION["a$nav_tab_id"] = $answer_value;

    if (!empty($answer_value)) {
        mysql_query($insertSQL);
    }
    //echo $answer_name."<br>";
    //echo $_SESSION["$nav_tab_id"]."<br>";
} 
?>
    
<?php include $docRoot.'template/styling.php'?>
<?php include $docRoot.'template/scripting.php'?>

<div class="surveybox">
    <?php include $docRoot.'template/header.php'?>
    <?php include $docRoot.'template/menu.php'?>

    <div class="content">

        <div class="thanks">
            <h1>Thank you very very much!</h1>
            <p>Hope it was not not too hard. Wanna post a 
                <fb:if-is-app-user>
                    <a href="http://apps.facebook.com/uomsurvey/comment.php">comment</a>
                <fb:else>
                    <a href="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/comment.php&scope=publish_stream">comment</a>                    
                </fb:else>
 
            <fb:if-is-app-user> 
                . If you wish to review or alter your input please <a href="http://apps.facebook.com/uomsurvey">click here</a>
            </fb:if-is-app-user>
            </p>
        </div>
        <div class="crazy">
        
        <h1>Here is the answer to the tickling question.</h1> 
Each time you fold the paper it doubles the thickness. So at the first fold the paper will be 2 times (2<span class="atoms">1</span>) the thickness of the paper 2 x 0.1 = 0.2mm. At the second fold we will be having 4 times (2 x 2 or 2<span class="atoms">2</span>) the thickness of the paper 4 x 0.1 = 0.4mm. This follows what is called a geometric progression and we keep on folding at the end of the fiftieth fold (2<span class="atoms">50</span>) the resulting stack of paper will be, now hold your breath here:
<br><br>2<span class="atoms">50</span> X 0.1 = 112,589,990,684,262mm or approximately <strong>112,589,990km</strong>. The Moon is approximately 384,403km away from the earth and the sun is approximately 149,565,511km away.
<br><br>So if you could take a sheet of paper and fold it 50 times then the resulting thickness of the paper will be approximately 113 million kilometres which is about two third the distance between the earth and the sun. Crazy isn`t it :-) Well this is the very basis of viral marketing. If someone likes something and tell this to least 2 freinds who in turn tell at least 2 friends each and so on ...

        
        </div>
        <div class="share-link">
            <h1>Pass this on to your friends</h1>
            <ul>
                <fb:if-is-app-user>
                    <li><a href="http://apps.facebook.com/uomsurvey/comment.php">Comment</a> <span class="lik-sep">.</span></li>
                    <li><a href="http://apps.facebook.com/uomsurvey/friends.php">Share</a></li>
                <fb:else>
                    <li><a href="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/comment.php&scope=publish_stream">Comment</a> <span class="lik-sep">.</span></li>                    
                    <li><a href="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/friends.php&scope=publish_stream">Share</a></li>
                </fb:else>
                </fb:if-is-app-user> 
            </ul>
        </div>
    </div>
</div>
