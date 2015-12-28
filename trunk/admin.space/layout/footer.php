<?php include '../../includes/configuration/master.configuration.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
<link href="../../includes/style/admin.space.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<base target="contents">
</head>

<body class="footer_background">

<div class="footer_copyright"> © <?php echo date('Y')?>. All rights reserved</div>

<?php if  (getSetting(company) == 'Webline') {?>
<ul class="footer_links">
	<li><a href="#a">Terms of use</a></li>
	<li><a href="#a">Contact details</a></li>
	<li><a href="#a">Support</a></li>
	<li><a href="#a">About Webline</a></li>
</ul>
<?php }?>

<?php
if(getSetting(company) == 'Web')		$picture = "../../multimedia/pictures/template/admin.space/layout.pictures/logo.web.png";
if(getSetting(company) == 'Webline')	$picture = "../../multimedia/pictures/template/admin.space/layout.pictures/logo.webline.png";
?>

<img alt="<?php echo getSetting(company)?>" src="<?php echo $picture?>?time=<?php echo gettimeofday(true)?>" class="footer_image" />
</body>

</html>
