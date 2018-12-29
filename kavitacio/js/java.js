
var NoScroll = false;
function LoadPage(thisUrl,state,thisPost) {
	var URLpushState = true;
	
	thisUrl.replace($(location).attr('protocol')+'//'+$(location).attr('hostname')+'/', '/');
	//if(thisUrl!='/hu/') { thisUrl = thisUrl.replace('/hu/', '/'); }
	if(!thisUrl) {
		thisUrl = location.pathname;
	} else if(thisUrl.substr(0,1)=='?') {
		thisUrl = location.pathname.replace('/index.html', '/')+'index.html'+thisUrl;
	}
	
	thisUrl = thisUrl.replace('/?', '/index.html?');
	
	if(thisUrl.substr(thisUrl.length-1,1)=='/') {
		thisUrl = thisUrl+'index.html';
	} else if(thisUrl.substr(thisUrl.length-5,5)!='.html') {
		//thisUrl = thisUrl+'.html';
	}
	
	if(typeof thisPost == 'undefined') {
		var thisPost = '';
		var thisGets = parse_url(thisUrl, 'query');
		var thisGet = new Array;
		parse_str(thisGets,thisGet);
		if(thisGet['postHash']) {
			thisPost = JSON.parse(sessionStorage.getItem(thisGet['postHash']));
			URLpushState = false;
		}
	} else {
		var postHash = md5(JSON.stringify(thisPost));
		var thisGets = parse_url(thisUrl, 'query');
		var thisGet = new Array;
		parse_str(thisGets,thisGet);
		if(thisGet['postHash'] && postHash) {
			thisUrl = thisUrl.replace('postHash='+thisGet['postHash'], '');
			if(thisUrl.substr(thisUrl.length-1,1)=='?' || thisUrl.substr(thisUrl.length-1,1)=='&') {
				thisUrl = thisUrl.substr(0,thisUrl.length-1);
			}
		}
		thisUrl = thisUrl+((strstr(thisUrl,'?'))?('&'):('?'))+'postHash='+escape(postHash);
		sessionStorage.setItem(postHash, JSON.stringify(thisPost));
		URLpushState = true;
	}
	
	if(state=='foo:bar' && thisPost=='') { var URLpushState = false; }
	
	if(((typeof state == 'undefined' || state=='foo:bar')) && !$('body').attr('sending')) {
		
		$('body').attr('sending','sending'); // Dupla klikk ellen
		setTimeout(function() { $('body').attr('sending',null); },300);
		var pleaseWait = setTimeout(function() { $('body').append('<div class="pWaitTable"><div class="pWaitRow"><div class="pWaitCell"><span>Kérem Várjon!</span></div></div></div>'); },500);

		if(typeof _gaq != 'undefined') { _gaq.push(['_trackPageview', thisUrl]); }
		$.ajax({
			type: "POST",
			url: thisUrl.replace('.html', '.json'),
			dataType: 'json',
			data: thisPost,
			timeout: 30000, /* 30mp */
			error: function(jqXHR, status, errorThrown) {
				//alert('Betőltési hiba!\r\n'+((thisUrl.substr(thisUrl.length-1,1)=='/')?(thisUrl+'index.json'):(thisUrl.replace('.html', '.json'))));
			}
		}).done(function(data) {
			clearTimeout(pleaseWait);
			$('.pWaitTable').remove();
			$.each(data, function(key, val) {
				if(val) { $('#'+key).html(val); }
			});
			if(data['SitePage'].length>0) {
				if(URLpushState) {
					if(typeof (window.history.pushState) == 'function') {
						if(!state || URLpushState) {
							if(data['SiteTitle']) { $('title').html(data['SiteTitle']); }
							window.history.pushState('foo:bar', ((data['SiteTitle'])?(data['SiteTitle']):('Betöltés...')), thisUrl.replace('/index.html', '/'));
						}
					} else { window.location.hash = '#!'+thisUrl.replace('/index.html', '/'); }
				}
				setTimeout(function() {
					if($('#SitePage').attr('noscroll')!='true') {
						$('html,body').animate({scrollTop : 0},300);
						$('#SitePage').animate({top:'0%'},300);
					} else { $('#SitePage').attr('noscroll','false'); }
				},100);
				if(typeof FB != 'undefined') { setTimeout(function() { FB.XFBML.parse(); },300); }
			}
			DefineAllLoad();
		});
		/* */
	}
	return false;
}

