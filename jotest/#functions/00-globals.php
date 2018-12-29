<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

function fileWrite($file,$data,$open=false) {
	if(is_file($file) AND $open) { $_data = file_get_contents($file); }
	$fh = fopen($file, 'w');
		fwrite($fh, ($_data.$data));
	fclose($fh);
}

function stripslashes_deep($s) {
	if(get_magic_quotes_gpc()) {
		$s = ((is_array($s))?(array_map('stripslashes_deep', $s)):(stripslashes($s)));
	}
	return $s;
}

function in_get($s) {
	$s = stripslashes_deep($s);
	if(!is_array($s)AND!is_object($s)) {
		$s = str_replace("→", "", $s);
		$s = str_replace("\\0", "", $s);
		$s = str_replace("\\Z", "", $s);
		$s = str_replace("\x00", "", $s);
		$s = str_replace("\x1a", "", $s);
		$s = str_replace(chr(0), "", $s);
		$s = str_replace(chr(26), "", $s);
	}
	return $s;
}

function in_text($s) {
	if(!is_array($s)AND!is_object($s)) {
		$s = in_get($s);
		$s = htmlspecialchars_decode($s);
		$s = str_replace(Array('Õ', 'õ', 'Û', 'û', "\r", "\n", "\t"), Array('Ő', 'ő', 'Ű', 'ű', ' ', ' ', ' '), $s);
		for($a=0;strstr($s,'  ');$a++) { $s = str_replace('  ',' ',$s); }
		if(substr($s,-1)==' ') { $s = substr($s,0,-1); }
		if(substr($s,0,1)==' ') { $s = substr($s,1); }
		$s = htmlspecialchars($s, ENT_IGNORE);
		$s = str_replace(Array('{','}'),Array('&#123;','&#125;'),$s);
	}
	return $s;
}

function in_html($s) {
	if(!is_array($s)AND!is_object($s)) {
		$s = in_get($s);
		
		isDir(DOCUMENT_ROOT.'/files/images');
		$_srcImg = Array();
		$resultat = preg_match_all("(<[Ii]{1}[Mm]{1}[Gg]{1} [^>]{0,}[Ss]{1}[Rr]{1}[Cc]{1}=[\"'<>]{0,1}([^\"'=<>]{1,})[\"'<> ]{0,1}[^>]{0,}>)", $s, $_srcImg, PREG_PATTERN_ORDER);
		for($i = 0; $i < count($_srcImg[1]); $i++) {
			$src = $_srcImg[1][$i];
			if(substr($src,0,5)=='data:' AND strstr($src,'image/')) {
				$_src = explode(':',$src);
				$_src = explode(';',$_src[1]);
				$type = $_src[0];
				$_src = explode(',',$_src[1]);
				$data = base64_decode($_src[1]);
				$url = '/files/images/'.(date('Y-m-d_H-i-s')).'_('.($i).').jpg';
				fileWrite(DOCUMENT_ROOT.$url.'.tmp.jpg',$data,false);
				$mime = getimagesize(DOCUMENT_ROOT.$url.'.tmp.jpg');
				$im = KepUP::convert_image(DOCUMENT_ROOT.$url.'.tmp.jpg',$mime['mime']);
				KepUP::resizeImage($im,600,600,DOCUMENT_ROOT.$url,80,$type);
				imagedestroy($im);
				unlink(DOCUMENT_ROOT.$url.'.tmp.jpg');
				$s = str_replace($src,$url,$s);
			}
		}
		
		$s = str_replace(Array('Õ', 'õ', 'Û', 'û'), Array('Ő', 'ő', 'Ű', 'ű'), $s);
		$s = htmlspecialchars($s, ENT_IGNORE);
		$s = htmlspecialchars_decode($s);
		$s = addslashes($s);
	}
	return $s;
}

function out_text($s) {
	if(!is_array($s)AND!is_object($s)) {
		$s = nl2br($s);
	}
	return $s;
}

