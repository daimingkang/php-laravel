/*!
 * jQuery plugin gapples v1.0
 * posfixed
 * http://gapples.sinaapp.com/
 *
 * Copyright 2013 gapples.sinaapp.com
 * Released under the GPLv2 license
 * http://gapples.sinaapp.com/license
 * 
 * Written by Boyn Xiong
 * Date: 2013-1-3
 */
(function(jQuery){

	if(jQuery.browser) return;

	jQuery.browser = {};
	jQuery.browser.mozilla = false;
	jQuery.browser.webkit = false;
	jQuery.browser.opera = false;
	jQuery.browser.msie = false;

	var nAgt = navigator.userAgent;
	jQuery.browser.name = navigator.appName;
	jQuery.browser.fullVersion = ''+parseFloat(navigator.appVersion);
	jQuery.browser.majorVersion = parseInt(navigator.appVersion,10);
	var nameOffset,verOffset,ix;

// In Opera, the true version is after "Opera" or after "Version"
	if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
		jQuery.browser.opera = true;
		jQuery.browser.name = "Opera";
		jQuery.browser.fullVersion = nAgt.substring(verOffset+6);
		if ((verOffset=nAgt.indexOf("Version"))!=-1)
			jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
	}
// In MSIE, the true version is after "MSIE" in userAgent
	else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
		jQuery.browser.msie = true;
		jQuery.browser.name = "Microsoft Internet Explorer";
		jQuery.browser.fullVersion = nAgt.substring(verOffset+5);
	}
// In Chrome, the true version is after "Chrome"
	else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
		jQuery.browser.webkit = true;
		jQuery.browser.name = "Chrome";
		jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
	}
// In Safari, the true version is after "Safari" or after "Version"
	else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
		jQuery.browser.webkit = true;
		jQuery.browser.name = "Safari";
		jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
		if ((verOffset=nAgt.indexOf("Version"))!=-1)
			jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
	}
// In Firefox, the true version is after "Firefox"
	else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
		jQuery.browser.mozilla = true;
		jQuery.browser.name = "Firefox";
		jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
	}
// In most other browsers, "name/version" is at the end of userAgent
	else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) <
		(verOffset=nAgt.lastIndexOf('/')) )
	{
		jQuery.browser.name = nAgt.substring(nameOffset,verOffset);
		jQuery.browser.fullVersion = nAgt.substring(verOffset+1);
		if (jQuery.browser.name.toLowerCase()==jQuery.browser.name.toUpperCase()) {
			jQuery.browser.name = navigator.appName;
		}
	}
