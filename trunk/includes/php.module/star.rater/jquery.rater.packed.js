jQuery.fn.rater=function(url,options){if(url==null)return;var settings={url : url,maxvalue : 5,curvalue : 0};if(options){jQuery.extend(settings,options);};jQuery.extend(settings,{cancel:(settings.maxvalue>1)?true : false});var container=jQuery(this);jQuery.extend(container,{averageRating: settings.curvalue,url: settings.url});if(!settings.style||settings.style==null||settings.style=='basic'){var raterwidth=settings.maxvalue*25;var ratingparent='<ul class="star-rating" style="width:'+raterwidth+'px">';}if(settings.style=='disabled-big'){var raterwidth=settings.maxvalue*25;var ratingparent='<ul class="star-rating star-disabled" style="width:'+raterwidth+'px">';}if(settings.style=='disabled-small'){var raterwidth=settings.maxvalue*14;var ratingparent='<ul class="star-rating small-star star-disabled" style="width:'+raterwidth+'px">';}if(settings.style=='small'){var raterwidth=settings.maxvalue*14;var ratingparent='<ul class="star-rating small-star" style="width:'+raterwidth+'px">';}if(settings.style=='inline'){var raterwidth=settings.maxvalue*10;var ratingparent='<span class="inline-rating"><ul class="star-rating small-star" style="width:'+raterwidth+'px">';}container.append(ratingparent);var starWidth,starIndex,listitems='';var curvalueWidth=Math.floor(100/settings.maxvalue*settings.curvalue);for(var i=0;i<=settings.maxvalue;i++){if(i==0){listitems+='<li class="current-rating" style="width:'+curvalueWidth+'%;">'+settings.curvalue+'/'+settings.maxvalue+'</li>';}else{starWidth=Math.floor(100/settings.maxvalue*i);starIndex=(settings.maxvalue-i)+2;listitems+='<li class="star"><a href="#'+i+'" title="'+i+'/'+settings.maxvalue+'" style="width:'+starWidth+'%;z-index:'+starIndex+'">'+i+'</a></li>';}}container.find('.star-rating').append(listitems);if(settings.maxvalue>1){container.append('<span class="star-rating-result"></span>');}var stars=jQuery(container).find('.star-rating').children('.star');stars.click(function(){if(settings.style=='disabled'){return false;}if(settings.maxvalue==1){settings.curvalue=(settings.curvalue==0)?1 : 0;jQuery(container).find('.star-rating').children('.current-rating').css({width:(settings.curvalue*100)+'%'});jQuery.post(container.url,{"rating": settings.curvalue});return false;}else{settings.curvalue=stars.index(this)+1;raterValue=jQuery(this).children('a')[0].href.split('#')[1];jQuery.post(container.url,{"rating": raterValue},function(response){container.html(response)});return false;}return true;});return this;}