<?php print('<?xml version="1.0" encoding="utf-8"?>'."\r\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
			xmlns:og="http://ogp.me/ns#"
			xmlns:fb="http://www.facebook.com/2008/fbml"
			xml:lang="{head:lang}">
	<head>
		<title>Admin - {head:title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="Cache-Control" content="no-cache"/>
		<meta http-equiv="Content-Language" content="{head:lang}"/>
		<link rel="shortcut icon" href="/admin/pic/favico.png" />
		<link rel="stylesheet" href="/admin/styles.css" type="text/css"/>
		<script type="text/javascript">var jQuery=false;function onReadyDoc(fn){if(jQuery){setTimeout(fn,0);}else{if(window.addEventListener){window.addEventListener('load',fn,false);}else if(window.attachEvent){window.attachEvent('onload',fn);}}}</script>
		<script src="/admin/javas.js" type="text/javascript" ></script>
		<base href="/admin/" />
	</head>
	<body id="MyBody">
		<div id="SitePage">
<?php
if($_ENV['AdminPage']) {
	if(is_file(realpath(DOCUMENT_ROOT.'/admin/'.$_ENV['AdminPage'].'.tpl'))) {
		include(realpath(DOCUMENT_ROOT.'/admin/'.$_ENV['AdminPage'].'.tpl'));
	}
}
?>
		</div>
		<div id="select_div" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
		<div class="highslide-html-content" id="my-content" style="width: 300px;display:none; background-color: #FFFFFF;">
			<div style="text-align: right;"><a id="hs_close" onclick="hs.close(this); document.getElementById('alert_body').innerHTML=' ';">{bezar}</a></div>
			<div class="highslide-body" id="alert_body"> </div>
		</div>
	</body>
</html>