function KepLoad(form,kepid) {
	if(typeof kepid == 'undefined') { var kepid = 'kepuploadFile'; }
	if(!(typeof FileReader == 'undefined')) {
		if(!(document.getElementById(kepid).files.length === 0)) {
			var oFile = document.getElementById(kepid).files[0];
			if(!rFilter.test(oFile.type)) { alert("Nem megfelelő képformátum!"); } else {
				oFReader.readAsDataURL(oFile);
			}
		}
	} else {
		if(!$('#kepuploadFrame').attr('id')) { $(kepid).after('<iframe src="about:blank" name="'+kepid+'Frame" id="'+kepid+'Frame" style="display: none;"></iframe>'); }
		$('form#'+form).each(function(i) {
			$(this).attr('kepAction',$('#'+form).attr('action'));
			$(this).attr('action','/kepupload.php?r='+Math.random());
			$(this).attr('target',kepid+'Frame');
			$(this).unbind('submit');
			setTimeout(function() { $('form#'+form).submit(); $('#'+kepid+'UploadPreview').attr('src','/images/loading.gif'); },100);
			setTimeout(function() {
				$('form#'+form).each(function(i) {
					$(this).attr('action',$(this).attr('kepAction'));
					$(this).attr('target','');
					$(this).submit(function() {
						if($(this).attr('ajaxonsubmit')) {
							var ctr = eval($(this).attr('ajaxonsubmit').substr(($(this).attr('ajaxonsubmit').indexOf("return")+6)));
						} else { var ctr = true; }
						if(ctr) {
							LoadPage($(this).attr('action'),'foo:bar',serializePost(this));
						}
						return false;
					});
				});
			},500);
		});
	}
}

function DefineLinks() {
	$('a').each(function(i) {
		if(!($(this).attr('AjaxDefine')) && !($(this).attr('target'))) {
			if($(this).attr('href')) {
				if($(this).attr('class')!='KepNagyitas'
				&& $(this).attr('href').substr(0,1)!='#'
				&& $(this).attr('href').substr(0,11)!='javascript:'
				&& $(this).attr('href').substr(0,7)!='mailto:'
				&& $(this).attr('href').substr(0,6)!='skype:'
				&& $(this).attr('href').substr(0,6)!='https:'
				&& $(this).attr('href').substr(0,5)!='http:'
				&& $(this).attr('href').substr(0,5)!='data:'
				&& $(this).attr('href').substr(0,2)!='//'
				&& ( $(this).attr('href').search('.html')>0 || $(this).attr('href').search('.ajax')>0 || $(this).attr('href').search('.json')>0 || $(this).attr('href').substr(($(this).attr('href').length-1),1)=='/' )
				&& $(this).attr('href')!='') {
					$(this).click(function() {
						LoadPage($(this).attr('href'));
						return false;
					});
				} else if($(this).attr('href').substr(0,1)=='#') {
					$(this).click(function() {
						return false;
					});
				}
				$(this).attr('AjaxDefine','true');
			}
		}
	});

	$('.KepNagyitas').click(function() {
		if(!($(this).attr('href'))) { $(this).attr('href',$(this).children('img').attr('src')); }
		return hs.expand(this, {wrapperClassName: 'borderless floating-caption', dimmingOpacity: 0.75, align: 'center'});
	});
}