// trim the fullVersion string at semicolon/space if present
	if ((ix=jQuery.browser.fullVersion.indexOf(";"))!=-1)
		jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix);
	if ((ix=jQuery.browser.fullVersion.indexOf(" "))!=-1)
		jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix);

	jQuery.browser.majorVersion = parseInt(''+jQuery.browser.fullVersion,10);
	if (isNaN(jQuery.browser.majorVersion)) {
		jQuery.browser.fullVersion = ''+parseFloat(navigator.appVersion);
		jQuery.browser.majorVersion = parseInt(navigator.appVersion,10);
	}
	jQuery.browser.version = jQuery.browser.majorVersion;
})(jQuery);
(function($){
    $.extend($.fn, {
		posfixed: function(configSettings){
            var settings = {
            	direction:"top",
            	type:"while",
            	hide:false,
				distance:0,
				voffset:0
			};			
			$.extend(settings, configSettings);

			//initial
			if($.browser.msie&&$.browser.version==6.0){
				$("html").css("overflow","hidden");
				$("body").css({
					height:"100%",
					overflow:"auto"
				});
			}
			
			var obj = this;
			var initPos = $(obj).offset().top;
			var initPosLeft = $(obj).offset().left;
			var anchoredPos = settings.distance;

			if(settings.type=="while"){
				if($.browser.msie&&$.browser.version==6.0){
					$("body").scroll(function(event) {
						var objTop = $(obj).offset().top - $("body").scrollTop();
						if(objTop<=settings.distance){
							$(obj).css("position","absolute");
							$(obj).css("top",settings.distance+"px");
							$(obj).css("left",initPosLeft+"px");
						}
						if($(obj).offset().top<=initPos){						
							$(obj).css("position","static");
						}
					});
					
				}else{
					$(window).scroll(function(event) {
						if(settings.direction == "top"){
							var objTop = $(obj).offset().top - $(window).scrollTop();
						
							if(objTop<=settings.distance){
								$(obj).css("position","fixed");
								$(obj).css(settings.direction,settings.distance+"px");
								
							}
							if($(obj).offset().top<=initPos){
								$(obj).css("position","static");
							}
						}
						else if(settings.direction == "side"){
							if(($(obj).outerHeight(true)+settings.voffset) > $(window).height()){
								if(($(obj).outerHeight(true)+settings.voffset) < $(document).height()){
									$(obj).css("position","fixed");
									$(obj).css("bottom",settings.distance+"px");
								}
							}
							else {
								$(obj).css("position","fixed");
								$(obj).css("top",settings.distance+"px");
							}
							if($(obj).offset().top<=initPos){
								$(obj).css("position","static");
							}
						}
						else{
							var objBottom = $(window).height() - $(obj).offset().top + $(window).scrollTop() - $(obj).outerHeight() ;
							
							if(objBottom<=settings.distance){
								
								$(obj).css("position","fixed");
								$(obj).css(settings.direction,settings.distance+"px");
								
							}
							if($(obj).offset().top>=initPos){
								$(obj).css("position","static");
							}
						}
						


					});
				}
			}
			
			if(settings.type=="always"){
				if($.browser.msie&&$.browser.version==6.0){
					if(settings.hide){
						$(obj).hide();
					}
					$("body").scroll(function(event) {
						if($("body").scrollTop()>300){
							$(obj).fadeIn(200);
						}else{
							$(obj).fadeOut(200);
						}
					});
					$(obj).css("position","absolute");
					$(obj).css(settings.direction,settings.distance+"px");
					if(settings.tag!=null){
						if(settings.tag.obj!=null){
							if(settings.tag.direction=="right"){
								$(obj).css("left",(settings.tag.obj.offset().left+settings.tag.obj.width()+settings.tag.distance)+"px");
								$(window).resize(function(){
									$(obj).css("left",(settings.obj.tag.offset().left+settings.tag.obj.width()+settings.tag.distance)+"px");
								});
							}else{
								console.log(settings.tag.obj.offset().left-settings.tag.obj.width()-settings.tag.distance);
								$(obj).css("left",(settings.tag.obj.offset().left-$(obj).outerWidth()-settings.tag.distance)+"px");
								$(window).resize(function(){
									$(obj).css("left",(settings.tag.obj.offset().left-$(obj).outerWidth()-settings.tag.distance)+"px");
								});
							}
							
						}else{
							$(obj).css(settings.tag.direction,settings.tag.distance+"px");
						}
					}

				}else{
					if(settings.hide){
						$(obj).hide();
					}
					$(window).scroll(function(event) {
						if($(window).scrollTop()>300){
							$(obj).fadeIn(200);
						}else{
							$(obj).fadeOut(200);
						}
					});
					var objLeft = $(obj).offset().left;

					$(obj).css("position","fixed");
					$(obj).css(settings.direction,settings.distance+"px");
					if(settings.tag!=null){
						if(settings.tag.obj!=null){
							if(settings.tag.direction=="right"){
								$(obj).css("left",(settings.tag.obj.offset().left+settings.tag.obj.width()+settings.tag.distance)+"px");
								$(window).resize(function(){
									$(obj).css("left",(settings.obj.tag.offset().left+settings.tag.obj.width()+settings.tag.distance)+"px");
								});
							}else{
								console.log(settings.tag.obj.offset().left-settings.tag.obj.width()-settings.tag.distance);
								$(obj).css("left",(settings.tag.obj.offset().left-$(obj).outerWidth()-settings.tag.distance)+"px");
								$(window).resize(function(){
									$(obj).css("left",(settings.tag.obj.offset().left-$(obj).outerWidth()-settings.tag.distance)+"px");
								});
							}
							
						}else{
							$(obj).css(settings.tag.direction,settings.tag.distance+"px");
						}
					}
				}
				
				
				
			}
			
			
		}
	});
	
	
})(jQuery);
