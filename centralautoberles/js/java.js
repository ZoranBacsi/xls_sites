/* Készítő: H.Tibor */
function ThemeScript() {
	$('.menuIcon').click(function(){menuOpen();});
	$('.shopIcon').click(function(){shopOpen();});
	$('#SitePage').on("swipeleft",function() { if($('#SitePage').attr('open')) { menuOpen(); } });
	$('#SitePage').on("swiperight",function() { if($('#SitePage').attr('shopopen')) { shopOpen(); } });
	$('#SitePage').animate({'left':'0px'},300,function(){$('#SitePage').attr('open',null);});
	resizeMobile();
	
	$('#nav ul ul').each(
	function() { 
		if(!$(this).parent().hasClass('aktive')){ 
			$(this).css({'display':'none'});  
		} else { 
			$(this).css({'display':'block'}); 
		} 
	});

	/* Első szint */
	$('#nav > ul > li > ul').parent().children('a').unbind('click');
	$('#nav > ul > li > a').click(
		function() {
			if($(this).parent().children('ul')){
				$('#nav > ul > li').removeClass('open');
				$(this).parent().addClass('open');
				$('#nav > ul > li > ul').delay(100).each(
				function(){
					if(!$(this).parent().hasClass('open') && !$(this).parent().hasClass('aktive')){
						$(this).slideUp();
					}
				});  
				$(this).parent().children('ul').slideToggle();
				return false;
			}
		}
	);
	
	/* Második szint */
	$('#nav > ul > li > ul > li > ul').parent().children('a').unbind('click');
	$('#nav > ul > li > ul > li > a').click(
		function() {
			if($(this).parent().children('ul')){
				$('#nav > ul > li > ul > li').removeClass('open');
				$(this).parent().addClass('open');
				$('#nav > ul > li > ul > li > ul').delay(100).each(
					function(){
						if(!$(this).parent().hasClass('open') && !$(this).parent().hasClass('aktive')){
							$(this).slideUp();
						}
					});  
				$(this).parent().children('ul').slideToggle();
				return false;
			}
		}
	);
	
	/* Products Scroll */
	if($('.KiemeltTer')) {
		var StepItem = 1;
		var ItemWidth = 230;
		$('.KiemeltTerList .Products').addClass('KiemeltProducts');
		var Products = parseFloat($('.KiemeltProducts').length);
		$('.KiemeltTerList').css('width',((Products+5)*ItemWidth));
		
		$('.KiemeltTerList .Products:first-child').clone().insertAfter('.KiemeltTerList .Products:last-child');
		$('.KiemeltTerList .Products:last-child').removeClass('KiemeltProducts');
		
		$('.KiemeltTerList .Products:first-child').next().clone().insertAfter('.KiemeltTerList .Products:last-child')
		$('.KiemeltTerList .Products:last-child').removeClass('KiemeltProducts');
		
		$('.KiemeltTerList .Products:first-child').next().next().clone().insertAfter('.KiemeltTerList .Products:last-child')
		$('.KiemeltTerList .Products:last-child').removeClass('KiemeltProducts');
		
		$('.KiemeltTerList .Products:first-child').next().next().next().clone().insertAfter('.KiemeltTerList .Products:last-child')
		$('.KiemeltTerList .Products:last-child').removeClass('KiemeltProducts');
		
		$('.KiemeltTerList .Products:first-child').next().next().next().next().clone().insertAfter('.KiemeltTerList .Products:last-child')
		$('.KiemeltTerList .Products:last-child').removeClass('KiemeltProducts');
		
		/*
		$('.KiemeltTer').mousewheel(function(event, delta) {
			StepProductItem(false,(delta*StepItem),true);
			event.preventDefault();
		});
		*/
	}
	$(".KiemeltLayerBG, .KiemeltNext, .KiemeltPrev, .KiemeltTer, .KiemeltTerList").hover(
		function () { setTimeout(function() { $('.KiemeltTerList').attr('fixed',1); },10); },
		function () { $('.KiemeltTerList').attr('fixed',0); }
	);
	
	$('#shopMenu a').click(function() {
		if(!$(this).attr('href')) {
			if($(this).parent().hasClass('aktive')) {
				$(this).parent().removeClass('aktive');
				$(this).next().slideUp(600);
			} else {
				$(this).parent().addClass('aktive');
				$(this).next().slideDown(600);
			}
		}
	});
	
	if(parseFloat($('html,body').width())<1000) {
		$('.gal_kep a').attr('onclick',' ');
	}
	
}

function StepProductItem(reload,StepItem,scroll) {
	if(!scroll) { var scroll = false; }
	var Fixed = $('.KiemeltTerList').attr('fixed');
	if(Fixed!=1 || scroll) {
		if($('.KiemeltTerList').attr('animated')!='1') {
			$('.KiemeltTerList').attr('animated','1');
			var ItemWidth = 220;      /* Product Width */
			var ItemLength = 3;       /* Product / page */
			var AnimatedSpeed = 0.3;  /* Sec / item */
			var LoadNextItem = 5;     /* Sec */
			if(!StepItem) { var StepItem = ItemLength; }
			var Products = parseFloat($('.KiemeltProducts').length);
			var aLeft = parseFloat($('.KiemeltTerList').css('left'));
			var nLeft = ((StepItem>0)?('+'):('-'))+'='+ItemWidth*Math.abs(StepItem);
			if((0+((ItemLength)*ItemWidth))<(aLeft+(StepItem*ItemWidth))) {
				nLeft = (0-((Products-Math.abs(StepItem))*ItemWidth));
			} else if((0-((Products)*ItemWidth))>(aLeft+(StepItem*ItemWidth))) {
				nLeft = 0;
			}
			
			if(0<(aLeft+(StepItem*ItemWidth))) {
				$('.KiemeltTerList').css({left: (0-(Products*ItemWidth))+'px'});
			}
		
		if(!scroll) { $('.KiemeltTerList').attr('fixed',1); }
			$('.KiemeltTerList').animate({left: nLeft}, (1000*AnimatedSpeed*Math.abs(StepItem)), function() {
				if((0+((ItemLength-1)*ItemWidth))<(aLeft+(StepItem*ItemWidth))) {
					//$('.KiemeltTerList').css({left: 0});
				} else if((0-((Products-1)*ItemWidth))>(aLeft+(StepItem*ItemWidth))) {
					$('.KiemeltTerList').css({left: 0});
				}
				if(!scroll) { $('.KiemeltTerList').attr('fixed',0); }
				$('.KiemeltTerList').attr('animated','0');
			});
		}
	}
	if(reload) { setTimeout('StepProductItem(true,'+StepItem+',false);', (1000*LoadNextItem)); }
}