function DefineForms() {
	$('form').each(function(i) {
		if(!($(this).attr('AjaxDefine')) && !($(this).attr('target'))) {
			if($(this).attr('action')=='') { $(this).attr('action',location.pathname+location.search); }
			if($(this).attr('action')) {
				if($(this).attr('action').substr(0,1)!='#'
				&& $(this).attr('action').substr(0,11)!='javascript:'
				&& $(this).attr('action').substr(0,7)!='mailto:'
				&& $(this).attr('action').substr(0,6)!='skype:'
				&& $(this).attr('action').substr(0,6)!='https:'
				&& $(this).attr('action').substr(0,5)!='http:'
				&& $(this).attr('action').substr(0,5)!='data:'
				&& $(this).attr('action').substr(0,2)!='//'
				&& $(this).attr('action')!='') {
					if($(this).attr('onsubmit')) {
						$(this).attr('ajaxonsubmit',$(this).attr('onsubmit'));
						$(this).attr('onsubmit','');
					}
					$(this).submit(function() {
						var ctr = false;
						if($(this).attr('ajaxonsubmit')) {
							var ctr = eval($(this).attr('ajaxonsubmit').substr(($(this).attr('ajaxonsubmit').indexOf("return")+6)));
						} else {
							ctr = true;
							$('input, textarea',$(this)).each(function(i) {
								$(this).attr('inWrite','true');
								$(this).attr('inError','false');
								$(this).keyup()
								if($(this).hasClass('error')) { ctr = false; }
							});
						}
						if(ctr) {
							LoadPage($(this).attr('action'),'foo:bar',serializePost(this));
						}
						return false;
					});
				}
				$(this).attr('AjaxDefine','true');
			}
		}
	});

	$('input, textarea').each(function(i) {
		if(!($(this).attr('AjaxDefine')) && $(this).attr('type')!='file' && ( $(this).attr('placeholder') || $(this).attr('title') ) ) {
			if(!($(this).attr('placeholder')) && $(this).attr('type')!='file') { $(this).attr('placeholder',$(this).attr('title')); }
			$(this).focus(function() {
				if($(this).attr('placeholder')!='') {
					$(this).attr('placeholderoff',$(this).attr('placeholder'));
					$(this).attr('placeholder','');
				}
			});
			$(this).blur(function() {
				if($(this).attr('placeholderoff')!='') {
					$(this).attr('placeholder',$(this).attr('placeholderoff'));
				}
				$(this).keyup();
				if($(this).val().length>0) {
					$(this).css({'color':'#666666'});
				} else {
					$(this).css({'color':'#999999'});
				}
			});
			$(this).focus(function() {
				$(this).css({'color':(($(this).attr('textColor'))?($(this).attr('textColor')):('#000000'))});
			});
			$(this).keyup(function(e) {
				$(this).css({'color':(($(this).attr('textColor'))?($(this).attr('textColor')):('#000000'))});
				$(this).removeClass('error');
				if(InputControl(this)) {
					if($('.error',$(this).parent()).attr('class')) {
						if($(this).parent().children('.inputError').attr('class')) {
							$(this).parent().children('.inputError').css({'opacity':'1'});
						} else if($(this).parent().parent().parent().children('.inputError').attr('class')) {
							$(this).parent().parent().parent().children('.inputError').css({'opacity':'1'});
						}
					} else {
						if($(this).parent().children('.inputError').attr('class')) {
							$(this).parent().children('.inputError').css({'opacity':'0'});
						} else if($(this).parent().parent().parent().children('.inputError').attr('class')) {
							$(this).parent().parent().parent().children('.inputError').css({'opacity':'0'});
						}
					}
					$(this).attr('inWrite','false');
					//if(!($(this).val())) { setTimeout('$("#'+($(this).attr('id'))+'").blur()',100); }
					return true;
				} else if(!(e.keyCode) && $(this).attr('inWrite')=='true') {
					if($(this).parent().children('.inputError').attr('class')) {
						$(this).parent().children('.inputError').css({'opacity':'1'});
					} else if($(this).parent().parent().parent().children('.inputError').attr('class')) {
						$(this).parent().parent().parent().children('.inputError').css({'opacity':'1'});
					}
					$(this).addClass('error');
					if($(this).val().length>0) {
						$(this).css({'color':'#666666'});
					} else {
						$(this).css({'color':'#999999'});
					}
				}
				return false;
			});
			$(this).attr('AjaxDefine','true');
			$(this).attr('inWrite','false');
		}
		$(this).blur();
	});
	$('.inputError').each(function(i) {
		if($(this).parent().children('.inputError').attr('class')) {
			$(this).parent().children('.inputError').css({'opacity':'0'});
		} else if($(this).parent().parent().parent().children('.inputError').attr('class')) {
			$(this).parent().parent().parent().children('.inputError').css({'opacity':'0'});
		}
	});
}

