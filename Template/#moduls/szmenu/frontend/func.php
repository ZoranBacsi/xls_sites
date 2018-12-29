<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/frontend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/frontend',true);

$_ENV['HEAD']['CSS'][] = $_ENV['MODS']['PURL'].'/style.css';

$_ENV['SZMENU'] = Array();
if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	if(!is_array($_ENV['USER']['uw_kategs'])) { $_ENV['USER']['uw_kategs'] = explode('|',$_ENV['USER']['uw_kategs']); }

	/* Egyéni szótár betöltése */
	load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

	/* ReUrl értelmezése */
	$_ENV['CONF']['ReURLcontrols'] = Array();
	function szmenu_ReUrlConstrue() {
		if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "reurl"'))) {
			$con = mysqli_query($_ENV['MYSQLI'],'
							SELECT *
							FROM `szpage`
							WHERE `szp_status`="A"
								AND `szp_reurl`="'.($_ENV['REURL'][1]).'"
							LIMIT 1');
			if(mysqli_num_rows($con)>0) {
				$_ENV['SZPAGE'] = mysqli_fetch_array($con,MYSQLI_ASSOC);
				$con = mysqli_query($_ENV['MYSQLI'],'
								SELECT *
								FROM `reurl`
								WHERE `ru_modul`="'.($_ENV['SYSTEM']['MODUL']).'"
									AND `ru_reurl`="'.(end($_ENV['REURL'])).'"
									AND `ru_elem_id`="szp_{'.($_ENV['SZPAGE']['szp_id']).'}"
								LIMIT 1');
			}	else {
				$con = mysqli_query($_ENV['MYSQLI'],'
								SELECT `a`.*
								FROM `szmenu` AS `a`
								LEFT JOIN `szmenu` AS `p`
									ON `p`.`szm_id`=`a`.`szm_k_id`
								WHERE `p`.`szm_id`=`a`.`szm_k_id`
									AND `a`.`szm_status`="A"
									AND `p`.`szm_status`="A"
									'.(($_ENV['REURL'][1]==$_ENV['CONF']['def_modul'] AND $_ENV['CONF']['def_modul']=='szmenu')?(''):(' AND `a`.`szm_reurl`="'.(end($_ENV['REURL'])).'" ')).'
									AND ( `p`.`szm_reurl`="'.($_ENV['parentReurl']).'" OR `p`.`szm_reurl`="index" )
								ORDER BY `szm_sorsz` LIMIT 1');
				if(mysqli_num_rows($con)>0) { $_ENV['SZMENU'] = mysqli_fetch_array($con,MYSQLI_ASSOC); }
				else if($_ENV['REURL'][1]==$_ENV['CONF']['def_modul'] AND $_ENV['REURL'][2]=='index') {
					$con = mysqli_query($_ENV['MYSQLI'],'
									SELECT `a`.*
									FROM `szmenu` AS `a`
									LEFT JOIN `szmenu` AS `p`
										ON `p`.`szm_id`=`a`.`szm_k_id` AND `p`.`szm_reurl`="'.($_SESSION['LANG']).'"
									WHERE `p`.`szm_id`=`a`.`szm_k_id`
										AND `a`.`szm_status`="A"
										AND `a`.`szm_reurl`="#"
										AND `p`.`szm_reurl`="'.($_ENV['parentReurl']).'"
									ORDER BY `szm_sorsz` LIMIT 1');
					if(mysqli_num_rows($con)>0) { $_ENV['SZMENU'] = mysqli_fetch_array($con,MYSQLI_ASSOC); }
				}
				$con = mysqli_query($_ENV['MYSQLI'],'
								SELECT *
								FROM `reurl`
								LEFT JOIN `modul`
									ON `mod_id`="'.($_ENV['SYSTEM']['MODUL']).'"
								WHERE `ru_modul`="'.($_ENV['SYSTEM']['MODUL']).'"
									AND `ru_reurl`="'.(end($_ENV['REURL'])).'"
									AND `ru_elem_id`="szm_{'.($_ENV['SZMENU']['szm_id']).'}"
								LIMIT 1');
			}
			if($_ENV['REURL'][1]!=$_ENV['SZMENU']['szm_reurl'] AND $_ENV['SZMENU']['szm_reurl'] AND !(mysqli_num_rows($con)>0)) {
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: /".$_ENV['SZMENU']['szm_reurl']."/"); 
				exit();
			}
			if(mysqli_num_rows($con)>0) {
				$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
				if($sor['ru_mywfile']) { $_ENV['SYSTEM']['MPHPWF'] = $sor['ru_mywfile']; }
				if($sor['ru_index']) { $_ENV['HEAD']['INDEX'] = $sor['ru_index']; }
				if($sor['ru_h1']) { $_ENV['HEAD']['H1'] = out_header($sor['ru_h1'],'H1'); }
				else if($sor['mod_h1']) { $_ENV['HEAD']['H1'] = out_header($sor['mod_h1'],'H1'); }
				else if($_ENV['SZMENU']['szm_cim'] AND !$_ENV['HEAD']['H1']) { $_ENV['HEAD']['H1'] = out_header($_ENV['SZMENU']['szm_cim'],'H1'); }
				else if($_ENV['SZMENU']['szp_cim'] AND !$_ENV['HEAD']['H1']) { $_ENV['HEAD']['H1'] = out_header($_ENV['SZMENU']['szp_cim'],'H1'); }
				if($sor['ru_title']) { $_ENV['HEAD']['TITLE'] = $sor['ru_title']; }
				else if($sor['mod_title']) { $_ENV['HEAD']['TITLE'] = out_header($sor['mod_title'],'TITLE'); }
				else if($_ENV['SZMENU']['szm_cim'] AND !$_ENV['HEAD']['TITLE']) { $_ENV['HEAD']['TITLE'] = out_header($_ENV['SZMENU']['szm_cim'],'TITLE'); }
				else if($_ENV['SZMENU']['szp_cim'] AND !$_ENV['HEAD']['TITLE']) { $_ENV['HEAD']['TITLE'] = out_header($_ENV['SZMENU']['szp_cim'],'TITLE'); }
				if($sor['ru_keyw']) { $_ENV['HEAD']['KEYWORDS'] = $sor['ru_keyw']; }
				else if($sor['mod_keyw']) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['mod_keyw'],'KEYWORDS'); }
				else if($_ENV['SZMENU']['szm_cim'] AND !$_ENV['HEAD']['KEYWORDS']) { $_ENV['HEAD']['KEYWORDS'] = out_header($_ENV['SZMENU']['szm_cim'],'KEYWORDS'); }
				else if($_ENV['SZMENU']['szp_cim'] AND !$_ENV['HEAD']['KEYWORDS']) { $_ENV['HEAD']['KEYWORDS'] = out_header($_ENV['SZMENU']['szp_cim'],'KEYWORDS'); }
				if($sor['ru_desc']) { $_ENV['HEAD']['DESCRIPTION'] = $sor['ru_desc']; }
				else if($sor['mod_desc']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['mod_desc'],'DESCRIPTION'); }
				else if($_ENV['SZMENU']['szm_text'] AND !$_ENV['HEAD']['DESCRIPTION']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($_ENV['SZMENU']['szm_text'],'DESCRIPTION'); }
				else if($_ENV['SZMENU']['szp_text'] AND !$_ENV['HEAD']['DESCRIPTION']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($_ENV['SZMENU']['szp_text'],'DESCRIPTION'); }
			}
			if($_ENV['SZMENU']['szm_id']>0) {
				$kepCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="szm_{'.($_ENV['SZMENU']['szm_id']).'}" ORDER BY `kep_sorsz` LIMIT 1');
				if($kep = mysqli_fetch_array($kepCon,MYSQLI_ASSOC)) {
					$_SERVER['MenuBG'] = $kep['kep_nagy'];
				}
			}
		}
	}

	function SzMenuKategs($parent,$minta,$sub=false) { $out = $subMenu = '';
		if(!is_numeric($parent)) {
			$parentCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_status`="A" AND `szm_reurl`="'.($parent).'" ORDER BY `szm_reurl` LIMIT 1');
			$parentSor = mysqli_fetch_array($parentCon,MYSQLI_ASSOC);
			$parent = $parentSor['szm_id'];
			$_ENV['secMenu'] = $parent;
		}
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_status`="A" AND `szm_k_id`="'.($parent).'" ORDER BY `szm_sorsz`');
		while($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			$_private_enable=false;
			$_private = explode('|',$sor['szm_private_kategs']);
			for($a=0;$a<count($_private);$a++) { if(in_array($_private[$a],$_ENV['USER']['uw_kategs'])) { $_private_enable=true; } }
			if(count($_private)>0 AND $_private[0]>0 AND !$_private_enable) {
				/* Nincs joga hozzá */
			} else {
				$iconHtml = '';
				$kepCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="szm_{'.($sor['szm_id']).'}" ORDER BY `kep_sorsz` LIMIT 1');
				if($kep = mysqli_fetch_array($kepCon,MYSQLI_ASSOC)) {
					$iconHtml = '<span class="icon" style="background-image:url(\''.($kep['kep_kozepes']).'\');"></span>';
				}
				$menuInfo = '<li class="menuInfo"><h3 class="title">'.($sor['szm_title']).'</h3><p class="desc">'.($sor['szm_desc']).'</p></li>';
				if($sub) {
					$subMenu = SzMenuKategs($sor['szm_id'],$minta,$sub); // almenü beolvasása
				}
				$subHtml = (($subMenu AND ($sor['szm_tipus']=='' OR $sor['szm_tipus']=='N'))?('<ul>'.($subMenu).($menuInfo).'</ul>'):(''));
				$link = out_icons($sor['szm_link']);
				$active = ((in_array($sor['szm_reurl'],$_ENV['REURL']))?(' aktive'):(''));
				$url = MenuFa($sor['szm_id']).'/';
				$url = str_replace('/index/','/',$url);
				if($sor['szm_mod']=='L' AND $sor['szm_href']) {
					$url = $sor['szm_href'].(($sor['szm_target'])?('" target="_blank'):(''));
					$active = ((strstr($sor['szm_href'],$_ENV['REURL'][1]))?(' aktive'):(''));
				} else if($sor['szm_mod']=='F') {
					$fcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="mfile_{'.($sor['szm_id']).'}" ORDER BY `kep_sorsz` LIMIT 1');
					if($fsor=mysqli_fetch_array($fcon,MYSQLI_ASSOC)) { $url = $fsor['kep_eredeti']; }
				} else {
					if($subHtml AND strlen(in_text(strip_tags(out_html($sor['szm_text']))))<=3) { $url="#"; }
				}
				if(!$active AND !($_ENV['SZMENU']['szm_id'] OR $_ENV['SZMENU']['parent_id'])) {
					/*$_REFURL = parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH);
					$_REFURL = ReURL::decode($_REFURL);
					$_REFURL = explode('/',$_REFURL);
					$active = ((in_array($sor['szm_reurl'],$_REFURL))?(' aktive'):(''));
					if($active) { $_ENV['SZMENU'] = $sor; }*/
				}
				if($sub) {
					$subMenu = SzMenuKategs($sor['szm_id'],$minta,$sub); // almenü beolvasása
				}
				$subHtml = (($subMenu AND ($sor['szm_tipus']=='' OR $sor['szm_tipus']=='N'))?('<ul style="display:none;">'.($subMenu).($menuInfo).'</ul>'):(''));
				$out .= str_replace(
					Array('[active]','[url]','[link]','[sub]','[icon]','[desc]','[[icon:home]]','[[icon:search]]'),
					Array($active,$url,(($subMenu AND ($sor['szm_tipus']=='' OR $sor['szm_tipus']=='N'))?('<span class="arrow"></span>'):('')).$link,$subHtml,$iconHtml,$sor['szm_desc'],'<img src="/images/icon-home.png" class="menuHome" />','<img src="/images/icon-search.png" class="menuSearch" />'),
					strtolower($minta)
				);
			}
		}
		return $out;
	}
	
	$_ENV['OutFunc'][] = 'out_menuUrl';
	function out_menuUrl($txt) {
		$Array = Array();
		$resultat = preg_match_all("/\#\{menuUrl:(([0-9])+?)\}/", $txt, $Array, PREG_SET_ORDER);
		$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		for($i=0;$i<count($Array);$i++) {
			$_menuUrl = menuUrlFa($Array[$i][1]);
			$txt = str_replace($Array[$i][0],$_menuUrl,$txt);
		}
		$txt = str_replace(Array('[[',']]'),Array('{','}'),$txt);
		return $txt;
	}
	
	function menuUrlFa($id) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'
			SELECT *
			FROM `szmenu`
			WHERE `szm_status`="A"
				AND `szm_id`="'.($id).'"
			LIMIT 1');
		if($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) { $out .= MenuFa($sor['szm_id']).'/'; }
		return $out;
	}
	
	$_ENV['OutFunc'][] = 'out_pageUrl';
	function out_pageUrl($txt) {
		$Array = Array();
		$resultat = preg_match_all("/\#\{pageUrl:(([0-9])+?)\}/", $txt, $Array, PREG_SET_ORDER);
		$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		for($i=0;$i<count($Array);$i++) {
			$_pageUrl = pageUrlFa($Array[$i][1]);
			$txt = str_replace($Array[$i][0],$_pageUrl,$txt);
		}
		return $txt;
	}
	
	function pageUrlFa($id) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'
			SELECT *
			FROM `szpage`
			WHERE `szp_status`="A"
				AND `szp_id`="'.($id).'"
			LIMIT 1');
		if($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) { $out .= $sor['szp_reurl'].'/'; }
		return $out;
	}
	
	$_ENV['SiteFunc'][] = 'outMenu';
	function outMenu($txt) {

		$Array = Array();
		$resultat = preg_match_all("/\{menu:(([0-9a-zA-Z$()<>=`~_.,+*!%&|';\	\ \-\"\/[\]\/\\\])+?)\}/", $txt, $Array, PREG_SET_ORDER);
		$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		for($i=0;$i<count($Array);$i++) {
			$_outMenu = SzMenuKategs($_SESSION['LANG'],$Array[$i][1],true);
			$txt = str_replace($Array[$i][0],$_outMenu,$txt);
		}

		$pCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_status`="A" AND `szm_reurl`="'.($_SESSION['LANG']).'" ORDER BY `szm_reurl` LIMIT 1');
		$pSor = mysqli_fetch_array($pCon,MYSQLI_ASSOC);
		$secMenu = $pSor['szm_id']+10;
		
		$Array = Array();
		$resultat = preg_match_all("/\{secMenu:(([0-9a-zA-Z$()<>=`~_.,+*!%&|';\	\ \-\"\/[\]\/\\\])+?)\}/", $txt, $Array, PREG_SET_ORDER);
		$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		for($i=0;$i<count($Array);$i++) {
			$_outMenu = SzMenuKategs($secMenu,$Array[$i][1],true);
			$txt = str_replace($Array[$i][0],$_outMenu,$txt);
		}

		$Array = Array();
		$resultat = preg_match_all("/\{subMenu:(([0-9a-zA-Z$()<>=`~_.,+*!%&|';\	\ \-\"\/[\]\/\\\])+?)\}/", $txt, $Array, PREG_SET_ORDER);
		$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		if($_ENV['SZMENU']['szm_k_id']>9) {
			$_leftMenuID = $_ENV['SZMENU']['szm_k_id'];
		} else if($_ENV['SZMENU']['szm_id']>0) {
			$_leftMenuID = $_ENV['SZMENU']['szm_id'];
		} else {
			$_leftMenuID = '-1';
		}
		for($i=0;$i<count($Array);$i++) {
			$_outMenu = SzMenuKategs($_leftMenuID,$Array[$i][1],true);
			$txt = str_replace($Array[$i][0],$_outMenu,$txt);
		}

		return $txt;
	}

}
?>