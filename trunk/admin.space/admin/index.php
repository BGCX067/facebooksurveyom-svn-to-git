<?php 
include '../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();
s

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
<link href="../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="save.php" method="post" class="navigation_structure_backend">
<h1 style="margin-bottom:15px; border-bottom:1px #C0C0C0 dotted; display:block; float:none">Administrator Login</h1>
<div class="navigation_structure_backend">


<h3 class="setting_header"><strong>Change Password</strong></h3>
	<ul class="settings">

<?php
/*************************************************************************************************************************
	GET GENERAL SETTINGS
**************************************************************************************************************************/

$mySQL	= "SELECT * FROM admin";
$recSET	= mysql_query($mySQL) or die ("Error occured".mysql_error());
while($recROW	= mysql_fetch_assoc($recSET)) { 
?>

	
	<li><label><a href="#"><?php echo $recROW['username']?></a></label>
	<input name="password[<?php echo $recROW['admin_id']?>]" type="text" value="<?php echo $recROW['password']?>"></li>
	
<?php }?>
	</ul>

		

<br><br><br>
<input name="Submit1" type="submit" value="Save password"/>

</div>	

</form>

</body>

</html>
