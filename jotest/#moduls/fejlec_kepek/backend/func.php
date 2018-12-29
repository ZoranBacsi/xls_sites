<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('fejlec_kepek/backend',false);
$_ENV['MODS']['PURL'] = rPath('fejlec_kepek/backend',true);

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	/* Egyéni szótár betöltése */
	load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

	if(!$_ENV['MOD_MENU'][3]) { $_ENV['MOD_MENU'][3] = ''; }
	$_ENV['MOD_MENU'][3] .= '
			<div class="adminMenuCim"><b>Fejléc</b></div>
			<div><a class="adminMenu" href="?oldal=fejlec_kepek">Képváltó</a></div>
			<hr/>';
}

?>