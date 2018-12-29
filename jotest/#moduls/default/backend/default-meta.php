<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
if($rogzit AND !($_ENV['USER']['u_guest'])) {
	for($a=0;$a<count($_REQUEST['mod_id']);$a++) {
		mysqli_query($_ENV['MYSQLI'],'
			UPDATE `modul`
			SET `mod_h1`="'.(in_text($_REQUEST['mod_h1'][$_REQUEST['mod_id'][$a]])).'",
					`mod_title`="'.(in_text($_REQUEST['mod_title'][$_REQUEST['mod_id'][$a]])).'",
					`mod_keyw`="'.(in_text($_REQUEST['mod_keyw'][$_REQUEST['mod_id'][$a]])).'",
					`mod_desc`="'.(in_text($_REQUEST['mod_desc'][$_REQUEST['mod_id'][$a]])).'"
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
						<td><label for="mod_h1_'.($sor['mod_id']).'"><b>{h1}:</b></label></td>
						<td>
							<input type="text" id="mod_h1_'.($sor['mod_id']).'" name="mod_h1['.($sor['mod_id']).']" value="'.($sor['mod_h1']).'" class="typeText" minlength="3" maxlength="60" />
							<div class="helpBox">{h1_info}</div>
						</td>
					</tr>
					<tr>
						<td><label for="mod_title_'.($sor['mod_id']).'"><b>{title}:</b></label></td>
						<td>
							<input type="text" id="mod_title_'.($sor['mod_id']).'" name="mod_title['.($sor['mod_id']).']" value="'.($sor['mod_title']).'" class="typeText" minlength="3" maxlength="60" />
							<div class="helpBox">{title_info}</div>
						</td>
					</tr>
					<tr>
						<td><label for="mod_keyw_'.($sor['mod_id']).'"><b>{keywords}:</b></label></td>
						<td>
							<input type="text" id="mod_keyw_'.($sor['mod_id']).'" name="mod_keyw['.($sor['mod_id']).']" value="'.($sor['mod_keyw']).'" class="typeText" minlength="3" maxlength="80" />
							<div class="helpBox">{keywords_info}</div>
						</td>
					</tr>
					<tr>
						<td><label for="mod_desc_'.($sor['mod_id']).'"><b>{description}:</b></label></td>
						<td>
							<input type="text" id="mod_desc_'.($sor['mod_id']).'" name="mod_desc['.($sor['mod_id']).']" value="'.($sor['mod_desc']).'" class="typeText" minlength="3" maxlength="200" />
							<div class="helpBox">{description_info}</div>
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