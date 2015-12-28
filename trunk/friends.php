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

    <div class="friends-content">
    <div class="friends-selection-box">
    <fb:if-is-app-user>   
        <fb:request-form 
            type="UOMsurvey" 
            invite="true" 
            method="POST"
            action="http://apps.facebook.com/uomsurvey/" 
            content="Hi there! Please help a friend for his final year thesis by taking on this cool survey app. It will not take more than 15mins to do it :-)<?php echo htmlentities("<fb:req-choice url=\"http://apps.facebook.com/uomsurvey/\" label=\"Start survey\"") ?>">
     
          <fb:multi-friend-selector 
            actiontext="Please pass this Survey on to your friends"
            max="100"
            email_invite="true" 
            showborder="false"
            bypass="cancel" 
            rows="3"
            import_external_friends="true" 
            cols="4" />
   
        </fb:request-form>
      <fb:else>
        <fb:redirect url="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/friends.php&scope=publish_stream" />
      </fb:else>  
    </fb:if-is-app-user> 
    </div>

    </div>
</div>