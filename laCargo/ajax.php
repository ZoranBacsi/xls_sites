<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV=Array(); $_ENV['SiteStart']='AJAX';
$_timeStart = microtime(true);
$_ENV['AJAX'] = true;

include(realpath('./#config.php'));
include(realpath(DOCUMENT_ROOT.'/#functions.php'));

/* HTML Header */
header('Content-type: text/html; charset=utf-8');
header('Content-disposition: inline; filename="index.html"');
header('Content-Language: '.($_ENV['HEAD']['LANG']));
webCache(($_ENV['CONF']['ReLoad']>0)?($_ENV['CONF']['ReLoad']):(-1));


print(out_site($_ENV['SITE']['PAGE']));

if(substr(strtolower($_ENV['CONF']['sysSiteFejlesztes']),0,1)=='i') {
	echo "\r\n<!-- Oldal generálása: ".(round((microtime(true)-$_timeStart)*1000)/1000)." mp / Memória: ".(formatSizeUnits(memory_get_peak_usage()))." -->";
}
?>