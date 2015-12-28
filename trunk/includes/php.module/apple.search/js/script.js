/*
* Author:      Marco Kuiper (http://www.marcofolio.net/)
*/

/*************************************************************************************************************************
		COMMENTS FROM VISHAL: 
		
		This Script uses jsapi from google. So need to call that first. Use as follow
		
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<script type="text/javascript" src="js/script.js"></script>
		
		the text box should be as follows:
		
		<input type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value, '<?php echo $absoluteURL?>');" />
		
		
**************************************************************************************************************************/




function lookup(inputString, absoluteURL) {
	if(inputString.length == 0) {
		$('#suggestions').fadeOut(); // Hide the suggestions box
	} else {
		$.post(absoluteURL+"/includes/webfiles/quick.search.php", {queryString: ""+inputString+""}, function(data) { // Do an AJAX call
			$('#suggestions').fadeIn(); // Show the suggestions box
			$('#suggestions').html(data); // Fill the suggestions box
		});
	}
	 $("#inputString").blur(function(){
		$('#suggestions').fadeOut();
	 });
}