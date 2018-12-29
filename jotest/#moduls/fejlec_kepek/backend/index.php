<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('fejlec_kepek/backend',false);
$_ENV['MODS']['PURL'] = rPath('fejlec_kepek/backend',true);

$_ENV['F_KEP'] = Array();
$_ENV['F_KEP']['PATH'] = fPath('/files/fejlec_kepek/');
$_ENV['F_KEP']['fPATH'] = fPath(DOCUMENT_ROOT.$_ENV['F_KEP']['PATH']);
isDir($_ENV['F_KEP']['fPATH'],true);

$_ENV['KEPRESIZE'] = Array();
$_ENV['KEPRESIZE']['FILE_A'] = '.jpg';
$_ENV['KEPRESIZE']['NAGY_A'] = '_l.jpg';
$_ENV['KEPRESIZE']['NAGY_W'] = $_ENV['CONF']['fksKepFixWidth'];
$_ENV['KEPRESIZE']['NAGY_H'] = $_ENV['CONF']['fksKepFixHeight'];
$_ENV['KEPRESIZE']['NORM_A'] = '_m.jpg';
$_ENV['KEPRESIZE']['NORM_W'] = round($_ENV['CONF']['fksKepFixWidth']/10);
$_ENV['KEPRESIZE']['NORM_H'] = round($_ENV['CONF']['fksKepFixHeight']/10);
echo'
					<h1>Fejléc képeinek szerkesztése</h1>';
if($_REQUEST['rogzit']) {
	if($_REQUEST['kepupload']) {
		if(!(is_array($_REQUEST['kepupload'])) AND $_REQUEST['kepupload']) {
			$_tmp_file = explode('|',$_REQUEST['kepupload']);
			if(count($_tmp_file)>=3) {
				if(!(is_array($_FILES['kepupload']))) {	$_FILES['kepupload'] = Array();	}
				$_FILES['kepupload']['name'] = $_tmp_file[0];
				$_FILES['kepupload']['type'] = $_tmp_file[1];
				$_FILES['kepupload']['tmp_name'] = DOCUMENT_ROOT.'/tmp/'.$_tmp_file[2].'.tmp';
				$_ENV['KepUploadMode'] = 'copy';
			}
		}
	}
	if(!$_FILES['kepupload']['name']) {
		echo'<span style="color: #ff0000;">Hiányos kitöltés!</span><br><br>';
	} else {
		if(strstr($_FILES['kepupload']['type'],'image')) {
			$_kepupname = explode('.',$_FILES['kepupload']['name']);
			$_ENV['KEPRESIZE']['FILE'] = utf8urldecode(date('Y-m-d_H-i-s_').substr($_FILES['kepupload']['name'], 0, (0 - 1 - strlen(end($_kepupname)))));
			$type = ($_FILES['kepupload']['type']);
			$upload_file_eredeti = fPath($_ENV['KEPRESIZE']['FILE'].$_ENV['KEPRESIZE']['FILE_A']);
			$upload_file_norm = fPath($_ENV['KEPRESIZE']['FILE'].$_ENV['KEPRESIZE']['NAGY_A']);
			$upload_file_kics = fPath($_ENV['KEPRESIZE']['FILE'].$_ENV['KEPRESIZE']['NORM_A']);
			if($_ENV['KepUploadMode']($_FILES['kepupload']['tmp_name'], fPath($_ENV['F_KEP']['fPATH'].$upload_file_eredeti))){
				$mime = getimagesize($_ENV['F_KEP']['fPATH'].$upload_file_eredeti);
				$im = KepUP::convert_image($_ENV['F_KEP']['fPATH'].$upload_file_eredeti,$mime['mime']);
				KepUP::FixResizeImage($im,$_ENV['KEPRESIZE']['NAGY_W'],$_ENV['KEPRESIZE']['NAGY_H'],$_ENV['F_KEP']['fPATH'].$upload_file_norm,90,$type);
				imagedestroy($im);
				$mime = getimagesize($_ENV['F_KEP']['fPATH'].$upload_file_eredeti);
				$im = KepUP::convert_image($_ENV['F_KEP']['fPATH'].$upload_file_eredeti,$mime['mime']);
				KepUP::FixResizeImage($im,$_ENV['KEPRESIZE']['NORM_W'],$_ENV['KEPRESIZE']['NORM_H'],$_ENV['F_KEP']['fPATH'].$upload_file_kics,90,$type);
				imagedestroy($im);
				if(mysqli_query($_ENV['MYSQLI'],'INSERT INTO `fejlec_kepek` ( `fk_status`, `fk_sorszam`, `fk_url`, `fk_kep_kicsi`, `fk_kep_nagy` ) values ("A", "999", "'.$add_fk_url.'","'.$upload_file_kics.'","'.$upload_file_norm.'")')) {
					echo'<span style="color: #00aa00;">A beszúrás megtörtént!</span><br><br>';
				} else {
					echo'<span style="color: #ff0000;">A beszúrás nem sikerült!</span><br><br>';
					unlink(fPath($_ENV['F_KEP']['fPATH'].$upload_file_kics));
					unlink(fPath($_ENV['F_KEP']['fPATH'].$upload_file_norm));
				}
				unlink(fPath($_ENV['F_KEP']['fPATH'].$upload_file_eredeti));
			} else {
				echo'<span style="color: #ff0000;">Kép feltöltése sikertelen!</span><br><br>';
			}
		} else {
			echo'<span style="color: #ff0000;">Csak képet lehet feltölteni!</span><br><br>';
		}
	}
}

