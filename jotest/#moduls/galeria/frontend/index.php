<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('galeria/frontend',false);
$_ENV['MODS']['PURL'] = rPath('galeria/frontend',true);

/* TARTALOM */

$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_reurl`="'.(end($_ENV['REURL'])).'" LIMIT 1');
$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
if(!is_numeric($sor['gal_level'])) {
	echo'
		<h1>Galériák</h1>';
	$rcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_p_id`="'.(($sor['gal_id']>0)?($sor['gal_id']):(0)).'" AND `gal_status`="A" ORDER BY `gal_sorsz`');
	if(mysqli_num_rows($rcon)) { $i=0;
		echo'<div class="gal_fokep_group">';
		while($row = mysqli_fetch_array($rcon,MYSQLI_ASSOC)) { $i++;
			$kiskep = GalKisKep($row['gal_id'],$row['gal_defkep']);
			echo'
				<div class="gal_fokep">
					<a href="'.fPath('/galeria/'.($row['gal_reurl'])).'/" '.((!is_numeric($sor['gal_level']) AND $_ENV['GAL']['LISTAS'])?('onclick="location.href=\'#'.($row['gal_reurl']).'\'; return false;" '):('')).' title="'.($row['gal_cim'.$_ENV['LangPref']]).'">
						'.(($kiskep)?('<span title="'.($row['gal_cim'.$_ENV['LangPref']]).'" style="background-image: url(\''.fPath('/'.($kiskep)).'\');" class="hsimg"></span>'):('')).'
						'.(($row['gal_cim'.$_ENV['LangPref']])?('<span class="gal_fokep_szoveg">'.($row['gal_cim'.$_ENV['LangPref']]).'</span>'):('')).'
						<span class="album"></span>
					</a>
				</div>';
		}
		echo'</div>';
	} else {
		echo'<div style="text-align:center; margin: 50px; font-size: 16px; font-weight: bold;">A galériák üres!</div>';
	}
	if($_ENV['GAL']['LISTAS']) {
		$rcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_p_id`="'.($sor['gal_id']).'" AND `gal_status`="A" ORDER BY `gal_sorsz`');
		if(mysqli_num_rows($rcon)) { $n=0;
			echo'<div class="gal_albums">';
			while($grow = mysqli_fetch_array($rcon,MYSQLI_ASSOC)) { $n++;
				$kiskep = GalKisKep($grow['gal_id'],$grow['gal_defkep']);
				echo'<div id="'.(($grow['gal_reurl'])).'" class="gal_album">';
				echo'<h2>'.($grow['gal_cim'.$_ENV['LangPref']]).'</h2>';
				$kep_con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_modul`="'.($_ENV['SITE']['MODUL']).'" AND `kep_mid`="gal_{'.($grow['gal_id']).'}" ORDER BY `kep_sorsz`');
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
				echo'</div>';
			}
			echo'</div>';
		}
	}
} else {
	echo'<h1>'.($sor['gal_cim'.$_ENV['LangPref']]).'</h1>';
	$kep_con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_modul`="'.($_ENV['SITE']['MODUL']).'" AND `kep_mid`="gal_{'.($sor['gal_id']).'}" ORDER BY `kep_sorsz`');
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
	echo'<div><a href="/galeria/" onclick="history.go(-1); return false;" title="Vissza &#187;">Vissza &#187;</a></div>';
}
echo'
<script type="text/javascript">
	//<!--
		if(typeof galDefine == "undefined") {
			hs.graphicsDir = "/js/highslide/imamges/";
			//hs.align = "center";
			hs.transitions = ["expand", "crossfade"];
			hs.fadeInOut = true;
			hs.dimmingOpacity = 0.8;
			hs.wrapperClassName = "borderless floating-caption";
			hs.captionEval = "this.thumb.alt";
			hs.marginLeft = 100; // make room for the thumbstrip
			hs.marginBottom = 80 // make room for the controls and the floating caption
			hs.numberPosition = "caption";
			hs.lang.number = "%1/%2";

			// Add the controlbar
			hs.addSlideshow({
				//slideshowGroup: "group1",
				interval: 5000,
				repeat: false,
				useControls: true,
				fixedControls: "fit",
				overlayOptions: {
					opacity: 0.75,
					position: "bottom center",
					hideOnMouseOut: true
				}
			});
		}
		var galDefine=true;
	//-->;
</script>';
?>