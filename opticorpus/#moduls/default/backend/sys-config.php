<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
if($rogzit AND !($_ENV['USER']['u_guest'])) {

	for($a=0;$a<count($_REQUEST['cf_id']);$a++) {
		mysqli_query($_ENV['MYSQLI'],'
			UPDATE `sys_config`
			SET `cf_value`="'.(in_text($_REQUEST['cf_value'][$_REQUEST['cf_id'][$a]])).'"
			WHERE `cf_id`="'.(in_text($_REQUEST['cf_id'][$a])).'" LIMIT 1');
	}

	if(!mysqli_error($_ENV['MYSQLI'])) {
		echo'<script type="text/javascript">AddAlert("ok","Rendszer beállítások módosítva!");</script>';
	} else {
		echo'<script type="text/javascript">AddAlert("no","Rendszer beállítások módosítása sikertelen!");</script>';
	}

}
echo'
		<h1 class="cim">{dc_web_conf_title}</h1>
		<p>&nbsp;</p>
		<form action="?oldal='.($oldal).'&mode='.($mode).'" onsubmit="return noAlert();" name="iForm" id="iForm" method="post">
			<input class="admin_btn save_btn" name="smbt" type="submit" value="{modosit}" onclick="$(\'#MyBody\').attr(\'edited\',null);" />
			<input type="hidden" name="rogzit" value="1" />
			<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
				<tbody>
					<tr class="fejlec"> <th width="200">{dc_beallita}</td> <th>{dc_ertek}</td> </tr>';
$con = mysqli_query($_ENV['MYSQLI'],'
				SELECT *
				FROM `sys_config`
				LEFT JOIN `sys_config_pack`
					ON `cfp_pref` = `cf_pack`
				ORDER BY `cfp_index` DESC, `cf_pack` ASC, `cf_id` ASC');
$col=Array(); $cf=Array();
while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $col[$sor['cf_code']]=$sor; $cf[]=$sor['cf_code']; }
for($a=0;$a<count($cf);$a++) {
	$_set = explode('|',$col[$cf[$a]]['cf_set']);
	if($last_pack!=$col[$cf[$a]]['cf_pack']) {
		echo'<tr><th colspan="2">'.($col[$cf[$a]]['cfp_name']).'</th></tr>';
		$last_pack=$col[$cf[$a]]['cf_pack'];
	}
	switch ($col[$cf[$a]]['cf_type']) {
		case 'none':
		case 'text': $type = 'typeText'; break;
		case 'user': $type = 'typeUser'; break;
		case 'pass': $type = 'typePass'; break;
		case 'mail': $type = 'typeEmail'; break;
		case 'date': $type = 'typeDate'; break;
		case 'number': $type = 'typeNumber'; break;
		default: $type = 'typeText'; break;
	}
	echo'
					<tr>
						<td><label for="cf_value_'.($col[$cf[$a]]['cf_id']).'"><b>'.($col[$cf[$a]]['cf_name']).':</b></label></td>
						<td>
							<input type="hidden" name="cf_id[]" value="'.($col[$cf[$a]]['cf_id']).'" />
							<input type="hidden" name="cf_pack[]" value="'.($col[$cf[$a]]['cf_pack']).'" />';
	if(!($col[$cf[$a]]['cf_type'])
		OR $col[$cf[$a]]['cf_type']=='none'
		OR $col[$cf[$a]]['cf_type']=='text'
		OR $col[$cf[$a]]['cf_type']=='pass'
		OR $col[$cf[$a]]['cf_type']=='mail'
		OR $col[$cf[$a]]['cf_type']=='number') {
		echo'
							<input type="text" id="cf_value_'.($col[$cf[$a]]['cf_id']).'" name="cf_value['.($col[$cf[$a]]['cf_id']).']" value="'.($col[$cf[$a]]['cf_value']).'"  class="'.($type).'" minlength="'.(($_set[0])?($_set[0]):(0)).'" maxlength="'.(($_set[1])?($_set[1]):(250)).'" />';
	} else if($col[$cf[$a]]['cf_type']=='select') {
		echo'
							<select id="cf_value_'.($col[$cf[$a]]['cf_id']).'" name="cf_value['.($col[$cf[$a]]['cf_id']).']">
								<option value=""> ---- </option>';
		for($b=0;$b<count($_set);$b++) {
			echo'
								<option value="'.($_set[$b]).'"'.(($_set[$b]==$col[$cf[$a]]['cf_value'])?(' SELECTED'):('')).'>'.($_set[$b]).'</option>';
		}
		echo'
							</select>';
	}
	echo'
						</td>
					</tr>';
}
echo'
					<tr><td colspan="2" align="center"><input class="admin_btn" name="smbt" type="submit" value="{modosit}" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></td></tr>
				</tbody>
			</table>
		</form>';
?>