if($update) {
	for($a=0;$a<count($fk_id);$a++) {
		mysqli_query($_ENV['MYSQLI'],'UPDATE `fejlec_kepek` SET `fk_url`="'.$fk_url[$a].'", `fk_sorszam`="'.$fk_sorszam[$a].'" WHERE `fk_id`="'.$fk_id[$a].'"');
	}
	if($a>0) { echo'<span style="color: #00aa00;">A módosítás megtörtént!</span><br><br>'; }
	for($a=0;$a<count($fk_delete);$a++) {
		$con=mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `fejlec_kepek` WHERE `fk_id`="'.$fk_delete[$a].'"');
		if($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
			if(mysqli_query($_ENV['MYSQLI'],'DELETE FROM `fejlec_kepek` WHERE `fk_id`="'.$fk_delete[$a].'"')) {
				unlink(fPath($_ENV['F_KEP']['fPATH'].$sor['fk_kep_kicsi']));
				unlink(fPath($_ENV['F_KEP']['fPATH'].$sor['fk_kep_nagy']));
			}
		}
	}
	if($a>0) { echo'<span style="color: #00aa00;">A törlés megtörtént!</span><br><br>'; }
}

echo'
	<form name="fejlec_kepek" action="?oldal='.($_REQUEST['oldal']).'" onsubmit="return FormControlMode(1);" method="POST">
		<input type="hidden" name="update" value="1" />
	<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
		<tr class="fejlec"><th colspan="4">Feltöltött fejléc képek</th> </tr>
		<tr>
			<td style="width: 40px;"><b>Kép</b></td>
			<td><b>URL</b></td>
			<td width="40"><b>Sorrend</b></td>
			<td style="width: 70px;"><b>Töröl</b></td>
		</tr>';
	
	$con=mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `fejlec_kepek` ORDER BY `fk_sorszam`');
	$fk_darab = mysqli_num_rows($con);
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $i++;
		echo'
		<input name="fk_id['.($i-1).']" type="hidden" value="'.$sor['fk_id'].'">
		<tr class="'.(($i/2==round($i/2))?(''):('cella')).'">
			<td><a href="'.(fPath($_ENV['F_KEP']['PATH'].$sor['fk_kep_nagy'])).'" class="highslide" onclick="return hs.expand(this,{wrapperClassName: \'highslide-no-border\', dimmingOpacity: 0.75, align: \'center\'})" ajaxdefine="true"><img src="'.(fPath($_ENV['F_KEP']['PATH'].$sor['fk_kep_kicsi'])).'" style="height:20px;border:0px;margin:0px 5px;padding:0px;" /></a></td>
			<td><input class="smallinput" type="textbox" name="fk_url['.($i-1).']" value="'.$sor['fk_url'].'" style="width: 500px;"></td>
			<td><select class="fk_sorszam" name="fk_sorszam['.($i-1).']" onfocus="$(this).attr(\'oldValue\',$(this).val());" onchange="var thisValue=$(this).val(); zSorszam(thisValue,$(this).attr(\'oldValue\'),\'fk_sorszam\'); this.value=thisValue; $(this).attr(\'oldValue\',$(this).val());" style="width:75px;">'.(xSorrend($fk_darab,$i)).'</select></td>
			<td><input class="checkbox" type="checkbox" name="fk_delete[]" value="'.$sor['fk_id'].'" _onclick="if(this.checked) { if(confirm(\'Biztosan törlöd?\')) { this.checked = true; } else { this.checked = false; } }"></td>
		</tr>
		';
	}

$uploadPreview = '/images/noimage.png';
$kepID = 'kepupload';
echo'
			<tr class="fejlec"><td colspan="2">&nbsp;</td><td><input class="admin_btn" type="submit" name="fk_mod_sbmt" value="Rögzít" style="width:75px;" /></td><td colspan="3">&nbsp;</td></tr>
		</table>
	</form>
	<script type="text/javascript">
		function FormControlMode(xa) {
			$("#MyBody").attr("edited",null);
			return true;
		}
	</script>
	<br/><br/>
	<form name="add_fk" id="add_fk" action="?oldal='.($_REQUEST['oldal']).'" method="POST" onsubmit="return FormControlUP(1);" enctype="multipart/form-data">
		<input type="hidden" name="rogzit" value="1" />
		<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">
			<tr class="fejlec"><th colspan="3">Új fejléc kép feltöltése</th> </tr>
			<tr>
				<td><b>Kép <small>('.($_ENV['KEPRESIZE']['NAGY_W']).'x'.($_ENV['KEPRESIZE']['NAGY_H']).'px)</small>:</b></td>
				<td>
					<div class="kepuploadFile">
						<img class="uploadPreview" id="'.($kepID).'UploadPreview" src="'.($uploadPreview).'" alt="'.($uploadPreview).'" />
						<div class="kepuploadInputRow" id="'.($kepID).'InputRow">
							<span class="kepuploadFileName" id="'.($kepID).'FileName"></span>
							<input type="button" class="admin_btn" value="Tallózás" />
							<input class="kepuploadInputFile" type="file" accept="image/*" name="'.($kepID).'File" id="'.($kepID).'File" onchange="KepLoad($(this.form).attr(\'id\'),\''.($kepID).'\');" />
							<input type="hidden" name="kepupload" id="'.($kepID).'" value="" />
						</div>
						<div> <input type="text" name="add_fk_url" value="" style="width: 215px;" /> </div>
					</div>
				</td>
				<td style="width: 75px;"><input style="width: 60px;" class="admin_btn" type="submit" name="add_fk_sbmt" value="Mehet" /></td>
			</tr>
		</table>
	</form>
	<script type="text/javascript">
		function FormControlUP(xa) {
			$("#MyBody").attr("edited",null);
			return true;
		}
	</script>';
?>