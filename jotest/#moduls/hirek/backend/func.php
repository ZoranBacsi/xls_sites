<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('hirek/backend',false);
$_ENV['MODS']['PURL'] = rPath('hirek/backend',true);

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	/* Egyéni szótár betöltése */
	load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

	/* Admin menü definiálása */
	if(!$_ENV['MOD_MENU'][1]) { $_ENV['MOD_MENU'][1] = ''; }
	$_ENV['MOD_MENU'][1] .= '
			<div class="adminMenuCim"><b>{menu_hirek_cim}</b></div>
			<div><a class="adminMenu" href="?oldal=hirek">{menu_hirek_kateg}</a></div>
			<hr/>';
	
	$_ENV['CONF']['ReURLcontrols']['hirek'] = 'hirek_ReURLControl';
	function hirek_ReURLControl($reurl,$table,$id,$pid) {
		$PageCon = mysqli_query($_ENV['MYSQLI'],'
				SELECT *
				FROM `hirek`
				WHERE `hir_reurl`="'.($reurl).'"
					AND `hir_id`!="'.($id).'"
				LIMIT 1');
		if(!mysqli_num_rows($PageCon)) {
			return false;
		} else { return true; }
	}
	
}
?>