<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('default/backend',false);
$_ENV['MODS']['PURL'] = rPath('default/backend',true);

/* Egyéni szótár betöltése */
load_lang_file($_ENV['MODS']['PATH'].'/dic/'.(strtolower($_SESSION['LANG'])).'.ini');
if(!$_ENV['MOD_MENU'][0]) { $_ENV['MOD_MENU'][0] = ''; }
$_ENV['MOD_MENU'][0] .= '
	<div class="adminMenuCim">{menu_rendszer_admin_cim}</div>
	<div><a class="adminMenu" href="?oldal=default&amp;mode=admin-users">{menu_admin_felhasznalok}</a></div>
	<div><a class="adminMenu" href="?oldal=default&amp;mode=default-meta">{menu_default_seo}</a></div>
	'.(($_ENV['USER']['u_sys'])?('<div><a class="adminMenu" href="?oldal=default&amp;mode=maps">{menu_terkepek}</a></div>'):('')).'
	'.(($_ENV['USER']['u_sys'])?('<div><a class="adminMenu" href="?oldal=default&amp;mode=forms">{menu_formok}</a></div>'):('')).'
	'.(($_ENV['USER']['u_sys'])?('<div><a class="adminMenu" href="?oldal=default&amp;mode=sys-config">{menu_default_config}</a></div>'):('')).'
	<hr/>';

function htmlTextaInsertRow($textaid,$html,$name) { $out = '';
	$out .= '<p><a onclick=\'tinyMCE.get("'.($textaid).'").execCommand("mceInsertContent",false,"'.(str_replace(Array('"',"'"),Array('\"','"'),$html)).'"); hs.close(this); return false;\'>'.($name).'</a></p>';
	return $out;
}

$_ENV['CONF']['htmlTextaInsert'][] = 'forms';
function htmlTextaInsert_forms($textaid) { $out = '';
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` ORDER BY `form_name` LIMIT 100');
	if(mysqli_num_rows($con)) {
		$out .= '<h3>Formok:</h3>';
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			$name = $sor['form_name'];
			$html = '<iframe src="#{forms:'.($sor['form_id']).'}" width="500" height="250"></iframe>';
			$out .= htmlTextaInsertRow($textaid,$html,$name);
		}
		$out .= '<br/>';
	}
	return $out;
}

$_ENV['CONF']['htmlTextaInsert'][] = 'maps';
function htmlTextaInsert_maps($textaid) { $out = '';
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `maps` ORDER BY `map_cimke` LIMIT 100');
	if(mysqli_num_rows($con)) {
		$out .= '<h3>Térképek:</h3>';
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			$name = $sor['map_cimke'];
			$html = '<iframe src="#{maps:'.($sor['map_id']).'}" width="400" height="300"></iframe>';
			$out .= htmlTextaInsertRow($textaid,$html,$name);
		}
		$out .= '<br/>';
	}
	return $out;
}

function htmlTextaInsert($textaid) { $out = '';
	$_out_links = '';
	foreach($_ENV['CONF']['htmlTextaInsert'] as $ext) {
		$funcName = 'htmlTextaInsert_'.$ext;
		$_out_links .= ((function_exists($funcName))?($funcName($textaid)):(''));
	}
	if($_out_links) {
		$out .= '
		<input class="admin_btn" type="button" value="Beszúrás" onclick="$(\'#insert_'.($textaid).'\').click();" style="margin:5px 10px;" />
		<a href="#" onclick="return hs.htmlExpand(this,{outlineType:\'rounded-white\',wrapperClassName:\'draggable-header\',headingText:\'Beszúrás HTML szerkesztőbe\'})" id="insert_'.($textaid).'"></a>
		<div class="highslide-maincontent">'.($_out_links).'</div>';
	}
	return $out;
}
?>