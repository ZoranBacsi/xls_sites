<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('galeria/backend',false);
$_ENV['MODS']['PURL'] = rPath('galeria/backend',true);

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	/* Egyéni szótár betöltése */
	load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

	if(!$_ENV['MOD_MENU'][3]) { $_ENV['MOD_MENU'][3] = ''; }
	$_ENV['MOD_MENU'][3] .= '
			<div class="adminMenuCim"><b>{menu_galeria_cim}</b></div>
			<div><a class="adminMenu" href="?oldal=galeria">{menu_galeria_kateg}</a></div>
			<hr/>';
	
	$_ENV['CONF']['ReURLcontrols']['galeria'] = 'galeria_ReURLControl';
	function galeria_ReURLControl($reurl,$table,$id,$pid) {
		$PageCon = mysqli_query($_ENV['MYSQLI'],'
				SELECT *
				FROM `galeria`
				WHERE `gal_reurl`="'.($reurl).'"
					AND `gal_id`!="'.($id).'"
				LIMIT 1');
		if(!mysqli_num_rows($PageCon)) {
			return false;
		} else { return true; }
	}
	
	$_ENV['CONF']['htmlTextaInsert'][] = 'galeries';
	function htmlTextaInsert_galeries($textaid) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` ORDER BY `gal_sorsz` LIMIT 100');
		if(mysqli_num_rows($con)) {
			$out .= '<div class="insertBlock"><h3>Galériák linkje:</h3>';
			while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				$name = $sor['gal_cim'];
				$html = '<a href="#{galeriaUrl:'.($sor['gal_id']).'}">\'+((tinyMCE.get(\''.($textaid).'\').selection.getContent())?(tinyMCE.get(\''.($textaid).'\').selection.getContent()):(\''.($name).'\'))+\'</a>';
				$out .= '<div>'.htmlTextaInsertRow($textaid,$html,$name).'</div>';
			}
			$out .= '</div>';
		}
		return $out;
	}
}
?>