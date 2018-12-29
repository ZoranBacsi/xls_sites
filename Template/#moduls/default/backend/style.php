<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
if($hmode=='del' AND is_numeric($sid) AND !($_ENV['USER']['u_guest'])) {
	if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `styles` WHERE `s_id`="'.($sid).'" LIMIT 1')) {
		echo'<script type="text/javascript">AddAlert("ok","Stílus törölve!");</script>';
	} else {
		echo'<script type="text/javascript">AddAlert("no","Stílus törlése sikertelen!");</script>';
	}
}
if(!$xmode) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `styles` ORDER BY `s_nev` LIMIT 100');
	$_ENV['SITE']['style_cim_num'] = mysqli_num_rows($con);
	echo'
			<h1 class="cim">{style_cim_num}</h1>
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'&amp;xmode=new">{style_uj_stilus}</a><br/><br/>
			<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
				<tbody>
					<tr class="fejlec">
						<th width="25">#</th>
						<th>{style_neve}</th>
						<th>{style_code}</th>
						<th class="admin_btn">{modosit}</th>
						<th class="admin_btn">{torol}</th>
					</tr>';
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $i++;
		echo'
					<tr>
						<td>'.($i).'.</td>
						<td>'.($sor['s_nev']).'</td>
						<td>'.($sor['s_code']).'</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="xmode" value="mod"/>
								<input type="hidden" name="sid" value="'.($sor['s_id']).'"/>
								<input class="admin_btn" type="submit" value="{modosit}"/>
							</form>
						</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="hmode" value="del"/>
								<input type="hidden" name="sid" value="'.($sor['s_id']).'"/>
								<input class="admin_btn" type="submit" value="{torol}" onclick="if(confirm(\'{style_torol_confirm}\')) { return true; } else { return false; }" />
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
		$s_code = str_replace(' ','',ucwords(str_replace(Array('.','-','+','_','   ','  '),' ',utf8urldecode($s_nev))));
		if($sid>0) {
			if(mysqli_query($_ENV['MYSQLI'],'
				UPDATE `styles`
				SET
					`s_nev`="'.(in_text($s_nev)).'",
					`s_code`="'.(in_text($s_code)).'",
					`s_width`="'.(in_text($s_width)).'",
					`s_height`="'.(in_text($s_height)).'",
					`s_padding`="'.(in_text($s_padding)).'",
					`s_bgimgpos`="'.(in_text($s_bgimgpos)).'",
					`s_bgimgrep`="'.(in_text($s_bgimgrep)).'",
					`s_bgcolor`="'.(in_text($s_bgcolor)).'",
					`s_fontfamily`="'.(in_text($s_fontfamily)).'",
					`s_fontsize`="'.(in_text($s_fontsize)).'",
					`s_color`="'.(in_text($s_color)).'",
					`s_style`="'.(in_html($s_style)).'"
				WHERE `s_id`="'.($sid).'"
				LIMIT 1')) {
				echo'<script type="text/javascript">AddAlert("ok","Stílus módosítva!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Stílus módosítása sikertelen!");</script>';
			}
		} else {
			mysqli_query($_ENV['MYSQLI'],'
				INSERT INTO `styles`
					( `s_nev`, `s_code`, `s_width`, `s_height`, `s_padding`, `s_bgimgpos`, `s_bgimgrep`, `s_bgcolor`, `s_fontfamily`, `s_fontsize`, `s_color`, `s_style` )
				VALUES
					( "'.(in_text($s_nev)).'", "'.(in_text($s_code)).'", "'.(in_text($s_width)).'", "'.(in_text($s_height)).'", "'.(in_text($s_padding)).'", "'.(in_text($s_bgimgpos)).'", "'.(in_text($s_bgimgrep)).'", "'.(in_text($s_bgcolor)).'", "'.(in_text($s_fontfamily)).'", "'.(in_text($s_fontsize)).'", "'.(in_text($s_color)).'", "'.(in_html($s_style)).'" )');
			$sid = mysqli_insert_id($_ENV['MYSQLI']);
			if($sid) {
				echo'<script type="text/javascript">AddAlert("ok","Stílus felvíve!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Stílus felvitele sikertelen!");</script>';
			}
		}
		
		$_ENV['CONF']['sysKeprNagyWidth'] = 1920;
		$_ENV['CONF']['sysKeprNagyHeight'] = 1280;
		$_ENV['CONF']['sysKeprKozepesWidth'] = 1200;
		$_ENV['CONF']['sysKeprKozepesHeight'] = 960;
		KepUP::Load('style_{'.($sid).'}');
		
		/* CSS OUT */
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `styles` WHERE `s_code` != "" ORDER BY `s_nev` LIMIT 100');
		if(mysqli_num_rows($con)>0) {
			$css = '/* Készítő: H.Tibor */';
			while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				$css .= "\r\n".'.'.($sor['s_code']).'{';
					if($sor['s_bgcolor']) { $css .= 'background-color:'.$sor['s_bgcolor'].';'; }
					
					$kep_con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="style_{'.($sor['s_id']).'}" LIMIT 1');
					if(mysqli_num_rows($kep_con)) {
						$kep = mysqli_fetch_array($kep_con,MYSQLI_ASSOC);
						$css .= 'background-image:url('.$kep['kep_nagy'].');';
						if($sor['s_bgimgpos']) { $css .= 'background-position:'.$sor['s_bgimgpos'].';'; }
						if($sor['s_bgimgrep']) { $css .= 'background-repeat:'.$sor['s_bgimgrep'].';'; }
					}
					if($sor['s_width']) { $css .= 'width:'.$sor['s_width'].';'; }
					if($sor['s_height']) { $css .= 'min-height:'.$sor['s_height'].';'; }
					if($sor['s_padding']) { $css .= 'padding:'.$sor['s_padding'].';'; }
					if($sor['s_fontfamily']) { $css .= 'font-family:'.$sor['s_fontfamily'].';'; }
					if($sor['s_fontsize']) { $css .= 'font-size:'.$sor['s_fontsize'].';'; }
					if($sor['s_color']) { $css .= 'color:'.$sor['s_color'].';'; }
					if($sor['s_style']) { $css .= $sor['s_style']; }
				$css .= '}';
			}
			fileWrite(rPath('default/frontend',false).'/mystyle.css',$css,false);
		}
	}
	if($sid>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `styles` WHERE `s_id`="'.($sid).'" ORDER BY `s_nev`');
		$sor=mysqli_fetch_array($con,MYSQLI_ASSOC); unSet($con);
		echo'
			<h1 class="cim">"'.($sor['s_nev']).'" {style_szerkesztese}</h1>';
	} else {
		$sor = $_POST;
		echo'
			<h1 class="cim">{style_uj_sitlus_szerkesztese}</h1>';
	}
	echo'
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'">&#171;{vissza}</a><br/><br/>
			<form action="?oldal='.($oldal).'" method="post" name="iForm" id="iForm" onsubmit="return FormControl(1);" ENCTYPE="multipart/form-data">
				<input class="admin_btn save_btn" name="smbt" type="submit" value="'.(($sid>0)?('{modosit}'):('{felvisz}')).'" style="margin-top:-535px;" onclick="$(\'#MyBody\').attr(\'edited\',null);" />
				<input type="hidden" name="rogzit" value="1" />
				<input type="hidden" name="mode" value="'.($mode).'" />
				<input type="hidden" name="xmode" value="'.($xmode).'" />
				<input type="hidden" name="sid" value="'.($sid).'" />
				<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
					<tbody>
						<tr class="fejlec"> <th colspan="2"> {style_stilus_adatai} </th> </tr>
						<tr>
							<td class="cimke"><label for="s_nev"><b>{style_neve}:</b></label></td>
							<td> <input type="text" name="s_nev" id="s_nev" value="'.($sor['s_nev']).'"  class="typeText required" minlength="3" maxlength="128" title="{style_neve_label}" /> </td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_width"><b>{style_width}:</b></label></td>
							<td> <input type="text" name="s_width" id="s_width" value="'.($sor['s_width']).'"  class="typeText" minlength="3" maxlength="8" title="{style_width_label}" /> </td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_height"><b>{style_height}:</b></label></td>
							<td> <input type="text" name="s_height" id="s_height" value="'.($sor['s_height']).'"  class="typeText" minlength="3" maxlength="8" title="{style_height_label}" /> </td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_padding"><b>{style_padding}:</b></label></td>
							<td> <input type="text" name="s_padding" id="s_padding" value="'.($sor['s_padding']).'"  class="typeText" minlength="3" maxlength="16" title="{style_padding_label}" /> </td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_bgcolor"><b>{style_bgcolor}:</b></label></td>
							<td>
								<input type="text" name="s_bgcolor" id="s_bgcolor" value="'.($sor['s_bgcolor']).'"  class="typeText" minlength="3" maxlength="8" title="{style_bgcolor_label}" />
								<input type="button" value="Colors" onclick="$(this).ColorPicker({color:$(\'#s_bgcolor\').val(),onShow:function(colpkr){$(colpkr).fadeIn(500);return false;},onHide: function(colpkr){$(colpkr).fadeOut(500);return false;},onChange:function(hsb, hex, rgb){$(\'#s_bgcolor\').val(\'#\' + hex);}});$(this).attr(\'onclick\',\'$(this).click();\');$(this).click();" />
							</td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_fontfamily"><b>{style_fontfamily}:</b></label></td>
							<td> <input type="text" name="s_fontfamily" id="s_fontfamily" value="'.($sor['s_fontfamily']).'"  class="typeText" minlength="3" maxlength="64" title="{style_fontfamily_label}" /> </td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_fontsize"><b>{style_fontsize}:</b></label></td>
							<td> <input type="text" name="s_fontsize" id="s_fontsize" value="'.($sor['s_fontsize']).'"  class="typeText" minlength="3" maxlength="8" title="{style_fontsize_label}" /> </td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_color"><b>{style_color}:</b></label></td>
							<td>
								<input type="text" name="s_color" id="s_color" value="'.($sor['s_color']).'"  class="typeText" minlength="3" maxlength="8" title="{style_color_label}" />
								<input type="button" value="Colors" onclick="$(this).ColorPicker({color:$(\'#s_color\').val(),onShow:function(colpkr){$(colpkr).fadeIn(500);return false;},onHide: function(colpkr){$(colpkr).fadeOut(500);return false;},onChange:function(hsb, hex, rgb){$(\'#s_color\').val(\'#\' + hex);}});$(this).attr(\'onclick\',\'$(this).click();\');$(this).click();" />
							</td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_style"><b>{style_other}:</b></label></td>
							<td><textarea class="typeText" minlength="3" maxlength="65000" name="s_style" id="s_style" style="width:400px;height:300px;border-radius:7px;" title="{style_other_label}">'.($sor['s_style']).'</textarea></td>
						</tr>
						<tr>
							<td class="cimke"><label><b>{style_bgimage}:</b></label></td>
							<td>
								<table style="width:100%">'.(KepUP::AdminForm('style_{'.(($sor['s_id'])?($sor['s_id']):(0)).'}',1,false,false,false,'{style_bgimage}')).'</table>
							</td>
						</tr>';
	$kep_con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="style_{'.(($sor['s_id'])?($sor['s_id']):(0)).'}" LIMIT 1');
	if(mysqli_num_rows($kep_con)) {
			echo'
						<tr>
							<td class="cimke"><label for="s_bgimgpos"><b>{style_bgimgpos}:</b></label></td>
							<td>
								<select name="s_bgimgpos" id="s_bgimgpos" >
									<option value="" '.(($sor['s_bgimgpos']=='')?(' SELECTED'):('')).'> - - - - </option>
									<option value="0% 0%" '.(($sor['s_bgimgpos']=='0% 0%')?(' SELECTED'):('')).'>Top - Left</option>
									<option value="50% 0%" '.(($sor['s_bgimgpos']=='50% 0%')?(' SELECTED'):('')).'>Top - Center</option>
									<option value="100% 0%" '.(($sor['s_bgimgpos']=='100% 0%')?(' SELECTED'):('')).'>Top - Right</option>
									<option value="0% 50%" '.(($sor['s_bgimgpos']=='0% 50%')?(' SELECTED'):('')).'>Middle - Left</option>
									<option value="50% 50%" '.(($sor['s_bgimgpos']=='50% 50%')?(' SELECTED'):('')).'>Middle - Center</option>
									<option value="100% 50%" '.(($sor['s_bgimgpos']=='100% 50%')?(' SELECTED'):('')).'>Middle - Right</option>
									<option value="0% 100%" '.(($sor['s_bgimgpos']=='0% 100%')?(' SELECTED'):('')).'>Bottom - Left</option>
									<option value="50% 100%" '.(($sor['s_bgimgpos']=='50% 100%')?(' SELECTED'):('')).'>Bottom - Center</option>
									<option value="100% 100%" '.(($sor['s_bgimgpos']=='100% 100%')?(' SELECTED'):('')).'>Bottom - Right</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="cimke"><label for="s_bgimgrep"><b>{style_bgimgrep}:</b></label></td>
							<td>
								<select name="s_bgimgrep" id="s_bgimgrep" >
									<option value="" '.(($sor['s_bgimgrep']=='')?(' SELECTED'):('')).'> - - - - </option>
									<option value="no-repeat" '.(($sor['s_bgimgrep']=='no-repeat')?(' SELECTED'):('')).'>NO Repeat</option>
									<option value="repeat-x" '.(($sor['s_bgimgrep']=='repeat-x')?(' SELECTED'):('')).'>Repeat X</option>
									<option value="repeat-y" '.(($sor['s_bgimgrep']=='repeat-y')?(' SELECTED'):('')).'>Repeat Y</option>
									<option value="repeat" '.(($sor['s_bgimgrep']=='repeat')?(' SELECTED'):('')).'>Repeat X+Y</option>
								</select>
							</td>
						</tr>';
	}
	echo'
						<tr class="fejlec"><td colspan="2" align="center"><input class="admin_btn" name="smbt" type="submit" value="'.(($sid>0)?('{modosit}'):('{felvisz}')).'" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></td></tr>
					</tbody>
				</table>
			</form>
			<div style="color:red;font-size:11px;padding:10px;">{style_update_info}</div>
			<script type="text/javascript">
				function FormControl(cont) {
					var hibastr="";

					var eName = InputControl($("#s_nev",$("#iForm")));
					var eKep = (($("img[uploading=\'true\']").length>0)?(0):(1));
					
					if(!eName) { hibastr +="\nKérem adja meg a nevét!"; }
					if(!eKep) { hibastr +="\n{kepupload_error}!"; }

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