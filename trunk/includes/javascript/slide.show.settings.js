
var preload_ctrl_images=true;

//And configure the image buttons' images here:
var previmg='left.gif';
var stopimg='stop.gif';
var playimg='play.gif';
var nextimg='right.gif';

/*************************************************************************************************************************
	THE SECTION BELOW DEFINES THE FIRST PICTURE slides[0] THIS PICTURE IS OVERWRITTEN IN THE SCRIPT WHEN CALLING THE SHOW
**************************************************************************************************************************/

var slides				=[]; 
slides[0] 				= ["http://www.weblineuk.com/images/template/logo.png", "Website developped by www.weblineuk.com", "http://www.weblineuk.com"];
slides.pause			=1; //use for pause onmouseover
slides.no_controls		=1; //use images for controls
slides.no_descriptions	=1; 
//slides.width			=400; //use to set width of widest image if dimensions vary
//slides.height			=200; //use to set height of tallest image if dimensions vary


/*************************************************************************************************************************
	All options of this slide show can be found here http://www.dynamicdrive.com/dynamicindex14/swissarmy/index.htm <<< check so life
	
	optional properties for these images:
	slides.desc_prefix='<b>Description:<\/b> '; //string prefix for image descriptions display
	slides.controls_top=0; //use for top controls
	slides.counter=0; //use to show image count
	slides.width=140; //use to set width of widest image if dimensions vary
	slides.height=225; //use to set height of tallest image if dimensions vary
	slides.no_auto=0; //use to make show completely user operated (no play button, starts in stopped mode)
	slides.use_alt=0; //use for descriptions as images alt attributes
	slides.use_title=0; //use for descriptions as images title attributes
	slides.nofade=0; //use for no fade-in, fade-out effect for this show
	slides.border=0; //set border width for images
	slides.border_color='lightblue'; //set border color for images

	slides#.target will set a target for a slide group, will be overridden by slides#[#][3], if present
	slides#.specs will set new window specifications for a slide group, will be overridden by slides#[#][4], if present
	slides#.fadecolor will set fading images background color, defaults to white
	slides#.no_controls will set a slide show with no controls
	slides#.random will set a random slide sequence on each page load
	slides#.delay=3000 will set miliseconds delay between slides for a given show, may also be set in the call as the last parameter
	slides#.jumpto=1 will display added controls to jump to a particular image by its number
	slides#.no_added_linebreaks=1; use for no added line breaks in formatting of texts and controls

	use below to create a customized onclick event for linked images in a given show:
	-----------------------------------------------------------------------------------------------------------------------------------------
	slides#.onclick="window.open(this.href,this.target,'top=0, left=0, width='+screen.availWidth+', height='+screen.availHeight);return false;"



	To Display the slide show in your page use the code below
	Usage: new inter_slide(Slides_array_name, Width, Height, Interval)
	-----------------------------------------------------------------------------------------------------------------------------------------

	<script type="text/javascript">
	
		slides[0] = ["http://www.cartersclassicmusclecars.com/images/Cyclone/Carter%20Cars%2015.JPG", "Seated Woman"];
		slides[1] = ["http://www.cartersclassicmusclecars.com/images/Cyclone/Carter%20Cars%2015.JPG", "Seated Woman"];
		slides[2] = ["http://www.fathead.com/_landing_images/land-disney_cars_yellow.jpg"];
		slides[3] = ["http://www.inhabitat.com/wp-content/uploads/c-metisse-06.jpg", "Standing Woman"];
		slides[4] = ["http://www.thedailygreen.com/cm/thedailygreen/images/Uu/smart-cars-blog.jpg", "John, Mary and Jesus"];
		
		new inter_slide(slides)
		
	</script>


**************************************************************************************************************************/


