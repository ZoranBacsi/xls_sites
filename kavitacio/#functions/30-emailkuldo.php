<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
class eMail {
	static function eMailSend($from_name, $from_mail, $to_name, $to_mail, $subject, $massage, $file) {
		$from_mail = $_ENV['CONF']['MAIL']['MAIL'];
		$massage = str_replace("\r\n","\n",$massage);
	$massage = str_replace("\r", "\n", $massage);
	while(strstr($massage,"\n\n")) { $massage = str_replace("\n\n", "\n", $massage); }

		$_ENV['SMTP_CMD'] = NULL;
		$_MAIL = Array();
		$_MAIL['multipart_boundary'] = '==Multipart_Boundary_x'.(md5(uniqid(mt_rand(), 1))).'x';
		$csatol = '';
		$_MAIL['llistaobjectes'] = array();
		$_MAIL['llistalinks'] = array();
		$resultat = preg_match_all("(<[Ii]{1}[Mm]{1}[Gg]{1} [^>]{0,}[Ss]{1}[Rr]{1}[Cc]{1}=[\"'<>]{0,1}([^\"'=<>]{1,})[\"'<> ]{0,1}[^>]{0,}>)", $massage, $_MAIL['llistalinks'], PREG_PATTERN_ORDER);
		for($i = 0; $i < count($_MAIL['llistalinks'][1]); $i++) { $_MAIL['llistaobjectes'][] = $_MAIL['llistalinks'][1][$i]; }
		$_MAIL['llistalinks'] = array();
		$resultat = preg_match_all("(<[Ee]{1}[Mm]{1}[Bb]{1}[Ee]{1}[Dd]{1} [^>]{0,}[Ss]{1}[Rr]{1}[Cc]{1}=[\"'<>]{0,1}([^\"'=<>]{1,})[\"'<> ]{0,1}[^>]{0,}>)", $massage, $_MAIL['llistalinks'], PREG_PATTERN_ORDER);
		for($i = 0; $i < count($_MAIL['llistalinks'][1]); $i++) { $_MAIL['llistaobjectes'][] = $_MAIL['llistalinks'][1][$i]; }
		for($a = 0; $a < count($_MAIL['llistaobjectes']); $a++) {
			$ext = end(explode('.', $_MAIL['llistaobjectes'][$a]));
			$massage = str_replace($_MAIL['llistaobjectes'][$a], 'cid:'.(eMail::str_cid($_MAIL['llistaobjectes'][$a])), $massage);
			$open_file = file($_SERVER['DOCUMENT_ROOT'].$_MAIL['llistaobjectes'][$a]);
			$file_adat = '';
			for($b = 0; $b < count($open_file); $b++) {
				$file_adat .= $open_file[$b];
			}
			$csatol .= "\n".'--{'.($_MAIL['multipart_boundary']).'}'."\n".'Content-Type: '.(eMail::mime($ext)).'; name="'.(eMail::str_cid($_MAIL['llistaobjectes'][$a])).'"'."\n".'Content-Transfer-Encoding: base64'."\n".'Content-ID: <'.(eMail::str_cid($_MAIL['llistaobjectes'][$a])).'>'."\n".'Content-Disposition: inline; filename="'.(eMail::str_cid($_MAIL['llistaobjectes'][$a])).'"'."\n".(chunk_split(base64_encode($file_adat)))."\n";
		}
		if(is_array($file)) {
			for($a = 0; $a < count($file); $a++) {
				$fp = fopen($file[$a], 'rb');
				$data = chunk_split(base64_encode(fread($fp, filesize($file[$a]))));
				fclose($fp);
				$csatol .= "\n".'--{'.($_MAIL['multipart_boundary']).'}'."\n".'Content-Type: '.(eMail::mime(end(explode('.', $file[$a])))).'; name="'.eMail::str_cid((end(explode('/', $file[$a])))).'"'."\n".'Content-Transfer-Encoding: base64'."\n".'Content-ID: <'.(eMail::str_cid(end(explode('/', $file[$a])))).'>'."\n".'Content-Disposition: attachment; filename="'.eMail::str_cid((end(explode('/', $file[$a])))).'"'."\n".$data.'."\n".'.'--{'.($_MAIL['multipart_boundary']).'}--'."\n";
			}
			$content_type = 'Content-Type: multipart/mixed; boundary="{'.($_MAIL['multipart_boundary']).'}"; type="text/html"';
		} else if($file) {
			$fp = fopen($file, 'rb');
			$data = chunk_split(base64_encode(fread($fp, filesize($file))));
			fclose($fp);
			$csatol .= "\n".'--{'.($_MAIL['multipart_boundary']).'}'."\n".'Content-Type: '.(eMail::mime(end(explode('.', $file)))).'; name="'.eMail::str_cid((end(explode('/', $file)))).'"'."\n".'Content-Transfer-Encoding: base64'."\n".'Content-ID: <'.(eMail::str_cid(end(explode('/', $file)))).'>'."\n".'Content-Disposition: attachment; filename="'.eMail::str_cid((end(explode('/', $file)))).'"'."\n".$data.'."\n".'.'--{'.($_MAIL['multipart_boundary']).'}--'."\n";
			$content_type = 'Content-Type: multipart/mixed; boundary="{'.($_MAIL['multipart_boundary']).'}"; type="text/html"';
		} else {
			$content_type = 'Content-Type: multipart/related; boundary="{'.($_MAIL['multipart_boundary']).'}"; type="text/html"';
		}
		$_MAIL['masage'] = $massage."\n".$csatol;
		if($_ENV['CONF']['MAIL']['MODE'] == 'PHP') {
			$_MAIL['head'] = 'From: '.(eMail::str_bMail($from_name)).' <'.$from_mail.'>'."\n".'Return-Path: <'.$from_mail.'>'."\n".'MIME-Version: 1.0'."\n".''.$content_type.''."\n".'--{'.($_MAIL['multipart_boundary']).'}'."\n".'Content-Type: text/html; charset = "UTF-8"'."\n".'Content-Transfer-Encoding: 8bit'."\n";
			if(mail($to_mail, eMail::str_bMail($subject), $_MAIL['masage'], $_MAIL['head'])) {
				return true;
			} else {
				return false;
			}
		} else if($_ENV['CONF']['MAIL']['MODE'] == 'SMTP') {
			$_MAIL['head'] = 'From: '.(eMail::str_bMail($from_name)).' <'.$from_mail.'>'."\n".'Return-Path: <'.$from_mail.'>'."\n".'Subject: '.(eMail::str_bMail($subject)).''."\n".'MIME-Version: 1.0'."\n".''.$content_type.''."\n".'--{'.($_MAIL['multipart_boundary']).'}'."\n".'Content-Type: text/html; charset = "UTF-8"'."\n".'Content-Transfer-Encoding: 8bit'."\n";
			if(eMail::mail_send($to_mail, $from_mail, $_MAIL['head'].$_MAIL['masage'])) {
				return true;
			} else {
				return false;
			}
		}
	}
	static function mime($ext) {
		$ext = strtolower($ext);
		switch ($ext) {
			case 'zip': $ctype = 'application/zip'; break;
			case 'exe': $ctype = 'application/octet-stream'; break;
			case 'doc': $ctype = 'application/msword'; break;
			case 'xls': $ctype = 'application/vnd.ms-excel'; break;
			case 'bmp': $ctype = 'image/bmp'; break;
			case 'pdf': $ctype = 'application/pdf'; break;
			case 'gif': $ctype = 'image/gif'; break;
			case 'png': $ctype = 'image/png'; break;
			case 'jpg': $ctype = 'image/jpg'; break;
			case 'jpeg': $ctype = 'image/jpg'; break;
			case 'txt': $ctype = 'text/plain'; break;
			case 'tar': $ctype = 'application/x-tar'; break;
			case 'png': $ctype = 'image/png'; break;
			case 'ico': $ctype = 'image/x-icon'; break;
			default: $ctype = 'application/force-download';
		}
		return $ctype;
	}
	static function cmd($str, $report = true) {
		$ret = fwrite($_ENV['SMTP_CMD'], $str."\n");
		if($report === true) { fread($_ENV['SMTP_CMD'], 256); }
	}
	static function mail_send($to, $from, $mail) {
		$_ENV['SMTP_CMD'] = NULL;
		$_ENV['SMTP_CMD'] = fsockopen((($_ENV['CONF']['SMTP']['KAPCSOLAT']).'://'.($_ENV['CONF']['SMTP']['SERVER'])), ($_ENV['CONF']['SMTP']['PORT']), $errno, $errstr);
		if(!$_ENV['SMTP_CMD']) { return false; }
		fread($_ENV['SMTP_CMD'], 256);
		eMail::cmd('EHLO '.($_ENV['CONF']['SMTP']['MYDOMAIN']));
		if($_ENV['CONF']['SMTP']['USER']AND $_ENV['CONF']['SMTP']['PASS']) {
			eMail::cmd('AUTH LOGIN');
			eMail::cmd(base64_encode($_ENV['CONF']['SMTP']['USER']));
			eMail::cmd(base64_encode($_ENV['CONF']['SMTP']['PASS']));
		}
		eMail::cmd('MAIL FROM: <'.($from).'>');
		eMail::cmd('RCPT TO: <'.($to).'>');
		eMail::cmd('DATA');
		eMail::cmd($mail, false);
		eMail::cmd('.');
		eMail::cmd('QUIT');
		fclose($_ENV['SMTP_CMD']);
		unSet($_ENV['SMTP_CMD']);
		return true;
	}
	static function str_cid($s) {
		$s = str_replace(Array('/', '\\', "'", '"', ':', ';', '?', '=', ','), Array('_', '_', '_', '_', '_', '_', '_', '_'), end(explode('/', $s)));
		return $s;
	}
	static function str_bMail($s) {
		$s = urlencode($s);
		$s = str_replace('%', '=', $s);
		$s = str_replace('+', '=20', $s);
		return '=?utf-8?Q?'.($s).'?=';
	}
}
?>