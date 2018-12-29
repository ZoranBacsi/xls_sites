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
					theme_advanced_buttons1 : "styleselect,formatselect,fontselect,fontsizeselect,|,removeformat,cleanup,code,pastetext,pasteword,|,undo,redo",
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
					cleanup : true,
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
					
					remove_linebreaks : false,
					relative_urls: false,
					remove_script_host: false,
					convert_urls: false,
					force_p_newlines : true,
					font_size_style_values : "8px,10px,12px,14px,18px,24px,36px",
					entities : "38,amp,34,quot,60,lt,62,gt",
					resize: false,
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