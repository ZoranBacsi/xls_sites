/* Készítő: H.Tibor */
var Cgood = "#EEFFEE";
var Cwait = "#FFFFCC";
var Cbad = "#FFDDDD";

window.onbeforeunload = function(event) {
	/* if($('#MyBody').attr('edited')) { return 'Nem mentette el a változásokat!'; } */
}

function LoadPage(thisUrl,state,thisPost) {
	var URLpushState = true;
	thisUrl.replace($(location).attr('protocol')+'//'+$(location).attr('hostname')+'/', '/');
	if(!thisUrl) {
		thisUrl = location.pathname;
	} else if(thisUrl.substr(0,1)=='?') {
		thisUrl = location.pathname.replace('/index.php', '/')+'index.php'+thisUrl;
	}
	if(typeof sessionStorage == 'undefined') { if(typeof thisPost == 'undefined' || thisPost == '') { var thisPost = ''; } }
	else if(typeof thisPost == 'undefined' || thisPost == '') {
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
		/* thisUrl = thisUrl+((strstr(thisUrl,'?'))?('&'):('?'))+'postHash='+escape(postHash); */
		sessionStorage.setItem(postHash, JSON.stringify(thisPost));
		URLpushState = true;
	}
	
	if(state=='foo:bar' && thisPost=='') { var URLpushState = false; }
	
	if($('#MyBody').attr('edited')) {
		AddAlert('confirm','Nem mentette el a változásokat!\r\nBiztos hogy tovább lép!?',"$('#MyBody').attr('edited',null);LoadPage('"+thisUrl+"','foo:bar','"+thisPost+"');");
		return false;
	}
	if(((typeof state == 'undefined' || state=='foo:bar')) && !($('body').attr('sending'))) {
		
		$('body').attr('sending','sending'); // Dupla klikk ellen
		setTimeout(function() { $('body').attr('sending',''); },300);
		var pleaseWait = setTimeout(function() { $('body').append('<div class="pWaitTable"><div class="pWaitRow"><div class="pWaitCell"><span>Kérem Várjon!</span></div></div></div>'); },500);
		
		$.ajax({
			type: "POST",
			url: ((thisUrl.substr(thisUrl.length-1,1)=='/')?(thisUrl+'index.json'):(thisUrl.replace('.php', '.json'))),
			dataType: 'json',
			data: thisPost,
			timeout: 30000, /* 30mp */
			error: function(jqXHR, status, errorThrown) {
				//alert('Betőltési hiba!\r\n'+((thisUrl.substr(thisUrl.length-1,1)=='/')?(thisUrl+'index.json'):(thisUrl.replace('.php', '.json'))));
			}
		}).done(function(data) {
			clearTimeout(pleaseWait);
			$('.pWaitTable').remove();
			$.each(data, function(key, val) {
				if(val) { $('#'+key).html(val); }
			});
			if(data['SitePage']) {
				$('#MyBody').attr('edited',null);
				
				if(URLpushState) {
					if(typeof (history.pushState) == 'function') {
						if(!state || URLpushState) {
							if(data['SiteTitle']) { $('title').html(data['SiteTitle']); }
							history.pushState('foo:bar', 'Betöltés...', thisUrl);
						}
					} else { location.hash = '#!'+thisUrl; }
				}
				$('#SitePage').animate({top:'0%'},300);
				$('.highslide-close').children('a').click();
				$('html,body').animate({scrollTop : 0},300);
			}
			DefineAllLoad();
		});
		/* */
	}
	return false;
}

