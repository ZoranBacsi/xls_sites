<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/backend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/backend',true);

if(!$_REQUEST['mode']) { $_REQUEST['mode'] = 'kateg'; }
if($_REQUEST['level']<1 OR $_REQUEST['p_id']<1) { $_REQUEST['level']=1; $_REQUEST['p_id']=1; }

/* Kategória fa megjelenítése */
function Pozicio($p_id,$oldal,$mode) {
	if($p_id>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_id`="'.($p_id).'" LIMIT 1');
		if($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			Pozicio($sor['szm_k_id'],$oldal,$mode);
			echo'
					<a href="?oldal='.($oldal).'&amp;mode='.($mode).'&amp;p_id='.($p_id).'&amp;level='.($sor['szm_level']+1).'">'.(out_icons($sor['szm_link'])).'</a> &#187; ';
		}
	}
}

function xPozicio($p_id,$oldal,$mode) {
	echo'<div class="pozicio">';
	Pozicio($p_id,$oldal,$mode);
	echo'</div>';
}

/* Menű törlés funkció */
function szmDel($szmid) {
	KepUP::Del('mfile_{'.($szmid).'}');
	KepUP::Del('mkep_{'.($szmid).'}');
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_k_id`="'.($szmid).'" ORDER BY `szm_sorsz`');
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { szmDel($sor['szm_id']); }
	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `szmp` WHERE `szmp_m_id`="'.($szmid).'"');
	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `reurl` WHERE `ru_modul`="'.($_ENV['SITE']['MODUL']).'" AND `ru_elem_id`="szm_{'.($szmid).'}"');
	if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `szmenu` WHERE `szm_id`="'.($szmid).'" LIMIT 1')) { return 1; }
}

/* Oldal törlés funkció */
function szpDel($szpid) {
	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `szmp` WHERE `szmp_p_id`="'.($szpid).'"');
	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `reurl` WHERE `ru_modul`="'.($_ENV['SITE']['MODUL']).'" AND `ru_elem_id`="szp_{'.($szpid).'}"');
	if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `szpage` WHERE `szp_id`="'.($szpid).'" LIMIT 1')) { return 1; }
}

if($_REQUEST['xMode']=='szmNew' OR $_REQUEST['xMode']=='szmMod') {
	/* Menüpont készítése szerkesztése */
	include($_ENV['MODS']['PATH'].'/menu-adatlap.php');
} else if($_REQUEST['xMode']=='szpNew' OR $_REQUEST['xMode']=='szpMod') {
	/* Szerkeszthető oldalak szerkesztése */
	include($_ENV['MODS']['PATH'].'/page-adatlap.php');
} else if($_REQUEST['mode']=='kateg') {
	/* Menüpont/kategória listázása */
	include($_ENV['MODS']['PATH'].'/menu-listazas.php');
} else if($_REQUEST['mode']=='pages') {
	/* Szerkeszthető oldalak listázása */
	include($_ENV['MODS']['PATH'].'/page-listazas.php');
}

?>