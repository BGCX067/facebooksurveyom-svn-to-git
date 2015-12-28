<?php include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

$nav_tab_id	= SanitizeData($_GET['id']);

if (isset($_POST['confirm'])) {
	DeleteAllChildren($nav_tab_id);
	header("Location:$absoluteURL/admin.space/website.navigation/");
}

?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>New Page 1</title>

<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form method="POST" action="index.php?id=<?php echo $nav_tab_id?>">
			<div class="confirmation_message">
						<p style="margin: 0 10px; font-size:12pt; color:black; font-family:Arial, Helvetica, sans-serif">
							Deleting a navigation 
							tab will cause all pages initially attached to it 
							to be deleted<br><br>
						</p>
						<p style="margin: 0 10px">
							<font face="Arial" size="1" color="#333333">
							Click no to return back to the list</font>
						</p>
						<p style="margin: 0 10px">&nbsp;</p>
						<p style="margin: 0 10px"><font face="Arial">
						<font color="#333333">
						<input type="submit" value="yes" name="confirm"></font><font size="2" color="#333333">
						</font><font color="#333333"><input type="button" value="no" name="B2" onclick="javascript:history.go(-1)" ></font></font>
			
			</div>
			</form>
				
</body>

</html>