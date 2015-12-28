<?php include '../../includes/configuration/master.configuration.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
<base target="main" />
<link href="../../includes/style/admin.space.css" rel="stylesheet" type="text/css" />

</head>

<body class="navigation_background">

<ul class="backend_navigation">
    <li><a href="<?php echo $absoluteURL."admin.space/website.navigation/"?>" target="body">Website Navigation</a></li>
	<li><a href="<?php echo $absoluteURL."admin.space/report/csv/"?>" target="body">Survey report</a></li>
	<li><a href="<?php echo $absoluteURL."admin.space/installation/configuration.simple/"?>" target="body">Simple Configuration</a></li>
	<li><a href="<?php echo $absoluteURL."admin.space/admin/"?>" target="body">Admin Logins</a></li>
<?php if(GetSetting('mod_rewrite_htaccess')=='on') {?>
	<li><a href="<?php echo $absoluteURL."admin.space/installation/generate.htaccess/"?>" target="body">Generate .Htaccess</a></li>
<?php }?>
<?php if ($debug_mode == 1) {?>
	<li><a href="<?php echo $absoluteURL."admin.space/installation/setup/"?>" target="body">Setup</a></li>
	<li><a href="<?php echo $absoluteURL."admin.space/installation/configuration.feature/"?>" target="body">Configuration</a></li>
<?php }?>
</ul>

</body>

</html>
