<?php /* Készítő: H.Tibor */ $_ENV['SiteStart']='HTML';
$_timeStart = microtime(true);

include(realpath('./#config.php'));
include(realpath(DOCUMENT_ROOT.'/#functions.php'));

/* Mini .htaccess */
if(!is_file(DOCUMENT_ROOT.'/.htaccess')) { fileWrite(DOCUMENT_ROOT.'/.htaccess',"<iFModule mod_rewrite.c>\r\nrewritebase /\r\nRewriteEngine on\r\nRewriteCond %{HTTP_HOST} !^www\\.\r\nRewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]\r\nRewriteRule ^(javas.js)$ javas.phtml [QSA]\r\nRewriteRule ^(styles.css)$ styles.phtml [QSA]\r\nRewriteCond %{REQUEST_FILENAME} !-f\r\nRewriteCond %{REQUEST_FILENAME} !-d\r\nRewriteRule ^(.*)\\.json$ json.php [QSA]\r\nRewriteCond %{REQUEST_FILENAME} !-f\r\nRewriteCond %{REQUEST_FILENAME} !-d\r\nRewriteRule ^(.*)\\.ajax$ ajax.php [QSA]\r\nRewriteCond %{REQUEST_FILENAME} !-f\r\nRewriteCond %{REQUEST_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php [QSA]\r\n</iFModule>",false); }

header('Content-type: text/html; charset=utf-8');
header('Content-disposition: inline; filename="'.((end($_ENV['REURL']))?(end($_ENV['REURL']).'.html'):('index.html')).'"');
header('Content-Language: '.($_ENV['HEAD']['LANG']));
webCache(($_ENV['CONF']['ReLoad']>0)?($_ENV['CONF']['ReLoad']):(-1));

/* Tartalom betöltése */
if(is_file(realpath(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'].'/'.($_ENV['CONF']['PAGE']).'.tpl'))) {
	ob_start();
		include(realpath(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'].'/'.($_ENV['CONF']['PAGE']).'.tpl'));
		$_ENV['SitePage'] = out_site(ob_get_contents());
	ob_end_clean();
}

/* Keretbeillesztés betöltése */
if(is_file(realpath(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'].'/index.tpl'))) {
	ob_start();
		include(realpath(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'].'/index.tpl'));
		$_ENV['SitePageKeret'] = out_site(ob_get_contents());
	ob_end_clean();
}

print(out_site($_ENV['SitePageKeret']));


if(substr(strtolower($_ENV['CONF']['sysSiteFejlesztes']),0,1)=='i') {
	/* Generálási idő */
	echo "\r\n<!-- Oldal generálása: ".(round((microtime(true)-$_timeStart)*1000)/1000)." mp / Memória: ".(formatSizeUnits(memory_get_peak_usage()))." -->";
}
?>