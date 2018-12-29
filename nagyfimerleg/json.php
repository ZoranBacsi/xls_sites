<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV=Array(); $_ENV['SiteStart']='JSON';
$_timeStart = microtime(true);
$_ENV['jSon']['SiteLoadPage']=true;

include(realpath('./#config.php'));
include(realpath(DOCUMENT_ROOT.'/#functions.php'));

/* HTML Header */
header('Content-type: application/json; charset=utf-8');
header('Content-disposition: inline; filename="'.((end($_ENV['REURL']))?(end($_ENV['REURL']).'.json'):('index.json')).'"');
header('Content-Language: '.($_ENV['HEAD']['LANG']));
webCache(($_ENV['CONF']['ReLoad']>0)?($_ENV['CONF']['ReLoad']):(-1));

if(!$_ENV['SitePage']) {
	if(is_file(realpath(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'].'/'.($_ENV['CONF']['PAGE']).'.tpl'))) {
		ob_start();
			include(realpath(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'].'/'.($_ENV['CONF']['PAGE']).'.tpl'));
			$_ENV['SitePage'] = ob_get_contents();
		ob_end_clean();
	}
}

/* Tartalom */
if($_ENV['jSon']['SiteLoadPage']===true AND $_ENV['SitePage']) {
	$_ENV['jSon']['SiteTitle'] = out_site($_ENV['HEAD']['TITLE']);
	$_ENV['jSon']['SitePage']  = $_ENV['SitePage'];
	if(substr(strtolower($_ENV['CONF']['sysSiteFejlesztes']),0,1)=='i') {
		$_ENV['jSon']['SitePage'] .= "\r\n<!-- Oldal generálása: ".(round((microtime(true)-$_timeStart)*1000)/1000)." mp / Memória: ".(formatSizeUnits(memory_get_peak_usage()))." -->";
	}
}

if(!$_ENV['JSON_KEYS']) { $_ENV['JSON_KEYS'] = array_keys($_ENV['jSon']); }
for($a=0;$a<count($_ENV['JSON_KEYS']);$a++) {
	if($_ENV['JSON_KEYS'][$a] AND !is_numeric($_ENV['JSON_KEYS'][$a])) {
		$_ENV['jSon'][$_ENV['JSON_KEYS'][$a]] = out_site(out_site($_ENV['jSon'][$_ENV['JSON_KEYS'][$a]]));
	}
}

print(json_encode($_ENV['jSon']));

?>