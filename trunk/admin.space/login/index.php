<?php 
include '../../includes/configuration/master.configuration.php';

$button																													= "Login &raquo;";
if($_GET['error'] == 1) $button					= "Login incorrect. Try again &raquo;"; 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title>Backend Name &rsaquo; Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?php echo $absoluteURL."includes/style/"?>admin.login.form.css?version=2.2.3" type="text/css" />
	<!--[if IE]><style type="text/css">#login h1 a { margin-top: 35px; } #login #login_error { margin-bottom: 10px; }</style><![endif]--><!-- Curse you, IE! -->
	<script type="text/javascript">
		function focusit() {
			document.getElementById('user_login').focus();
		}
		window.onload = focusit;
	</script>
</head>
<body class="login">

<div id="login"><h1><a href="http://weblineuk.com/" title="Powered by Webline"><?php echo GetSetting('BackendName')?> (Powered by Webline Ltd) </a></h1>

<form name="loginform" id="loginform" action="loginto.php" method="post">
	<p>
		<label>Username:<br />
		<input type="text" name="uni1" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
	</p>
	<p>
		<label>Password:<br />

		<input type="password" name="ptree2" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
	</p>
	<p><label style="text-decoration:none; color:#ffffff"><a href="forget.php" style="color:white;border:none">Lost your password?</a></label></p>	
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" value="<?php echo $button?>" tabindex="100" />
		<input type="hidden" name="redirect_to" value="wp-admin/" />
	</p>
</form>

</div>


</body>
</html>
