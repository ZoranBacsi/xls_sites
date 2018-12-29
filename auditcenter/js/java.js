/* Készítő: H.Tibor */
function ThemeScript() {
	$('.menuIcon').click(function(){menuOpen();});
	$('.shopIcon').click(function(){shopOpen();});
	$('#SitePage').on("swipeleft",function() { if($('#SitePage').attr('open')) { menuOpen(); } });
	$('#SitePage').on("swiperight",function() { if($('#SitePage').attr('shopopen')) { shopOpen(); } });
	$('#SitePage').animate({'left':'0px'},300,function(){$('#SitePage').attr('open',null);});

	LoadEfects();

}

function subMenu(obj) {
	if($('ul',$(obj).parent()).size()>0) {
		if($(obj).parent().hasClass('aktive')) {
			$(obj).parent().removeClass('aktive');
			$(obj).parent().children('ul').slideUp('300');
		} else {
			$(obj).parent().addClass('aktive');
			$(obj).parent().children('ul').slideDown('300');
		}
		return false;
	}
}

function menuOpen(mode) {
	$('#SitePage').attr('open');
	if($('#SitePage').attr('open')) {
		$('#SitePage').animate({'left':'0px'},300,function(){$('#SitePage').attr('open',null);});
		$('#header').animate({'left':'0px'},300,function(){$('#SitePage').attr('open',null);});
	} else {
		$('#SitePage').animate({'left':'280px'},300,function(){$('#SitePage').attr('open','open');});
		$('#header').animate({'left':'280px'},300,function(){$('#SitePage').attr('open','open');});
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

function loadSubNav() {
	$('#subNav li').each(function(i) {
		$(this).delay(i*200).animate({'left':'0px','opacity':'1'},500);
	});
}

$(document).scroll(function() {
	if(parseFloat($('html').width())>1200) {
		var x = $(window).scrollTop();
	}
});

$(function () {
	$.srSmoothscroll({
		step: 55,
		speed: 400,
		ease: 'swing',
		target: $('body'),
		container: $(window)
	})
});
