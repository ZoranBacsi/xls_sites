<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV=Array(); $_ENV['SiteStart']='HTML';
$_timeStart = microtime(true);

include(realpath('../#config.php'));
include(realpath(DOCUMENT_ROOT.'/admin/#functions.php'));

/* HTML Header */
header('Content-type: text/html; charset=utf-8');
header('Content-disposition: inline; filename="index.php"');
header('Content-Language: '.($_ENV['HEAD']['LANG']));
webCache(-1);

ob_start();
	include(DOCUMENT_ROOT.'/admin/index.tpl');
	$_print = out_site(ob_get_contents());
ob_end_clean();

print(out_site($_print));

echo "\r\n<!-- Oldal generálása: ".(round((microtime(true)-$_timeStart)*1000)/1000)." mp / Memória: ".(formatSizeUnits(memory_get_peak_usage()))." -->";
?>