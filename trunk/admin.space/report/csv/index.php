<?php
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();


$mySQL  = "SELECT DISTINCT session_id FROM facebook";
$recSET = mysql_query($mySQL);
$count  = mysql_num_rows($recSET);

$mySQL	= "SHOW TABLES FROM $database";
$recSET	= mysql_query($mySQL);


?>



<table border="0" width="100%" id="table14" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td>
		<div align="center">
			<form method="POST" action="capture.php">
				<table border="0" width="601" id="table15" cellspacing="0" cellpadding="0" height="236" >
					<tr>
						<td width="349" style="border-left-style: solid; border-left-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px" bordercolor="#808080" bgcolor="#F9F9F9">
						<table border="0" width="100%" id="table5" height="100%" cellspacing="0" cellpadding="0">
							<!--tr>
								<td height="91">
								&nbsp;</td>
								<td height="91" width="321">
								<p style="margin-top: 0; margin-bottom: 0">
								<font face="Arial" size="2">please select a table to 
								export</font></p>
								<p style="margin-top: 0; margin-bottom: 0">
								<select size="1" name="table" style="font-family: Arial; font-size: 10pt; width:312; height:22">
								<?php while ($recROW = mysql_fetch_row($recSET)) {?>
								<option value="<?php echo $recROW[0]?>"><?php echo $recROW[0]?></option>
								<?php }?>
								</select></td>
							</tr!-->
							<tr>
								<td>
								&nbsp;</td>
								<td width="321" valign="top">
								&nbsp;</td>
							</tr>
							<tr>
								<td>
								&nbsp;</td>
								<td width="321" valign="top">
                                <div>
                                    <h1 style="text-align: center; margin: 0px; font-size: 87px;"><?php echo $count?></h1>
                                </div>
								<table border="0" width="311" id="table6" cellspacing="0" cellpadding="0" height="119" style="display: none;">
									<tr>
										<td width="187" align="center" style="border-left-style: solid; border-left-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px" bordercolor="#999999" bgcolor="#EFEFEF">
										<p style="margin-top: 0; margin-bottom: 0; margin-left:15px" align="left">
										<font size="1" face="Arial" color="#C7C7C7">
										starting date</font></p>
										<p style="margin-top: 0; margin-bottom: 0; margin-left:15px" align="left">
										<font size="1">
							
							<select size="1" name="day" style="font-family: Arial; font-size: 8pt; width:50px">
							<option value="1">date</option>
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
							<select size="1" name="month"  style="font-family: Arial; font-size: 8pt; width:50px">
							<option value="1">month</option>
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
							<select size="1" name="year" style="font-family: Arial; font-size: 8pt; width:50px">
							<option value="2000">year</option>
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
							</font></p>
										<p style="margin-left: 15px; margin-top: 0; margin-bottom: 0" align="left">
										<font size="1" face="Arial" color="#C7C7C7">
										ending date</font></p>
										<p style="margin-top: 0; margin-bottom: 0; margin-left:15px" align="left">
										<font size="1">
							
							<select size="1" name="dayto" style="font-family: Arial; font-size: 8pt; width:50px">
							<option value="1">day</option>
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
							<select size="1" name="monthto" style="font-family: Arial; font-size: 8pt; width:50px">
							<option value="1">month</option>
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
							<select size="1" name="yearto" style="font-family: Arial; font-size: 8pt; width:50px">
							<option value="2035">year</option>
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
														
							</font></p></td>
										<td width="124" align="left" style="border-right-style: solid; border-right-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px" bordercolor="#999999" bgcolor="#EFEFEF">
										<p style="margin-left: 10px; margin-right: 10px">
										<font face="Arial" size="1">Choose from starting date to end date. Note that if you dont seelct any date, the default range of date is 
										 01.01.00 - 01.01.35</font></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td>
								&nbsp;</td>
								<td width="321" valign="top">
								&nbsp;</td>
							</tr>
						</table>
						</td>
						<td width="252" style="border-right-style: solid; border-right-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px" bordercolor="#808080" bgcolor="#F9F9F9">
						<p style="margin-left:30px; margin-right:30px; margin-top:10px; margin-bottom:0" class="style1">
						<font size="5">CSV Export File</font></p>
						<p style="margin:0 30px; ">
						<font face="Arial" size="2">A list of data relating to the survey done will be exported in CSV format</font><p style="margin:0 30px; ">
						&nbsp;<p style="margin-left:30px; margin-right:30px; margin-top:0; margin-bottom:20px">
						<input type="submit" value="Export CSV" name="B1" style="font-family: Arial; font-size: 10pt"></td>
					</tr>
				</table>
				<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			</form>
		</div>
		</td>
	</tr>
</table>