function KepLoad(form,kepid) {
	if(typeof kepid == 'undefined') { var kepid = 'kepupload'; }
	if(!$('#'+kepid+'Frame').attr('id')) { $('#'+kepid).after('<iframe src="about:blank" name="'+kepid+'Frame" id="'+kepid+'Frame" style="display: none;"></iframe>'); }
	var filePath = $('#'+kepid+'File').val().replace(/\\/g,'/').split('/');
	var fileName = filePath[(filePath.length-1)];
	$('span#'+kepid+'FileName').html(fileName);
	$('form#'+form).each(function(i) {
		$(this).attr('kepAction',$('#'+form).attr('action'));
		$(this).attr('action','/kepupload.php?kepID='+kepid+'&r='+Math.random());
		$(this).attr('target',kepid+'Frame');
		if($(this).attr('onsubmit')) {
			$(this).attr('ajaxonsubmit',$(this).attr('onsubmit'));
			$(this).attr('onsubmit','');
		}
		$(this).unbind('submit');
		setTimeout(function() { $('#'+kepid+'UploadPreview').attr('uploading','true'); $('#'+kepid+'UploadPreview').attr('src','/images/loading.gif'); $('form#'+form).submit(); },100);
		setTimeout(function() {
			$('form#'+form).each(function(i) {
				$(this).attr('action',$(this).attr('kepAction'));
				$(this).attr('target','');
				$(this).submit(function() {
					if($(this).attr('ajaxonsubmit')) {
						var ctr = eval($(this).attr('ajaxonsubmit').substr(($(this).attr('ajaxonsubmit').indexOf("return")+6)));
					} else { var ctr = true; }
					if(ctr && !(strstr($(this).attr('action'),'index.ajax'))) {
						LoadPage($(this).attr('action'),'foo:bar',serializePost(this));
					} else if(ctr) {
						return true;
					}
					return false;
				});
			});
			setTimeout("$('#"+kepid+"File').val('');",1000);
		},500);
	});
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
	/*  Form Ajaxosítása */
	$('form').each(function(i) {
		if(!($(this).attr('AjaxDefine')) && !($(this).attr('target'))) {
			if($(this).attr('action')=='') { $(this).attr('action',location.pathname+location.search); }
			if($(this).attr('action')) {
				if($(this).attr('action').substr(0,1)!='#'
				&& !(strstr($(this).attr('action'),'index.ajax'))
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
						if($(this).attr('ajaxonsubmit')) {
							var ctr = eval($(this).attr('ajaxonsubmit').substr(($(this).attr('ajaxonsubmit').indexOf("return")+6)));
						} else { var ctr = true; }
						if(ctr) {
							tinyMCE.triggerSave();
							LoadPage($(this).attr('action'),'foo:bar',serializePost(this));
						}
						return false;
					});
				}
				$(this).attr('AjaxDefine','true');
			}
		}
	});
	/*  */

	$('select,input').each(function(i) { $(this).change(function() { $('#MyBody').attr('edited','true'); }); });
	$('input, textarea').each(function(i) {
		if(!($(this).attr('AjaxDefine')) && $(this).attr('type')!='file') {
			$(this).keyup(function(e) {
				if(e.which && e.which!=13) { $('#MyBody').attr('edited','true'); } else if(e.which==13) { $('#MyBody').attr('edited',null); }
				InputControl(this);
			});
		}
		if(!$(this).attr('placeholder') && $(this).attr('type')!='file' && $(this).attr('title')) { $(this).attr('placeholder',$(this).attr('title')); }
		if(!($(this).attr('AjaxDefine')) && $(this).attr('placeholder') && $(this).attr('type')!='file') {
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
			});
			$(this).attr('AjaxDefine','true');
		}
		$(this).keyup();
		$(this).blur();
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

