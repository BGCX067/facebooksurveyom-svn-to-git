<?php 
include_once "archive/fbmain.php";
//$config['baseurl']  =   "http://facebooksurvey.mauritiusresto.com/";
include 'includes/configuration/master.configuration.php';


?>

<?php include $docRoot.'template/styling.php'?>
<?php include $docRoot.'template/scripting.php'?>

<div class="surveybox">
    <?php include $docRoot.'template/header.php'?>
    <?php include $docRoot.'template/menu.php'?>

    <form id="facebooksurveyform" name="facebooksurveyformname" action="answer.php" method="post"">
        <div class="content">
            <div class="question">
                <?php include $docRoot.'questions.php'?>
            </div>
            <div class="finalmessage">
                <h1>One sec before you submit</h1>
                <p>Please make sure that you have answered all questions otherwise all your answers will be invalid.</p>
                <input class="submit" type="submit" value="Finish & Submit"></input>
            </div>
        </div>
    </form>
</div>
