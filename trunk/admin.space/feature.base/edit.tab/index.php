<?php include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();
			
$id				= SanitizeData($_GET['id']);	

$nav_tab_id 	= SanitizeData($_GET['id']);

$mySQL			= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$id'";
$recSET			= mysql_query($mySQL);
$recROW			= mysql_fetch_assoc($recSET);

$title			= $recROW['nav_tab_name'];

$parent_id		= $recROW['parent_id'];
$nav_tab_name	= $recROW['nav_tab_name'];
$template_id	= $recROW['template_id'];

$parent_id		= $recROW['parent_id']; 
$nav_pos_id		= $recROW['nav_position_id'];



$nav_tabSQL		= "SELECT * from navigation_tab WHERE nav_tab_id = '$parent_id'";
$nav_tabSET		= mysql_query($nav_tabSQL);
$nav_tabROW		= mysql_fetch_assoc($nav_tabSET);

$nav_tab		= $nav_tabROW['nav_tab_name'];


$nav_posSQL		= "SELECT * from navigation_position WHERE nav_position_id = '$nav_pos_id'";
$nav_posSET		= mysql_query($nav_posSQL);
$nav_posROW		= mysql_fetch_assoc($nav_posSET);

$nav_position	= $nav_posROW['nav_position'];

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>New Page 1</title>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" />
<link href="../../../includes/style/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../includes/javascript/call.navigation.template.js"></script>


</head>

<body>
<div class="navigation_structure_backend" >
	<div class="title_space">
			<h1>Website Navigation Structure (edit)</h1>
			<p class="clear"></p>
	</div>
	
	<div id="backend_create_nav" style="display:" class="hidden_box">

		<form method="post" action="save.php?nav_tab_id=<?php echo $nav_tab_id?>" class="form_class">
		<h4>Information</h4>
		<p><label>Title</label><input type="text" name="nav_tab_name" value="<?php echo $nav_tab_name?>" style="margin-left:4px;width:295px"/></p>
		<p><label>Select page template</label>
			<?php 
			/*************************************************************************************************************************
				ON SELECT WILL SELECT MENU FRON NodeStructure.PHP TO POPULATE NEXT DROP DOWN
			**************************************************************************************************************************/
			echo getTemplate($template_id,$nav_tab_id);					
			?>					
		</p>
		<p>
		<label>Select Parent node</label>
								
								<span id="parentnode">
								<?php

									$tempSQL	= "SELECT * FROM template WHERE template_id = '$template_id'";
									$tempSET	= mysql_query($tempSQL);
									$tempROW	= mysql_fetch_assoc($tempSET);
									
									$p_id		= $tempROW['p_id'];
									
									if($p_id > '0'){ ?>
											<select name = "NodeStructure">
												<option>Select</option>
													<?php 
													$query		=	"select * from navigation_tab where template_id='$p_id'";
													$result		=	mysql_query($query);
													while($row	=	mysql_fetch_array($result)) { 
													?>
														<option value="<?php echo $row['nav_tab_id']?>" <?php if ($row['nav_tab_id']==$recROW['parent_id']) echo "selected"?>><?php echo $row['nav_tab_name']?></option>
													<?php } ?>
											</select>
									<?php }
									
									else
									
									echo CreateParentDrop($parent_id,"..");


								?>
								</span>
					</p>
				<button type="submit" class="buttton">
						<span>Save</span>
				</button>
				<button type="button" class="buttton" style="margin-left:10px" onclick="window.location='<?php echo $absoluteURL."admin.space/website.navigation/"?>' ">
						<span>Cancel</span>
				</button>
				</form>
	
	</div>
</div>


</body>

</html>