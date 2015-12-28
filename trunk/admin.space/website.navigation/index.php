<?php include '../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
<title>Untitled 1</title>

<script type="text/javascript" src="../../includes/javascript/jquery.animated.collapse.js"></script>
<script type="text/javascript" src="../../includes/javascript/jquery.animated.collapse.code.js"></script>
<script type="text/javascript" src="../../includes/javascript/call.navigation.template.js"></script>

<link href="../../includes/style/admin.space.css" rel="stylesheet" type="text/css" >
<link href="../../includes/style/form.css" rel="stylesheet" type="text/css" >


</head>

<body>
<div class="navigation_structure_backend" >
	<div class="title_space">
			<h1>Website Navigation Structure</h1>
			<h2><a href="javascript:animatedcollapse.toggle('backend_create_nav')">Create new</a></h2>
			<p class="clear"></p>
	</div>
	
	<div id="backend_create_nav" style="display:none" class="hidden_box">
		<form method="post" action="save/save.php" class="form_class">
			<h4>Information</h4>
			<p><label>Title</label><input type="text" name="nav_tab_name" style="margin-left:4px;width:295px"/></p>
			<p><label>Select page template</label>
				<?php 
				/*************************************************************************************************************************
					ON SELECT WILL SELECT MENU FROM NodeStructure.php TO POPULATE NEXT DROP DOWN
				**************************************************************************************************************************/
				echo getTemplate(0,"..");
				?>					
			</p>
			<p><label>Select Parent node</label><span id="parentnode" style="padding-left:4px"><?php if($template_id == '') echo "  Choose a template first"?></span></p>
			
			<button type="submit" class="buttton">
					<span>Create</span>
			</button>
		</form>
	</div>
	
	<div><?php echo CreateParentPages(0)?></div>
</div>

</body>

</html>
