<?php
$username   = "wwwmrest_vishal";
$password   = "alphabeta#1";
$database   = "wwwmrest_survey";
$server     = "localhost";

$DBlink = mysql_connect($server, $username, $password) or die('databse not found');
mysql_select_db($database) or die('Masterconfig error:'. mysql_error());
?>