function serializePost(form) {
	var data = {};
	form = $(form).serializeArray();
	for (var i = form.length; i--;) {
		var name = form[i].name;
		var value = form[i].value;
		var index = name.indexOf('[]');
		if (index > -1) {
			name = name.substring(0, index);
			if (!(name in data)) {
				data[name] = [];
			}
			data[name].push(value);
		}
		else
			data[name] = value;
	}
	return data;
}


function InputControl(obj) {
	if(obj.length>3) {
		if(obj.substr(0,1)=='#') {
			if($(obj).hasClass('typeRadio') || $(obj).hasClass('typeCheckbox')) {
				var iRequired = (($(obj).hasClass('kotelezo') || $(obj).hasClass('required'))?(true):(false));
				var iMinLength = ((parseInt($(obj).attr('minlength')))?(parseInt($(obj).attr('minlength'))):(1));
				var iMaxLength = ((parseInt($(obj).attr('maxlength')))?(parseInt($(obj).attr('maxlength'))):(99));
				var iLength = 0;
				$(obj).each(function() { if($(this).is(':checked')) { iLength++; } });
				if( (!(iRequired) || (iLength>=iMinLength) )
					&& (!(iMaxLength) || iLength<=iMaxLength)) {
					return true;
				} else { return false; }
			}
		}
	} else if($(obj).hasClass('typeCheckbox')) {
		var iRequired = (($(obj).hasClass('kotelezo') || $(obj).hasClass('required'))?(true):(false));
		var iMinLength = ((parseInt($(obj).attr('minlength')))?(parseInt($(obj).attr('minlength'))):(1));
		var iMaxLength = ((parseInt($(obj).attr('maxlength')))?(parseInt($(obj).attr('maxlength'))):(99));
		if($(obj).is(':checked')) { var iLength = 1; } else { var iLength = 0; }
		if(!(iRequired) || iLength) { return true; } else { return false; }
	}
	if(!obj) {
		var iRequired = (($(obj).hasClass('kotelezo') || $(obj).hasClass('required'))?(true):(false));
		if(iRequired) { return false; } else { return true; }
	}	else if(obj === true) { return true; }
	var filter = false;
	var iLength = parseInt($(obj).val().length);
	var iMinLength = ((parseInt($(obj).attr('minlength')))?(parseInt($(obj).attr('minlength'))):(($(obj).hasClass('typeNumber'))?(1):(3)));
	var iMaxLength = ((parseInt($(obj).attr('maxlength')))?(parseInt($(obj).attr('maxlength'))):(($(obj).hasClass('typeNumber'))?(10):(255)));
	var iRequired = (($(obj).hasClass('kotelezo') || $(obj).hasClass('required'))?(true):(false));
	if($(obj).hasClass('typeEmail')) {
		filter=/^[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i
	} else if($(obj).hasClass('typeUser')) {
		filter=/^[\.\@\w-]*$/i
	} else if($(obj).hasClass('typePass')) {
		filter=/^[\w-]*$/i
	} else if($(obj).hasClass('typeDate')) {
		filter=/^([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})$/i
	} else if($(obj).hasClass('typeNumber')) {
		filter=/^[0-9\.]*$/i
		$(obj).val(str_replace(',','.',$(obj).val()));
	} else if($(obj).hasClass('typeCaptcha')) {
		if(getCookie(MD5($('.captcha_value').val().toLowerCase()+$('.captcha_key').val()))) {
			return true;
		} else { return false; }
	}
	if(  (!(iRequired) || (iLength>=iMinLength) )
		&& (!(iMaxLength) || iLength<=iMaxLength)
		&& ( $(obj).val() != $(obj).attr('title'))
		&& ((!(iRequired) && iLength==0) || !(filter) || filter.test($(obj).val()))) {
		return true;
	}
	return false;
}

function strstr(haystack, needle, bool) {
	var pos = 0;
	haystack += '';
	pos = haystack.indexOf( needle );
	if (pos == -1) {
		return false;
	} else {
		if (bool){
			return haystack.substr( 0, pos );
		} else {
			return haystack.slice( pos );
		}
	}
}

function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for(i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if(x==c_name) { return unescape(y); }
	}
}

