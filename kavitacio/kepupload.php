<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV = Array(); $_ENV['SiteStart'] = 'IMAGE';

function convert_image($imagetemp,$imagetype) {
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

function resizeImage($im,$maxwidth,$maxheight,$urlandname,$comp,$imagetype) {
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


$_temp_path = $_SERVER['DOCUMENT_ROOT'].'/tmp/';
$_temp_file = md5(date('Ymdhis').rand(10000000,99999999));
$_temp_file_ext = '.tmp';
$_temp_file_expire = 3600; /* mp */

$type = strtolower($_FILES[$_GET['kepID'].'File']['type']);
$name = strtolower($_FILES[$_GET['kepID'].'File']['name']);
if(is_dir($_temp_path)) {
	if(strstr($type,'image') AND strlen($_GET['kepID'])>=3) {
		$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__);
		$_temp_file = md5(date('Ymdhis').rand(10000000,99999999));
		$upload_file_eredeti = $_temp_path.$_temp_file.$_temp_file_ext;
		$upload_file_kics = $_temp_path.$_temp_file.'_s'.$_temp_file_ext;
		if(move_uploaded_file($_FILES[$_GET['kepID'].'File']['tmp_name'], $_temp_path.$_temp_file.$_temp_file_ext)) {
			
			$mime = getimagesize($upload_file_eredeti);
			$im = convert_image($upload_file_eredeti,$mime['mime']);
			resizeImage($im,1200,1200,$upload_file_eredeti,90,$type);
			imagedestroy($im);
			
			$mime = getimagesize($upload_file_eredeti);
			$im = convert_image($upload_file_eredeti,$mime['mime']);
			resizeImage($im,150,150,$upload_file_kics,90,$type);
			imagedestroy($im);
			
			$_temp_file_data = base64_encode(file_get_contents($upload_file_kics));
			if($_temp_file_data) {
				unlink($upload_file_kics);
				$data = 'data:'.($type).';base64,'.($_temp_file_data);
				echo'
					<script type="text/javascript">
						window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").src="'.($data).'";
						window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").setAttribute("uploading","false");
						window.parent.document.getElementById("'.($_GET['kepID']).'").value="'.($name).'|'.($type).'|'.($_temp_file).'";
					</script>
				';
			} else {
				echo'
					<script type="text/javascript">
						window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").setAttribute("uploading","false");
						alert("Feltöltési adat hiba! (Size:'.$_FILES[$_GET['kepID'].'File']['size'].' / error:'.$_FILES[$_GET['kepID'].'File']['error'].')");
					</script>';
			}
		} else {
			echo'
				<script type="text/javascript">
					window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").setAttribute("uploading","false");
					alert("Feltöltési hiba!");
				</script>';
		}
	} else if($type) {
		echo'
			<script type="text/javascript">
				window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").setAttribute("uploading","false");
				alert("Rossz fáljformátum!");
			</script>';
	} else {
		echo'
			<script type="text/javascript">
				window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").setAttribute("uploading","false");
				//alert("Nincs feltöltendő kép!");
			</script>';
	}

		if($_dh = opendir($_temp_path)) {
			while(($_filename = readdir($_dh)) !== false) {
				$_file_path = realpath($_temp_path.'/'.$_filename);
				if(filetype($_file_path)=='file' AND substr($_filename,-4)=='.tmp') {
					$_file_date = filectime($_file_path);
					if(strtotime(date('Y-m-d H:i:s'))>($_file_date+$_temp_file_expire)) {
						unlink($_file_path);
					}
				}
			}
			closedir($_dh);
		}
} else {
		echo'
			<script type="text/javascript">
				window.parent.document.getElementById("'.($_GET['kepID']).'UploadPreview").setAttribute("uploading","false");
				alert("TEMP mappa nem érhető el!");
			</script>';
}
?>