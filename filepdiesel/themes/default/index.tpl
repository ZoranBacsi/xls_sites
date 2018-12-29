<!DOCTYPE html>
<html lang="{lang:code}">
		<title>{head:title}</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="robots" content="<?php print(($_ENV['HEAD']['INDEX']=='I')?('index, follow'):('noindex, nofollow')); ?>" />
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
		<?php if(!(strstr(strtolower($_SERVER['HTTP_USER_AGENT']),'google') AND ( strstr(strtolower($_SERVER['HTTP_USER_AGENT']),'bot') OR strstr(strtolower($_SERVER['HTTP_USER_AGENT']),'speed') ))) { ?>
		<link rel="stylesheet" href="http://{head:host}/styles.css" type="text/css" media="screen" />
		<script src="http://{head:host}/javas.js" type="text/javascript"></script>
		<?php } ?>
	</head>
	<body>
		<div id="SitePage">
			<?php print($_ENV['SitePage']); ?>
		</div>
		{site:sysAlert}
		{site:sysCookieAlert}
	</body>
	<?php if((strstr(strtolower($_SERVER['HTTP_USER_AGENT']),'google') AND ( strstr(strtolower($_SERVER['HTTP_USER_AGENT']),'bot') OR strstr(strtolower($_SERVER['HTTP_USER_AGENT']),'speed')))) { ?>
	<link rel="stylesheet" async href="http://{head:host}/styles.css" type="text/css" media="screen" />
	<script async src="http://{head:host}/javas.js" type="text/javascript" ></script>
	<?php } ?>
</html>