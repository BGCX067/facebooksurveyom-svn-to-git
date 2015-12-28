/*************************************************************************************************************************
	Below is a sample how to use it. you will need to replace test4.php with a name of valid page
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
	<script type="text/javascript" src="ajax.content.changer.js"></script>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Untitled 1</title>
	</head>
	
	<body>
	<a href="#" onclick="getdata('test4.php','content1');">Click here – put it in content box 1</a>
	  
	<a href="#" onclick="getdata('test.php','content2');">Click here – put it in content box 2</a>
	
	<div id="content1" style="border: 1px solid #cccccc;width:640px;height:240px; overflow:auto">CONT1 </div>
	<div id="content2" style="border: 1px solid #cccccc;width:640px;height:240px; overflow:auto">CONT2 </div>
	</body>
	
	</html>
	
	
	
**************************************************************************************************************************/

// here we define global variable
var ajaxdestination="";

function getdata(what,where) { // get data from source (what)
 try {
   xmlhttp = window.XMLHttpRequest?new XMLHttpRequest():
  		new ActiveXObject("Microsoft.XMLHTTP");
 }
 catch (e) { /* do nothing */ }

 document.getElementById(where).innerHTML ="<center><img src='loading.gif'></center>";
// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
 ajaxdestination=where;
 xmlhttp.onreadystatechange = triggered; // when request finished, call the function to put result to destination DIV
 xmlhttp.open("GET", what);
 xmlhttp.send(null);
  return false;
}

function triggered() { // put data returned by requested URL to selected DIV
  if (xmlhttp.readyState == 4) if (xmlhttp.status == 200) 
    document.getElementById(ajaxdestination).innerHTML =xmlhttp.responseText;
}



