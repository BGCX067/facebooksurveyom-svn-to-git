<?php include '../../includes/configuration/master.configuration.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Admin Space - Banner</title>
<base target="contents" />

<link href="../../includes/style/admin.space.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../includes/javascript/clock.js"></script>

<style type="text/css">
.back_end_name {
	float: right;
	padding-top: 8px;
	padding-right: 10px;
}

</style>

</head>

<body onload="StartClock24();">
<div class="banner_container">
	<div class="black_strip">
		<img class="logo" alt="Logo" src="../../multimedia/pictures/template/admin.space/layout.pictures/logo.png" height="42" width="177" />
		<div class="top_timedate" id="time">Time</div>
		<div class="top_timedate"><?php echo date('l jS F Y')?> </div>
	</div>
	<div class="top_navigation">
		<ul class="top_navigation_link_container">
			<li><a href="<?php echo $absoluteURL."admin.space/"?>" target="_top">Home</a></li>
			<li style="background-image:none"><a href="<?php echo $absoluteURL."admin.space/login/logout.php"?>" target="_top">Log out</a></li>
		</ul>
		<div class="back_end_name"><?php echo GetSetting('BackendName')?></div>
	</div>
	<div class="top_sub_navigation">You are logged in as <strong><?php echo ucfirst(getAdmin($_SESSION['admin_login']))?></strong>. Not you, please 
		<strong><a href="<?php echo $absoluteURL."admin.space/login/logout.php"?>" target="_top">Sign out</a></strong></div>
</div>
</body>

</html>
