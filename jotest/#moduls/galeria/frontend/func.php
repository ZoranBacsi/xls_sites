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
	if(!$sor['ru_h1'] AND $row['ru_h1']) { $_ENV['HEAD']['H1'] = $row['ru_h1']; }
	if(!$sor['ru_title'] AND $row['ru_title']) { $_ENV['HEAD']['TITLE'] = $row['ru_title']; }
	if(!$sor['ru_keyw'] AND $row['ru_keyw']) { $_ENV['HEAD']['KEYWORDS'] = $row['ru_keyw']; }
	if(!$sor['ru_desc'] AND $row['ru_desc']) { $_ENV['HEAD']['DESCRIPTION'] = $row['ru_desc']; }
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
		$out .= '
					<img src="'.($sor['kep_nagy']).'" alt="'.($sor['kep_cimke'.$_ENV['LangPref']]).'" title="'.($row['gal_cim'.$_ENV['LangPref']]).'" onclick="location.href=\'/'.($row['gal_reurl']).'.html\';" /><br/><br/>';
	}
	return $out;
}

$_ENV['LeftPic'] = GalRandPic(0,3);

?>