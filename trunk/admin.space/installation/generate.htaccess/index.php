<?php 
include '../../../includes/configuration/master.configuration.php';
checkAdminSpaceLogin();

/*************************************************************************************************************************
	SET THE VARIABLES HERE
**************************************************************************************************************************/
$file			= GetSetting('mod_rewrite_file');
$download		= GetSetting('mod_rewrite_download');

$linebreak		= chr(13).chr(10);
$seo1			= "RewriteRule ^(.*)?";
$seo2			= "([^/]+)/([^/]+)\.html		";
$string			= "&%{QUERY_STRING}";		
$variables		= "?".GetSetting('mod_rewrite_variable1')."=$2&".GetSetting('mod_rewrite_variable2')."=$3".$string.$linebreak;



if(GetSetting('mod_rewrite')<>'on') {
	if (file_exists($docRoot.$file)) unlink($docRoot.$file);
}


if(GetSetting('mod_rewrite')=='on') {
$somecontent	= $somecontent."Options +FollowSymlinks".$linebreak;
$somecontent	= $somecontent."RewriteEngine on".$linebreak;




/*************************************************************************************************************************
	BUILD UP THE .htaccess FILE FROM THE TEMPLATE TABLE
**************************************************************************************************************************/
$mySQL	= "SELECT * FROM template WHERE seo_link <> '' ORDER BY template_type ASC";
$recSET	= mysql_query($mySQL) or die (mysql_error());
while ($recROW = mysql_fetch_assoc($recSET)) {

	$middleContent	= $middleContent.$seo1.$recROW['seo_link'].$seo2.$absoluteURL.$recROW['link'].$variables;

}

$somecontent	= $somecontent.$middleContent;


/*************************************************************************************************************************
	DEFINE THE PATH OF THE FILE TO WRITE IN
**************************************************************************************************************************/
$filename = $docRoot.$file;


/*************************************************************************************************************************
	CHECK IF FILE IS WRITEABLE AND WRITE TO IT
**************************************************************************************************************************/
if (!$handle = fopen($filename, 'w')) {
	echo "Cannot open file ($filename)";
	exit;
}

if (fwrite($handle, $somecontent) === FALSE) {
	echo "Cannot write to file ($filename)";
	exit;
}

//echo "Success, wrote (".str_replace('\n', '<br>', $somecontent).") to file ($filename)";


/*************************************************************************************************************************
	CLOSE THE FILE
**************************************************************************************************************************/
fclose($handle);


/*************************************************************************************************************************
	DOWNLOAD THE FILE
**************************************************************************************************************************/
if ($download == 'yes') {
	
	$link	= $absoluteURL.$file;
	header("location:$link");
	
}

if ($debug_mode == 1) print_r(str_replace(chr(13).chr(10), '<br>', $somecontent));

}
?>





<head>
<link href="../../../includes/style/admin.space.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>

<div class="messageBox" style="width:900px">
	<h1 style="text-align:left">File Generated successfully</h1>
	<p style="text-align:left"><?php if ($debug_mode <> 1) print_r('Thank you for your kind patience');?></p><br><br>
	<p style="text-align:left"><?php if ($debug_mode == 1) print_r(str_replace('		', '&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;', str_replace(chr(13).chr(10), '<br>', $somecontent)));?></p><br><br>
</div>