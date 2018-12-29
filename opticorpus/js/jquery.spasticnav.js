(function($) {

	$.fn.spasticNav = function(options) {
	
		options = $.extend({
			xHeight : -30,
			xWidth : 0,
			hWidth : 20,
			hLeft : -2,
			hTop : 2,
			speed : 1000,
			reset : 300,
			color : '#D0D0D0',
			easing : 'easeOutExpo'
		}, options);
	
		return this.each(function() {
		
		 	var nav = $(this),
		 		currentPageItem = $('.aktive', nav),
		 		blob,
		 		reset;
			if($(currentPageItem).attr('class')) {
				$('<li id="blob"></li>').css({
					width : currentPageItem.outerWidth() + options.xWidth,
					height : currentPageItem.outerHeight() + options.xHeight,
					left : currentPageItem.position().left + options.hLeft,
					top : currentPageItem.position().top - options.xHeight / 2 + options.hTop,
					backgroundColor : options.color
				}).appendTo(this);
			}
		 	blob = $('#blob', nav);
					 	
			$('li:not(#blob)', nav).hover(function() {
				// mouse over
				clearTimeout(reset);
				blob.animate(
					{
						left : $(this).position().left + options.hLeft,
						width : $(this).width() + options.hWidth
					},
					{
						duration : options.speed,
						easing : options.easing,
						queue : false
					}
				);
			}, function() {
				// mouse out	
				reset = setTimeout(function() {
					blob.animate({
						width : currentPageItem.outerWidth() + options.xWidth,
						left : currentPageItem.position().left + options.hLeft
					}, options.speed)
				}, options.reset);
				
			});
		 
		
		}); // end each
	
	};

})(jQuery);