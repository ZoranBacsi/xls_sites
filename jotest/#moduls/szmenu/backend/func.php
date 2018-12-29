<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/backend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/backend',true);

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	/* Egyéni szótár betöltése */
	load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

	/* Admin menü definiálása */
	if(!$_ENV['MOD_MENU'][1]) { $_ENV['MOD_MENU'][1] = ''; }
	$_ENV['MOD_MENU'][1] .= '
			<div class="adminMenuCim">{menu_szmenu_cim}</div>
			'.((in_array('hu',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=1&level=1">{menu_szmenu_kateg_hu}</a></div>'):('')).'
			'.((in_array('en',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=1&level=1">{menu_szmenu_kateg_en}</a></div>'):('')).'
			'.((in_array('de',$_ENV['LANGS']))?('<div><a class="adminMenu" href="?oldal=szmenu&amp;mode=kateg&p_id=1&level=1">{menu_szmenu_kateg_de}</a></div>'):('')).'
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

	$_ENV['CONF']['htmlTextaInsert'][] = 'pages';
	function htmlTextaInsert_pages($textaid) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szpage` ORDER BY `szp_cim` LIMIT 100');
		if(mysqli_num_rows($con)) {
			$out .= '<h3>Szerkeszthető oldalak linkje:</h3>';
			while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				$name = $sor['szp_cim'];
				$html = '<a href="/'.($sor['szp_reurl']).'/">\'+((tinyMCE.get(\''.($textaid).'\').selection.getContent())?(tinyMCE.get(\''.($textaid).'\').selection.getContent()):(\''.($name).'\'))+\'</a>';
				$out .= htmlTextaInsertRow($textaid,$html,$name);
			}
			$out .= '<br/>';
		}
		return $out;
	}
}
?>