function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null)?(""):("; expires="+exdate.toUTCString()));
	document.cookie=c_name + "=" + c_value;
}

function str_replace(search,replace,subject,count) {
	f = [].concat(search),
	r = [].concat(replace),
	s = subject, ra = r instanceof Array, sa = s instanceof Array;
	s = [].concat(s);
	if(count) {
		this.window[count] = 0;
	}
	for(i=0, sl=s.length; i < sl; i++) {
		if(s[i] === '') {
			continue;
		}
		for(j=0, fl=f.length; j < fl; j++) {
			temp = s[i]+'';
			repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
			s[i] = (temp).split(f[j]).join(repl);
			if(count && s[i] !== temp) {
				this.window[count] += (temp.length-s[i].length)/f[j].length;
			}
		}
	}
	return sa ? s : s[0];
}

function in_array(needle, haystack, argStrict) {
	var key = '', strict = !!argStrict;
	if (strict) {
		for (key in haystack) {
			if (haystack[key] === needle || haystack[key]!=str_replace(needle,'',haystack[key])) {
				return true;
			}
		}
	} else {
		for (key in haystack) {
			if (haystack[key] == needle || haystack[key]!=str_replace(needle,'',haystack[key])) {
				return true;
			}
		}
	}
	return false;
}

function rand(min,max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

$(document).ready(function() {
	$("input,textarea").focus(function() {
		$(this).attr("title",$(this).attr("placeholder"));
		$(this).attr("placeholder","");
		if($(this).attr("title")==$(this).val()) { $(this).val(""); }
	});
	$("input,textarea").blur(function(){
		$(this).attr("placeholder",$(this).attr("title"));
		if($(this).val()=="") { $(this).val($(this).attr("title")); }
	});
});

function parse_url(str, component) {
	var query, key = ['source', 'scheme', 'authority', 'userInfo', 'user', 'pass', 'host', 'port', 'relative', 'path', 'directory', 'file', 'query', 'fragment'],
		ini = (this.php_js && this.php_js.ini) || {},
		mode = (ini['phpjs.parse_url.mode'] &&
			ini['phpjs.parse_url.mode'].local_value) || 'php',
		parser = {
			php: /^(?:([^:\/?#]+):)?(?:\/\/()(?:(?:()(?:([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?()(?:(()(?:(?:[^?#\/]*\/)*)()(?:[^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
			strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
			loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
		};

	var m = parser[mode].exec(str),
		uri = {},
		i = 14;
	while(i--) {
		if(m[i]) {
			uri[key[i]] = m[i];
		}
	}

	if(component) {
		return uri[component.replace('PHP_URL_', '').toLowerCase()];
	}
	if(mode!=='php') {
		var name = (ini['phpjs.parse_url.queryKey'] &&
			ini['phpjs.parse_url.queryKey'].local_value) || 'queryKey';
		parser = /(?:^|&)([^&=]*)=?([^&]*)/g;
		uri[name] = {};
		query = uri[key[12]] || '';
		query.replace(parser, function($0, $1, $2) {
			if ($1) {
				uri[name][$1] = $2;
			}
		});
	}
	delete uri.source;
	return uri;
}
function parse_str(str, array) {
	var strArr = String(str)
		.replace(/^&/, '')
		.replace(/&$/, '')
		.split('&'),
		sal = strArr.length,
		i, j, ct, p, lastObj, obj, lastIter, undef, chr, tmp, key, value,
		postLeftBracketPos, keys, keysLen,
		fixStr = function(str) {
			return decodeURIComponent(str.replace(/\+/g, '%20'));
		};
	if (!array) {
		array = this.window;
	}
	for (i = 0; i < sal; i++) {
		tmp = strArr[i].split('=');
		key = fixStr(tmp[0]);
		value = (tmp.length < 2) ? '' : fixStr(tmp[1]);
		while (key.charAt(0) === ' ') {
			key = key.slice(1);
		}
		if (key.indexOf('\x00') > -1) {
			key = key.slice(0, key.indexOf('\x00'));
		}
		if (key && key.charAt(0) !== '[') {
			keys = [];
			postLeftBracketPos = 0;
			for (j = 0; j < key.length; j++) {
				if (key.charAt(j) === '[' && !postLeftBracketPos) {
					postLeftBracketPos = j + 1;
				} else if (key.charAt(j) === ']') {
					if (postLeftBracketPos) {
						if (!keys.length) {
							keys.push(key.slice(0, postLeftBracketPos - 1));
						}
						keys.push(key.substr(postLeftBracketPos, j - postLeftBracketPos));
						postLeftBracketPos = 0;
						if (key.charAt(j + 1) !== '[') {
							break;
						}
					}
				}
			}
			if (!keys.length) {
				keys = [key];
			}
			for (j = 0; j < keys[0].length; j++) {
				chr = keys[0].charAt(j);
				if (chr === ' ' || chr === '.' || chr === '[') {
					keys[0] = keys[0].substr(0, j) + '_' + keys[0].substr(j + 1);
				}
				if (chr === '[') {
					break;
				}
			}
			obj = array;
			for (j = 0, keysLen = keys.length; j < keysLen; j++) {
				key = keys[j].replace(/^['"]/, '')
					.replace(/['"]$/, '');
				lastIter = j !== keys.length - 1;
				lastObj = obj;
				if ((key !== '' && key !== ' ') || j === 0) {
					if (obj[key] === undef) {
						obj[key] = {};
					}
					obj = obj[key];
				} else { // To insert new dimension
					ct = -1;
					for (p in obj) {
						if (obj.hasOwnProperty(p)) {
							if (+p > ct && p.match(/^\d+$/g)) {
								ct = +p;
							}
						}
					}
					key = ct + 1;
				}
			}
			lastObj[key] = value;
		}
	}
}

var rotation = 0;
jQuery.fn.rotate = function(degrees) {
	$(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
							 '-moz-transform' : 'rotate('+ degrees +'deg)',
							 '-ms-transform' : 'rotate('+ degrees +'deg)',
							 'transform' : 'rotate('+ degrees +'deg)'});
	return $(this);
};

function DefineAllLoad() {
	setTimeout(function() {
		DefineLinks(); /* Hivatkozások ajaxosítása */
		DefineForms(); /* Formok ajaxosítása */
		$('.KepNagyitas, .kepnagyitas').click(function() {
			if(!$(this).attr('href')) { $(this).attr('href',$(this).children('img').attr('src')); }
			return hs.expand(this, {wrapperClassName: 'borderless floating-caption', dimmingOpacity: 0.75, align: 'center'});
		});
		$('img').each(function(){
			if($(this).attr('src').substr(0,1)=='#') {
				$(this).attr('src',$(this).attr('src').substr(1));
			}
		});
		$('span').each(function(){
			if($(this).attr('title')) {
				if($(this).attr('title').substr(0,1)=='#') {
					$(this).css({'background-image':'url('+$(this).attr('title').substr(1)+')'});
					$(this).attr('title',null);
				}
			}
		});
		if(typeof ThemeScript != 'undefined') {
			ThemeScript(); /* Theme egyedi scriptje betöltéskor */
		}
	},10);
}

$(document).ready(function() {
	$('#SitePage').attr('NoScroll','false');
	/* Oldal betőltése vissza lépésnél */
	window.onpopstate = function(e) {
		LoadPage(location.href, e.state);
	}

	DefineAllLoad();
	setInterval(function(){if(typeof _gaq != 'undefined') { _gaq.push(['_trackPageview', location.pathname]); }},(1000*60*5));

});