function out_html($s) {
	if(!is_array($s)) {
		$s = str_replace('mce:script', 'script', $s);
		$s = str_replace('_mce_bogus=&quot;1&quot;', '/', $s);
		$s = str_replace('../', '/', $s);
		$s = stripslashes($s);
		foreach($_ENV['OutFunc'] as $value) { $s=((function_exists($value))?($value($s)):($s)); }
	}
	return $s;
}

function out_header($s,$type=NULL) {
	$s = in_get($s);
	$s = strip_tags($s);
	$s = str_replace(Array('Õ', 'õ', 'Û', 'û', "\r", "\n", "\t"), Array('Ő', 'ő', 'Ű', 'ű', ' ', ' ', ' '), $s);
	for($a=0;strstr($s,'  ');$a++) { $s = str_replace('  ',' ',$s); }
	if(substr($s,-1)==' ') { $s = substr($s,0,-1); }
	if(substr($s,0,1)==' ') { $s = substr($s,1); }
	if(!$type OR strtoupper($type)=='H1' OR strtoupper($type)=='TITLE') {
		$s = mb_substr($s,0,90);
	} else if(strtoupper($type)=='KEYWORDS') {
		$in = explode(' ',str_replace(',','',$s));
		$s = join(', ',$in);
	} else if(strtoupper($type)=='DESCRIPTION') { $s = mb_substr($s,0,250); }
	else { $s = mb_substr($s,0,250); }
	return $s;
}

function fPath($path) {
	$path = str_replace(array('\\','//'),'/',$path);
	return $path;
}

function rPath($modul,$url) { $path=null;
	$path = fPath((MODULS_ROOT).'/'.($modul).'/');
	if($url) {
		$path = fPath(str_replace(fPath(DOCUMENT_ROOT),'/',$path));
		$path = str_replace('#','%23',$path);
	}
	return $path;
}

function RePost($tomb,$no,$_name='') { return ReInput($tomb,$no,$_name); }
function ReInput($tomb,$no,$_name='') { $_out=null;
	if(!is_array($tomb)) { $tomb = $_POST; }
	if(!is_array($no)) { $no = Array(); }
	$name = array_keys($tomb);
	for($a=0;$a<count($name);$a++) {
		if( !(in_array($name[$a],$no) OR strlen($name[$a])==0) AND $tomb[$name[$a]] ) {
			if(!is_array($tomb[$name[$a]])) {
				$out .= '<input type="hidden" name="'.(($_name)?($_name.'['.($name[$a]).']'):($name[$a])).'" value="'.(in_text($tomb[$name[$a]])).'" />';
			} else {
				$out .= ReInput($tomb[$name[$a]],$no,(($_name)?($_name.'['.($name[$a]).']'):($name[$a])));
			}
		}
	}
	return $out;
}

function ReGet($tomb,$no,$_name='') { $_out=null;
	if(!is_array($tomb)) { $tomb = $_GET; }
	$name = array_keys($tomb);
	for($a=0;$a<count($name);$a++) {
		if( ( !in_array($name[$a],$no) OR $name[$a]==0 ) AND $tomb[$name[$a]] ) {
			if(!is_array($tomb[$name[$a]])) {
				$out .= '&'.(($_name)?($_name.'['.($name[$a]).']'):($name[$a])).'='.(in_text($tomb[$name[$a]])).'';
			} else {
				$out .= ReGet($tomb[$name[$a]],$no,(($_name)?($_name.'['.($name[$a]).']'):($name[$a])));
			}
		}
	}
	return $out;
}

