/* Készítő: H.Tibor */
function ThemeScript() {
	$('.menuIcon').click(function(){menuOpen();});
	/*$('#SitePage').on("swipeleft",function() { if($('#SitePage').attr('open')) { menuOpen(); } });
	$('#SitePage').on("swiperight",function() { if(!$('#SitePage').attr('open')) { menuOpen(); } });*/
	$('#SitePage').animate({'left':'0px'},300,function(){$('#SitePage').attr('open',null);});
	resizeMobile();
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

function resizeMobile() {
	/*
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
	*/
}

$(document).ready(function() {
	window.addEventListener('resize', function(){ resizeMobile(); }, true);
});