<?php print('<?xml version="1.0" encoding="utf-8"?>'."\r\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
			xmlns:og="http://ogp.me/ns#"
			xmlns:fb="http://ogp.me/ns/fb#"
			xml:lang="{lang:code}">
	<head>
		<title>{head:title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="{lang:code}" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="author" content="{site:author-name}, {site:author-mail}, {site:author-site}" />
		<meta name="keywords" content="{head:keywords}" />
		<meta name="description" content="{head:description}" /> 
		<meta property="og:title" content="{head:title}"/>
		<meta property="og:site_name" content="{head:host}"/>
		<meta property="og:description" content="{head:description}"/>
		<meta property="og:image" content="http://{head:host}{head:image}"/>
		<meta property="og:url" content="http://{head:host}{head:uri}"/>
		<link rel="image_src" href="http://{head:host}{head:image}" />
		<link rel="shortcut icon" type="image/png" href="http://{head:host}/themes/{conf:theme}/images/favicon.png" />
		<link rel="apple-touch-icon-precomposed" type="image/png" href="http://{head:host}/themes/{conf:theme}/images/favicon.png" />
		<link rel="search" href="http://{head:host}/search.xml" type="application/opensearchdescription+xml" title="{conf:sitename}" />
		<link rel="stylesheet" href="http://{head:host}/styles.css" type="text/css" media="screen" />
		<script src="http://{head:host}/javas.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="SitePage">
			{php:$_ENV['SitePage']}
		</div>
	</body>
</html>