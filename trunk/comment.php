<?php 
include_once "archive/fbmain.php";
$config['baseurl']  =   "http://facebooksurvey.mauritiusresto.com/";
include 'includes/configuration/master.configuration.php'
?>

<?php include $docRoot.'template/styling.php'?>
<?php include $docRoot.'template/scripting.php'?>

<div class="surveybox">
    <?php include $docRoot.'template/header.php'?>
    <?php include $docRoot.'template/menu.php'?>

    <div class="comments-content">
    <div class="friends-selection-box">
    <fb:if-is-app-user>  
        <fb:comments 
            xid="uom_survey_comments" 
            canpost="true"
            publish_feed="true" 
            candelete="false" 
            returnurl="http://apps.facebook.com/uomsurvey/">
            
            <fb:title>What others say about the survey?</fb:title>
        </fb:comments>
      <fb:else>
        <fb:redirect url="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/friends.php&scope=publish_stream" />
      </fb:else>  
    </fb:if-is-app-user> 
    </div>

    </div>
</div>
