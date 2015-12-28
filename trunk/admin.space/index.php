<?php 
include '../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();
?>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title></title>
</head>

<frameset rows="125,*,51" border="0" frameborder="0" framespacing="0">
	<frame marginheight="0" marginwidth="0" name="banner" noresize="noresize" scrolling="no" target="contents" src="layout/banner.php">
	<frameset cols="230,*">
		<frame marginheight="0" marginwidth="0" name="navigation" scrolling="auto" target="main" noresize="noresize" src="layout/navigation.php">
		<frame name="body" scrolling="auto" marginheight="0" marginwidth="0" noresize="noresize" src="layout/welcome.php">
	</frameset>
	<frame marginheight="0" marginwidth="0" name="footer" noresize="noresize" scrolling="no" target="contents" src="layout/footer.php">
	<noframes>
	<body>

	<p>This page uses frames, but your browser doesn&#39;t support them.</p>

	</body>
	</noframes>
</frameset>

</html>
