<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

function HTML_TEXTAREA($xClass) {
	$out = '
		<script type="text/javascript">
			onReadyDoc(function(){
				
				tinyMCE.init({
					mode : "specific_textareas",
					editor_selector : "'.($xClass).'",
					script_url : "/js/tiny_mce/tiny_mce.js",
					//doctype : \'<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\',
					theme : "advanced",
					skin : "o2k7",
					language : "hu",
					skin_variant : "silver",
					file_browser_callback : "tinyBrowser",
					plugins : "style,layer,table,advhr,advimage,advlink,media,paste,inlinepopups",
					theme_advanced_buttons1 : "'.(($_ENV['NoSyles'])?(''):('styleselect,')).'formatselect,fontselect,fontsizeselect,|,removeformat,cleanup,code,pastetext,pasteword,|,undo,redo",
					theme_advanced_buttons2 : "image,media,|,bold,italic,underline,strikethrough,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,bullist,numlist,|,outdent,indent,|,link,unlink",
					theme_advanced_buttons3 : "tablecontrols,|,visualaid,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,hr",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : false,
					theme_advanced_fonts : "Andale Mono=andale mono,times;"+
                "Arial=arial,helvetica,sans-serif;"+
                "Arial Black=arial black,avant garde;"+
                "Book Antiqua=book antiqua,palatino;"+
                "Comic Sans MS=comic sans ms,sans-serif;"+
                "Courier New=courier new,courier;"+
                "Georgia=georgia,palatino;"+
                "Helvetica=helvetica;"+
                "Icon Font=iconfont;"+
                "Impact=impact,chicago;"+
                "Roboto=Roboto;Roboto Condensed=Roboto Condensed;"+
                "Symbol=symbol;"+
                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
                "Terminal=terminal,monaco;"+
                "Times New Roman=times new roman,times;"+
                "Trebuchet MS=trebuchet ms,geneva;"+
                "Verdana=verdana,geneva;"+
                "Webdings=webdings;"+
                "Wingdings=wingdings,zapf dingbats",
					cleanup : '.(($_ENV['noCleanup'])?('false'):('true')).',
					extended_valid_elements : ""
						+"@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],"
						+"a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur],"
						+"div[id|class|style|title],"
						+"strong/b,em/i,strike,u,#p,-ol[type|compact],-ul[type|compact],-li,br,"
						+"img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,-blockquote,"
						+"-table[border=0|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],"
						+"-tr[rowspan|width|height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
						+"#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor|scope],"
						+"#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,-span,-code,-pre,address,"
						+"-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
						+"object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width|height|src|*],script[src|type],map[name],"
						+"area[shape|coords|href|alt|target],bdo,button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|valign|width],"
						+"dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
						+"input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
						+"kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
						+"q[cite],samp,select[disabled|multiple|name|size],small,textarea[cols|rows|disabled|name|readonly],tt,var,big",
					browser_spellcheck: true,
					remove_linebreaks : false,
					relative_urls: false,
					remove_script_host: false,
					convert_urls: false,
					force_p_newlines : true,
					theme_advanced_font_sizes: "8 px=8px,9 px=9px,10 px=10px,11 px=11px,12 px=12px,13 px=13px,14 px=14px,15 px=15px,16 px=16px,17 px=17px,18 px=18px,19 px=19px,20 px=20px,21 px=21px,22 px=22px,23 px=23px,24 px=24px,25 px=25px,26 px=26px,27 px=27px,28 px=28px,29 px=29px,30 px=30px,32 px=32px,34 px=34px,36 px=36px,38 px=38px,40 px=40px,44 px=44px,48 px=48px,52 px=52px,56 px=56px,60 px=60px,66 px=66px,72 px=72px",
					font_size_style_values: "8px,9px,10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px,21px,22px,23px,24px,25px,26px,27px,28px,29px,30px,32px,34px,36px,38px,40px,44px,48px,52px,56px,60px,66px,72px",
					entities : "38,amp,34,quot,60,lt,62,gt",
					'.(($_ENV['htmlContentStyle'])?('content_style: "'.($_ENV['htmlContentStyle']).'",'):('')).'
					resize: '.(($_ENV['htmlResize'])?('true'):('false')).',
					setup : function(ed) {
						ed.onKeyUp.add(function(ed, e) {
							$("#MyBody").attr("edited",e.keyCode);
						});
					}

				});
			});
		</script>';
	return $out;
}
?>