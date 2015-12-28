<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

//$date = date(3/1/2006);
//$date = getdate($date);
//$fromdate	= date("Y-m-d", mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']));
//echo $fromdate;

if(!function_exists('str_split')){
   function str_split($string,$split_length=1){
       $count = strlen($string); 
       if($split_length < 1){
           return false; 
       } elseif($split_length > $count){
           return array($string);
       } else {
           $num = (int)ceil($count/$split_length); 
           $ret = array(); 
           for($i=0;$i<$num;$i++){ 
               $ret[] = substr($string,$i*$split_length,$split_length); 
           } 
           return $ret;
       }     
   }  
}

if (ISSET($_POST['export'])) {

$fromdate	= date("Y-m-d H:i:s", mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']));
$todate		= date("Y-m-d H:i:s", mktime(23, 59, 29, $_POST['monthto'], $_POST['dayto'], $_POST['yearto']));

$fromdate1	= date("Y-m-d", mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']));
$todate1	= date("Y-m-d", mktime(23, 59, 29, $_POST['monthto'], $_POST['dayto'], $_POST['yearto']));


$category	= "guide";
$mySQL		= "SELECT * FROM feedback WHERE category = '$category' AND date >= '$fromdate' AND date <= '$todate' ORDER BY date DESC";
$recSET		= mysql_query($mySQL) or die(mysql_error());
$reccount		= mysql_num_rows($recSET);

$sep1			= "\"";
$sep2			= "\",\"";
$end			= "\n";
$blank			= " ";

$filename = "csv/".$fromdate1."to".$todate1.".csv";
if (file_exists($filename)) unlink($filename);
$handle = fopen($filename, 'a');

while ($recROW	= mysql_fetch_assoc($recSET)) {
	$array1		= $recROW['title'];
	$array2		= $recROW['first_name'];;
	$array3		= $recROW['surname'];
	$array4		= $recROW['address_2'];
	$array5		= $recROW['postcode'];
	$array6		= $recROW['email_add'];
	
	
	$array7		= $recROW['daytime_tel'];
	$array7		= str_replace(' ', '', $array7);
	$stringlen	= strlen($array7);
	if ($stringlen > 6) {	
		$breakpt	= $stringlen - 6;
		$strsplit	= str_split($array7, $breakpt);	
		$array7_1	= $strsplit[0];
		$array7		= $strsplit[0]." ".$strsplit[1].$strsplit[2].$strsplit[3].$strsplit[4].$strsplit[5];
	}
	
	$array8		= $blank;
	$array9		= $blank;
	$array10	= $recROW['property_value'];
	$array11	= $blank;
	
	$how_many	= $recROW['how_many'];
	if ($how_many == "nil") $how_many = "0";
	if ($how_many == "&gt;3") $how_many = ">3";
	$array12	= $how_many;
	
	$array13	= $blank;
	$array14	= $blank;
	$array15	= $blank;
	$array16	= $recROW['comments'];
	$array17	= $blank;
	$array18	= $blank;
	$array19	= $blank;
	$array20	= "buytolet4sale";
	$array21	= $blank;
	$array22	= $blank;
	$array23	= $blank;
	$array24	= $blank;
	$array25	= $blank;
	$array26	= $blank;
	$array27	= $blank;
	$array28	= $blank;
	$array29	= $blank;
	$array30	= $blank;
	$array31	= $blank;
	$array32	= $blank;
	$array33	= $blank;
	$array34	= $blank;
	$array35	= $blank;
	$array36	= $blank;
	$array37	= $blank;
	$array38	= $blank;
	$array39	= $blank;
	$array40	= $blank;
	$array41	= $blank;
	$array42	= $blank;
	
	$csvline	= $sep1.$array1;
	$csvline	= $csvline.$sep2.$array2;
	$csvline	= $csvline.$sep2.$array3;
	$csvline	= $csvline.$sep2.$array4;
	$csvline	= $csvline.$sep2.$array5;
	$csvline	= $csvline.$sep2.$array6;
	$csvline	= $csvline.$sep2.$array7;
	$csvline	= $csvline.$sep2.$array8;
	$csvline	= $csvline.$sep2.$array9;
	$csvline	= $csvline.$sep2.$array10;
	$csvline	= $csvline.$sep2.$array11;
	$csvline	= $csvline.$sep2.$array12;
	$csvline	= $csvline.$sep2.$array13;
	$csvline	= $csvline.$sep2.$array14;
	$csvline	= $csvline.$sep2.$array15;
	$csvline	= $csvline.$sep2.$array16;
	$csvline	= $csvline.$sep2.$array17;
	$csvline	= $csvline.$sep2.$array18;
	$csvline	= $csvline.$sep2.$array19;
	$csvline	= $csvline.$sep2.$array20;
	$csvline	= $csvline.$sep2.$array21;
	$csvline	= $csvline.$sep2.$array22;
	$csvline	= $csvline.$sep2.$array23;
	$csvline	= $csvline.$sep2.$array24;
	$csvline	= $csvline.$sep2.$array25;
	$csvline	= $csvline.$sep2.$array26;
	$csvline	= $csvline.$sep2.$array27;
	$csvline	= $csvline.$sep2.$array28;
	$csvline	= $csvline.$sep2.$array29;
	$csvline	= $csvline.$sep2.$array30;
	$csvline	= $csvline.$sep2.$array31;
	$csvline	= $csvline.$sep2.$array32;
	$csvline	= $csvline.$sep2.$array33;
	$csvline	= $csvline.$sep2.$array34;
	$csvline	= $csvline.$sep2.$array35;
	$csvline	= $csvline.$sep2.$array36;
	$csvline	= $csvline.$sep2.$array37;
	$csvline	= $csvline.$sep2.$array38;
	$csvline	= $csvline.$sep2.$array39;
	$csvline	= $csvline.$sep2.$array40;
	$csvline	= $csvline.$sep2.$array41;
	$csvline	= $csvline.$sep2.$array42;
	$csvline	= $csvline.$sep1.$end;
	
	
	fwrite($handle, $csvline);
}

}


?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>New Page 1</title>
</head>

<body>

<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<?php if (!ISSET($_POST['export'])) { ?>
<form method="POST" action="archive.php">
	<div align="center">
		<table border="0" width="477" id="table2" cellspacing="0" cellpadding="0" height="116">
			<tr>
				<td bgcolor="#EBEBEB">
				<div align="center">
					<table border="0" width="93%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td>
							<p style="margin-bottom: 10px"><b>
							<font face="Arial" size="4">Input the date range 
							here</font></b></td>
						</tr>
						<tr>
							<td width="84%" valign="top">
							
							<select size="1" name="day">
							<option>date</option>
							<?php 
							$count	= 1;
							while ($count < 32) {
							?>
							<option value="<?php echo $count?>"><?php echo $count?></option>
							<?php 
							$count = $count + 1;
							} 
							?>
							</select>
							<select size="1" name="month">
							<option>month</option>
							<?php 
							$count	= 1;
							while ($count < 13) {
							?>
							<option value="<?php echo $count?>"><?php echo $count?></option>
							<?php 
							$count = $count + 1;
							} 
							?>
							</select>
							<select size="1" name="year">
							<option>year</option>
							<?php 
							$count	= 2005;
							while ($count < 2106) {
							?>
							<option value="<?php echo $count?>"><?php echo $count?></option>
							<?php 
							$count = $count + 1;
							} 
							?>
							</select>
							<font face="Arial" style="font-size: 8pt; font-weight: 700">
							TO </font>
							
							<select size="1" name="dayto">
							<option>day</option>
							<?php 
							$count	= 1;
							while ($count < 32) {
							?>
							<option value="<?php echo $count?>"><?php echo $count?></option>
							<?php 
							$count = $count + 1;
							} 
							?>
							</select>
							<select size="1" name="monthto">
							<option>month</option>
							<?php 
							$count	= 1;
							while ($count < 13) {
							?>
							<option value="<?php echo $count?>"><?php echo $count?></option>
							<?php 
							$count = $count + 1;
							} 
							?>
							</select>
							<select size="1" name="yearto">
							<option>year</option>
							<?php 
							$count	= 2005;
							while ($count < 2106) {
							?>
							<option value="<?php echo $count?>"><?php echo $count?></option>
							<?php 
							$count = $count + 1;
							} 
							?>
							</select>
														
							<input type="submit" value="export" name="export" style="font-family: Arial; font-size: 8pt"></td>
							
						</tr>
					</table>
				</div>
				</td>
			</tr>
		</table>
	</div>
</form>
<?php } ?>
<div align="center">
<?php if (isset($_POST['export'])) {?>
	<table border="0" width="66%" id="table1" cellspacing="0" cellpadding="0" height="210">
		<tr>
			<td bgcolor="#EBEBEB">
			<p align="center" style="margin-top: 0; margin-bottom: 0">
			<font face="Arial" size="5" color="#4E4E4E">Database exported 
			successfully</font></p>
			<p align="center" style="margin-top: 0; margin-bottom: 0"><b>
			<font face="Arial"><font color="#4E4E4E"><?php echo $reccount?> lines written to </font>
			<a href="<?php echo $filename?>"><font color="#4E4E4E">
			<?php echo $fromdate1."to".$todate1.".csv"?></font></a></font></b></p>
			<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p align="center" style="margin-top: 0; margin-bottom: 0">
			<font face="Arial" style="font-size: 8pt">from <?php echo $fromdate?> to <?php echo $todate?></font></p>
			<p align="center" style="margin-top: 0; margin-bottom: 0">
			<font face="Arial" size="1" color="#4E4E4E">to save the file 
			right-click on the link and click on save target as</font></td>
		</tr>
	</table>
<?php } ?>
</div>

</body>

</html>