function NextKiemeltItem(reload) {
	StepProductItem(reload,-1,((reload)?(false):(true)));
}
function PrevKiemeltItem(reload) {
	StepProductItem(reload,1,((reload)?(false):(true)));
}

function menuOpen(mode) {
	$('#SitePage').attr('open');
	if($('#SitePage').attr('open')) {
		$('#SitePage').animate({'left':'0px'},300,function(){$('#SitePage').attr('open',null);});
	} else {
		$('#SitePage').animate({'left':'280px'},300,function(){$('#SitePage').attr('open','open');});
	}
	if($(window).scrollTop()>0) { $('html,body').animate({scrollTop : 0},300); }
}

function shopOpen(mode) {
	$('#SitePage').attr('shopopen');
	if($('#SitePage').attr('shopopen')) {
		$('#SitePage').animate({'left':'0px'},300,function(){$('#SitePage').attr('shopopen',null);});
	} else {
		$('#SitePage').animate({'left':'-280px'},300,function(){$('#SitePage').attr('shopopen','shopopen');});
	}
	if($(window).scrollTop()>0) { $('html,body').animate({scrollTop : 0},300); }
}

$(document).scroll(function() {
	if(parseFloat($('html').width())>1000) {
		var x = $(window).scrollTop();
		$('html').css('background-position','50% '+parseInt(+x/3)+'px');
	}
});

/*
$(document).scroll(function() {
	if(parseFloat($('html').width())>1000) {
		var x = $(window).scrollTop();
		$('#header').css('background-position','50% '+parseInt(+x/3)+'px');
		$('#topLine .topLibneBG').css('background-position','50% '+parseInt(-x/3)+'px');

		var startPoz = -250;
		var x = $(window).scrollTop() - $('#introBlackLine').offset().top + 400;
		$('#introBlackLine .introBlackLineBG').css('background-position','50% '+(parseInt(-x/4)+startPoz)+'px');
	}

	if(parseFloat($('html').width())>1000) {
		if($(window).scrollTop()>60 && $('#nav').attr('isfixed')!='isfixed') {
			$('#nav').attr('isfixed','isfixed');
			$('#nav').css({'position':'fixed','top':'-50px','background-color':'rgba(0,0,0,0.8)'});
			$('#nav').animate({'top':'0px'},1500);
			$('#nav').removeClass('absTop');
		} else if($(window).scrollTop()<=15 && $('#nav').attr('isfixed')=='isfixed') {
			$('#nav').attr('isfixed',null);
			$('#nav').css({'position':'absolute','top':'15px'});
			$('#nav').addClass('absTop');
			// $('#nav').animate({'background-color':'rgba(0,0,0,0.01'},1500);
		}
	}

});
*/
/*
$(function () {
	$.srSmoothscroll({
		// defaults
		step: 55,
		speed: 400,
		ease: 'swing',
		target: $('body'),
		container: $(window)
	})
});
*/





function resizeMobile() {
	if(parseFloat($('html,body').width())<1000) {
		$('#SitePage p, #SitePage div, #SitePage center').each(function() {
			$(this).css({'width':''});
			var wWidth = parseFloat($('html').width());
			var iWidth = parseFloat($(this).width());
			if(wWidth<iWidth) {
				$(this).css({'width':wWidth+'px'});
			}
		});
		$('#SitePage img').each(function(){
			$(this).css({'width':''});
			var wWidth = parseFloat($('html').width())-10;
			var iWidth = parseFloat($(this).width());
			if(iWidth>wWidth) { $(this).css({'width':wWidth+'px','margin-left':'0'}); } else {  }
		});
		$('#SitePage table').each(function() {
			if(!$(this).attr('noZoom') && !$(this).hasClass('gal_kep') && !$(this).hasClass('noZoom') && !$(this).hasClass('nozoom')) {
				$(this).attr('style',null);
				var wWidth = parseFloat($('html').width())-20;
				var iWidth = parseFloat($(this).width());
				var iHeight = parseFloat($(this).height());
				if(wWidth<iWidth) {
					var scale = ( wWidth / iWidth );
					$(this).parent().css({'position':'relative'});
					$(this).css({'position':'relative'});
					$(this).css({'webkit-transform':'scale('+(scale)+', '+(scale)+')'});
					$(this).css({'transform':'scale('+(scale)+', '+(scale)+')'});
					$(this).css({'margin':'-'+((1-scale)/2*iHeight)+'px -'+((1-scale)/2*iWidth)+'px'});
				} else {
					$(this).attr('style',null);
				}
				$('table',$(this)).attr('noZoom','1');
			}
		});
	}
}



$(document).ready(function() {
	window.addEventListener('resize', function(){ resizeMobile(); }, true);
	setTimeout(function() { StepProductItem(true,-1,false); },3000);
});