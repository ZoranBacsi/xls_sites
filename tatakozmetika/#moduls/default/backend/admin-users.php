<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

//Delete
if($hmode=='del' AND is_numeric($aid) AND $_ENV['USER']['u_id']!=$aid AND !($_ENV['USER']['u_guest'])) {
	if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `admin_users` WHERE `u_id`="'.($aid).'" AND `u_id`!="'.($_ENV['USER']['u_id']).'" LIMIT 1')) {
		echo'<script type="text/javascript">AddAlert("ok","Admin felhasználó törölve!");</script>';
	} else {
		echo'<script type="text/javascript">AddAlert("no","Admin felhasználó törölése sikertelen!");</script>';
	}
}
if(!$xmode) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `admin_users` '.(($_ENV['USER']['u_sys'])?(''):('WHERE `u_sys`="0"')).' ORDER BY `u_nev`');
	$_ENV['SITE']['admin_felhasznalok_num'] = mysqli_num_rows($con);
	echo'
			<h1 class="cim">{admin_felhasznalok_num}</h1>
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'&amp;xmode=new">{af_uj_felhasznalo}</a><br/><br/>
			<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
				<tbody>
					<tr class="fejlec">
						<th width="25">#</th>
						<th width="40">St.</th>
						<th>{af_nev}</th>
						<th>{af_user}</th>
						<th>{af_email}</th>
						<th class="admin_btn">{modosit}</th>
						<th class="admin_btn">{torol}</th>
					</tr>';
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $i++;
		echo'
					<tr>
						<td>'.($i).'.</td>
						<td>'.(($sor['u_status']=='A')?('<font color="#0000CC">{aktiv}</font>'):('<font color="#CC0000">{inaktiv}</font>')).'</td>
						<td>'.($sor['u_nev']).'</td>
						<td>'.($sor['u_user']).'</td>
						<td>'.($sor['u_mail']).'</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="xmode" value="mod"/>
								<input type="hidden" name="aid" value="'.($sor['u_id']).'"/>
								<input class="admin_btn" type="submit" value="{modosit}"/>
							</form>
						</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="hmode" value="del"/>
								<input type="hidden" name="aid" value="'.($sor['u_id']).'"/>
								<input class="admin_btn" type="submit" value="{torol}" '.(($sor['u_id']==$_ENV['USER']['u_sys'])?('onclick="return false;"'):('onclick="if(strtoupper(prompt(\'{af_torol_confirm}\'))==\'OK\') { return true; } else { return false; }"')).' />
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
		if($aid>0) {
			if(mysqli_query($_ENV['MYSQLI'],'UPDATE `admin_users` SET `u_admin`="'.(in_text($u_admin)).'", `u_nev`="'.(in_text($u_nev)).'", `u_user`="'.(in_text($u_user)).'", '.((strlen($u_pass)>0 AND $u_pass==$u_repass)?('`u_pass`="'.(md5(in_text($u_pass))).'", '):('')).'`u_mail`="'.(in_text($u_mail)).'" '.(($_ENV['USER']['u_id']!=$aid)?(', `u_status`="'.(in_text($u_status)).'", `u_sys`="'.(in_text($u_sys)).'" '):('')).'WHERE `u_id`="'.($aid).'" LIMIT 1')) {
				echo'<script type="text/javascript">AddAlert("ok","Felhasználó adatai módosítva!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Felhasználó módosítása sikertelen!");</script>';
			}
		} else {
			mysqli_query($_ENV['MYSQLI'],'INSERT INTO `admin_users` ( `u_admin`, `u_nev`, `u_user`, `u_pass`, `u_mail`, `u_status`, `u_sys` ) VALUES ( "'.(in_text($u_admin)).'", "'.(in_text($u_nev)).'", "'.(in_text($u_user)).'", "'.(in_text(md5($u_pass))).'", "'.(in_text($u_mail)).'", "'.(in_text($u_status)).'", "'.(in_text($u_sys)).'" )');
			$aid = mysqli_insert_id($_ENV['MYSQLI']);
			if($aid) {
				echo'<script type="text/javascript">AddAlert("ok","Új felhasználó sikeresen rögzítve!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Új felhasználó rögzítése seikrtelen!");</script>';
			}
		}
	}
	if($aid>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `admin_users` WHERE `u_id`="'.($aid).'" ORDER BY `u_nev`');
		$sor=mysqli_fetch_array($con,MYSQLI_ASSOC); unSet($con);
		echo'
			<h1 class="cim">'.($sor['u_nev']).' {af_user_szerkeszt}!</h1>';
	} else {
		echo'
			<h1 class="cim">{af_user_felvisz}!</h1>';
	}
	echo'
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'">&#171;{vissza}</a><br/><br/>
			<form action="?oldal='.($oldal).'" method="POST" name="iForm" id="iForm" onsubmit="return FormControl(1);">
				<input class="admin_btn save_btn" name="smbt" type="submit" value="'.(($aid>0)?('{modosit}'):('{felvisz}')).'" onclick="$(\'#MyBody\').attr(\'edited\',null);" />
				<input type="hidden" name="rogzit" value="1" />
				<input type="hidden" name="mode" value="'.($mode).'"/>
				<input type="hidden" name="xmode" value="'.($xmode).'">
				<input type="hidden" name="aid" value="'.($aid).'">
				<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
					<tbody>
						<tr class="fejlec"> <th colspan="2"> {af_user_szerkesztese} </th> </tr>
						<tr>
							<td class="cimke"><label for="u_nev"><b>{af_nev}:</b></label></td>
							<td>
								<input type="text" id="u_nev" name="u_nev" value="'.($sor['u_nev']).'" class="typeText required" minlength="3" maxlength="32" />
							</td>
						</tr>
						<tr>
							<td><label for="u_user"><b>{af_felhasznalonev}:</b></label></td>
							<td>
								<input type="text" id="u_user" name="u_user" value="'.($sor['u_user']).'" class="typeUser required" minlength="3" maxlength="32"
							onkeyup="InputControl(this,0,\'user\',2,32,false,false,\'users\',\'u_\',\'user\','.(($aid>0)?($aid):(0)).')"/>
								<div class="helpBox">{af_felhasznalonev_info}</div>
							</td>
						</tr>
						<tr>
							<td><label for="u_pass"><b>{af_jelszo}:</b></label></td>
							<td>
								<input type="password" id="u_pass" name="u_pass" value="" class="typePass '.(($aid>0)?(''):('required')).'" minlength="3" maxlength="32" />
								<div class="helpBox">{af_jelszo_info}</div>
							</td>
						</tr>
						<tr>
							<td><label for="u_repass"><b>{af_jelszo_ujra}:</b></label></td>
							<td>
								<input type="password" id="u_repass" name="u_repass" value="" class="typePass '.(($aid>0)?(''):('required')).'" minlength="3" maxlength="32" />
								<div class="helpBox">{af_jelszo_ujra_info}</div>
							</td>
						</tr>
						<tr>
							<td><label for="u_mail"><b>{af_email}:</b></label></td>
							<td>
								<input type="text" id="u_mail" name="u_mail" value="'.($sor['u_mail']).'" class="typeEmail required" minlength="6" maxlength="64" />
								<!--div class="helpBox">{af_email_info}</div-->
							</td>
						</tr>
						<tr>
							<td><label for="u_status"><b>{status}:</b></label></td>
							<td>
								<select id="u_status" name="u_status"'.(($_ENV['USER']['u_id']==$aid)?(' DISABLED'):('')).'>
									<option value="A"'.(($sor['u_status']=='A')?(' SELECTED'):('')).'>{aktiv}</option>
									<option value="I"'.(($sor['u_status']=='I')?(' SELECTED'):('')).'>{inaktiv}</option>
								</select>
								<!--div class="helpBox">{af_status_info}</div-->
							</td>
						</tr>
						<tr style="display:none;">
							<td>&nbsp;</td>
							<td>
								<input class="checkbox" type="checkbox" name="u_admin" value="1"'.(($sor['u_admin'])?(' checked'):(' checked')).' '.(($aid==$_ENV['USER']['u_id'])?('readonly'):('')).' /> <label for="u_admin"><b>{af_superadmin}</b></label>
								<div class="helpBox">{af_superadmin_info}</div>
							</td>
						</tr>
					'.(($_ENV['USER']['u_sys'])?('
						<tr>
							<td>&nbsp;</td>
							<td>
								<input class="checkbox" type="checkbox" name="u_sys" value="1"'.(($sor['u_sys'])?(' checked'):('')).' '.(($aid==$_ENV['USER']['u_id'])?('readonly'):('')).' /> <label for="u_sys"><b>{af_sysadmin}</b></label>
								<div class="helpBox">{af_sysadmin_info}</div>
							</td>
						</tr>'):('')).'
						<input type="hidden" name="u_sys" value="'.($sor['u_sys']).'">
						<tr class="fejlec"><td colspan="2" align="center"><input class="admin_btn" name="smbt" type="submit" value="'.(($aid>0)?('{modosit}'):('{felvisz}')).'" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></td></tr>
					</tbody>
				</table>
			</form>
			<script type="text/javascript">
				function FormControl(xa) {
					var hibastr="";
					var eNev = InputControl($("#u_nev",$("#iForm")));
					var eUser = InputControl($("#u_user",$("#iForm")));
					var ePass = InputControl($("#u_pass",$("#iForm")));
					var eRePass = InputControl($("#u_repass",$("#iForm")));
					var eMail = InputControl($("#u_mail",$("#iForm")));
					if(!eNev) { hibastr +="\n{af_nev_hiba}"; }
					if(!eUser) { hibastr +="\n{af_felhasznalonev_hiba}"; }
					if(!ePass) { hibastr +="\n{af_jelszo_hiba}!"; }
					if(!eRePass) { hibastr +="\n{af_jelszo_ujra_hiba}"; }
					if(!eRePass) { hibastr +="\n{af_jelszo_ujra_hiba}"; }
					else if($("#u_pass",$("#iForm")).val()!=$("#u_repass",$("#iForm")).val()) { hibastr +="\n{af_jelszo_ujra_hiba}"; }
					if(xa>0) {
						if(hibastr!="") {
							AddAlert("alert","{formhibak}:"+hibastr);
							return false;
						} else { $("#MyBody").attr("edited",null); return true; }
					} else { return false; }
				}
			</script>';
	unSet($sor); unSet($con);
}
?>