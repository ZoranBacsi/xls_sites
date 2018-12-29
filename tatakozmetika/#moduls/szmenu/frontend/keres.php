<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/frontend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/frontend',true);

echo '<h1>Keresés</h1>';

if($_REQUEST['keyw']) {
	if($_ENV['szmSzerkCikkOldal']) {
		echo'
			<div class="szMenuItems szMenuSearch">';
		$con = mysqli_query($_ENV['MYSQLI'],'
			SELECT * 
			FROM `szpage` 
			WHERE `szp_status`="A"
				AND (
						 `szp_cim` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szp_title` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szp_h1` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szp_desc` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szp_rtext` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szp_text` LIKE "%'.in_text($_REQUEST['keyw']).'%"
				)
				AND `szp_status`="A"
			ORDER BY `szp_date` DESC LIMIT 50');
		$cikkNum = mysqli_num_rows($con); $n=0; $_hasab = Array();
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			if(!$_hasab[$n]) { $_hasab[$n] = ''; }
			$_hasab[$n] .= '
				<div class="szMenuItem dontsplit"'.((!$cikkNum)?(' style="display:block;width:100%;"'):('')).'>
					<h2>'.(out_html($sor['szp_cim'])).'</h2>
					<div class="szMenuText">'.(out_html((strlen(strip_tags($sor['szp_rtext']))>3)?($sor['szp_rtext']):($sor['szp_text']))).'</div>
					<div class="szMenuBovebben"><a href="'.(MenuFa($sor['szmp_m_id'])).'/'.($sor['szp_reurl']).'/">Bővebben</a></div>
				</div>';
			$n++;
			if($n>1) { $n=0; }
		}
		if(count($_hasab)) { echo '<div'.((count($_hasab)>1)?(' class="szMenuColl"'):('')).'> '.(join('</div><div class="szMenuColl">',$_hasab)).' </div>'; }
		echo'
			</div>';
	} else {
		$con = mysqli_query($_ENV['MYSQLI'],'
			SELECT *
			FROM `szmenu`
			WHERE `szm_status`="A"
				AND (
						 `szm_cim` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szm_title` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szm_h1` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szm_desc` LIKE "%'.in_text($_REQUEST['keyw']).'%"
					OR `szm_text` LIKE "%'.in_text($_REQUEST['keyw']).'%"
				)
			ORDER BY `szm_sorsz`');
		if(mysqli_num_rows($con)>0) {
			$_links = $_texts = $_jsList = array();
			while($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				if(strlen($sor['szm_text'])>3) {
					echo
					'<div class="szMenuMainTextListItem" id="szm_'.($sor['szm_reurl']).'">'
						.'<h3><a href="'.(MenuFa($sor['szm_id'])).'">'.($sor['szm_cim']).'</a></h3>'
						.'<div class="szMenuShort">'.(out_html($sor['szm_text'])).'</div>'
						.'<div class="szMenuBovebben"><a href="'.(MenuFa($sor['szm_id'])).'">Bővebben</a></div>'
					.'</div>';
				}
			}
		} else {
			echo'<p style="text-align:center;padding:30px;">Nincs találat!</p>';
		}
	}
} else {
	echo'<p style="text-align:center;padding:30px;">Kereset kifejezés túl rövid!</p>';
}
?>