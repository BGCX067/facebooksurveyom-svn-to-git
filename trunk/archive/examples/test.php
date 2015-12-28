<?php

require '../src/facebook.php';

function d($d){
    echo '<pre>';
    print_r($d);
    echo '</pre>';
}

// Create our Application instance.
$facebook = new Facebook(array(
  'appId'  => '254752073152',
  'secret' => '904270b68a2cc3d54485323652da4d14',
  'cookie' => true,
));


$session = $facebook->getSession();
if (!$session) {

    $url = $facebook->getLoginUrl();

    echo '<a href=' . $url . '>Log in!</a>';

} else {
  try {
    //CALL API to get me(logged-in user) object
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
    $id = $me['id']; //GET nothing
   

    echo 'The name of the current user is ' . $me['name'];

    //include_once 'user_add.php';
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

d($uid);

?>

