<?php
include '../../includes/configuration/master.configuration.php';
$username 		= mysql_escape_string(SanitizeData($_POST['uni1']));
$password 		= mysql_escape_string(SanitizeData($_POST['ptree2']));
$mySQL 					= "SELECT admin_id FROM admin WHERE username = '$username' AND password = '$password'";
$recSET 				= mysql_query($mySQL) or die(mysql_error());

if($recROW	= mysql_fetch_assoc($recSET)){					
					$_SESSION['admin_login'] = $recROW['admin_id'];
					header("Location:$absoluteURL"."admin.space/");
					exit(); 
}
else{
				header("Location:$absoluteURL"."admin.space/login/index.php?error=1");
				exit();
}
	

?>