function tkdCounter() {
	$('input').filter(function () {
		var maxLen = new Array();
				maxLen['title'] = 60;
				maxLen['keyw'] = 80;
				maxLen['desc'] = 200;
		var title = /^[a-z]+_title/.test(this.name);
		var keyw = /^[a-z]+_keyw/.test(this.name);
		var desc = /^[a-z]+_desc/.test(this.name);
		var date1 = /^[a-z\_]+_date/.test(this.name);
		var date2 = /^[a-z\_]+_date+[a-z\_]/.test(this.name);
		var datum1 = /^[a-z\_]+_datum/.test(this.name);
		var datum2 = /^[a-z\_]+_datum+[a-z\_]/.test(this.name);
		if(title || keyw || desc) {
			if(title) { var tipus = 'title' }
			if(keyw) { var tipus = 'keyw' }
			if(desc) { var tipus = 'desc' }
			$('input[id='+this.id+']').each(function() {
				var thisID = this.id;
				var newID = this.id+'_tkd';
				$(this).after('<span class="tkdCounter" id="'+newID+'"></span>');
				$(this).keyup(function() {
					var inLen = parseInt($('input[id='+thisID+']').val().length);
					var insert='';
					if(keyw) {
						var inkeyw = $('input[id='+thisID+']').val().split(',');
						insert = ' | '+((inLen)?(inkeyw.length):(0))+'/10';
					}
					$('#'+newID).html(inLen+'/'+maxLen[tipus]+insert);
					if(inLen<parseInt(maxLen[tipus]/3)) {
						var bgColor = Cbad;
					} else if(inLen>=parseInt(maxLen[tipus]/3) && inLen<=(parseInt(maxLen[tipus]/3)*2)) {
						var bgColor = Cwait;
					} else if(inLen>=(parseInt(maxLen[tipus]/3)*2) && inLen<=maxLen[tipus]) {
						var bgColor = Cgood;
					} else {
						var bgColor = Cbad;
					}
					$('#'+newID).css('backgroundColor',bgColor);
				});
				$(this).keyup();
			});
		} else if(date1 || date2 || datum1 || datum2) {
			var cDate = new Date();
			$(this).datepicker({ dateFormat: 'yy-mm-dd '+((cDate.getHours()<10)?('0'):(''))+''+cDate.getHours()+':'+((cDate.getMinutes()<10)?('0'):(''))+''+cDate.getMinutes()+':'+((cDate.getSeconds()<10)?('0'):(''))+''+cDate.getSeconds() });
		}
	});
}

function strtoupper(str) { return (str+"").toUpperCase(); }
function strtolower(str) { return (str+"").toLowerCase(); }

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

function InputFocus(InputOb,InputType,mode) {
	if(InputOb.placeholder) {
		var xPlaceholder = InputOb.placeholder;
	} else {
		var xPlaceholder = InputOb.title;
	}
	if(mode==true && InputOb.value==xPlaceholder) {
		InputOb.style.fontStyle="normal";
		InputOb.style.color="#111111";
		InputOb.type=InputType;
		InputOb.value="";
	} else
	if(mode==false && InputOb.value.length==0) {
		InputOb.style.fontStyle="italic";
		InputOb.style.color="#999999";
		InputOb.type=InputType;
		InputOb.value=xPlaceholder;
	}
}

