/*************************************************************************************************************************
		COMMENTS FROM VISHAL: Used to display the stars on the restaurant about page
**************************************************************************************************************************/
	$('#star_rating').rater('<?php echo $absoluteURL?>includes/webfiles/star.rating.php?resto_id=test_id&menu_id=10', {maxvalue:5, curvalue:3.5});

/*************************************************************************************************************************
		COMMENTS FROM VISHAL: Display the image slider on the about us page
**************************************************************************************************************************/
	$(document).ready(function(){
		$("#controller").jFlow({
			slides: "#slides",
			width: "370px",
			height: "255px",
			autorotate: "yes",
			duration: 600
		});
	});