function out_site($txt) {
	$Array = Array();
	$resultat = preg_match_all("/\{php:(([0-9a-zA-Z$()<>=`~_.,+*!%&|';:\?\	\ \-\"\/[\]\/\\\])+?)\}/", $txt, $Array, PREG_PATTERN_ORDER);
	//$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
	for($i=0;$i<count($Array[0]);$i++) {
		if($Array[1][$i]) {
			ob_start();
				eval('print '.$Array[1][$i].';');
				$_out_eval = ob_get_contents();
			ob_end_clean();
			$txt = str_replace($Array[0][$i],$_out_eval,$txt);
		}
	}
	
	$Array = Array();
	$resultat = preg_match_all("/\{php\}((\s|.)+?)\{\/php\}/", $txt, $Array, PREG_PATTERN_ORDER);
	//$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
	for($i=0;$i<count($Array[0]);$i++) {
		if($Array[1][$i]) {
			ob_start();
				eval('print '.$Array[1][$i].';');
				$_out_eval = ob_get_contents();
			ob_end_clean();
			$txt = str_replace($Array[0][$i],$_out_eval,$txt);
		}
	}
	
	foreach($_ENV['SiteFunc'] as $value) { $txt=((function_exists($value))?($value($txt)):($txt)); }
	
	$txt = out_lang(out_lang($txt));
	return $txt;
}

function isDir($dir,$cpHtc=false) {
	if(!is_dir($dir)) {
		mkdir($dir,0755);
		if($cpHtc AND is_file(realpath($dir.'/../').'/.htaccess')) {
			copy(realpath($dir.'/../').'/.htaccess',realpath($dir).'/.htaccess');
		}
		if($cpHtc AND is_file(realpath($dir.'/../').'/index.html')) {
			copy(realpath($dir.'/../').'/index.html',realpath($dir).'/index.html');
		}
	}
}

if( !function_exists('apache_request_headers') ) {
	function apache_request_headers() {
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach($_SERVER as $key => $val) {
			if( preg_match($rx_http, $key) ) {
				$arh_key = preg_replace($rx_http, '', $key);
				$rx_matches = array();
				$rx_matches = explode('_', $arh_key);
				if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
					foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}
		return( $arh );
	}
}

function webCache($time) {
	$timestamp = time();
	$etag = md5($timestamp);
	$tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
	$headers = apache_request_headers();
	header("Last-Modified: ".$tsstring);
	header("ETag: \"{$etag}\"");
	header('Expires: Thu, 01-Jan-70 00:00:01 GMT');
	if(isset($headers['If-Modified-Since'])) {
		if(intval(time()) - intval(strtotime($headers['If-Modified-Since'])) < $time) {
			header('HTTP/1.1 304 Not Modified');
			exit();
		}
	}
}

function formatSizeUnits($bytes) {
	if($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2, '.', ' ').' GB';
	} else if($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2, '.', ' ').' MB';
	} else if($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2, '.', ' ').' KB';
	} else if($bytes > 0) {
		$bytes = number_format($bytes, 0, '.', ' ').' B';
	} else {
		$bytes = '0 B';
	}
	return $bytes;
}

/* Cookie méretének túl méretezésének megakadályozása */
$n=0;
foreach($_COOKIE as $key => $value) { $n++;
	if(($n>30 AND strlen($key)==32 AND strlen($value)==32) OR $n>50) {
		unset($_COOKIE[$key]);
		setcookie($key, null, -1, '/');
	}
}

function in_opt($s) {
	$s = strtolower($s);
	if($s=='yes' OR $s == 'y' OR $s == 'igen' OR $s == 'i' OR $s == 1 OR $s === true ) { return true; }
	return false;
}

$_REQUEST = in_get($_REQUEST);
$_SESSION = in_get($_SESSION);
$_COOKIE = in_get($_COOKIE);
$_POST = in_get($_POST);
$_GET = in_get($_GET);

$_REQUEST = ((function_exists('array_replace_recursive'))?(array_replace_recursive($_REQUEST, $_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER)):($_REQUEST));
extract($_REQUEST, EXTR_PREFIX_INVALID, 'x');

if($_REQUEST['PHPSESSID']) { setcookie('PHPSESSID', $_REQUEST['PHPSESSID'], time() + 3600, '/'); }
else if($_COOKIE['PHPSESSID']) {$_REQUEST['PHPSESSID'] = $_COOKIE['PHPSESSID']; }

$_ENV['OutFunc'] = Array(); /* HTML kimenetet formázások tömbje */
$_ENV['SiteFunc'] = Array(); /* Site formázások tömbje */
?>