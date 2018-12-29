<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
if($hmode=='del' AND is_numeric($formid) AND !($_ENV['USER']['u_guest'])) {
	if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `forms` WHERE `form_id`="'.($formid).'" LIMIT 1')) {
		$rCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_row` WHERE `fr_form_id`="'.($formid).'" ORDER BY `fr_sorsz`');
		while($row = mysqli_fetch_array($rCon)) {
			mysqli_query($_ENV['MYSQLI'],'DELETE FROM `forms_row` WHERE `fr_id`="'.($row['fr_id']).'" LIMIT 1');
			mysqli_query($_ENV['MYSQLI'],'DELETE FROM `forms_log` WHERE `fl_fr_id`="'.($row['fr_id']).'"');
		}
		echo'<script type="text/javascript">AddAlert("ok","Form törölve!");</script>';
	} else {
		echo'<script type="text/javascript">AddAlert("no","Form törlése sikertelen!");</script>';
	}
}
if(!$xmode) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` ORDER BY `form_name` LIMIT 100');
	$_ENV['FIX']['forms_cim_num'] = mysqli_num_rows($con);
	echo'
			<h1 class="cim">{forms_cim_num}</h1>
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'&amp;xmode=new">{forms_uj_form}</a><br/><br/>
			<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
				<tbody>
					<tr class="fejlec">
						<th width="25">#</th>
						<th>{cime}</th>
						<th class="admin_btn">Log</th>
						<th class="admin_btn">{modosit}</th>
						<th class="admin_btn">{torol}</th>
					</tr>';
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $i++;
		echo'
					<tr>
						<td>'.($i).'.</td>
						<td>'.($sor['form_name']).'</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="xmode" value="log"/>
								<input type="hidden" name="formid" value="'.($sor['form_id']).'"/>
								<input class="admin_btn" type="submit" value="Log"/>
							</form>
						</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="xmode" value="mod"/>
								<input type="hidden" name="formid" value="'.($sor['form_id']).'"/>
								<input class="admin_btn" type="submit" value="{modosit}"/>
							</form>
						</td>
						<td>
							<form action="?oldal='.($oldal).'" onsubmit="return noAlert();" method="POST">
								<input type="hidden" name="mode" value="'.($mode).'"/>
								<input type="hidden" name="hmode" value="del"/>
								<input type="hidden" name="formid" value="'.($sor['form_id']).'"/>
								<input class="admin_btn" type="submit" value="{torol}" onclick="if(confirm(\'{forms_torol_confirm}\')) { return true; } else { return false; }" />
							</form>
						</td>
					</tr>';
	}
	echo'
				</tbody>
			</table>';
	unSet($i); unSet($sor); unSet($con);
} elseif($xmode=='log') {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` WHERE `form_id`="'.(in_text($_REQUEST['formid'])).'" ORDER BY `form_name` LIMIT 1');
	if($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
		$xCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_log` WHERE `fl_form_id`="'.($sor['form_id']).'" GROUP BY `fl_post_hash`');
		$_ENV['FIX']['forms_log_num'] = mysqli_num_rows($xCon);
		echo'
			<h1 class="cim">"'.($sor['form_name']).'" - {forms_log_num}</h1>
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'">&#171;{vissza}</a><br/><br/>
			<style type="text/css">tr.hidden{display:none;}</style>';

		$rows = Array();
		$rCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_row` WHERE `fr_form_id`="'.($sor['form_id']).'" ORDER BY `fr_sorsz`');
		while($row=mysqli_fetch_array($rCon,MYSQLI_ASSOC)) {
			$rows[$row['fr_id']] = Array();
			$rows[$row['fr_id']]['required'] = $row['fr_required'];
			$rows[$row['fr_id']]['label'] = $row['fr_label'];
			$rows[$row['fr_id']]['type'] = $row['fr_type'];
		}
		$_lastPostHash = NULL;
		$_lastRowID = NULL;
		$xCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_log` WHERE `fl_form_id`="'.($sor['form_id']).'" ORDER BY `fl_date` DESC, `fl_post_hash`, `fl_id`');
		while($log=mysqli_fetch_array($xCon,MYSQLI_ASSOC)) {
			if($_lastPostHash!=$log['fl_post_hash']) {
				if($_lastPostHash!=NULL) { echo'</table><br/><br/>'; }
				echo'
					<table class="table logs" width="100%" cellspacing="0" cellpadding="3" border="0">
						<tr class="fejlec"><th style="width:150px">Beküldve:</th><th>'.($log['fl_date']).'</th></tr>';
			}
			if($_lastRowID!=$log['fl_fr_id']) {
				if($_lastPostHash!=NULL) { echo'</td></tr>'; }
				echo'<tr class="'.(($rows[$log['fl_fr_id']]['required'])?(''):('hidden')).'"><td><b>'.($rows[$log['fl_fr_id']]['label']).':</b></td><td>';
			}
			echo (($_lastRowID==$log['fl_fr_id'])?('<br/>'):(''));
			echo ($log['fl_text']);

			$_lastRowID=$log['fl_fr_id'];
			$_lastPostHash=$log['fl_post_hash'];
		}
		echo'</td></tr></table><br/><br/>
			<script type="text/javascript">
				$("table.logs").hover(
					function() {
						$("tr.hidden",this).fadeIn();
					},
					function(){
						$("tr.hidden",this).delay(1000).fadeOut();
					}
				);
			</script>';

	}
} elseif($xmode=='mod' OR $xmode=='new') {
	if($rogzit AND !($_ENV['USER']['u_guest'])) {
		if($formid>0) {
			if(mysqli_query($_ENV['MYSQLI'],'
				UPDATE `forms`
				SET
					`form_one`="'.(in_text($form_one)).'",
					`form_name`="'.(in_text($form_name)).'",
					`form_mail`="'.(in_text($form_mail)).'",
					`form_text`="'.(in_html($form_text)).'"
				WHERE `form_id`="'.($formid).'"
				LIMIT 1')) {
				echo'<script type="text/javascript">AddAlert("ok","Form módosítva!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Form módosítása sikertelen!");</script>';
			}
		} else {
			mysqli_query($_ENV['MYSQLI'],'
				INSERT INTO `forms`
					( `form_one`, `form_name`, `form_mail`, `form_text`, `form_date` )
				VALUES
					( "'.(in_text($form_one)).'", "'.(in_text($form_name)).'", "'.(in_text($form_mail)).'", "'.(in_html($form_text)).'", NOW() )');
			$formid = mysqli_insert_id($_ENV['MYSQLI']);
			if($formid) {
				echo'<script type="text/javascript">AddAlert("ok","Form felvíve!");</script>';
			} else {
				echo'<script type="text/javascript">AddAlert("no","Form felvitele sikertelen!");</script>';
			}
		}
		if($formid>0) {
			$sorszam = 0;
			for($a=0;$a<count($_POST['fr_id']);$a++) {
				$sorszam++;
				mysqli_query($_ENV['MYSQLI'],'
					UPDATE `forms_row`
					SET
						`fr_sorsz`="'.(in_text($_POST['fr_sorsz'][$_POST['fr_id'][$a]])).'",
						`fr_label`="'.(in_text($_POST['fr_label'][$_POST['fr_id'][$a]])).'",
						`fr_type`="'.(in_text($_POST['fr_type'][$_POST['fr_id'][$a]])).'",
						`fr_minlength`="'.(in_text($_POST['fr_minlength'][$_POST['fr_id'][$a]])).'",
						`fr_maxlength`="'.(in_text($_POST['fr_maxlength'][$_POST['fr_id'][$a]])).'",
						`fr_value`="'.(in_html($_POST['fr_value'][$_POST['fr_id'][$a]])).'",
						`fr_required`="'.(in_text($_POST['fr_required'][$_POST['fr_id'][$a]])).'"
					WHERE `fr_id`="'.(in_text($_POST['fr_id'][$a])).'"
					LIMIT 1
				');
			}
			for($a=0;$a<count($_POST['new_fr_label']);$a++) {
				if(strlen($_POST['new_fr_label'][$a])>=3) {
					$sorszam++;
					mysqli_query($_ENV['MYSQLI'],'
						INSERT INTO `forms_row`
							( `fr_form_id`, `fr_sorsz`, `fr_label`, `fr_type`, `fr_minlength`, `fr_maxlength`, `fr_value`, `fr_required` )
						VALUES
							(
								"'.(in_text($formid)).'",
								"'.(in_text($sorszam)).'",
								"'.(in_text($_POST['new_fr_label'][$a])).'",
								"'.(in_text($_POST['new_fr_type'][$a])).'",
								"'.(in_text($_POST['new_fr_minlength'][$a])).'",
								"'.(in_text($_POST['new_fr_maxlength'][$a])).'",
								"'.(in_html($_POST['new_fr_value'][$a])).'",
								"'.(in_text($_POST['new_fr_required'][$a])).'"
							)
					');
				}
			}
			if(is_array($_POST['form_del'])) {
				for($a=0;$a<count($_POST['form_del']);$a++) {
					mysqli_query($_ENV['MYSQLI'],'DELETE FROM `forms_row` WHERE `fr_id`="'.(in_text($_POST['form_del'][$a])).'" LIMIT 1');
					mysqli_query($_ENV['MYSQLI'],'DELETE FROM `forms_log` WHERE `fl_fr_id`="'.(in_text($_POST['form_del'][$a])).'"');
				}
			}
		}
	}
	if($formid>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` WHERE `form_id`="'.($formid).'" ORDER BY `form_name`');
		$sor=mysqli_fetch_array($con,MYSQLI_ASSOC); unSet($con);
		echo'
			<h1 class="cim">"'.($sor['form_name']).'" {forms_szerkesztese}</h1>';
	} else {
		$sor = $_POST;
		echo'
			<h1 class="cim">{forms_uj_form_szerkesztese}</h1>';
	}
	echo'
			<a class="new_link" href="?oldal='.($oldal).'&amp;mode='.($mode).'">&#171;{vissza}</a><br/><br/>
			<form action="?oldal='.($oldal).'" method="POST" id="iForm" name="iForm" onsubmit="return FormControl(1);">
				<input class="admin_btn save_btn" name="smbt" type="submit" value="'.(($formid>0)?('{modosit}'):('{felvisz}')).'" onclick="$(\'#MyBody\').attr(\'edited\',null);" />
				<input type="hidden" name="rogzit" value="1" />
				<input type="hidden" name="mode" value="'.($mode).'" />
				<input type="hidden" name="xmode" value="'.($xmode).'" />
				<input type="hidden" name="formid" value="'.($formid).'" />
				<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
					<tbody>
						<tr class="fejlec"> <th colspan="2"> {forms_adatai} </th> </tr>

						<tr>
							<td class="cimke"><label for="form_name"><b>{forms_name}:</b></label></td>
							<td> <input type="text" name="form_name" id="form_name" value="'.($sor['form_name']).'" class="typeText required" minlength="3" maxlength="255" title="{forms_name_title}" /> </td>
						</tr>

						<tr>
							<td class="cimke"><label for="form_mail"><b>{forms_email}:</b></label></td>
							<td>
								<input type="text" name="form_mail" id="form_mail" value="'.($sor['form_mail']).'" class="typeText" minlength="3" maxlength="255" title="{forms_email_title}" />
								<div class="helpBox">{forms_email_info}</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table class="table forms_rows" width="100%" cellspacing="0" cellpadding="3" border="0" style="border:0px solid transparent;box-shadow: 0px 0px 0px transparent;">';
	function frWriteRoe($row,$n) { $out = '';
		switch ($row['fr_type']) {
			case '':
			case 'typeText':
			case 'typeEmail':
			case 'typeNumber':
				$optg1 = 'texts'; break;
			case 'typeSelect':
			case 'typeRadio':
			case 'typeCheckbox':
			case 'typeDate':
				$optg1 = 'selects'; break;
		}
		$out .= '
				<tr id="forms_row_'.($n).'" '.(($row['a']==0)?(''):('class="hidden"')).' style="display:'.(($row['a']==0)?('table-row'):('none')).'">
					<td style="vertical-align:top">
						'.(($row['fr_id']>0)?('
						<p>
							<input type="hidden" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_id[]" value="'.(($row['fr_id'])?($row['fr_id']):($row['na'])).'" />
							<label style="display:inline-block;width:100px;"><b>{forms_row_sorszam}:</b></label>
							<select class="fr_sorsz" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_sorsz['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" onfocus="$(this).attr(\'oldValue\',$(this).val());" onchange="var thisValue=$(this).val(); zSorszam(thisValue,$(this).attr(\'oldValue\'),\'fr_sorsz\'); this.value=thisValue; $(this).attr(\'oldValue\',$(this).val());" style="width:75px;">'.(xSorrend($row['max'],$n)).'</select>
						</p>
						'):('')).'
						<p>
							<label style="display:inline-block;width:100px;"><b>{forms_row_cimke}:</b></label>
							<input type="text" class="typeText required frName" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_label['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" id="fr_label_'.($n).'" value="'.($row['fr_label']).'" title="{forms_row_cimke_title}" style="width:200px;" minlength="3" maxlength="128" />
						</p>
						<p>
							<label style="display:inline-block;width:100px;"><b>{forms_row_tipus}:</b></label>
							<select name="'.(($row['fr_id']>0)?(''):('new_')).'fr_type['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" id="fr_type_'.($n).'" style="width:205px;" onchange="frSelectType(this,'.($n).')">
								<option value="typeText"'.(($row['fr_type']=='typeText')?(' selected'):('')).'>{forms_row_tipus_text}</option>
								<option value="typeEmail"'.(($row['fr_type']=='typeEmail')?(' selected'):('')).'>{forms_row_tipus_email}</option>
								<option value="typeNumber"'.(($row['fr_type']=='typeNumber')?(' selected'):('')).'>{forms_row_tipus_number}</option>
								<option value="typeDate"'.(($row['fr_type']=='typeDate')?(' selected'):('')).'>{forms_row_tipus_date}</option>
								<!--option value="typeFile"'.(($row['fr_type']=='typeFile')?(' selected'):('')).'>{forms_row_tipus_file}</option-->
								<option value="typeSelect"'.(($row['fr_type']=='typeSelect')?(' selected'):('')).'>{forms_row_tipus_select}</option>
								<option value="typeRadio"'.(($row['fr_type']=='typeRadio')?(' selected'):('')).'>{forms_row_tipus_radio}</option>
								<option value="typeCheckbox"'.(($row['fr_type']=='typeCheckbox')?(' selected'):('')).'>{forms_row_tipus_checkbox}</option>
								<option value="typeTexta"'.(($row['fr_type']=='typeTexta')?(' selected'):('')).'>{forms_row_tipus_texta}</option>
								<option value="typeCaptcha"'.(($row['fr_type']=='typeCaptcha')?(' selected'):('')).'>{forms_row_tipus_captcha}</option>
								<option value="typeTitle"'.(($row['fr_type']=='typeTitle')?(' selected'):('')).'>{forms_row_tipus_title}</option>
							</select>
						</p>
					</td>
					<td class="forms_row_optiongroup1">
						<div class="texts" style="display:'.(($optg1=='texts')?('table-row'):('none')).';">
							<p>
								<label style="display:inline-block;width:100px;"><b>{forms_row_minlength}:</b></label>
								<input type="text" class="typeNumber" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_minlength['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" id="fr_minlength_'.($n).'" value="'.(($row['fr_minlength'])?($row['fr_minlength']):('')).'" title="{forms_row_minlength_title}" style="width:120px;" minlength="1" maxlength="11" />
							</p>
							<p>
							<label style="display:inline-block;width:100px;"><b>{forms_row_maxlength}:</b></label>
							<input type="text" class="typeNumber" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_maxlength['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" id="fr_maxlength_'.($n).'" value="'.(($row['fr_maxlength'])?($row['fr_maxlength']):('')).'" title="{forms_row_maxlength_title}" style="width:120px;" minlength="1" maxlength="11" />
							</p>
						</div>
						<div class="selects" style="display:'.(($optg1=='selects')?('table-row'):('none')).';">
							<label style="display:block;"><b>{forms_row_valasztek}:</b></label>
							<textarea class="typeText values required" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_value['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" id="fr_value_'.($n).'" style="width:300px;height:230px;" wrap="off">'.($row['fr_value']).'</textarea>
						</div>
					</td>
					<td style="vertical-align:top">
						<p>
							<input class="checkbox" type="checkbox" name="'.(($row['fr_id']>0)?(''):('new_')).'fr_required['.(($row['fr_id'])?($row['fr_id']):($row['na'])).']" id="form_required_'.($n).'" value="1" '.(($row['fr_required'])?('checked'):('')).' />
							<label for="form_required_'.($n).'"><b>{forms_row_required}</b></label>
						</p>
						'.(($row['fr_id']>0)?('
						<p>
							<input class="checkbox" type="checkbox" name="'.(($row['fr_id']>0)?(''):('new_')).'form_del[]" id="form_del_'.($n).'" value="'.(($row['fr_id'])?($row['fr_id']):($row['na'])).'" '.(($row['form_del'])?('checked'):('')).' />
							<label for="form_del_'.($n).'"><b>{forms_row_del}</b></label>
						</p>
						<p><a onclick=\'tinyMCE.get("form_text").execCommand("mceInsertContent",false,"[[req"+":"+"fr'.($row['fr_id']).']]"); hs.close(this); return false;\'>[Beszúrás]</a></p>
						'):('')).'
					</td>
				</tr>';
		return $out;
	}

	$n=0;
	$rCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_row` WHERE `fr_form_id`="'.($sor['form_id']).'" ORDER BY `fr_sorsz`');
	while($row = mysqli_fetch_array($rCon)) { $n++;
		$row['a']=0;
		$row['max']=mysqli_num_rows($rCon);
		echo frWriteRoe($row,$n);
	}

	for($a=0;$a<25;$a++) { $n++;
		echo frWriteRoe(Array('a'=>$n-1,'na'=>$a),$n);
	}

	echo'
								</table>
								<script type="text/javascript">
									function frNewRow() {
										var n = 0;
										$("tr.hidden",".forms_rows").each(function() {
											if(n==0) {
												if(InputControl($(".frName",$(this).prev("tr")))) {
													$(this).css({"display":"table-row"});
													$(this).removeClass("hidden");
												} else {
													AddAlert("no","Előző sincs kitőltve!");
												}
											}
											n++;
										});
										if(n<=1) { $(".frNewRowBTN").css({"display":"none"}); }
									}
									function frSelectType(obj,n) {
										$(".forms_row_optiongroup1 div",$("#forms_row_"+n)).css({"display":"none"});
										if(obj.value=="typeText"
										|| obj.value=="typeEmail"
										|| obj.value=="typeNumber") {
											$(".forms_row_optiongroup1 div.texts",$("#forms_row_"+n)).css({"display":"block"});
										}
										if(obj.value=="typeSelect"
										|| obj.value=="typeRadio"
										|| obj.value=="typeCheckbox"
										|| obj.value=="typeDate") {
											$(".forms_row_optiongroup1 div.selects",$("#forms_row_"+n)).css({"display":"block"});
										}
										if(obj.value=="typeDate") {
											$(".values",$(".forms_row_optiongroup1 div.selects",$("#forms_row_"+n))).val(\'dateFormat:"yy-mm-dd"\');
										}
									}
								</script>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<input class="checkbox" type="checkbox" name="form_one" id="form_one" value="1" '.(($sor['form_one'])?('checked'):('')).' />
								<label for="form_one"><b>{forms_one}</b></label>
								<div class="helpBox">{forms_one_info}</div>
								<input class="admin_btn frNewRowBTN" type="button" value="Új sor" onclick="frNewRow()" style="float:right;margin-right:50px;" />
							</td>
						</tr>

						<tr id="tr_text" style="display:'.(($sor['szp_mod']=='L')?('none'):('')).'">
							<td colspan="2" style="padding-top:10px;">
								<label for="form_text"><b>{forms_text}:</b></label>
								'.(htmlTextaInsert('form_text')).'
								'.(HTML_TEXTAREA('form_text',false,false)).'
								<div class="helpBox">{forms_text_info}</div><br/>
								<textarea class="form_text tinymce" id="form_text" name="form_text" cols="10" rows="10" style="min-width:675px; min-height:500px;">'.($sor['form_text']).'</textarea>
							</td>
						</tr>

						<tr class="fejlec"><td colspan="2" align="center"><input class="admin_btn" name="smbt" type="submit" value="'.(($formid>0)?('{modosit}'):('{felvisz}')).'" onclick="$(\'#MyBody\').attr(\'edited\',null);" /></td></tr>
					</tbody>
				</table>
			</form>
			<script type="text/javascript">
				function FormControl(cont) {
					var hibastr="";

					var eName = InputControl($("#form_name",$("#iForm")));
					var eEmail = InputControl($("#form_mail",$("#iForm")));

					if(!(eName)) { hibastr +="\n{forms_name_error}"; }
					if(!(eEmail)) { hibastr +="\n{forms_email_error}"; }


					if(cont>0) {
						if(hibastr!="") {
							AddAlert("alert","{formhibak}:"+hibastr);
							return false;
						} else { $("#MyBody").attr("edited",null); return true; }
					} else { return false; }

				}
				setTimeout(function() { FormControl(0); }, 100);
			</script>';
}
?>