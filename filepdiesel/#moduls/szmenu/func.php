<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu',false);
$_ENV['MODS']['PURL'] = rPath('szmenu',true);

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	/* Modul beállításai */
	$_ENV['SzmenuMaxFirstLevel'] = $_ENV['CONF']['szmMaxFirstLevel']; // ennyi menüpontot tartalmazhat az első szinten
	$_ENV['SzmenuMaxLevel'] = $_ENV['CONF']['szmMaxLevel']; // ennyi szintes a menürendszer
	$_ENV['SzmenuType'] = in_opt($_ENV['CONF']['szmType']); // almenü típusok (minimum 2 szintes rendszernél)
	$_ENV['SzmenuRegKot'] = in_opt($_ENV['CONF']['szmRegKot']); // ha vannak felhasználók, lehet regisztrációhoz kötni
	$_ENV['SzmenuKulsoURL'] = in_opt($_ENV['CONF']['szmKulsoURL']); // külső URL -ek megadásának lehetősége
	$_ENV['szmFileLetolt'] = in_opt($_ENV['CONF']['szmFileLetolt']); // Fájlok letöltése mint menüpont
	$_ENV['SzmenuGalTarsit'] = in_opt($_ENV['CONF']['szmGalTarsit']); // ha van galéria modul, lehet társítani
	$_ENV['SzmenuSzerkOldal'] = in_opt($_ENV['CONF']['szmSzerkOldal']); // szerkeszthető oldalak engedélyezése
	$_ENV['szmSzerkRovOldal'] = in_opt($_ENV['CONF']['szmSzerkRovOldal']); //
	$_ENV['szmSzerkCikkOldal'] = in_opt($_ENV['CONF']['szmSzerkCikkOldal']); //
	$_ENV['SzmenuMenuKep'] = in_opt($_ENV['CONF']['szmMenuKep']); // Menü kép lehetősége
	$_ENV['SzmenuMenuKepMod'] = $_ENV['CONF']['szmMenuKepMod']; // Menü kép helye

	/* URL struktúra lekérdezése menühöz */
	function MenuFa($id) { $out=NULL;
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_id`="'.($id).'" LIMIT 1');
		$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
		if($sor['szm_k_id']>99) { $out .= MenuFa($sor['szm_k_id']); }
		if($sor['szm_id']>99) { $out .= (($sor['szm_reurl']!="" AND $sor['szm_reurl']!="#")?('/'.$sor['szm_reurl']):('')); }
		$out = str_replace('/index/','/',$out);
		$out = str_replace('/index','',$out);
		for($a=0;strstr($out,'//');$a++) { $out = str_replace('//','/',$out); }
		return $out;
	}

}

?>