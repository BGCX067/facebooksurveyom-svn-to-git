<?php
/*************************************************************************************************************************
	DO NOT TAMPER UNNECESSARILY
**************************************************************************************************************************/

$local				= 0;
$live				= 1;
$connect_database	= 1;
$debug_mode			= 1;

/*************************************************************************************************************************
	ON LOCAL COMPUTER
**************************************************************************************************************************/

if ($local == 1) {

	$username 			= "root";
	$password 			= "";
	$server				= "localhost";
	$database			= "masterbase";
	
	$absoluteURL		= "http://localhost/common.platform/websphere/";	
	$docRoot 			= $_SERVER['DOCUMENT_ROOT']."/common.platform/websphere/";
	
}


/*************************************************************************************************************************
	ON LIVE SERVER
**************************************************************************************************************************/

if ($live == 1) {

	$username 			= "wwwmrest_vishal";
	$password 			= "alphabeta#1";
	$server				= "localhost";
	$database			= "wwwmrest_survey";
	
	$absoluteURL		= "http://facebooksurvey.mauritiusresto.com/";	
	$docRoot 			= $_SERVER['DOCUMENT_ROOT']."/";

}


/*************************************************************************************************************************
	CONNECT TO DATABASE
**************************************************************************************************************************/

if ($connect_database == 1) {

	$DBlink = mysql_connect($server, $username, $password) or die('databse not found');
	mysql_select_db($database) or die('Masterconfig error:'. mysql_error());
	session_start();
}



/*************************************************************************************************************************
	CALL THE FUNCTIONS TO BE USED. general.php CALLS THE OTHER FUNCTION BASES
**************************************************************************************************************************/

include $docRoot.'/includes/function.base/general.php';



?>