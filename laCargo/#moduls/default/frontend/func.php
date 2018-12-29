<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('default/frontend',false);
$_ENV['MODS']['PURL'] = rPath('default/frontend',true);

$_ENV['HEAD']['CSS'][] = $_ENV['MODS']['PURL'].'/style.css';
$_ENV['HEAD']['CSS'][] = $_ENV['MODS']['PURL'].'/mystyle.css';

if($_ENV['SiteStart']!='CSS' AND $_ENV['SiteStart']!='JS') {

	$_ENV['OutFunc'][] = 'out_maps';
	$_ENV['OutFunc'][] = 'out_forms';

	function out_maps($s) {
		//<iframe src="#{maps:1}" width="640" height="400"></iframe>
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `maps` ORDER BY `map_id`');
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			if(strstr($s,'#{maps:'.($sor['map_id']).'}')) {
				$s = preg_replace(
					"/\<iframe src\=\"\#\{maps\:".($sor['map_id'])."\}\" width\=\"([0-9]+)\" height\=\"([0-9]+)\"\>\<\/iframe\>/i",
					'<span class="gmaps" id="gmaps'.($sor['map_id']).'" style="width:\\1px;height:\\2px;"><script type="text/javascript">$(document).ready(function(){setTimeout(function(){loadGoogleMaps({"ID":"gmaps'.($sor['map_id']).'","lati":"'.($sor['map_lati']).'","longi":"'.($sor['map_longi']).'","cimke":"'.($sor['map_cimke']).'","irsz":"'.($sor['map_irsz']).'","varos":"'.($sor['map_varos']).'","utca":"'.($sor['map_utca']).'","tel":"'.($sor['map_tel']).'","fax":"'.($sor['map_fax']).'","email":"'.($sor['map_email']).'","web":"'.($sor['map_web']).'"});},500);});</script></span>',
					$s
				);
				$s = preg_replace(
					"/\<iframe style\=\"([0-9a-z.\#\-\:\;\ \(\)\.\,]+)\" src\=\"\#\{maps\:".($sor['map_id'])."\}\" width\=\"([0-9]+)\" height\=\"([0-9]+)\"\>\<\/iframe\>/i",
					'<span class="gmaps" id="gmaps'.($sor['map_id']).'" style="\\1width:\\2px;height:\\3px;"><script type="text/javascript">$(document).ready(function(){setTimeout(function(){loadGoogleMaps({"ID":"gmaps'.($sor['map_id']).'","lati":"'.($sor['map_lati']).'","longi":"'.($sor['map_longi']).'","cimke":"'.($sor['map_cimke']).'","irsz":"'.($sor['map_irsz']).'","varos":"'.($sor['map_varos']).'","utca":"'.($sor['map_utca']).'","tel":"'.($sor['map_tel']).'","fax":"'.($sor['map_fax']).'","email":"'.($sor['map_email']).'","web":"'.($sor['map_web']).'"});},500);});</script></span>',
					$s
				);
			}
		}
		return $s;
	}

	function out_forms($s) {
		//<iframe src="#{forms:1}" width="640" height="400"></iframe>
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` ORDER BY `form_id`');
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			if(strstr($s,'#{forms:'.($sor['form_id']).'}')) {
				$s = preg_replace(
					"/\<iframe src\=\"\#\{forms\:".($sor['form_id'])."\}\" width\=\"([0-9]+)\" height\=\"([0-9]+)\"\>\<\/iframe\>/i",
					'<span class="forms" id="forms_'.($sor['form_id']).'" style="width:\\1px;min-height:\\2px;"><script type="text/javascript">$(document).ready(function(){setTimeout(function(){LoadPage("?formsload='.($sor['form_id']).((is_array($_GET))?(ReGet($_GET)):('')).((is_array($_POST))?(ReGet($_POST)):('')).'");},100);});</script></span>',
					$s
				);
				$s = preg_replace(
					"/\<iframe style\=\"([0-9a-z.\#\-\:\;\ \(\)\.\,]+)\" src\=\"\#\{forms\:".($sor['form_id'])."\}\" width\=\"([0-9]+)\" height\=\"([0-9]+)\"\>\<\/iframe\>/i",
					'<span class="forms" id="forms_'.($sor['form_id']).'" style="\\1width:\\2px;min-height:\\3px;"><script type="text/javascript">$(document).ready(function(){setTimeout(function(){LoadPage("?formsload='.($sor['form_id']).((is_array($_GET))?(ReGet($_GET)):('')).((is_array($_POST))?(ReGet($_POST)):('')).'");},100);});</script></span>',
					$s
				);
			}
		}
		return $s;
	}

	function FormsControlOne($formid,$mailRow) {
		$filled = false;
		if(!$_COOKIE['xForm'.(in_text($formid))]) {
			$lWhere = '';
			$lInterval = 7;
			if($mailRow['fr_id']>0 AND strlen($mailRow['iValue'])>0) {
				$lWhere .= ' AND ( `fl_fr_id`="'.($mailRow['fr_id']).'" AND ( `fl_text`="'.($mailRow['iValue']).'" OR `fl_ip`="'.(in_text($_SERVER['REMOTE_ADDR'])).'" ) ) ';
			} else {
				$lWhere .= ' AND ( `fl_ip`="'.(in_text($_SERVER['REMOTE_ADDR'])).'" ) ';
				$lInterval = 3;
			}
			$lCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_log` WHERE `fl_form_id`="'.(in_text($formid)).'" '.($lWhere).' AND `fl_date` > DATE_SUB(NOW(), INTERVAL '.($lInterval).' DAY) LIMIT 1');
			if(mysqli_num_rows($lCon)) { $filled = true; }
		} else { $filled = true; }
		return $filled;
	}

	function FormsPrint($formid) { $out = $_out_js = ''; $filled = false;
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` WHERE `form_id`="'.(in_text($formid)).'" LIMIT 1');
		if($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			if($sor['form_one']) {
				$filled = FormsControlOne($formid,false);
			}
			if($filled) {
				$out .= out_site(out_html(str_replace(Array('[[',']]'),Array('{','}'),$sor['form_text']))).' ';
			} else {
				$out .= '
					<span id="inputErrors_'.($sor['form_id']).'"></span>
					<form action="" method="post" name="forms'.($sor['form_id']).'" id="forms'.($sor['form_id']).'" onsubmit="return FormControl'.($sor['form_id']).'(1);">
						<div>
							<input type="hidden" name="formssend" value="'.($sor['form_id']).'" />
							<input type="hidden" name="formsload" value="'.($sor['form_id']).'" />';
				$rCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_row` WHERE `fr_form_id`="'.($sor['form_id']).'" ORDER BY `fr_sorsz`');
				while($row = mysqli_fetch_array($rCon)) {
					if($row['fr_type']=='typeDate') { $row['fr_value'] = str_replace('"',"'",$row['fr_value']); }
					$vals = explode("\n",str_replace(Array("\r\n","\r"),"\n",$row['fr_value']));
					switch ($row['fr_type']) {
						case 'typeText':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelCell"><label for="fr'.($row['fr_id']).'">'.($row['fr_label']).':</label></span>
										<span class="valusCell">
											<input type="text" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'" name="fr'.($row['fr_id']).'" value="'.(in_text($_REQUEST['fr'.$row['fr_id']])).'" '.(($row['fr_minlength'])?('minlength="'.($row['fr_minlength']).'"'):('')).' '.(($row['fr_maxlength'])?('maxlength="'.($row['fr_maxlength']).'"'):('')).' />
											<span class="formsInputError">{formsInputError}</span>
										</span>
									</span>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeEmail':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelCell"><label for="fr'.($row['fr_id']).'">'.($row['fr_label']).':</label></span>
										<span class="valusCell">
											<input type="email" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'" name="fr'.($row['fr_id']).'" value="'.(in_text($_REQUEST['fr'.$row['fr_id']])).'" '.(($row['fr_minlength'])?('minlength="'.($row['fr_minlength']).'"'):('')).' '.(($row['fr_maxlength'])?('maxlength="'.($row['fr_maxlength']).'"'):('')).' />
											<span class="formsInputError">{formsInputError}</span>
										</span>
									</span>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeNumber':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelCell"><label for="fr'.($row['fr_id']).'">'.($row['fr_label']).':</label></span>
										<span class="valusCell">
											<input type="number" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'" name="fr'.($row['fr_id']).'" value="'.(in_text(($_REQUEST['fr'.$row['fr_id']])?($_REQUEST['fr'.$row['fr_id']]):($row['fr_minlength']))).'" '.(($row['fr_minlength'])?('min="'.($row['fr_minlength']).'"'):('min="0"')).' '.(($row['fr_maxlength'])?('max="'.($row['fr_maxlength']).'"'):('')).' style="max-width: 50px;" />
											<span class="formsInputError">{formsInputError}</span>
										</span>
									</span>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeDate':
							$vals = array_filter($vals);
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelCell"><label for="fr'.($row['fr_id']).'">'.($row['fr_label']).':</label></span>
										<span class="valusCell">
											<input type="text" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'" name="fr'.($row['fr_id']).'" value="'.(in_text($_REQUEST['fr'.$row['fr_id']])).'" '.(($row['fr_minlength'])?('minlength="'.($row['fr_minlength']).'"'):('')).' '.(($row['fr_maxlength'])?('maxlength="'.($row['fr_maxlength']).'"'):('')).' style="width:90px;" readonly onclick="$(\'#fr'.($row['fr_id']).'\',$(\'#forms'.($sor['form_id']).'\')).datepicker(\'destroy\');$(\'#fr'.($row['fr_id']).'\',$(\'#forms'.($sor['form_id']).'\')).datepicker({'.((count($vals)>0)?(join(',',$vals)):('')).'});" /> <span class="datePicker" onclick="$(\'#fr'.($row['fr_id']).'\',$(\'#forms'.($sor['form_id']).'\')).datepicker(\'destroy\');$(\'#fr'.($row['fr_id']).'\',$(\'#forms'.($sor['form_id']).'\')).datepicker({'.((count($vals)>0)?(join(',',$vals)):('')).'});$(\'#fr'.($row['fr_id']).'\').focus();"></span>
											<span class="formsInputError">{formsInputError}</span>
										</span>
									</span>
									<script type="text/javascript"></script>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeSelect':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelCell"><label for="fr'.($row['fr_id']).'">'.($row['fr_label']).':</label></span>
										<span class="valusCell">
											<select class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'" name="fr'.($row['fr_id']).'">
												<option value="">{formsSelectDefault}</option>';
							for($n=0;$n<count($vals);$n++) {
								$out .= '<option value="'.($vals[$n]).'"'.(($_REQUEST['fr'.$row['fr_id']]==$vals[$n])?(' selected'):('')).'>'.($vals[$n]).'</option>';
							}
							$out .= '
											</select>
											<span class="formsInputError">{formsInputError}</span>
										</span>
									</span>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeRadio':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">'.($row['fr_label']).':<span class="formsInputError">{formsInputError}</span></span>';
							for($n=0;$n<count($vals);$n++) {
								$out .= '
									<span class="row">
										<input type="radio" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'_'.($n).'" name="fr'.($row['fr_id']).'" value="'.($vals[$n]).'" '.(($_REQUEST['fr'.$row['fr_id']]==$vals[$n])?(' checked'):('')).' />
										<label for="fr'.($row['fr_id']).'_'.($n).'">'.($vals[$n]).'</label>
									</span>';
							}
							$out .= '
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl("#fr'.($row['fr_id']).'_row  input[type=radio]");
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeCheckbox':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">'.($row['fr_label']).':<span class="formsInputError">{formsInputError}</span></span>';
							if(!is_array($_REQUEST['fr'.$row['fr_id']])) { $_REQUEST['fr'.$row['fr_id']] = Array(); }
							for($n=0;$n<count($vals);$n++) {
								$out .= '
									<span class="row">
										<input type="checkbox" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'_'.($n).'" name="fr'.($row['fr_id']).'[]" value="'.($vals[$n]).'" '.((in_array($vals[$n],$_REQUEST['fr'.$row['fr_id']]))?(' checked'):('')).' />
										<label for="fr'.($row['fr_id']).'_'.($n).'">'.($vals[$n]).'</label>
									</span>';
							}
							$out .= '
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl("#fr'.($row['fr_id']).'_row input[type=checkbox]");
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeTexta':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row"><label for="fr'.($row['fr_id']).'" style="font-weight:bold;">'.($row['fr_label']).':</label></span>
									<span class="row">
										<textarea type="text" class="'.($row['fr_type']).' '.(($row['fr_required'])?('required'):('')).'" id="fr'.($row['fr_id']).'" name="fr'.($row['fr_id']).'">'.(in_text($_REQUEST['fr'.$row['fr_id']])).'</textarea>
										<span class="formsInputError">{formsInputError}</span>
									</span>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeCaptcha':
							$out .= '
								<p style="text-align:center;"><img src="/captcha.png?r='.md5(rand(100000,999999)).'" alt="Loading..." width="300" height="80" style="border:0px;" id="captcha_kep_'.($row['fr_id']).'" /></p>
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelCell"><label for="fr'.($row['fr_id']).'">'.($row['fr_label']).':</label></span>
										<span class="valusCell">
											<input type="hidden" class="captcha_key" id="captcha_key" value="'.md5($_SERVER['REMOTE_ADDR']).'" />
											<input type="text" class="'.($row['fr_type']).' required captcha_value" id="fr'.($row['fr_id']).'" name="captcha_value" value="'.(in_text($_REQUEST['captcha_value'])).'" title="{captcha_value}" minlength="5" maxlength="5" />
										</span>
										<span class="formsInputError">{formsInputError}</span>
									</span>
								</p>';
							$_out_js .= '
								var eFr'.($row['fr_id']).' = InputControl($("#fr'.($row['fr_id']).'"));
								$(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":((eFr'.($row['fr_id']).')?(0):(1))});
								if(!eFr'.($row['fr_id']).') { hibacount++; }
							';
							break;
						case 'typeTitle':
							$out .= '
								<p id="fr'.($row['fr_id']).'_row">
									<span class="row">
										<span class="labelTitle">'.($row['fr_label']).'</span>
									</span>
								</p>';
							break;
					}
				}
				$out .= '
							<p>
								<span class="sendRow">
									<input type="submit" class="typeButton send" value="{lang:btnsend}" />
								</span>
							</p>
						</div>
					</form>
					<script type="text/javascript">
						$("input, select, textarea",$("#forms'.($sor['form_id']).'")).uniform();
						function FormControl'.($sor['form_id']).'(cont) {
							var hibacount=0;
							'.($_out_js).'
							if(cont>0) {
								if(hibacount>0) {
									$("html, body").animate({ scrollTop: $("#forms'.($sor['form_id']).'").offset().top-150 }, 500);
									return false;
								} else { return true; }
							} else { return false; }
						}
					</script>';
			}
		}
		return $out;
	}
	
	function FormsControl($formid) { $out = $_out_js = '';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` WHERE `form_id`="'.(in_text($formid)).'" LIMIT 1');
		if($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			$mailRow = false;
			$rCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_row` WHERE `fr_form_id`="'.(in_text($formid)).'" ORDER BY `fr_sorsz`');
			while($row = mysqli_fetch_array($rCon)) {
				$iValue = in_text($_REQUEST['fr'.$row['fr_id']]);
				$iLength = ((is_array($iValue))?(count($iValue)):(strlen($iValue)));
				$iMinLength = (($row['fr_minlength']>0)?($row['fr_minlength']):(3));
				$iMaxLength = (($row['fr_maxlength']>0)?($row['fr_maxlength']):(255));
				$iRequired = (($row['fr_required'])?(1):(0));
				$iFilter = (($iRequired AND $iLength==0)?(0):(1));
				$_filter = false;
				switch ($row['fr_type']) {
					case 'typeText':
					case 'typeTexta':
						break;
					case 'typeEmail':
						$_filter = "/^[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i";
						$mailRow = $row;
						$mailRow['iValue'] = $iValue;
						break;
					case 'typeNumber':
						$iMinLength = 1;
						$iMaxLength = 11;
						$_filter = "/^[0-9\.]*$/i";
						break;
					case 'typeDate':
						$_filter = "/^([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})$/i";
						break;
					case 'typeSelect':
					case 'typeRadio':
					case 'typeCheckbox':
						$iMinLength = (($row['fr_minlength']>0)?($row['fr_minlength']):(1));
						break;
					case 'typeCaptcha':
						$iRequired = 1;
						$iValue = in_text($_REQUEST['captcha_value']);
						$iLength = ((is_array($iValue))?(count($iValue)):(strlen($iValue)));
						$iFilter = ((captcha_valied($iValue))?(1):(0));
						$iMinLength = 3;
						$iMaxLength = 9;
						$_out_js .= ' $("#captcha_kep_'.($row['fr_id']).'").attr("src","/captcha.png?r='.md5(rand(100000,999999)).'"); ';
						$_out_js .= ' $(".captcha_value").val(""); ';
						break;
				}
				if($_filter) { $iFilter = ((filter_var($iValue, FILTER_VALIDATE_REGEXP,Array("options"=>Array("regexp"=>$_filter))))?(1):(0)); }
				
				if( ( !($iRequired) OR ($iLength>=$iMinLength) )
				AND ( $iLength<=$iMaxLength )
				AND ( (!($iRequired) AND ( $iLength==0 OR $iValue==0 )) OR $iFilter )
				) {
					$_out_js .= ' $(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":"'.(($row['fr_type']=='typeCaptcha')?(1):(0)).'"}); ';
				} else {
					$_out_js .= ' $(".formsInputError",$("#fr'.($row['fr_id']).'_row")).animate({"opacity":"1"}); ';
					$_ENV['FormsErr'] = true;
				}
			}
			if($sor['form_one']) {
				$filled = FormsControlOne($formid,$mailRow);
				if($filled) {
					$_ENV['FormsErr'] = true;
					if($mailRow['fr_id']>0 AND strlen($mailRow['iValue'])>0) {
						$_out_js .= ' $(".formsInputError",$("#fr'.($mailRow['fr_id']).'_row")).animate({"opacity":"1"}); ';
					}
					$_out_js .= ' setTimeout(function(){ alert("Már kitöltötted!"); },100); ';
				}
			}
			if($_out_js) { $out = '<script type="text/javascript">'.($_out_js).'</script>'; }
		} else { $_ENV['FormsErr'] = true; }
		return $out;
	}
	
	function FormsSending($formid) { $out = '';
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms` WHERE `form_id`="'.(in_text($formid)).'" LIMIT 1');
		if($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			
			$mailDataRows = $mailFrom = '';
			$postHash = (($_REQUEST['postHash'])?(in_text($_REQUEST['postHash'])):(md5(time().rand(1000,9999))));
			setcookie('xForm'.(in_text($formid)), md5($formid), time()+(60*60*24*7), '/');
			$rCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `forms_row` WHERE `fr_form_id`="'.(in_text($formid)).'" ORDER BY `fr_sorsz`');
			while($row = mysqli_fetch_array($rCon)) {
				$iValue = in_html(((is_array($_REQUEST['fr'.$row['fr_id']]))?('<ul><li>'.join('</li><li>',$_REQUEST['fr'.$row['fr_id']]).'</li></ul>'):($_REQUEST['fr'.$row['fr_id']])));
				if($iValue) {
					if($row['fr_type']=='typeEmail') { $mailFrom = $iValue; }
					if($row['fr_type']!='typeCaptcha'
					&& $row['fr_type']!='typeTitle') { $mailDataRows .= '<p><b>'.($row['fr_label']).':</b> '.($iValue).'</p>'; }
					else if($row['fr_type']!='typeTitle') { $mailDataRows .= '<p><b>'.($row['fr_label']).'</b></p>'; }
					if(is_array($_REQUEST['fr'.$row['fr_id']])) {
						for($a=0;$a<count($_REQUEST['fr'.$row['fr_id']]);$a++) {
							mysqli_query($_ENV['MYSQLI'],'INSERT INTO `forms_log` ( `fl_form_id`, `fl_fr_id`, `fl_ip`, `fl_post_hash`, `fl_text`, `fl_date` ) VALUES ( "'.(in_text($formid)).'", "'.(in_text($row['fr_id'])).'", "'.(in_text($_SERVER['REMOTE_ADDR'])).'", "'.($postHash).'", "'.(in_text($_REQUEST['fr'.$row['fr_id']][$a])).'", NOW() )');
						}
					} else {
						mysqli_query($_ENV['MYSQLI'],'INSERT INTO `forms_log` ( `fl_form_id`, `fl_fr_id`, `fl_ip`, `fl_post_hash`, `fl_text`, `fl_date` ) VALUES ( "'.(in_text($formid)).'", "'.(in_text($row['fr_id'])).'", "'.(in_text($_SERVER['REMOTE_ADDR'])).'", "'.($postHash).'", "'.($iValue).'", NOW() )');
					}
				}
			}
			
			if($sor['form_mail'] AND $mailDataRows) {
				$to_name = $_ENV['CONF']['MAIL']['NAME'];
				$from_name = $_ENV['CONF']['MAIL']['NAME'];
				$from_mail = (($mailFrom)?($mailFrom):($_ENV['CONF']['MAIL']['MAIL']));
				$_ENV['FIX']['mailDataRows']  = $mailDataRows;
				$_ENV['FIX']['mailDataRows'] .= '<p>Forrás: <a href="http://'.$_ENV['HEAD']['HOST'].$_ENV['HEAD']['URI'].'">http://'.$_ENV['HEAD']['HOST'].$_ENV['HEAD']['URI'].'</a></p>';
				$_ENV['FIX']['mailSubject'] = $subject = $sor['form_name'];
				$massage = out_site(file_get_contents($_ENV['MODS']['PATH'].'/forms-email.tpl'));
				$toMails = explode(',',str_replace(Array("\r","\n","\t"," ",";"),Array('','','','',','),$sor['form_mail']));
				for($a=0;$a<count($toMails);$a++) {
					if(strtolower($toMails[$a])=='[sysmail]') { $toMails[$a] = $_ENV['CONF']['MAIL']['MAIL']; }
					if(filter_var($toMails[$a], FILTER_VALIDATE_EMAIL)) {
						$to_mail = $toMails[$a];
						eMail::eMailSend($from_name, $from_mail, $to_name, $to_mail, $subject, $massage, false);
					}
					
					if(strtolower($toMails[$a])=='[frommail]') {
						if(filter_var($mailFrom, FILTER_VALIDATE_EMAIL)) {
							$to_mail = $mailFrom;
							$_ENV['FIX']['_mailDataRows'] = $_ENV['FIX']['mailDataRows'];
							$_ENV['FIX']['mailDataRows'] = out_site(out_html(str_replace(Array('[[',']]'),Array('{','}'),$sor['form_text']))).' ';
							$xMassage = out_site(file_get_contents($_ENV['MODS']['PATH'].'/forms-email.tpl'));
							eMail::eMailSend($from_name, $_ENV['CONF']['MAIL']['MAIL'], $to_name, $to_mail, $subject, $xMassage, false);
							$_ENV['FIX']['mailDataRows'] = $_ENV['FIX']['_mailDataRows'];
							$_ENV['FIX']['_mailDataRows'] = null;
						}
					}
				}
			}
			
			$out .= out_site(out_html(str_replace(Array('[[',']]'),Array('{','}'),$sor['form_text']))).' ';
		}
		return $out;
	}

	if(is_numeric($_REQUEST['formsload'])) {
		$_ENV['CONF']['ReLoad'] = false;
		$_ENV['jSon']['SitePage'] = '';
		if(is_numeric($_REQUEST['formssend'])) {
			$_ENV['FormsErr'] = false;
			$_ENV['jSon']['inputErrors_'.(in_text($_REQUEST['formsload']))] = FormsControl(in_text($_REQUEST['formsload']));
			if(!$_ENV['FormsErr']) {
				$_ENV['jSon']['inputErrors_'.(in_text($_REQUEST['formsload']))] = false;
				$_ENV['jSon']['forms_'.(in_text($_REQUEST['formsload']))] = FormsSending(in_text($_REQUEST['formsload']));
			}
			print(json_encode($_ENV['jSon']));
			exit();
		}
		$_ENV['jSon']['forms_'.(in_text($_REQUEST['formsload']))] = out_site(FormsPrint(in_text($_REQUEST['formsload'])));
		print(json_encode($_ENV['jSon']));
		exit();
	}
	
	if(substr(strtolower($_ENV['CONF']['sysSiteFejlesztes']),0,1)=='i') {
		if($_ENV['SiteStart']!='AJAX' AND $_ENV['SiteStart']!='JSON') {
			header('HTTP/1.0 404 Not Found',$replace=false,404);
			$_SESSION['sysSiteFejlesztes'];
		}
		if($_SERVER['REQUEST_URI']=='/') {
			$_ENV['SITE']['sysAlert'] = '
				<div id="sysAlert" style="position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:9999999999;background-color:rgba(0,0,0,0.7);">
					<div style="position:absolute;top:15%;left:50%;margin-left:-230px;width:460px;background-color:#FFF;color:#933;border-radius:7px;border:1px solid #333;">
						<a onclick="$(\'#sysAlert\').css({\'display\':\'none\'});" style="display:block;position:absolute;top:-10px;right:-10px;width:30px;height:30px;background-image:url(/js/highslide/imamges/close.png);"></a>
						<h2 style="text-align:center;padding:10px;font-size:33px;">A weboldal feltöltés alatt!</h2>
						<p style="text-align:center;"><img src="/images/info.png" border="0" style="height:150px;" /></p>
						<div style="text-align:center;">
							<div style="padding:15px 30px;font-size:18px;width:auto;margin:auto;display:inline-block;text-align:left;">
								<p>
									Jelenleg weboldal feltöltése folyamatban van.<br/>
									Ezen időszakban, míg a tartalom feltöltésre kerül,<br/>
									weboldalát a keresők nem látják, nem indexelik.
								</p>
								<p>
									Ha a tartalom feltöltésre került, jelezze felénk,<br/>
									és aktiváljuk weboldalát.
								</p>
								<p style="text-align: center;">
									<a style="display:inline-block;position:relative;color:#FFF;background-color:#59B200;padding:5px 10px;font-size:16px;font-weight:bold;border-radius:4px;" onclick="$(\'#sysAlert\').css({\'display\':\'none\'});">Tovább &#187;</a>
								</p>
							</div>
						</div>
					</div>
				</div>
			';
		}
	}

}
?>