/*************************************************************************************************************************
	This code was initially used on Scomat for the slider effect on the home page. To use the code on a page 
	
	
	-- This part of the script should be in the header
	
	<script language="javascript" type="text/javascript" src="includes/javascript/jquery-1.2.3.min.js"></script>
	<script language="javascript" type="text/javascript" src="includes/javascript/jquery.flow.1.1.new.js"></script>
	
	<script language="javascript" type="text/javascript">
	$(document).ready(function(){
	
		$("#myController").jFlow({
			slides: "#mySlides",
			width: "540px",
			height: "288px",
			duration: 600
		});
	});
	
	</script>
	
	
	-- Below is how you construct your Container and their corresponding controller
	
	<div id="myController">
		<span class="jFlowControl">No 1 </span>
		<span class="jFlowControl">No 2 </span>
		<span class="jFlowControl">No 3 </span>
		<span class="jFlowControl">No 4 </span>
	</div>
	
	<div id="mySlides">
		<div>First Slide</div>
		<div>Second Slide</div>
		<div>Third Slide </div>
		<div>Fourth Slide </div>
	</div>
	
	
	-----------------------------------------------------------
		SPECIAL NOTE : Amizer
	-----------------------------------------------------------
	
	To enable to automatic sliding, uncomment the dotimer() function
		
**************************************************************************************************************************/

(function($) {

	$.fn.jFlow = function(options) {
		var opts = $.extend({}, $.fn.jFlow.defaults, options);
		var cur = 0;
		var timer;
		var selected_class = "jFlowSelected";
		
				
		var maxi = $(".jFlowControl").length;
		$(this).find(".jFlowControl").each(function(i){
			$(this).click(function(){
				
				if (opts.autorotate == 'yes') dotimer(); 
				
				$(".jFlowControl").removeClass(selected_class);
				$(this).addClass(selected_class);
				//alert(cur);
				//alert(i);
				var dur = Math.abs(cur-i);
				$(opts.slides).animate({
					marginLeft: "-" + (i * $(opts.slides).find(":first-child").width() + "px")
				}, opts.duration*(dur));
				cur = i;
			});

			/*  This Code here is used to make the slider work on mouse over the controler
			
			$(this).mouseover(function(){
				
				$(".jFlowControl").removeClass(selected_class);
				$(this).addClass(selected_class);
				//alert(cur);
				//alert(i);
				var dur = Math.abs(cur-i);
				$(opts.slides).animate({
					marginLeft: "-" + (i * $(opts.slides).find(":first-child").width() + "px")
				}, opts.duration*(0.2));
				cur = i;
				clearInterval(timer);
			});
			*/
			
			$(this).mouseout(function(){
				//dotimer();
				if (opts.autorotate == 'yes') dotimer();   
			});
		});	

		$(opts.slides).before('<div id="jFlowSlide"></div>').appendTo("#jFlowSlide");

		$(opts.slides).find("div").each(function(){
			$(this).before('<div class="jFlowSlideContainer"></div>').appendTo($(this).prev());
		});

		//initialize the controller
		$(".jFlowControl").eq(cur).addClass(selected_class);

		var resize = function (x){
			$("#jFlowSlide").css({
				position: "relative",
				width: opts.width,
				height: opts.height,
				overflow: "hidden"
			});

			$(opts.slides).css({
				position:"relative",
				width: $("#jFlowSlide").width()*$(".jFlowControl").length+"px",
				height: $("#jFlowSlide").height()+"px",
				overflow: "hidden"
			});

			$(opts.slides).children().css({
				position: "relative",
				width: $("#jFlowSlide").width()+"px",
				height: $("#jFlowSlide").height()+"px",
				"float":"left"
			});

			$(opts.slides).css({
				marginLeft: "-" + (cur * $(opts.slides).find(":first-child").width() + "px")
			});
		}

		resize();

		$(window).resize(function(){
			resize();
		});

		$(".jFlowPrev").click(function(){
			//dotimer();
			if (opts.autorotate == 'yes') dotimer();   
			doprev();
		});
		
		var doprev = function (x){
			if (cur > 0)
				cur--;
			else
				cur = maxi -1;

			$(".jFlowControl").removeClass(selected_class);
			$(opts.slides).animate({
				marginLeft: "-" + (cur * $(opts.slides).find(":first-child").width() + "px")
			}, opts.duration);
			$(".jFlowControl").eq(cur).addClass(selected_class);
		}
		
		//$(".jFlowControl").mouseover

		$(".jFlowNext").click(function(){
			donext();
			//dotimer();
			if (opts.autorotate == 'yes') dotimer();   
		});

		var donext = function (x){
			if (cur < maxi - 1)
				cur++;
			else
				cur = 0;

			$(".jFlowControl").removeClass(selected_class);
			$(opts.slides).animate({
				marginLeft: "-" + (cur * $(opts.slides).find(":first-child").width() + "px")
			}, opts.duration);
			$(".jFlowControl").eq(cur).addClass(selected_class);
		}

		var dotimer = function (x){
			if(timer != null) 
			    clearInterval(timer);
			    
        		timer = setInterval(function() {
	                	donext();
    	        	}, 5000);
    	        	
    	        }

		//dotimer();
		if (opts.autorotate == 'yes') dotimer();   
	};

	$.fn.jFlow.defaults = {
		easing: "swing",
		duration: 600,
		width: "100%"
	};

})(jQuery);