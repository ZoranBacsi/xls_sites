/* Fejlesztő H.Tibor */
function LoadEfects(obj) {
	if(!obj) { var obj = $('html,body'); }
	if(parseFloat($('html').width())>1000) {
		
		$('.side-to, .side-left-to, .side-right-to',obj).each(function() {
			$(this).wrap('<div class="effect-wrap" style="width:'+parseFloat($(this).outerWidth())+'px;height:'+parseFloat($(this).outerHeight())+'px;"></div>');
		});
		
		$('.side-to',obj).each(function() {
			$(this).css({'position':'absolute', 'top':'0px', 'left':'0px', 'opacity':'0'});
		});
		
		$('.side-left-to',obj).each(function() {
			$(this).css({'position':'absolute', 'top':'0px', 'left':'-'+parseFloat($(this).outerWidth())*0.75+'px', 'opacity':'0'});
		});
		
		$('.side-right-to',obj).each(function() {
			$(this).css({'position':'absolute', 'top':'0px', 'left':''+parseFloat($(this).outerWidth())*0.75+'px', 'opacity':'0'});
		});
		
		$(document).scroll(function() { runEffects(obj); });
		runEffects(obj);
	}
	
}

function runEffects(obj) {
	var sTop = parseFloat($(window).scrollTop());
	var dHeight = parseFloat($(window).height());
	var dWidth = parseFloat($(document).width());
	
	$('.side-to, .side-left-to, .side-right-to',obj).each(function() {
		var eTop = parseFloat($(this).offset().top)-(dHeight*0.60);
		if(!($(this).hasClass('effectLoaded')) && sTop>=eTop) {
			$(this).animate({'position':'absolute', 'top':'0px', 'left':'0px', 'opacity':'1'},1000);
			$(this).addClass('effectLoaded');
		}
	});
}