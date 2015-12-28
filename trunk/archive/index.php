<?php
include_once "fbmain.php";
$config['baseurl']  =   "http://facebooksurvey.mauritiusresto.com/";

//if user is logged in and session is valid.
if ($fbme){
    //Retriving movies those are user like using graph api
    try{
        $movies = $facebook->api('/me/movies');
    }
    catch(Exception $o){
        d($o);
    }

    //Calling users.getinfo legacy api call example
    try{
        $param  =   array(
            'method'  => 'users.getinfo',
            'uids'    => $fbme['id'],
            'fields'  => 'name,current_location,profile_url',
            'callback'=> ''
        );
        $userInfo   =   $facebook->api($param);
    }
    catch(Exception $o){
        d($o);
    }

    //update user's status using graph api
    if (isset($_POST['tt'])){
        try {
            $statusUpdate = $facebook->api('/me/feed', 'post', array('message'=> $_POST['tt'], 'cb' => ''));
        } catch (FacebookApiException $e) {
            d($e);
        }
    }

    //fql query example using legacy method call and passing parameter
    try{
        //get user id
        $uid    = $facebook->getUser();
        //or you can use $uid = $fbme['id'];

        $fql    =   "select name, hometown_location, sex, pic_square from user where uid=" . $uid;
        $param  =   array(
            'method'    => 'fql.query',
            'query'     => $fql,
            'callback'  => ''
        );
        $fqlResult   =   $facebook->api($param);
    }
    catch(Exception $o){
        d($o);
    }
}
d($uid);
d($fbme);
d($uid);
?>

<fb:if-is-app-user>
  Your score: 55555!
  <fb:else>
  <fb:redirect url="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/&scope=user_photos,user_videos,publish_stream" />
  </fb:else>
</fb:if-is-app-user>
<fb:friend-selector name="uid" idname="friend_sel" />
<fb:multi-friend-input width="350px" border_color="#8496ba" exclude_ids="4,5,10,15" />
<fb:comments xid="titans_comments" canpost="true" candelete="false" returnurl="http://apps.facebook.com/myapp/titans/">
<fb:title>Talk about the Titans</fb:title>
</fb:comments>

 <fb:request-form type="The app name" invite="true" method="POST"
         action="http://apps.facebook.com/appurl" content="This is fun stuff">
 
      <fb:multi-friend-selector actiontext="Some action text here for the friends invited" showborder="false" rows="3" cols="3" />
 
</fb:request-form>
 
