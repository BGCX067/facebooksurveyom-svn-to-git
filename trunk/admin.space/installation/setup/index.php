<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">

</head>

<body><div class="navigation_structure_backend" style="width:auto">
	<div class="title_space">
			<h1>Template features</h1>
			<p class="clear"></p>
	</div>
	<form action="save.php" method="post" style="padding-top:10px">
		<div class="feature_list1"><strong>
			<a href="../configuration.template/create/create.template.php">Template</a> | 
			<a href="../configuration.feature/create/create.feature.php">Feature</a> </strong></div>	
		<?php
		$mySQL	= "SELECT * FROM feature ORDER BY usort ASC";
		$recSET	= mysql_query($mySQL) or die (mysql_error());
		while ($recROW = mysql_fetch_assoc($recSET)) {
		?>
			<div class="feature_list2">
				<a class="feature_list6 feature_list7" href="<?php echo $absoluteURL."admin.space/installation/configuration.feature/"?>?feature_id=<?php echo $recROW['feature_id']?>" title="<?php echo ucfirst($recROW['description'])?>"><?php echo ucfirst($recROW['title'])?> (<?php echo ucfirst($recROW['feature_id'])?>)</a>
			</div>	
		<?php }?>
		
		<hr class="feature_list3">
		
		<?php
		$mySQLt	= "SELECT * FROM template ORDER BY template_id DESC";
		$recSETt	= mysql_query($mySQLt) or die (mysql_error());
		while ($recROWt = mysql_fetch_assoc($recSETt)) {
		?>
			<div class="feature_list5"><a href="<?php echo $absoluteURL."admin.space/installation/configuration.template/"?>?template_id=<?php echo $recROWt['template_id']?>" title="<?php echo $recROWt['description']?>"><?php echo $recROWt['template_type']?> (<?php echo $recROWt['template_id']?>)</a></div>
			<?php
			$mySQL	= "SELECT * FROM feature ORDER BY usort ASC";
			$recSET	= mysql_query($mySQL) or die (mysql_error());
			while ($recROW = mysql_fetch_assoc($recSET)) {
			?>
				<div class="feature_list8"><input name="t<?php echo $recROWt['template_id']?>f<?php echo $recROW['feature_id']?>" type="checkbox" <?php if (templateFeatureCheck($recROWt['template_id'], $recROW['feature_id']) > 0) echo 'checked'?> value="on"></div>	
			<?php }?>
			<div class="feature_list3"></div>
		<?php }?>
		
		<input name="Submit1" type="submit" value="Save Settings" class="feature_list4">
	</form>
</div>

</body>

</html>
