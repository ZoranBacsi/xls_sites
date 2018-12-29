<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV=Array(); $_ENV['SiteStart']='AJAX';
$_timeStart = microtime(true);
$_ENV['AJAX'] = true;

include(realpath('../#config.php'));
include(realpath(DOCUMENT_ROOT.'/admin/#functions.php'));

/* HTML Header */
header('Content-type: text/html; charset=utf-8');
header('Content-disposition: inline; filename="index.html"');
header('Content-Language: '.($_ENV['HEAD']['LANG']));
webCache(-1);

ob_start();
	include(DOCUMENT_ROOT.'/admin/ajax.tpl');
	$_print = ob_get_contents();
ob_end_clean();

print(out_lang(out_lang($_print)));

echo "\r\n<!-- Oldal generálása: ".(round((microtime(true)-$_timeStart)*1000)/1000)." mp / Memória: ".(formatSizeUnits(memory_get_peak_usage()))." -->";
?>