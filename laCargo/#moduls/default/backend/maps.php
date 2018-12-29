<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
if($hmode=='del' AND is_numeric($mapid) AND !($_ENV['USER']['u_guest'])) {
	if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `maps` WHERE `map_id`="'.($mapid).'" LIMIT 1')) {
		echo'<script type="text/javascript">AddAlert("ok","Térkép törölve!");</script>';
	} else {
		echo'<script type="text/javascript">AddAlert("no","Térkép törlése sikertelen!");</script>';
	}
}
if(!$xmode) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `maps` ORDER BY `map_cimke` LIMIT 100');
	$_ENV['SITE']['maps_terkep_num'] = mysqli_num_rows($con);
	echo'
			<h1 class="cim">{maps_terkep_num}</h1>
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'&amp;xmode=new">{maps_uj_terkep}</a><br/><br/>
			<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
				<tbody>
					<tr class="fejlec">
						<th width="25">#</th>
						<th>{cimke}</th>
						<th class="admin_btn">{modosit}</th>
						<th class="admin_btn">{torol}</th>
					</tr>';
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $i++;
		echo'
					<tr>
						<td>'.($i).'.</td>
						<td>'.($sor['map_cimke']).'</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="xmode" value="mod"/>
								<input type="hidden" name="mapid" value="'.($sor['map_id']).'"/>
								<input class="admin_btn" type="submit" value="{modosit}"/>
							</form>
						</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="hmode" value="del"/>
								<input type="hidden" name="mapid" value="'.($sor['map_id']).'"/>
								<input class="admin_btn" type="submit" value="{torol}" onclick="if(confirm(\'{maps_torol_confirm}\')) { return true; } else { return false; }" />
							</form>
						</td>
					</tr>';
	}
	echo'
				</tbody>
			</table>';
	unSet($i); unSet($sor); unSet($con);
} elseif($xmode=='mod' OR $xmode=='new') {
	if($rogzit AND !($_ENV['USER']['u_guest'])) {
		if($mapid>0) {
			if(mysqli_query($_ENV['MYSQLI'],'
				UPDATE `maps`
				SET
					`map_cimke`="'.(in_text($map_cimke)).'",
					`map_lati`="'.(in_text($map_lati)).'",
					`map_longi`="'.(in_text($map_longi)).'",
					`map_irsz`="'.(in_text($map_irsz)).'",
					`map_varos`="'.(in_text($map_varos)).'",
					`map_utca`="'.(in_text($map_utca)).'",
					`map_tel`="'.(in_text($map_tel)).'",
					`map_fax`="'.(in_text($map_fax)).'",
					`map_email`="'.(in_text($map_email)).'",
					`map_web`="'.(in_text($map_web)).'",
					`map_text`="'.(in_text($map_text)).'"
				WHERE `map_id`="'.($mapid).'"
				LIMIT 1')) {
				echo'<script type="text/javascript">AddAlert("ok","Térkép módosítva!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Térkép módosítása sikertelen!");</script>';
			}
		} else {
			mysqli_query($_ENV['MYSQLI'],'
				INSERT INTO `maps`
					( `map_cimke`, `map_lati`, `map_longi`, `map_irsz`, `map_varos`, `map_utca`, `map_tel`, `map_fax`, `map_email`, `map_web`, `map_text` )
				VALUES
					( "'.(in_text($map_cimke)).'", "'.(in_text($map_lati)).'", "'.(in_text($map_longi)).'", "'.(in_text($map_irsz)).'", "'.(in_text($map_varos)).'", "'.(in_text($map_utca)).'", "'.(in_text($map_tel)).'", "'.(in_text($map_fax)).'", "'.(in_text($map_email)).'", "'.(in_text($map_web)).'", "'.(in_text($map_text)).'" )');
			$mapid = mysqli_insert_id($_ENV['MYSQLI']);
			if($mapid) {
				echo'<script type="text/javascript">AddAlert("ok","Térkép felvíve!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Térkép felvitele sikertelen!");</script>';
			}
		}
	}
	if($mapid>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `maps` WHERE `map_id`="'.($mapid).'" ORDER BY `map_cimke`');
		$sor=mysqli_fetch_array($con,MYSQLI_ASSOC); unSet($con);
		echo'
			<h1 class="cim">"'.($sor['map_cimke']).'" {maps_szerkesztese}</h1>';
	} else {
		$sor = $_POST;
		echo'
			<h1 class="cim">{maps_uj_terkep_szerkesztese}</h1>';
	}
	echo'
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'">&#171;{vissza}</a><br/><br/>
			<form action="#" onsubmit="showAddress(this.address.value); return false">
				<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
					<tbody>
						<tr class="fejlec">
							<th>
								<label for="address">{maps_cim_keres}:</label>
								<input type="text" size="60" id="address" name="address" value="" placeholder="{maps_cim_keres_title}" />
								<input class="admin_btn" type="submit" value="{maps_cim_keres_btn} &#187;" />
							</th>
						</tr>
						<tr> <td><div id="gmap" style="width: 100%; height: 400px;"></div></td> </tr>
					</tbody>
				</table>
			</form>
			<br/><br/>
			<form action="?oldal='.($oldal).'" method="POST" name="iForm" onsubmit="return FormControl(1);">
				<input class="admin_btn save_btn" name="smbt" type="submit" value="'.(($mapid>0)?('{modosit}'):('{felvisz}')).'" style="margin-top:-535px;" onclick="$(\'#MyBody\').attr(\'edited\',null);" />
				<input type="hidden" name="rogzit" value="1" />
				<input type="hidden" name="mode" value="'.($mode).'" />
				<input type="hidden" name="xmode" value="'.($xmode).'" />
				<input type="hidden" name="mapid" value="'.($mapid).'" />
				<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
					<tbody>
						<tr class="fejlec"> <th colspan="2"> {maps_terkep_adatai} </th> </tr>
						<tr>
							<td class="cimke"><label for="address"><b>{maps_pozicio}:</b></label></td>
							<td>
								<input type="text" name="map_lati" readonly="readonly" id="lati" style="width:192px;" value="'.(($sor['map_lati'])?($sor['map_lati']):('47.497912')).'" class="typeNumber required" minlength="3" maxlength="32" />,
								<input type="text" name="map_longi" readonly="readonly" id="longi" style="width:191px;" value="'.(($sor['map_longi'])?($sor['map_longi']):('19.040235')).'" class="typeNumber required" minlength="3" maxlength="32" />
							</td>
						</tr>
						<tr>
							<td class="cimke"><label for="irsz"><b>{maps_cim}:</b></label></td>
							<td>
								<input type="text" name="map_irsz" id="irsz" value="'.($sor['map_irsz']).'" style="width:65px;" class="typeText" minlength="3" maxlength="6" />
								<input type="text" name="map_varos" id="varos" value="'.($sor['map_varos']).'" style="width:155px;" class="typeText" minlength="3" maxlength="64" />
								<input type="text" name="map_utca" id="utca" value="'.($sor['map_utca']).'" style="width:155px;" class="typeText" minlength="3" maxlength="128" />
							</td>
						</tr>
						<tr>
							<td class="cimke"><label for="map_cimke"><b>{cimke}:</b></label></td>
							<td> <input type="text" name="map_cimke" id="map_cimke" value="'.($sor['map_cimke']).'"  class="typeText required" minlength="3" maxlength="128" title="Térkép megnvezése" /> </td>
						</tr>
						<tr>
							<td class="cimke"><b><label for="map_tel">{tel}</label>, <label for="map_fax">{fax}</label>:</b></td>
							<td>
								<input type="text" name="map_tel" id="map_tel" value="'.($sor['map_tel']).'" style="width:192px;" class="typeText" minlength="3" maxlength="32" title="3612345678" />,
								<input type="text" name="map_fax" id="map_fax" value="'.($sor['map_fax']).'" style="width:191px;"  class="typeText" minlength="3" maxlength="32" title="3612345678" />
							</td>
						</tr>
						<tr>
							<td class="cimke"><b><label for="map_email">{email}</label>, <label for="map_web">{web}</label>:</b></td>
							<td>
								<input type="text" name="map_email" id="map_email" value="'.($sor['map_email']).'" style="width:192px;" class="typeEmail" minlength="3" maxlength="64" title="info@domain.hu" />,
								<input type="text" name="map_web" id="map_web" value="'.($sor['map_web']).'" style="width:191px;" class="typeText" minlength="3" maxlength="64" title="www.domain.hu" />
							</td>
						</tr>
						<tr class="fejlec"><td colspan="2" align="center"><input class="admin_btn" name="smbt" type="submit" value="'.(($mapid>0)?('{modosit}'):('{felvisz}')).'" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></td></tr>
					</tbody>
				</table>
			</form>
			<script type="text/javascript">
				function FormControl(cont) {
					var hibastr="";

					var eCimke = InputControl($("#map_cimke",$("#iForm")));
					var eTel = InputControl($("#map_tel",$("#iForm")));
					var eFax = InputControl($("#map_fax",$("#iForm")));
					var eEmail = InputControl($("#map_email",$("#iForm")));
					var eWeb = InputControl($("#map_web",$("#iForm")));
					var eLati = InputControl($("#lati",$("#iForm")));
					var eLongi = InputControl($("#longi",$("#iForm")));
					var eIrsz = InputControl($("#irsz",$("#iForm")));
					var eVaros = InputControl($("#varos",$("#iForm")));
					var eUtca = InputControl($("#utca",$("#iForm")));

					if(cont>0) {
						if(hibastr!="") {
							AddAlert("alert","{formhibak}:"+hibastr);
							return false;
						} else { $("#MyBody").attr("edited",null); return true; }
					} else { return false; }

				}
				setTimeout(function() { FormControl(0); }, 100);
				setTimeout(function() { load(); },100);
			</script>';
}
?>