<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_REQUEST['COPY'] = false;
$_ENV['KepUploadMode'] = 'move_uploaded_file';
class KepUP {
	/* Képfeltöltés Admin Form */
	static function AdminForm($id,$limit,$cimke,$sorszam,$albumkep,$kepfelcimke=false) { $OUT=NULL; $i=0;
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="'.($id).'" ORDER BY `kep_sorsz` LIMIT '.($limit).'');
		$kepfent = mysqli_num_rows($con);
		print(mysqli_error($_ENV['MYSQLI']));
		if($kepfent>0) { $n=0;
			$OUT .= '
				<tr class="fejlec">
					<th colspan="2" align="left">Képek:</th>
				</tr>
				<tr>
					<td colspan="2">
						<div class="helpBox">
							<div>Itt tudja a kép adatait módosítani.</div>
							'.(($cimke)?('<div><b>Cimke:</b> Minden képnek egyedi leírást tud megadni.</div>'):('')).'
							'.(($sorszam)?('<div><b>Sorszám:</b> Összetudja állítani hogy milyen sorrendben jelenjenek meg a képek.</div>'):('')).'
							'.(($albumkep)?('<div><b>Album képe:</b> Kitudja vállasztani, melyik legyen a fő kép.</div>'):('')).'
							<div><b>Kép törlése:</b> A képet törlésre tudja jelőlni, mely rögzítéskor törlödik.</div>
						</div>';
			while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $n++;
				$OUT .= '
						<div style="display: inline-block; width: 140px; padding: 5px; margin:3px 2px; box-shadow: 0px 0px 3px rgba(0,0,0,0.33); background-color: rgba(255,255,255,0.8); border-radius: 3px;">
							<input type="hidden" name="kepid['.($n-1).']" value="'.($sor['kep_id']).'"/>
							<div class="kepuploadFile" style="position:relative;display:block;padding:0px;height:auto;">
								<div style="position:relative;text-align:center;height:155px;line-height:145px;"><img class="uploadPreview" id="'.($kepID).'UploadPreview" name="nagykep_'.($sor['kep_id']).'" src="'.str_replace('//','/','/'.($sor['kep_kicsi'])).'" alt="'.($sor['kep_name']).'" title="'.($sor['kep_name']).'" onclick="return hs.htmlExpand(this, {contentId: this.name,width: 600} );" style="float:none;position:relative;cursor:pointer;max-height:140px;max-width:120px;vertical-align:middle;" /></div>
								<div id="nagykep_'.($sor['kep_id']).'" class="highslide-html-content" onmouseout="hs.close(this);">
									<div class="highslide-header"> <ul> <li class="highslide-close"> <a href="#" onclick="return hs.close(this)"> <span>BEZÁR</span> </a> </li> </ul> </div>
									<div class="highslide-body">
										<img src="'.str_replace('//','/','/'.($sor['kep_nagy'])).'" alt="'.($sor['kep_name']).'" title="'.($sor['kep_name']).'" border="0" width="600" />
									</div>
									<div class="highslide-footer"> <div> <span class="highslide-resize" title="Resize"> <span></span> </span> </div> </div>
								</div>
							</div>';
				if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
					for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
						$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
						if($_lang AND $_lang!='hu') {
							$OUT .= '
								<div'.(($cimke)?(''):(' style="display:none;"')).'> <input type="text" name="kepcimke_'.($_lang).'['.($n-1).']" value="'.($sor['kep_cimke_'.($_lang)]).'" class="typeText" minlength="3" maxlength="255" title="Cimke ['.strtoupper($_lang).']" style="width:135px;padding:2px 3px;" /> </div>';
						} else {
							$OUT .= '
								<div'.(($cimke)?(''):(' style="display:none;"')).'> <input type="text" name="kepcimke['.($n-1).']" value="'.($sor['kep_cimke']).'" class="typeText" minlength="3" maxlength="255" title="Cimke" style="width:135px;padding:2px 3px;" /> </div>';
						}
					}
				} else {
					$OUT .= '
								<div'.(($cimke)?(''):(' style="display:none;"')).'> <input type="text" name="kepcimke['.($n-1).']" value="'.($sor['kep_cimke']).'" class="typeText" minlength="3" maxlength="255" title="Cimke" style="width:130px;padding:2px 3px;" /> </div>';
				}
				$OUT .= '
							<div'.(($sorszam)?(''):(' style="display:none;"')).'>
								<b>Sorszám:</b> <select class="kep_sorsz" name="kep_sorsz['.($n-1).']" onfocus="$(this).attr(\'oldValue\',$(this).val());" onchange="var thisValue=$(this).val(); zSorszam(thisValue,$(this).attr(\'oldValue\'),\'kep_sorsz\'); this.value=thisValue; $(this).attr(\'oldValue\',$(this).val());" style="width:75px;">'.(KepUP::KepSorrend($kepfent,$n)).'</select>
							</div>
							<div'.(($albumkep)?(''):(' style="display:none;"')).'>
								<input class="checkbox" type="radio" name="defkep" id="defkep_'.($sor['kep_id']).'" value="'.($sor['kep_id']).'"'.(($_ENV['DEFKEP']==$sor['kep_id'])?(' CHECKED'):('')).'/>
								<label for="defkep_'.($sor['kep_id']).'"> <b>Album képe!</b></label>
							</div>
							<div><input class="checkbox" type="checkbox" name="kepdel[]" id="deletekep_'.($sor['kep_id']).'" value="'.($sor['kep_id']).'"/><label for="deletekep_'.($sor['kep_id']).'"> <b>Kép törlése</b></label></div>
						</div>';
			}
			$OUT .= '
					</td>
				</tr>';
		}
		$n=0;
		if($kepfent<$limit) {
				$OUT .= '
				<tr class="fejlec">
					<th colspan="2" align="left">Képfeltöltés:</th>
				</tr>
				<tr>
					<td colspan="2">
						<div class="helpBox">
							<div>Itt tud képeket feltölteni.</div>
							'.(($cimke)?('<div><b>Cimke:</b> Minden képnek egyedi leírást tud megadni.</div>'):('')).'
							<div><b>Kép törlése:</b> A képet törlésre tudja jelőlni, mely rögzítéskor törlödik.</div>
						</div>';
			for($a=(($kepfent)?($kepfent):(0));$a<$limit;$a++) { $n++;
				$uploadPreview = '/images/noimage.png';
				$kepID = 'kepupload'.$a;
				$upscr=1;
				$OUT .= '
						<div style="display: none; width: 140px; padding: 5px; margin:3px 2px; box-shadow: 0px 0px 3px rgba(0,0,0,0.33); background-color: rgba(255,255,255,0.8); border-radius: 3px;" id="KepUp_'.($a).'">
							<div class="kepuploadFile" style="position:relative;display:block;padding:0px;height:auto;">
								<div style="position:relative;text-align:center;height:155px;line-height:145px;"><img class="uploadPreview" id="'.($kepID).'UploadPreview" src="'.($uploadPreview).'" alt="'.($uploadPreview).'" onclick="$(\'#'.($kepID).'File\').click();" style="float:none;position:relative;cursor:pointer;max-height:140px;max-width:120px;vertical-align:middle;" /></div>
								<div class="kepuploadInputRow" id="'.($kepID).'InputRow">
									<input type="hidden" name="kepupload[]" id="'.($kepID).'" value="" />
									<span class="kepuploadFileName" id="'.($kepID).'FileName" onclick="$(\'#'.($kepID).'File\').click();" style="width:138px;cursor:pointer;"><span style="font-style:italic;color:#777;padding:2px 3px;">Tallózás...</span></span>
									<!--input type="button" class="admin_btn" value="Tallózás" onclick="$(\'#'.($kepID).'File\').click();" /-->
									<input class="kepuploadInputFile" type="file" accept="image/*" name="'.($kepID).'File" id="'.($kepID).'File" onchange="KepLoad($(this.form).attr(\'id\'),\''.($kepID).'\'); '.(($a<$limit)?('if(this.value) { KepLoadForm(this,'.($a+1).'); }'):('')).'" style="display:none;" />
								</div>
							</div>';
				if(count($_ENV['LANG']['ENABLED_LANG'])>1) {
					for($b=0;$b<count($_ENV['LANG']['ENABLED_LANG']);$b++) {
						$_lang = strtolower($_ENV['LANG']['ENABLED_LANG'][$b]);
						if($_lang AND $_lang!='hu') {
							$OUT .= '
								<div'.(($cimke)?(''):(' style="display:none;"')).'> <input type="text" name="ujkepcimke_'.($_lang).'[]" value="" class="typeText" minlength="3" maxlength="255" title="Cimke ['.strtoupper($_lang).']" style="width:135px;padding:2px 3px;" /> </div>';
						} else {
							$OUT .= '
								<div'.(($cimke)?(''):(' style="display:none;"')).'> <input type="text" name="ujkepcimke[]" value="" class="typeText" minlength="3" maxlength="255" title="Cimke" style="width:135px;padding:2px 3px;" /> </div>';
						}
					}
				} else {
					$OUT .= '
								<div'.(($cimke)?(''):(' style="display:none;"')).'> <input type="text" name="ujkepcimke[]" value="" class="typeText" minlength="3" maxlength="255" title="Cimke" style="width:130px;padding:2px 3px;" /> </div>';
				}
				$OUT .= '
						</div>';
			}
			$OUT .= '
					</td>
				</tr>';
		}
		if($upscr) {
			$OUT .= '
							<script type="text/javascript">
								function KepLoadForm(obj,n) {
									var allowSubmit = true;
									if(obj) {
										var validExtensions = new Array(".jpg", ".jpeg",".png");
										var file = obj.value;
										var allowSubmit = false;
										var ext = file.slice(file.lastIndexOf(".")).toLowerCase();
										for(var i = 0; i < validExtensions.length; i++) {
											if(validExtensions[i] == ext) {
												allowSubmit = true;
											}
										}
									}
									if(allowSubmit) {
										document.getElementById("KepUp_"+n).style.display="inline-block";
									} else {
										obj.value="";
										alert("Csak JPG és PNG képet lehet feltölteni!");
									}
								}
								KepLoadForm(false,'.(($kepfent)?($kepfent):(0)).');
							</script>';
		}
		return $OUT;
	}

	/* Képek törlése, az album megszünésekor */
	static function Del($id) {
		$_REQUEST['kepdel'] = Array();
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_mid`="'.($id).'" ORDER BY `kep_sorsz`');
		while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			$_REQUEST['kepdel'][] = $sor['kep_id'];
		}
		KepUP::Load($id);
	}

	/* Kép feltöltés/módosítás/törlés */
	static function Load($id) {

		if(is_array($_REQUEST['kepupload'])) { $n=0;
			$_REQUEST['kepupload'] = array_reverse($_REQUEST['kepupload']);
			for($a=0;$a<count($_REQUEST['kepupload']);$a++) {
				if(!(is_array($_REQUEST['kepupload'][$a])) AND $_REQUEST['kepupload'][$a]) {
					$_tmp_file = explode('|',$_REQUEST['kepupload'][$a]);
					if(count($_tmp_file)>=3) {
						if(!(is_array($_FILES['kepupload']))) {
							$_FILES['kepupload'] = Array();
							$_FILES['kepupload']['name'] = Array();
							$_FILES['kepupload']['type'] = Array();
							$_FILES['kepupload']['tmp_name'] = Array();
						}
						$_FILES['kepupload']['name'][$n] = $_tmp_file[0];
						$_FILES['kepupload']['type'][$n] = $_tmp_file[1];
						$_FILES['kepupload']['tmp_name'][$n] = DOCUMENT_ROOT.'/tmp/'.$_tmp_file[2].'.tmp';
						$_ENV['KepUploadMode'] = 'copy';
						$n++;
					}
				}
			}
		}

		if(!is_dir(DOCUMENT_ROOT.$_ENV['CONF']['sysKeprPath'])) { mkdir(DOCUMENT_ROOT.$_ENV['CONF']['sysKeprPath']); chmod(DOCUMENT_ROOT.$_ENV['CONF']['sysKeprPath'],0777); }
		if($id) {
			for($a=0;$a<count($_FILES['kepupload']['tmp_name']);$a++) {
				if(strstr($_FILES['kepupload']['type'][$a],'image')) {
					$ext = explode('.',$_FILES['kepupload']['name'][$a]); $ext = end($ext);
					$_reName = utf8urldecode(date('Y-m-d_H-i-s_').substr($_FILES['kepupload']['name'][$a], 0, (0 - 1 - strlen($ext))));
					$type = ($_FILES['kepupload']['type'][$a]);
					$upload_file_eredeti = $_ENV['CONF']['sysKeprPath'].$_reName.'.jpg';
					$upload_file_nagy = $_ENV['CONF']['sysKeprPath'].$_reName.$_ENV['CONF']['sysKeprNagyAttr'];
					$upload_file_norm = $_ENV['CONF']['sysKeprPath'].$_reName.$_ENV['CONF']['sysKeprKozepesAttr'];
					$upload_file_kics = $_ENV['CONF']['sysKeprPath'].$_reName.$_ENV['CONF']['sysKeprKicsiAttr'];
					if($_ENV['KepUploadMode']($_FILES['kepupload']['tmp_name'][$a], DOCUMENT_ROOT.$upload_file_eredeti)){

						$mime = getimagesize(DOCUMENT_ROOT.$upload_file_eredeti);
						$im = KepUP::convert_image(DOCUMENT_ROOT.$upload_file_eredeti,$mime['mime']);
						KepUP::resizeImage($im,$_ENV['CONF']['sysKeprNagyWidth'],$_ENV['CONF']['sysKeprNagyHeight'],DOCUMENT_ROOT.$upload_file_nagy,90,$type);
						imagedestroy($im);

						$mime = getimagesize(DOCUMENT_ROOT.$upload_file_eredeti);
						$im = KepUP::convert_image(DOCUMENT_ROOT.$upload_file_eredeti,$mime['mime']);
						KepUP::resizeImage($im,$_ENV['CONF']['sysKeprKozepesWidth'],$_ENV['CONF']['sysKeprKozepesHeight'],DOCUMENT_ROOT.$upload_file_norm,90,$type);
						imagedestroy($im);

						$mime = getimagesize(DOCUMENT_ROOT.$upload_file_eredeti);
						$im = KepUP::convert_image(DOCUMENT_ROOT.$upload_file_eredeti,$mime['mime']);
						KepUP::resizeImage($im,$_ENV['CONF']['sysKeprKicsiWidth'],$_ENV['CONF']['sysKeprKicsiHeight'],DOCUMENT_ROOT.$upload_file_kics,90,$type);
						imagedestroy($im);

						$con=mysqli_query($_ENV['MYSQLI'],'SELECT count(*) as max FROM `kepek` WHERE `kep_mid`="'.($id).'"');
						$sor=mysqli_fetch_array($con,MYSQLI_ASSOC); $uj_sorsz = ($sor['max'] + 1);

						mysqli_query($_ENV['MYSQLI'],'INSERT INTO `kepek` ( `kep_mid`, `kep_sorsz`, `kep_cimke`, `kep_cimke_en`, `kep_cimke_de`, `kep_eredeti`, `kep_nagy`, `kep_kozepes`, `kep_kicsi`, `kep_type`, `kep_name`, `kep_date` ) VALUES ( "'.($id).'", "'.($uj_sorsz).'", "'.(in_text($_REQUEST['ujkepcimke'][$a])).'", "'.(in_text($_REQUEST['ujkepcimke_en'][$a])).'", "'.(in_text($_REQUEST['ujkepcimke_de'][$a])).'", "'.(in_text($upload_file_eredeti)).'", "'.(in_text($upload_file_nagy)).'", "'.(in_text($upload_file_norm)).'", "'.(in_text($upload_file_kics)).'", "'.(in_text($_FILES['kepupload']['type'][$a])).'", "'.(in_text($_FILES['kepupload']['name'][$a])).'", now() )');
						print(mysqli_error($_ENV['MYSQLI']));
						if(is_file(fPath(DOCUMENT_ROOT.$upload_file_eredeti))) unlink(fPath(DOCUMENT_ROOT.$upload_file_eredeti));
						if($_ENV['KepUploadMode']=='copy') { if(is_file($_FILES['kepupload']['tmp_name'][$a])) unlink($_FILES['kepupload']['tmp_name'][$a]); }
					}
				}
			}
			if(is_array($_REQUEST['kepid'])) {
				for($a=0;$a<count($_REQUEST['kepid']);$a++) {
					mysqli_query($_ENV['MYSQLI'],'UPDATE `kepek` SET `kep_sorsz`="'.(in_text($_REQUEST['kep_sorsz'][$a])).'", `kep_cimke`="'.(in_text($_REQUEST['kepcimke'][$a])).'" WHERE `kep_id`="'.($_REQUEST['kepid'][$a]).'" LIMIT 1');
				}
			}
			if($_REQUEST['kepdel']) {
				for($a=0;$a<count($_REQUEST['kepdel']);$a++) {
					$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `kepek` WHERE `kep_id`="'.($_REQUEST['kepdel'][$a]).'" LIMIT 1');
					if(mysqli_num_rows($con)) {
						$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
						if(is_file(realpath(DOCUMENT_ROOT.$sor['kep_eredeti']))) unlink(realpath(DOCUMENT_ROOT.$sor['kep_eredeti']));
						if(is_file(realpath(DOCUMENT_ROOT.$sor['kep_nagy']))) unlink(realpath(DOCUMENT_ROOT.$sor['kep_nagy']));
						if(is_file(realpath(DOCUMENT_ROOT.$sor['kep_kozepes']))) unlink(realpath(DOCUMENT_ROOT.$sor['kep_kozepes']));
						if(is_file(realpath(DOCUMENT_ROOT.$sor['kep_kicsi']))) unlink(realpath(DOCUMENT_ROOT.$sor['kep_kicsi']));
						mysqli_query($_ENV['MYSQLI'],'DELETE FROM `kepek` WHERE `kep_id`="'.($_REQUEST['kepdel'][$a]).'" LIMIT 1');
						mysqli_query($_ENV['MYSQLI'],'UPDATE `kepek` SET `kep_sorsz`=( `kep_sorsz` - 1 ) WHERE `kep_mid`="'.($sor['kep_mid']).'" AND `kep_sorsz` > "'.($sor['kep_sorsz']).'"');
					}
				}
			}
		}
	}

	static function convert_image($imagetemp,$imagetype) {
		if($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg') {
			$cim1 = imagecreatefromjpeg($imagetemp);
		} elseif($imagetype == 'image/x-png' || $imagetype == 'image/png') {
			$cim1 = imagecreatefrompng($imagetemp);
			imagealphablending($cim1, false);
			imagesavealpha($cim1, true);
		} elseif($imagetype == 'image/gif') {
			$cim1 = imagecreatefromgif($imagetemp);
		}
		return $cim1;
	}

	static function resizeImage($im,$maxwidth,$maxheight,$urlandname,$comp,$imagetype) {
		$width = imagesx($im);
		$height = imagesy($im);
		if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight)) {
		if($maxwidth && $width > $maxwidth) {
			$widthratio = $maxwidth/$width;
			$resizewidth=true;
		} else {
			$resizewidth=false;
		}
		if($maxheight && $height > $maxheight) {
			$heightratio = $maxheight/$height;
			$resizeheight=true;
		} else {
			$resizeheight=false;
		}
		if($resizewidth && $resizeheight) {
			if($widthratio < $heightratio) $ratio = $widthratio;
				else $ratio = $heightratio;
			} elseif($resizewidth) {
				$ratio = $widthratio;
			} elseif($resizeheight) {
				$ratio = $heightratio;
			}
			$newwidth = $width * $ratio;
			$newheight = $height * $ratio;
			if(function_exists('imagecopyresampled') && $imagetype !='image/gif') {
				$newim = imagecreatetruecolor($newwidth, $newheight);
			} else {
				$newim = imagecreate($newwidth, $newheight);
			}
			if($imagetype == 'image/x-png' || $imagetype == 'image/png') {
				imagealphablending($newim, false);
				imagesavealpha($newim, true);
			} elseif($imagetype == 'image/gif') {
				$originaltransparentcolor = imagecolortransparent( $im );
				if($originaltransparentcolor >= 0 && $originaltransparentcolor < imagecolorstotal( $im )) {
					$transparentcolor = imagecolorsforindex( $im, $originaltransparentcolor );
					$newtransparentcolor = imagecolorallocate($newim,$transparentcolor['red'],$transparentcolor['green'],$transparentcolor['blue']);
					imagefill( $newim, 0, 0, $newtransparentcolor );
					imagecolortransparent( $newim, $newtransparentcolor );
				}
			}
			imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			if($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg') {
				imagejpeg ($newim,$urlandname,$comp);
			} elseif($imagetype == 'image/x-png' || $imagetype == 'image/png') {
				imagepng ($newim,$urlandname,substr($comp,0,1));
			} elseif($imagetype == 'image/gif') {
				imagegif ($newim,$urlandname);
			}
			imagedestroy ($newim);
		} else {
			if($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg') {
				imagejpeg ($im,$urlandname,$comp);
			} elseif($imagetype == 'image/x-png' || $imagetype == 'image/png') {
				imagepng ($im,$urlandname,substr($comp,0,1));
			} elseif($imagetype == 'image/gif') {
				imagegif ($im,$urlandname);
			}
		}
	}

	static function FixResizeImage($im,$newwidth,$newheight,$urlandname,$comp,$imagetype) {
		$width = imagesx($im);
		$height = imagesy($im);
		if(function_exists('imagecopyresampled') && $imagetype !='image/gif') {
			$newim = imagecreatetruecolor($newwidth, $newheight);
		} else {
			$newim = imagecreate($newwidth, $newheight);
		}
		if($imagetype == 'image/x-png' || $imagetype == 'image/png') {
			imagealphablending($newim, false);
			imagesavealpha($newim, true);
		} elseif($imagetype == 'image/gif') {
			$originaltransparentcolor = imagecolortransparent( $im );
			if($originaltransparentcolor >= 0 && $originaltransparentcolor < imagecolorstotal( $im )) {
				$transparentcolor = imagecolorsforindex( $im, $originaltransparentcolor );
				$newtransparentcolor = imagecolorallocate($newim,$transparentcolor['red'],$transparentcolor['green'],$transparentcolor['blue']);
				imagefill( $newim, 0, 0, $newtransparentcolor );
				imagecolortransparent( $newim, $newtransparentcolor );
			}
		}
		imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		if($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg') {
			imagejpeg ($newim,$urlandname,$comp);
		} elseif($imagetype == 'image/x-png' || $imagetype == 'image/png') {
			imagepng ($newim,$urlandname,substr($comp,0,1));
		} elseif($imagetype == 'image/gif') {
			imagegif ($newim,$urlandname);
		}
		imagedestroy ($newim);
	}

	static function KepSorrend($kep_darab,$kep_sorsz) { $out = NULL;
		for($a=1;$a<=$kep_darab;$a++) {
				$out .='
							<option value="'.$a.'"'.($kep_sorsz == $a ? (' SELECTED') : ('')).'>'.$a.'.</option>';
		}
		return $out;
	}

}
?>