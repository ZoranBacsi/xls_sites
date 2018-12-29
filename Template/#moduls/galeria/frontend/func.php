<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('galeria',false);
$_ENV['MODS']['PATH'] = rPath('galeria/frontend',false);
$_ENV['MODS']['PURL'] = rPath('galeria/frontend',true);
$_ENV['HEAD']['CSS'][] = $_ENV['MODS']['PURL'].'/style.css';
$_ENV['GAL'] = Array();
$_ENV['GAL']['LISTAS'] = false;

$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_reurl`="'.(end($_ENV['REURL'])).'" LIMIT 1');
if(mysqli_num_rows($con)) {
	$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
	$def_con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `reurl` WHERE `ru_reurl`="galeria" LIMIT 1');
	$row = mysqli_fetch_array($def_con,MYSQLI_ASSOC);
	if($sor['gal_h1_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['H1'] = $row['gal_h1_'.(strtolower($_SESSION['LANG']))]; }
	else if($sor['gal_h1']) { $_ENV['HEAD']['H1'] = $row['gal_h1']; }
	else if($row['ru_h1']) { $_ENV['HEAD']['H1'] = $row['ru_h1']; }
	if($sor['gal_title_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['TITLE'] = $row['gal_title_'.(strtolower($_SESSION['LANG']))]; }
	else if($sor['gal_title']) { $_ENV['HEAD']['TITLE'] = $row['gal_title']; }
	else if($row['ru_title']) { $_ENV['HEAD']['TITLE'] = $row['ru_title']; }
	if($sor['gal_keyw_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['KEYWORDS'] = $row['gal_keyw_'.(strtolower($_SESSION['LANG']))]; }
	else if($sor['gal_keyw']) { $_ENV['HEAD']['KEYWORDS'] = $row['gal_keyw']; }
	else if($row['ru_keyw']) { $_ENV['HEAD']['KEYWORDS'] = $row['ru_keyw']; }
	if($sor['gal_desc_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['DESCRIPTION'] = $row['gal_desc_'.(strtolower($_SESSION['LANG']))]; }
	else if($sor['gal_desc']) { $_ENV['HEAD']['DESCRIPTION'] = $row['gal_desc']; }
	else if($row['ru_desc']) { $_ENV['HEAD']['DESCRIPTION'] = $row['ru_desc']; }
}

/* FUNKCIÓK */

function GalKisKep($id,$defkep) { $out=null;
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_id`="'.($defkep).'" LIMIT 1');
	if(mysqli_num_rows($con)) {
		$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
		$out = $sor['kep_kozepes'];
	} else {
		$con=mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_modul`="'.($_ENV['SITE']['MODUL']).'" AND `kep_mid`="gal_{'.(in_text($id)).'}" ORDER BY `kep_sorsz` LIMIT 1');
		if(mysqli_num_rows($con)) {
			$sor=mysqli_fetch_array($con,MYSQLI_ASSOC);
			$out = $sor['kep_kozepes'];
		} else {
			$out = '/pic/defaultgalkep.jpg';
		}
	}
	return $out;
}

function GalRandPic($id,$n) { $out = '';
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid` LIKE "gal_{'.(($id>0)?($id.'}'):('%')).'" ORDER BY RAND() LIMIT '.(($n>0)?($n):(5)));
	while($sor = mysqli_fetch_array($con)) {
		$gcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_id`="'.(str_replace(Array('gal_{','}'),'',$sor['kep_mid'])).'" LIMIT 1');
		$row = mysqli_fetch_array($gcon);
		$out .= '<span class="galRandPic" style="background-image:url(\''.($sor['kep_nagy']).'\');" onclick="LoadPage(\'/galeria/'.($row['gal_reurl']).'.html\');"></span>';
	}
	return $out;
}

	$_ENV['OutFunc'][] = 'out_galeriaUrl';
	function out_galeriaUrl($txt) {
		$Array = Array();
		$resultat = preg_match_all("/\#\{galeriaUrl:(([0-9])+?)\}/", $txt, $Array, PREG_SET_ORDER);
		$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		for($i=0;$i<count($Array);$i++) {
			$_pageUrl = galeriaUrlFa($Array[$i][1]);
			$txt = str_replace($Array[$i][0],$_pageUrl,$txt);
		}
		return $txt;
	}

	function galeriaUrlFa($id) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'
			SELECT *
			FROM `galeria`
			WHERE `gal_status`="A"
				AND `gal_id`="'.($id).'"
			LIMIT 1');
		if($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) { $out .= '/galeria/'.$sor['gal_reurl'].'/'; }
		return $out;
	}

$_ENV['LeftPic'] = GalRandPic(0,4);

?>