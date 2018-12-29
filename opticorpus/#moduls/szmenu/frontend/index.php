<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/frontend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/frontend',true);

if(!is_array($_ENV['USER']['uw_kategs'])) { $_ENV['USER']['uw_kategs'] = explode('|',$_ENV['USER']['uw_kategs']); }

$_private_enable=false;
$_private = explode('|',$_ENV['SZMENU']['szm_private_kategs']);
for($a=0;$a<count($_private);$a++) {
	if(in_array($_private[$a],$_ENV['USER']['uw_kategs'])) { $_private_enable=true; }
}


if(count($_private)>0 AND $_private[0]>0 AND !$_private_enable) {
	if($_ENV['USER']['uw_id']>0) {
		echo'<h1>Nincs megtekintéséhez joga!</h1>';
	} else {
		echo'<h1>Be kell jelentkeznie!</h1>';
	}
} else if($_ENV['SZMENU']['szm_id']>0) {
	echo ((strlen($_ENV['SZMENU']['szm_cim'])>2)?('<h1>'.($_ENV['SZMENU']['szm_cim']).'</h1>'):(''));
	if($_ENV['szmSzerkCikkOldal']) {
		echo'
			<div class="szMenuItems">';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szpage` INNER JOIN `szmp` ON `szmp_p_id`=`szp_id` WHERE `szmp_m_id`="'.($_ENV['SZMENU']['szm_id']).'" AND `szmp_p_id`=`szp_id` AND `szp_status`="A" ORDER BY `szmp_sorsz`');
		$cikkNum = mysqli_num_rows($con); $_hasab = Array();
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $n++;
			if(!$_hasab[$sor['szmp_coll']]) { $_hasab[$sor['szmp_coll']] = ''; }
			$_hasab[$sor['szmp_coll']] .= '
				<div class="szMenuItem dontsplit"'.(($cikkNum<=1)?(' _style="display:block;width:100%;margin:0;"'):('')).'>
					<h2>'.(out_html($sor['szp_cim'])).'</h2>
					<div class="szMenuText">'.(out_html((strlen(strip_tags($sor['szp_rtext']))>3)?($sor['szp_rtext']):($sor['szp_text']))).'</div>
					'.((strlen(strip_tags($sor['szp_text']))>3)?('<div class="szMenuBovebben"><a href="'.(MenuFa($sor['szmp_m_id'])).'/'.($sor['szp_reurl']).'/">Bővebben</a></div>'):('')).'
				</div>';
		}
		if(count($_hasab)) { echo '<div'.((count($_hasab)>1)?(' class="szMenuColl"'):('')).'> '.(join('</div><div class="szMenuColl">',$_hasab)).' </div>'; }
		echo'
			</div>';
	} else if(!$_ENV['SzmenuType'] OR $_ENV['SZMENU']['szm_tipus']=='N') {
		echo (($_ENV['SZMENU']['szm_text'])?('<div class="szMenuFullText">'.(out_html($_ENV['SZMENU']['szm_text'])).'</div>'):(''));
	} else {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_k_id`="'.($_ENV['SZMENU']['szm_id']).'" AND `szm_status`="A" ORDER BY `szm_sorsz`');
		if(mysqli_num_rows($con)>0) {
			$_links = $_texts = $_jsList = array();
			while($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				$_links[] = '<li><a href="'.(($_ENV['SZMENU']['szm_tipus']!='T')?(MenuFa($sor['szm_id'])):('#szm_'.$sor['szm_reurl'])).'">'.out_icons($sor['szm_link']).'</a></li>';
				if(strlen($sor['szm_text'])>3) {
					$_texts[] = '<div class="szMenuMainTextListItem" id="szm_'.($sor['szm_reurl']).'">'
					.(($_ENV['SZMENU']['szm_tipus']=='R' OR $_ENV['SZMENU']['szm_tipus']=='L')?('<h3><a href="'.(MenuFa($sor['szm_id'])).'">'.($sor['szm_cim']).'</a></h3>'):(''))
					.(($_ENV['SZMENU']['szm_tipus']=='R')?('<div class="szMenuShort">'.(out_html($sor['szm_text'])).'</div>'):(out_html($sor['szm_text'])))
					.(($_ENV['SZMENU']['szm_tipus']=='R')?('<div class="szMenuBovebben"><a href="'.(MenuFa($sor['szm_id'])).'">Bővebben</a></div>'):(''))
					.'</div>';
				}
				if($_ENV['SZMENU']['szm_tipus']=='S') {
					$_jsList[] = '
						<div class="szMenuRowJS">
							<h3 class="szMenuTitleJS"><span class="arrow"></span>'.out_icons($sor['szm_link']).'</h3>
							<div class="szMenuTextJS">'.(out_html($sor['szm_text'])).'</div>
						</div>';
				}
			}
			if($_ENV['SZMENU']['szm_tipus']=='M' OR $_ENV['SZMENU']['szm_tipus']=='T') {
				echo'<div class="szMenuMainMenuList"><ul>'.(join('',$_links)).'</ul></div>';
			}

			echo (($_ENV['SZMENU']['szm_text'])?('<div class="szMenuFullText">'.(out_html($_ENV['SZMENU']['szm_text'])).'</div>'):(''));
			
			if($_ENV['SZMENU']['szm_tipus']=='S') {
				echo'<div class="szMenuMainMenuList">'.(join('',$_jsList)).'</div>';
				echo'
					<script type="text/javascript">
						$(".szMenuTitleJS").click(function() {
							$(".szMenuTextJS",$(this).parent()).attr("opening","true");
							$(".szMenuTextJS").each(function() {
								if(!($(this).attr("opening")) || $(this).css("display")=="block") {
									$(this).slideUp(800);
									$(".arrow",$(this).parent()).rotate(0);
								} else {
									$(this).slideDown(800);
									$(".arrow",$(this).parent()).rotate(90);
									/* $("html, body").animate({ scrollTop: (($("#nav").offset().top-100<=$("html, body").scrollTop())?($("#nav").offset().top):(0)) }, 1000); */
								}
								$(".szMenuTextJS",$(this).parent()).attr("opening",null);
							});
						});
					</script>';
			}

			if($_ENV['SZMENU']['szm_tipus']=='L' OR $_ENV['SZMENU']['szm_tipus']=='R' OR $_ENV['SZMENU']['szm_tipus']=='T') {
				echo'<div class="szMenuMainMenuList">'.(join('',$_texts)).'</div>';
			}
		}

	}
} else if($_ENV['SZPAGE']['szp_id']>0) {
	echo ((strlen($_ENV['SZPAGE']['szp_cim'])>2)?('<h1>'.($_ENV['SZPAGE']['szp_cim']).'</h1>'):(''));
	echo (($_ENV['SZPAGE']['szp_text'])?('<div class="szMenuFullText">'.(out_html($_ENV['SZPAGE']['szp_text'])).'</div>'):('<div class="szMenuFullText">'.(out_html($_ENV['SZPAGE']['szp_rtext'])).'</div>'));
	echo (($_ENV['SZPAGE']['szp_text'] OR strstr($_SERVER['HTTP_REFERER'],'/search'))?('<div class="szMenuBack"><a href="#" onclick="history.go(-1);">Vissza</a></div>'):(''));
}

if($_ENV['SZMENU']['szm_gal']>0 AND $_ENV['SzmenuGalTarsit']) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_id`="'.($_ENV['SZMENU']['szm_gal']).'" LIMIT 1');
	if($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
		echo'<hr /><h3>'.($sor['gal_cim'.$_ENV['LangPref']]).'</h3>';
		$kep_con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="gal_{'.($sor['gal_id']).'}" ORDER BY `kep_sorsz`');
		if(mysqli_num_rows($kep_con)>0) { $i=0;
			echo'<div class="gal_kep_group">';
			while($row=mysqli_fetch_array($kep_con,MYSQLI_ASSOC)) { $i++;
				echo'
					<div class="gal_kep">
						<a href="'.fPath('/'.($row['kep_nagy'])).'" title="'.($row['kep_cimke'.$_ENV['LangPref']]).'" onclick="return hs.expand(this,{wrapperClassName: \'highslide-no-border\', dimmingOpacity: 0.75, align: \'center\'}); return false;">
							<span title="'.($row['gal_cim'.$_ENV['LangPref']]).'" style="background-image: url(\''.fPath('/'.($row['kep_kozepes'])).'\');" class="hsimg"></span>
							'.(($row['kep_cimke'.$_ENV['LangPref']])?('<span class="gal_kep_szoveg">'.($row['kep_cimke'.$_ENV['LangPref']]).'</span>'):('')).'
						</a>
					</div>';
			}
			echo'</div>';
		}
	}
}
?>