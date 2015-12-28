<?php include '../../../includes/configuration/master.configuration.php';


$template_id	=	$_REQUEST['template_id'];
$nav_tab_id		=	$_REQUEST['nav_tab_id'];
$NodeStructure 	= 	$template_id;

$mySQL			= "SELECT * FROM navigation_tab WHERE nav_tab_id = '$nav_tab_id'";
$recSET			= mysql_query($mySQL);
$recROW			= mysql_fetch_assoc($recSET);

$parent_id		= $recROW['parent_id'];


$tempSQL	= "SELECT * FROM template WHERE template_id = '$template_id'";
$tempSET	= mysql_query($tempSQL);
$tempROW	= mysql_fetch_assoc($tempSET);

$p_id		= $tempROW['p_id'];

if($p_id > '0'){ ?>
		<select name = "NodeStructure" style="margin-left:-4px">
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

echo CreateParentDrop($parent_id,"...");
?>