function InputControl(obj,reurlctrl) {
	if($(obj)) {
		if($(obj).is(":focus")) {
			var selectStart = ((typeof obj.selectionStart != 'undefined')?(obj.selectionStart):(0)),
						selectEnd = ((typeof obj.selectionEnd != 'undefined')?(obj.selectionEnd):(0));
		}
		
		if($(obj).attr('type')!='submit' && $(obj).attr('type')!='reset' && $(obj).attr('type')!='button') {
			var chr_hu = Array('.html','.htm','.php','Á','á','É','é','Í','í','Ó','ó','Ö','ö','Ő','ő','Ú','ú','Ü','ü','Ű','ű','Ä','ä','Đ','đ','Ł','ł','ß','€','+','-',' ','[',']','(',')','{','}','<','>','\\','\'','"','&','#','!','?','.',',','*',';',':','%','/');
			var chr_en = Array('','','','A','a','E','e','I','i','O','o','O','o','O','o','U','u','U','u','U','u','A','a','D','d','L','l','s','E','-','-','-','','','','','','','','','','','','','','','','','','','','','','-');
			var filter = false;
			var iLength = parseInt($(obj).val().length);
			var iMinLength = ((parseInt($(obj).attr('minlength')))?(parseInt($(obj).attr('minlength'))):(($(obj).hasClass('typeNumber'))?(1):(3)));
			var iMaxLength = ((parseInt($(obj).attr('maxlength')))?(parseInt($(obj).attr('maxlength'))):(($(obj).hasClass('typeNumber'))?(10):(255)));
			var iRequired = (($(obj).hasClass('kotelezo')||$(obj).hasClass('required'))?(true):(false));
			if($(obj).hasClass('typeEmail')) {
				filter=/^[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i
			} else if($(obj).hasClass('typeUser')) {
				filter=/^[\.\@\w-]*$/i
			} else if($(obj).hasClass('typePass')) {
				filter=/^[\w-]*$/i
			} else if($(obj).hasClass('typeDate')) {
				filter=/^([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})$/i
			} else if($(obj).hasClass('typeDateTime')) {
				filter=/^([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})([\ ]{1})([0-9]{2})(\:)([0-9]{2})(\:)([0-9]{2})$/i
			} else if($(obj).hasClass('typeNumber')) {
				filter=/^[0-9\.]*$/i
				$(obj).val(str_replace(',','.',$(obj).val()));
				if($(obj).is(":focus")) {
					if (typeof obj.setSelectionRange != "undefined") {
						obj.setSelectionRange(selectStart-(iLength-parseInt($(obj).val().length)), selectEnd-(iLength-parseInt($(obj).val().length)));
					}
				}
			} else if($(obj).hasClass('typeReURL')) {
				filter=/^[\.\_\-\w-]*$/i
				$(obj).val(strtolower(str_replace(chr_hu,chr_en,$(obj).val())));
				for(var i=0;strstr($(obj).val(),'++');i++) { $(obj).val(str_replace('++','+',$(obj).val())); }
				for(var i=0;strstr($(obj).val(),'--');i++) { $(obj).val(str_replace('--','-',$(obj).val())); }
				for(var i=0;strstr($(obj).val(),'__');i++) { $(obj).val(str_replace('__','_',$(obj).val())); }
				if($(obj).is(":focus")) {
					obj.setSelectionRange(selectStart-(iLength-parseInt($(obj).val().length)), selectEnd-(iLength-parseInt($(obj).val().length)));
				}
				var _out = $(obj).attr('reurl').split(',');
				if(reurlctrl && iLength>0) {
					var poststr = "table="+_out[0]+"&id="+_out[1]+"&pid="+_out[2]+"&reurl="+$(obj).val();
					var URL = "reurl_jsc.php";
					if(window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
					xmlhttp.open("POST",URL,false);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					//xmlhttp.setRequestHeader("Content-length", poststr.length);
					//xmlhttp.setRequestHeader("Connection", "close");
					xmlhttp.send(poststr);
					if(xmlhttp.responseText>0) {
						$(obj).css({'backgroundColor':Cbad});
						return false;
					}
				} else if(iLength<1) { $('#FixReurl').val(0); }
			}
			
			if($(obj).attr('copyReurl')) {
				if($('#FixReurl').val()==0 || $("#"+$(obj).attr('copyReurl')).val()=='') {
					$("#"+$(obj).attr('copyReurl')).val(strtolower(str_replace(chr_hu,chr_en,$(obj).val())));
					for(var i=0;strstr($("#"+$(obj).attr('copyReurl')).val(),'++');i++) { $("#"+$(obj).attr('copyReurl')).val(str_replace('++','+',$("#"+$(obj).attr('copyReurl')).val())); }
					for(var i=0;strstr($("#"+$(obj).attr('copyReurl')).val(),'--');i++) { $("#"+$(obj).attr('copyReurl')).val(str_replace('--','-',$("#"+$(obj).attr('copyReurl')).val())); }
					for(var i=0;strstr($("#"+$(obj).attr('copyReurl')).val(),'__');i++) { $("#"+$(obj).attr('copyReurl')).val(str_replace('__','_',$("#"+$(obj).attr('copyReurl')).val())); }
					$("#"+$(obj).attr('copyReurl')).keyup();
				}
			}
			
			if(  (!(iRequired) || (iLength>=iMinLength) )
				&& (!(iMaxLength) || iLength<=iMaxLength)
				&& ( $(obj).val() != $(obj).attr('title'))
				&& ((!(iRequired) && iLength==0) || !(filter) || filter.test($(obj).val()))) {
				$(obj).css({'backgroundColor':Cgood});
				if($(obj).hasClass('typeReURL') && $(obj).is(":focus")) { $('#FixReurl').val(1); }
				return true;
			}
			$(obj).css({'backgroundColor':Cbad});
			return false;
		} else { return true; }
	} else { return false; }
}

var thisValue = oldaValue = 0;
function __zSorszam(thisValue,oldaValue,xclass) {
	if($('.'+xclass)) {
		$('.'+xclass).each(function() {
			if(parseFloat($(this).val())<=parseFloat(thisValue) && parseFloat($(this).val())>parseFloat(oldaValue)) {
				$(this).val(parseFloat($(this).val())-1);
			}
			if(parseFloat($(this).val())>=parseFloat(thisValue) && parseFloat($(this).val())<parseFloat(oldaValue)) {
				$(this).val(parseFloat($(this).val())+1);
			}
		});
	}
}

var thisValue = oldaValue = 0;
function zSorszam(thisValue,oldaValue,xclass) {
	if($('.'+xclass)) {
		$('.'+xclass).each(function() {
			if(parseFloat($(this).val())<=parseFloat(thisValue) && parseFloat($(this).val())>parseFloat(oldaValue)) {
				$(this).val(parseFloat($(this).val())-1);
			}
			if(parseFloat($(this).val())>=parseFloat(thisValue) && parseFloat($(this).val())<parseFloat(oldaValue)) {
				$(this).val(parseFloat($(this).val())+1);
			}
		});
	}
}


function RemoveAlert(randId) {
	$('#'+randId).animate({'opacity':'0'},300);
	setTimeout("$('#"+randId+"').remove();",500);
}
function AddAlert(type,text,func) {
	if(!func) {var func='';}
	var randId = 'outAlert'+Math.floor(Math.random() * (999999 - 100000 + 1) + 100000);
		if(type=='ok' || type=='yes' || type=='no' || type=='fail' || type=='alert') {
		$('.main_left .SiteMaxWidth').prepend('<div class="outAlert" id="'+randId+'" style="opacity:0;"><span class="shadow"><span class="text '+type+'"><span class="close" onclick="RemoveAlert(\''+randId+'\');"></span><pre><span class="image"></span>'+text+'</pre><br/><input class="button button'+randId+'" type="button" onclick="RemoveAlert(\''+randId+'\');" value=" OK " /></span></span></div>');
		setTimeout("$('#"+randId+"').animate({'opacity':'1'},300);",500);
		setTimeout("$('.button"+randId+"').focus();",800);
		setTimeout("RemoveAlert('"+randId+"');",15000);
	} else if(type=='conf' || type=='confirm') {
		$('.main_left .SiteMaxWidth').prepend('<div class="outAlert" id="'+randId+'" style="opacity:0;"><span class="shadow"><span class="text '+type+'"><span class="close" onclick="RemoveAlert(\''+randId+'\');"></span><pre><span class="image"></span>'+text+'</pre><br/><center><input class="ok_button ok'+randId+'" type="button" onclick="'+(func)+'" value=" Igen! " /><input class="button no_button no'+randId+'" type="button" onclick="RemoveAlert(\''+randId+'\');" value=" Nem! " /></center></span></span></div>');
		setTimeout("$('#"+randId+"').animate({'opacity':'1'},300);",500);
		setTimeout("$('.no"+randId+"').focus();",800);
		setTimeout("RemoveAlert('"+randId+"');",20000);
	}
	return false;
}
function noAlert() { $('#MyBody').attr('edited',null); return true; }

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

function helpBox() {
	$('.helpBox').each(function() {
		var infoID = 'info_'+rand(100000,999999);
		var infoText = $(this).html();
		$(this).html('<img src="/admin/pic/info.png" name="'+infoID+'" alt="i" class="help" onclick="return hs.htmlExpand(this, {contentId: this.name,width: 300} );"/><div id="'+infoID+'" class="highslide-html-content info_layer" onmouseout="hs.close(this);"><div class="highslide-header"> <ul> <li class="highslide-close"> <a href="#" onclick="return hs.close(this)"> <span></span> </a> </li> </ul> </div><div class="highslide-body">'+infoText+'</div><div class="highslide-footer"> <div> <span class="highslide-resize" title="Resize"> <span></span> </span> </div> </div></div>');
		$(this).addClass('help');
		$(this).removeClass('helpBox');
	});
}

function DefineAllLoad() {
	$("body > div[class^=mce]").remove(); /* Régi TinyMCE eltávolítása */
	setTimeout(function() {
		DefineLinks(); /* Hivatkozások ajaxosítása */
		DefineForms(); /* Formok ajaxosítása */
		tkdCounter(); /* SEO számláló */
		helpBox(); /* Infó dobozok */
	},10);
}

$(document).ready(function() {
	/* Oldal betőltése vissza lépésnél */
	window.onpopstate = function(e) {
		LoadPage(location.href, e.state);
	}
	/*  */
	DefineAllLoad();
	$('#MyBody').attr('edited',null);
});