<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/backend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/backend',true);

$_secondMenu = true;

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	/* Egyéni szótár betöltése */
	load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

	/* Admin menü definiálása */
	if(!$_ENV['MOD_MENU'][1]) { $_ENV['MOD_MENU'][1] = ''; }
	$_ENV['MOD_MENU'][1] .= '
			<div class="adminMenuCim">{menu_szmenu_cim}</div>
			'.((in_array('hu',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=1&level=1">{menu_szmenu_kateg_hu}</a></div>'):('')).'
			'.((in_array('hu',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=11&level=1">{menu_szmenu_kateg2_hu}</a></div>'):('')).'
			'.((in_array('en',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=2&level=1">{menu_szmenu_kateg_en}</a></div>'):('')).'
			'.((in_array('en',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=12&level=1">{menu_szmenu_kateg2_en}</a></div>'):('')).'
			'.((in_array('de',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=3&level=1">{menu_szmenu_kateg_de}</a></div>'):('')).'
			'.((in_array('de',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=13&level=1">{menu_szmenu_kateg2_de}</a></div>'):('')).'
			'.((in_array('it',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=4&level=1">{menu_szmenu_kateg_it}</a></div>'):('')).'
			'.((in_array('it',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=14&level=1">{menu_szmenu_kateg2_it}</a></div>'):('')).'
			'.((in_array('ru',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=5&level=1">{menu_szmenu_kateg_ru}</a></div>'):('')).'
			'.((in_array('ru',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=15&level=1">{menu_szmenu_kateg2_ru}</a></div>'):('')).'
			'.((in_array('ro',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=6&level=1">{menu_szmenu_kateg_ro}</a></div>'):('')).'
			'.((in_array('ro',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=16&level=1">{menu_szmenu_kateg2_ro}</a></div>'):('')).'
			'.((in_array('sk',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=7&level=1">{menu_szmenu_kateg_sk}</a></div>'):('')).'
			'.((in_array('sk',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=17&level=1">{menu_szmenu_kateg2_sk}</a></div>'):('')).'
			'.((in_array('jp',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=8&level=1">{menu_szmenu_kateg_jp}</a></div>'):('')).'
			'.((in_array('jp',$_ENV['LANGS']) AND $_secondMenu)?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=18&level=1">{menu_szmenu_kateg2_jp}</a></div>'):('')).'
			'.(($_ENV['SzmenuSzerkOldal'])?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=pages">{menu_szmenu_pages}</a></div>'):('')).'
			<hr/>';
	
	$_ENV['CONF']['ReURLcontrols']['szpage'] = 'szmenu_ReURLControl';
	$_ENV['CONF']['ReURLcontrols']['szmenu'] = 'szmenu_ReURLControl';
	function szmenu_ReURLControl($reurl,$table,$id,$pid) {
		if($table=='szpage') {
			$PageCon = mysqli_query($_ENV['MYSQLI'],'
					SELECT *
					FROM `szpage`
					WHERE `szp_reurl`="'.($reurl).'"
						AND `szp_id`!="'.($id).'"
					LIMIT 1');
			if(!mysqli_num_rows($PageCon)) {
				for($a=1;$a<=9;$a++) {
					$MenuCon = mysqli_query($_ENV['MYSQLI'],'
							SELECT *
							FROM `szmenu`
							WHERE `szm_reurl`="'.($reurl).'"
								AND `szm_k_id`="'.($a).'"
							LIMIT 1');
					if(mysqli_num_rows($MenuCon)) { return true; }
				}
				return false;
			} else { return true; }
		} else if($table=='szmenu') {
			$MenuCon = mysqli_query($_ENV['MYSQLI'],'
					SELECT *
					FROM `szmenu`
					WHERE `szm_reurl`="'.($reurl).'"
						AND `szm_k_id`="'.($pid).'"
						AND `szm_id`!="'.($id).'"
					LIMIT 1');
			if(!mysqli_num_rows($MenuCon)) {
				$PageCon = mysqli_query($_ENV['MYSQLI'],'
						SELECT *
						FROM `szpage`
						WHERE `szp_reurl`="'.($reurl).'"
						LIMIT 1');
				if(mysqli_num_rows($PageCon)) {
					return true;
				} else { return false; }
			} else { return true; }
		}
	}
	
	function htmlTextaInsert_SzMenuKategsList($textaid,$parent,$minta) { $out = $subMenu = '';
		if(!is_numeric($parent)) {
			$parentCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_status`="A" AND `szm_reurl`="'.($parent).'" ORDER BY `szm_reurl` LIMIT 1');
			$parentSor = mysqli_fetch_array($parentCon,MYSQLI_ASSOC);
			$parent = $parentSor['szm_id'];
		}
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_status`="A" AND `szm_k_id`="'.($parent).'" ORDER BY `szm_sorsz`');
		while($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			$subMenu = htmlTextaInsert_SzMenuKategsList($textaid,$sor['szm_id'],$minta);
			$subHtml = (($subMenu)?('<div style="padding-left:20px;">'.($subMenu).'</div>'):(''));
			$name = out_icons($sor['szm_link']);
			if($sor['szm_mod']!='L' OR $sor['szm_href']) {
				$html = str_replace(
					Array('[ID]','[LINK]'),
					Array($sor['szm_id'],out_icons($sor['szm_link'])),
					$minta
				);
				$out .= '<div>'.htmlTextaInsertRow($textaid,$html,$name).$subHtml.'</div>';
			}
		}
		return $out;
	}

	$_ENV['CONF']['htmlTextaInsert'][] = 'szmenukategs';
	function htmlTextaInsert_szmenukategs($textaid) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_level`>0 ORDER BY `szm_cim` LIMIT 1');
		if(mysqli_num_rows($con)) {
			$out .= '<div class="insertBlock"><h3>Menüpontok linkje:</h3>';
			$html = '<a href="#{menuUrl:[ID]}">\'+((tinyMCE.get(\''.($textaid).'\').selection.getContent())?(tinyMCE.get(\''.($textaid).'\').selection.getContent()):(\'[LINK]\'))+\'</a>';
			$out .= htmlTextaInsert_SzMenuKategsList($textaid,$_SESSION['LANG'],$html);
			$out .= '</div>';
		}
		return $out;
	}

	$_ENV['CONF']['htmlTextaInsert'][] = 'pages';
	function htmlTextaInsert_pages($textaid) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szpage` ORDER BY `szp_cim` LIMIT 100');
		if(mysqli_num_rows($con)) {
			$out .= '<div class="insertBlock"><h3>Szerk. oldalak linkje:</h3>';
			while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				$name = $sor['szp_cim'];
				$html = '<a href="#{pageUrl:'.($sor['szp_id']).'}">\'+((tinyMCE.get(\''.($textaid).'\').selection.getContent())?(tinyMCE.get(\''.($textaid).'\').selection.getContent()):(\''.($name).'\'))+\'</a>';
				$out .= '<div>'.htmlTextaInsertRow($textaid,$html,$name).'</div>';
			}
			$out .= '</div>';
		}
		return $out;
	}
}
?>