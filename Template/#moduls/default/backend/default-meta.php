<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
if($rogzit AND !($_ENV['USER']['u_guest'])) {
	for($a=0;$a<count($_REQUEST['mod_id']);$a++) {
		mysqli_query($_ENV['MYSQLI'],'
			UPDATE `modul`
			SET
				`mod_h1`="'.(in_text($_REQUEST['mod_h1'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_en`="'.(in_text($_REQUEST['mod_h1_en'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_de`="'.(in_text($_REQUEST['mod_h1_de'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_it`="'.(in_text($_REQUEST['mod_h1_it'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_ru`="'.(in_text($_REQUEST['mod_h1_ru'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_ro`="'.(in_text($_REQUEST['mod_h1_ro'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_sk`="'.(in_text($_REQUEST['mod_h1_sk'][$_REQUEST['mod_id'][$a]])).'",
				`mod_h1_jp`="'.(in_text($_REQUEST['mod_h1_jp'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title`="'.(in_text($_REQUEST['mod_title'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_en`="'.(in_text($_REQUEST['mod_title_en'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_de`="'.(in_text($_REQUEST['mod_title_de'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_it`="'.(in_text($_REQUEST['mod_title_it'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_ru`="'.(in_text($_REQUEST['mod_title_ru'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_ro`="'.(in_text($_REQUEST['mod_title_ro'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_sk`="'.(in_text($_REQUEST['mod_title_sk'][$_REQUEST['mod_id'][$a]])).'",
				`mod_title_jp`="'.(in_text($_REQUEST['mod_title_jp'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw`="'.(in_text($_REQUEST['mod_keyw'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_en`="'.(in_text($_REQUEST['mod_keyw_en'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_de`="'.(in_text($_REQUEST['mod_keyw_de'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_it`="'.(in_text($_REQUEST['mod_keyw_it'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_ru`="'.(in_text($_REQUEST['mod_keyw_ru'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_ro`="'.(in_text($_REQUEST['mod_keyw_ro'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_sk`="'.(in_text($_REQUEST['mod_keyw_sk'][$_REQUEST['mod_id'][$a]])).'",
				`mod_keyw_jp`="'.(in_text($_REQUEST['mod_keyw_jp'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc`="'.(in_text($_REQUEST['mod_desc'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_en`="'.(in_text($_REQUEST['mod_desc_en'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_de`="'.(in_text($_REQUEST['mod_desc_de'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_it`="'.(in_text($_REQUEST['mod_desc_it'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_ru`="'.(in_text($_REQUEST['mod_desc_ru'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_ro`="'.(in_text($_REQUEST['mod_desc_ro'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_sk`="'.(in_text($_REQUEST['mod_desc_sk'][$_REQUEST['mod_id'][$a]])).'",
				`mod_desc_jp`="'.(in_text($_REQUEST['mod_desc_jp'][$_REQUEST['mod_id'][$a]])).'"
			WHERE `mod_id`="'.(in_text($_REQUEST['mod_id'][$a])).'" LIMIT 1');
	}
	if(!mysqli_error($_ENV['MYSQLI'])) {
		echo'<script type="text/javascript">AddAlert("ok","Fejléc adatok módosítva!");</script>';
	} else {
		echo'<script type="text/javascript">AddAlert("no","Fejléc adatok módosítása sikertelen!");</script>';
	}
}

echo'
		<h1 class="cim">{ds_alap_seo}</h1>
		<p>{ds_alap_seo_intro}</p>
		<form action="?oldal='.($oldal).'&mode='.($mode).'" onsubmit="return noAlert();" name="iForm" id="iForm" method="post">
			<input class="admin_btn save_btn" name="smbt" type="submit" value="{modosit}" onclick="$(\'#MyBody\').attr(\'edited\',null);" />
			<input type="hidden" name="rogzit" value="1" />
			<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
				<tbody>';

	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `modul` ORDER BY `mod_index` DESC'); $col=Array(); $cf=Array();
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
		echo'
					<tr class="fejlec">
						<th colspan="2">
							<input type="hidden" name="mod_id[]" value="'.($sor['mod_id']).'">
							'.($sor['mod_nev']).'
						</th>
					</tr>
					<tr class="fejlec"> <th width="120">{ds_megnevezes}</td> <th>{ds_ertek}</td> </tr>
					<tr>
						<td>
							<label for="mod_h1_'.($sor['mod_id']).'"><b>{h1}'.((count($_ENV['LANG']['ENABLED_LANG'])>1)?(' [HU]'):('')).':</b></label>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><label for="mod_h1_'.($sor['mod_id']).'_'.($_lang).'"><b>{h1} ['.(strtoupper($_lang)).']:</b></label>';
				}
			}
		}
	echo'
						</td>
						<td>
							<input type="text" id="mod_h1_'.($sor['mod_id']).'" name="mod_h1['.($sor['mod_id']).']" value="'.($sor['mod_h1']).'" class="typeText" minlength="3" maxlength="120" />
							<div class="helpBox">{h1_info}</div>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><input type="text" id="mod_h1_'.($sor['mod_id']).'_'.($_lang).'" name="mod_h1_'.($_lang).'['.($sor['mod_id']).']" value="'.($sor['mod_h1_'.($_lang).'']).'" class="typeText" minlength="3" maxlength="120" />';
				}
			}
		}
	echo'
						</td>
					</tr>
					<tr>
						<td>
							<label for="mod_title_'.($sor['mod_id']).'"><b>{title}'.((count($_ENV['LANG']['ENABLED_LANG'])>1)?(' [HU]'):('')).':</b></label>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><label for="mod_title_'.($sor['mod_id']).'_'.($_lang).'"><b>{title} ['.(strtoupper($_lang)).']:</b></label>';
				}
			}
		}
	echo'
						</td>
						<td>
							<input type="text" id="mod_title_'.($sor['mod_id']).'" name="mod_title['.($sor['mod_id']).']" value="'.($sor['mod_title']).'" class="typeText" minlength="3" maxlength="120" />
							<div class="helpBox">{title_info}</div>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><input type="text" id="mod_title_'.($sor['mod_id']).'_'.($_lang).'" name="mod_title_'.($_lang).'['.($sor['mod_id']).']" value="'.($sor['mod_title_'.($_lang).'']).'" class="typeText" minlength="3" maxlength="120" />';
				}
			}
		}
	echo'
						</td>
					</tr>
					<tr>
						<td>
							<label for="mod_keyw_'.($sor['mod_id']).'"><b>{keywords}'.((count($_ENV['LANG']['ENABLED_LANG'])>1)?(' [HU]'):('')).':</b></label>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><label for="mod_keyw_'.($sor['mod_id']).'_'.($_lang).'"><b>{keywords} ['.(strtoupper($_lang)).']:</b></label>';
				}
			}
		}
	echo'
						</td>
						<td>
							<input type="text" id="mod_keyw_'.($sor['mod_id']).'" name="mod_keyw['.($sor['mod_id']).']" value="'.($sor['mod_keyw']).'" class="typeText" minlength="3" maxlength="120" />
							<div class="helpBox">{keywords_info}</div>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><input type="text" id="mod_keyw_'.($sor['mod_id']).'_'.($_lang).'" name="mod_keyw_'.($_lang).'['.($sor['mod_id']).']" value="'.($sor['mod_keyw_'.($_lang).'']).'" class="typeText" minlength="3" maxlength="120" />';
				}
			}
		}
	echo'
						</td>
					</tr>
					<tr>
						<td>
							<label for="mod_desc_'.($sor['mod_id']).'"><b>{description}'.((count($_ENV['LANG']['ENABLED_LANG'])>1)?(' [HU]'):('')).':</b></label>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><label for="mod_desc_'.($sor['mod_id']).'_'.($_lang).'"><b>{description} ['.(strtoupper($_lang)).']:</b></label>';
				}
			}
		}
	echo'
						</td>
						<td>
							<input type="text" id="mod_desc_'.($sor['mod_id']).'" name="mod_desc['.($sor['mod_id']).']" value="'.($sor['mod_desc']).'" class="typeText" minlength="3" maxlength="250" />
							<div class="helpBox">{description_info}</div>';
		if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
			for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
				$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
				if($_lang AND $_lang!='hu') {
					echo'<br/><input type="text" id="mod_desc_'.($sor['mod_id']).'_'.($_lang).'" name="mod_desc_'.($_lang).'['.($sor['mod_id']).']" value="'.($sor['mod_desc_'.($_lang).'']).'" class="typeText" minlength="3" maxlength="250" />';
				}
			}
		}
	echo'
						</td>
					</tr>
					<tr class="fejlec"> <th colspan="2"> &nbsp; </th> </tr>';
	}

echo'
					<tr><td colspan="2" align="center"><input class="admin_btn" name="smbt" type="submit" value="{modosit}" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></td></tr>
				</tbody>
			</table>
		</form>';

?>