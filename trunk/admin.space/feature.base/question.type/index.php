<?php 
include '../../../includes/configuration/master.configuration.php';
include $docRoot.'includes/php.module/fckeditor/fckeditor.php';	
checkAdminSpaceLogin();

$navigation_id 	= SanitizeData($_GET['id']);
$mySQL			= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$navigation_id'";
$recSET			= mysql_query($mySQL) or die (mysql_error());
$recROW			= mysql_fetch_assoc($recSET);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
<title>Untitled 1</title>

<script type="text/javascript" src="../../../includes/javascript/jquery.animated.collapse.js"></script>
<script type="text/javascript" src="../../../includes/javascript/jquery.animated.collapse.code.js"></script>

<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css" >
<link href="../../../includes/style/form.css" rel="stylesheet" type="text/css" >

<style type="text/css">


</style>

</head>

<body>
<form method="post" action="save.php?id=<?php echo SanitizeData($_GET['id']) ?>" class="content_body_form form_class" style="width:750px; margin-right: auto; margin-left: auto;">
	<h2><?php echo $recROW['nav_tab_name']?></h2>
		<div class="editor_page">
		<ul>
			<li style="margin-left:0px; padding:0px; background:none"><a href="<?php echo $absoluteURL?>admin.space/website.navigation/">Website Navigation</a></li>
			<?php echo html_entity_decode(return_cats_path_nolink(SanitizeData($_GET['id']),$lang=$_SESSION['languageID'],1,1))?>
		</ul>
		</div>
		
		<p style="clear:both; padding:10px"></p>

		<?php
        $questiontypeSQL        = "SELECT * FROM question_type WHERE nav_tab_id = '$navigation_id'";
        $questiontypeSET        = mysql_query($questiontypeSQL) or die(mysql_error());
        $questiontypeROW        = mysql_fetch_assoc($questiontypeSET); 
        ?>

			
		<div class="content_title"><a href="javascript:animatedcollapse.toggle('content_<?php echo $recROW['question_type_id']?>')">Set the question type</a></div>
		<div class="content_body" id="content_<?php echo $recROW['question_type_id']?>" style="display:<?php if (languageCount() > 1) echo "none"?>; background-color: #F4F4F4;">
            <p>
                Declare question time:
                <select name="question_type">
                  <option value="1" <?php if($questiontypeROW['question_type']=='1') echo 'selected'?>>Single answer</option>
                  <option value="2" <?php if($questiontypeROW['question_type']=='2') echo 'selected'?>>Multiple answer</option>
                  <option value="3" <?php if($questiontypeROW['question_type']=='3') echo 'selected'?>>Open ended type</option>
                  <option value="4" <?php if($questiontypeROW['question_type']=='4') echo 'selected'?>>Rating type</option>
                </select>                
            </p>
		</div>
		
		<script type="text/javascript">	animatedcollapse.addDiv('content_<?php echo $recROW['question_type_id']?>', 'fade=0,speed=1000')</script

	    <div style="border-top-style: dotted; border-top-width: 1px; border-top-color: #C0C0C0">
	
		<button type="submit" class="buttton" style="float:left; margin:15px 0px 15px 0px"><span>Save</span></button>
				
	</div>
</form>
</body>

</html>