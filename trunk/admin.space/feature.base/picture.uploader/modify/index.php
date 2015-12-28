<?php
include '../../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$multimedia_id	= SanitizeData($_GET['multimedia_id']);

$mySQL	= "SELECT * FROM multimedia WHERE multimedia_id = '$multimedia_id'";
$recSET	= mysql_query($mySQL) or die (mysql_error());
$recROW	= mysql_fetch_assoc($recSET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Untitled 1</title>


<style type="text/css">
body {
	background-color: #E2E2E2;
	margin:0px;
}
</style>


<link href="../../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="delete_picture">
	<div class="picture" style="background-image:url('<?php echo getMultimediaPicture($multimedia_id, 'small')?>')"></div>
	<form method="post" action="save.php?multimedia_id=<?php echo $multimedia_id?>">
		<span>Set the title of your file here</span>
		<p><textarea name="description" tabindex="0"><?php echo deSanitizeData($recROW['description'])?></textarea></p>
		<p>
			<input type="submit" value="Save and close">
			<input type="button" value="Cancel" onclick="self.parent.myLytebox.end();">
		</p>
	</form>
</div>
</body>

</html>
