<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('hirek/backend',false);
$_ENV['MODS']['PURL'] = rPath('hirek/backend',true);

if($_REQUEST['xMode'] == 'hirEdit') {
	/* Hír felvitel/móosítása */
	if($_REQUEST['rogzit']>0) {
		if($_REQUEST['hirid']>0) {
			mysqli_query($_ENV['MYSQLI'],'
				UPDATE `hirek` SET
					`hir_nev`="'.(in_text($_REQUEST['hir_nev'])).'",
					`hir_h1`="'.(in_text($_REQUEST['hir_h1'])).'",
					`hir_title`="'.(in_text($_REQUEST['hir_title'])).'",
					`hir_keyw`="'.(in_text($_REQUEST['hir_keyw'])).'",
					`hir_desc`="'.(in_text($_REQUEST['hir_desc'])).'",
					`hir_status`="'.(in_text($_REQUEST['hir_status'])).'",
					`hir_lang`="'.strtoupper(in_text($_REQUEST['hir_lang'])).'",
					`hir_reurl`="'.(in_text($_REQUEST['hir_reurl'])).'",
					`hir_rovidleiras`="'.(in_html($_REQUEST['hir_rovidleiras'])).'",
					`hir_leiras`="'.(in_html($_REQUEST['hir_leiras'])).'",
					`hir_date`="'.(in_text($_REQUEST['hir_date'])).'"
				WHERE `hir_id`="'.($_REQUEST['hirid']).'" LIMIT 1');
		} else {
			$con=mysqli_query($_ENV['MYSQLI'],'SELECT count(*) as max FROM `hirek` WHERE `hir_lang`="'.strtoupper($_REQUEST['hir_lang']).'"');
			$sor=mysqli_fetch_array($con,MYSQLI_ASSOC); $_REQUEST['hir_sorszam'] = ($sor['max'] + 1);
			unSet($sor); unSet($con);
			mysqli_query($_ENV['MYSQLI'],'
				INSERT INTO `hirek`
					( `hir_sorszam`, `hir_nev`, `hir_h1`, `hir_title`, `hir_keyw`, `hir_desc`, `hir_status`, `hir_lang`, `hir_reurl`, `hir_rovidleiras`, `hir_leiras`, `hir_date` )
				VALUES
					(
						"'.(in_text($_REQUEST['hir_sorszam'])).'",
						"'.(in_text($_REQUEST['hir_nev'])).'",
						"'.(in_text($_REQUEST['hir_h1'])).'",
						"'.(in_text($_REQUEST['hir_title'])).'",
						"'.(in_text($_REQUEST['hir_keyw'])).'",
						"'.(in_text($_REQUEST['hir_desc'])).'",
						"'.(in_text($_REQUEST['hir_status'])).'",
						"'.strtoupper(in_text($_REQUEST['hir_lang'])).'",
						"'.(in_text($_REQUEST['hir_reurl'])).'",
						"'.(in_html($_REQUEST['hir_rovidleiras'])).'",
						"'.(in_html($_REQUEST['hir_leiras'])).'",
						now()
					)');
			$_REQUEST['hirid'] = mysqli_insert_id($_ENV['MYSQLI']);
		}
		if($_REQUEST['hirid']>0) {
			$con = mysqli_query($_ENV['MYSQLI'],'SELECT `ru_id` FROM `reurl` WHERE `ru_modul`="'.($_ENV['SITE']['MODUL']).'" AND `ru_elem_id`="hir_{'.($_REQUEST['hirid']).'}" LIMIT 1');
			if(mysqli_num_rows($con)>0) {
				if(mysqli_query($_ENV['MYSQLI'],'
					UPDATE `reurl`
					SET
						`ru_index`="I",
						`ru_reurl`="'.(in_text($_REQUEST['hir_reurl'])).'",
						`ru_h1`="'.(in_text($_REQUEST['hir_h1'])).'",
						`ru_title`="'.(in_text($_REQUEST['hir_title'])).'",
						`ru_keyw`="'.(in_text($_REQUEST['hir_keyw'])).'",
						`ru_desc`="'.(in_text($_REQUEST['hir_desc'])).'",
						`ru_date`=now()
					WHERE `ru_modul`="'.($_ENV['SITE']['MODUL']).'"
						AND `ru_elem_id`="hir_{'.($_REQUEST['hirid']).'}"
					LIMIT 1')) {
						echo'<script type="text/javascript">AddAlert("ok","Hír sikeresen módosítva!");</script>';
					} else {
						echo'<script type="text/javascript">AddAlert("no","Hír módosítása sikertelen!");</script>';
					}
			} else {
				mysqli_query($_ENV['MYSQLI'],'
					INSERT INTO `reurl`
						( `ru_modul`, `ru_elem_id`, `ru_reurl`, `ru_index`, `ru_h1`, `ru_title`, `ru_keyw`, `ru_desc`, `ru_date` )
					VALUES
					(
						"'.($_ENV['SITE']['MODUL']).'",
						"hir_{'.($_REQUEST['hirid']).'}",
						"'.(in_text($_REQUEST['hir_reurl'])).'",
						"I",
						"'.(in_text($_REQUEST['hir_h1'])).'",
						"'.(in_text($_REQUEST['hir_title'])).'",
						"'.(in_text($_REQUEST['hir_keyw'])).'",
						"'.(in_text($_REQUEST['hir_desc'])).'",
						now()
					)');
				if($_REQUEST['hirid']>0) {
					echo'<script type="text/javascript">AddAlert("ok","Hír sikeresen létrehozva!");</script>';
				} else {
					echo'<script type="text/javascript">AddAlert("no","Hír létrehozása meghiúsult!");</script>';
				}
			}
		}
	}

	/* Adatok kiolvasása */
	if($_REQUEST['hirid']>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` WHERE `hir_id`="'.($_REQUEST['hirid']).'" LIMIT 1');
		$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
	} else { $sor = $_REQUEST; }

	if($sor['hir_date']) {
		$date = explode(' ',$sor['hir_date']);
	} else {
		$date = Array(date('Y-m-d'),date('H:i:s'));
	}
	echo'
				<h1>'.(($_REQUEST['hirid']>0)?('{hir_szerkesztese}'):('{hir_uj_keszitese}')).'</h1>
				<a class="new_link" href="?oldal='.($_REQUEST['oldal']).'">&#171; {vissza}</a><br/><br/>
				<form action="?oldal='.($_REQUEST['oldal']).'" method="post" name="iForm" id="iForm" onsubmit="return FormControl(1);" ENCTYPE="multipart/form-data">
					<div style="text-align:right;"><input class="admin_btn save_btn" name="smbt" type="submit" value="'.(($_REQUEST['hirid']>0)?('{modosit}'):('{felvisz}')).'" style="float:none;margin: -25px 0px 10px;" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></div>
					<div>
						<input type="hidden" name="rogzit" value="1" />
						<input type="hidden" name="hirid" value="'.($_REQUEST['hirid']).'" />
						<input type="hidden" name="xMode" value="'.($_REQUEST['xMode']).'" />
						<input type="hidden" id="FixReurl" value="'.(($_REQUEST['hirid']>0)?(1):(0)).'"/>
						<table class="table" width="100%" cellspacing="0" cellpadding="3" align="center" border="0">
							<tbody>
								<tr class="fejlec">
									<th colspan="2">'.(($_REQUEST['hirid'])?('"'.($sor['hir_nev']).'" {hir_szerkesztese}'):('{hir_uj_keszitese}')).'</th>
								</tr>

								<tr>
									<td><label for="hir_nev"><b>{hir_neve}:</b></label></td>
									<td>
										<input type="text" id="hir_nev" name="hir_nev" value="'.($sor['hir_nev']).'" class="typeText required" minlength="3" maxlength="128" copyReurl="hir_reurl" />
										<div class="helpBox">{hir_neve_info}</div>
									</td>
								</tr>

								<tr>
									<td class="cimke"><label for="hir_reurl"><b>{rovid_url}:</b></label></td>
									<td>
										<input type="text" id="hir_reurl" name="hir_reurl" value="'.($sor['hir_reurl']).'" class="typeReURL required" minlength="3" maxlength="255" reurl="hirek,'.(($_REQUEST['hirid']>0)?($_REQUEST['hirid']):(0)).',0" />
										<div class="helpBox">{rovid_url_info}</div>
									</td>
								</tr>

								<tr>
									<td class="cimke"><label for="hir_h1"><b>{h1}</b></label></td>
									<td>
										<input type="text" id="hir_h1" name="hir_h1" value="'.($sor['hir_h1']).'" class="typeText" minlength="3" maxlength="255" />
										<div class="helpBox">{h1_info}</div>
									</td>
								</tr>

								<tr>
									<td class="cimke"><label for="hir_title"><b>{title}</b></label></td>
									<td>
										<input type="text" id="hir_title" name="hir_title" value="'.($sor['hir_title']).'" class="typeText" minlength="3" maxlength="255" />
										<div class="helpBox">{title_info}</div>
									</td>
								</tr>

								<tr>
									<td class="cimke"><label for="hir_keyw"><b>{keywords}:</b></label></td>
									<td>
										<input type="text" id="hir_keyw" name="hir_keyw" value="'.($sor['hir_keyw']).'" class="typeText" minlength="3" maxlength="255" />
										<div class="helpBox">{keywords_info}</div>
									</td>
								</tr>

								<tr>
									<td class="cimke"><label for="hir_desc"><b>{description}:</b></label></td>
									<td>
										<input type="text" id="hir_desc" name="hir_desc" value="'.($sor['hir_desc']).'"  class="typeText" minlength="3" maxlength="255" />
										<div class="helpBox">{description_info}</div>
									</td>
								</tr>

								<tr>
									<td class="cimke"><label for="hir_date"><b>{hir_date}:</b></label></td>
									<td>
										<input type="text" id="hir_date" name="hir_date" value="'.($date[0].' '.$date[1]).'" size="19" maxlength="19" style="width:120px;" />
									</td>
								</tr>

								<tr>
									<td><label for="hir_status"><b>{statusz}:</b></label></td>
									<td>
										<select id="hir_status" name="hir_status">
											<option '.(($sor['hir_status']=='A')?('selected'):('')).' value="A">{aktiv}</option>
											<option '.(($sor['hir_status']=='I')?('selected'):('')).' value="I">{inaktiv}</option>
										</select>
									</td>
								</tr>

		'.(($_ENV['CONF']['hirRovidHir'])?('
								<tr>
									<td colspan="2">
										<b>{hir_rovid_text}:</b>
										'.(HTML_TEXTAREA('hir_rovidleiras',false,'hirek')).'
										<div class="helpBox">{hir_rovid_text_info}</div><br/>
										<textarea class="hir_rovidleiras" id="hir_rovidleiras" name="hir_rovidleiras" style="width:990px; height:450px;">'.($sor['hir_rovidleiras']).'</textarea>
									</td>
								</tr>
		'):('')).'

								<tr>
									<td colspan="2">
										<b>{hir_full_text}:</b>
										'.(htmlTextaInsert('hir_leiras')).'
										'.(HTML_TEXTAREA('hir_leiras',false,'hirek')).'
										<div class="helpBox">{hir_full_text_info}</div><br/>
										<textarea class="hir_leiras" id="hir_leiras" name="hir_leiras" style="width:990px; height:450px;">'.($sor['hir_leiras']).'</textarea>
									</td>
								</tr>

								<tr class="fejlec">
										<th colspan="2"><input class="admin_btn" type="submit" value="'.(($_REQUEST['hirid']>0)?('{modosit}'):('{felvisz}')).'!" /></th>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			<script type="text/javascript">
				function FormControl(xa) {
					var hibastr="";

					var eNev = InputControl($("#hir_nev",$("#iForm")));
					var eReurl = InputControl($("#hir_reurl",$("#iForm")),true);
					var eDate = InputControl($("#hir_date",$("#iForm")));
					var eH1 = InputControl($("#hir_h1",$("#iForm")));
					var eTitle = InputControl($("#hir_title",$("#iForm")));
					var eKeyw = InputControl($("#hir_keyw",$("#iForm")));
					var eDesc = InputControl($("#hir_desc",$("#iForm")));

					if(!eNev) { hibastr +="\n{hir_neve_error}"; }
					if(!eReurl) { hibastr +="\n{rovid_url_error}"; }
					if(!eDate) { hibastr +="\n{hir_date_error}"; }
					if(!eH1) { hibastr +="\n{h1_error}"; }
					if(!eTitle) { hibastr +="\n{title_error}"; }
					if(!eKeyw) { hibastr +="\n{keywords_error}"; }
					if(!eDesc) { hibastr +="\n{description_error}"; }

					if(xa>0) {
						if(hibastr!="") {
							AddAlert("alert","{formhibak}:"+hibastr);
							//alert("Hibák:"+hibastr);
							return false;
						} else { $("#MyBody").attr("edited",null); return true; }
					} else { return false; }
				}
				setTimeout("FormControl(0);", 100);
			</script>';

} else {
	/* Hírek listázása */
	if($_REQUEST['hMode']=='hirDelete' AND $_REQUEST['hirid']>0) {
		if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `hirek` WHERE `hir_id`="'.($_REQUEST['hirid']).'"')) {
			mysqli_query($_ENV['MYSQLI'],'DELETE FROM `reurl` WHERE `ru_modul`="'.($_ENV['SITE']['MODUL']).'" AND `ru_elem_id`="hir_{'.($_REQUEST['hirid']).'}"');
			echo'<script type="text/javascript">AddAlert("ok","Hír törölve!");</script>';
		} else {
			echo'<script type="text/javascript">AddAlert("no","Hír törölése sikertelen!");</script>';
		}
	}

	/* Hírek listázása */
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` ORDER BY `hir_date` DESC LIMIT 100'); $i=0;
	$hirdb = mysqli_num_rows($con);
	echo'
				<h1>{hir_hirek_cim}</h1>
				<a class="new_link" href="?oldal='.($_REQUEST['oldal']).'&xMode=hirEdit">{hir_uj_hir}...</a><br/><br/>
				<form action="?oldal='.($_REQUEST['oldal']).'" onsubmit="return noAlert();" method="post" name="kategoriak" id="kategoriak">
					<div>
						<table width="100%" cellspacing="0" cellpadding="3" border="0" align="center" class="table">
							<tbody>
								<tr class="fejlec">
									<th class="urlap_ids">#</th>
									<th class="urlap_status">St.</th>
									<th>{cim}</th>
									<th>URL</th>
									<th class="urlap_button">{modosit}</th>
									<th class="urlap_button">{torol}</th>
								</tr>';
	while($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) { $i++;
		echo'
								<tr>
									<td>'.($sor['hir_id']).'.</td>
									<td width="70">'.(($sor['hir_status']=='A')?('<font color="#0000CC">{aktiv}</font>'):('<font color="#CC0000">{inaktiv}</font>')).'</td>
									<td>'.($sor['hir_nev']).'</td>
									<td>/hirek/'.($sor['hir_reurl']).'.html</td>
									<td width="80">
										<input class="admin_btn" type="button" value="{modosit}"
											onClick="location.href=\'?oldal='.($_REQUEST['oldal']).'&hirid='.($sor['hir_id']).'&xMode=hirEdit\';" />
									</td>
									<td width="80">
										<input class="admin_btn" type="button" value="{torol}"
											onClick="
												if(confirm(\'{hir_torol_confirm}\')) {
													location.href=\'?oldal='.($_REQUEST['oldal']).'&hirid='.($sor['hir_id']).'&hMode=hirDelete\';
												} else { return false; }
											" />
									</td>
								</tr>';
	}
	echo'
							</tbody>
						</table>
					</div>
				</form>';
}


?>