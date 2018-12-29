<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
class lang {
	static function out_replace($tomb,$pref,$text) {
		$Array = Array();
		$resultat = preg_match_all("/\{".(($pref)?($pref."\:"):(''))."((\d|[a-zA-Z\-\_\.])+?)\}/i", $text, $Array, PREG_PATTERN_ORDER);
		//$Array = array_map("unserialize", array_unique(array_map("serialize", $Array)));
		for($i=0;$i<count($Array[0]);$i++) {
			if($tomb[$Array[1][$i]]===0) { $text = str_replace($Array[0][$i],$tomb[$Array[1][$i]],$text); }
			if($tomb[$Array[1][$i]] AND !is_array($tomb[$Array[1][$i]])) {
				$text = str_replace($Array[0][$i],$tomb[$Array[1][$i]],$text);
			}
			if($tomb[strtolower($Array[1][$i])] AND !is_array($tomb[strtolower($Array[1][$i])])) {
				$text = str_replace($Array[0][$i],$tomb[strtolower($Array[1][$i])],$text);
			}
			if($tomb[strtoupper($Array[1][$i])] AND !is_array($tomb[strtoupper($Array[1][$i])])) {
				$text = str_replace($Array[0][$i],$tomb[strtoupper($Array[1][$i])],$text);
			}
		}
		if($last=='' AND $pref) { $text = preg_replace("/\{".($pref)."\:((\s|.)+?)\}/", "", $text); }
		return $text;
	}
	static function out($text) {
		if(!is_array($text)AND!is_object($text)) {
			$text = lang::out_replace($_REQUEST,'request',$text);
			$text = lang::out_replace($_REQUEST,'REQUEST',$text);
			$text = lang::out_replace($_REQUEST,'requ',$text);
			$text = lang::out_replace($_REQUEST,'REQU',$text);
			$text = lang::out_replace($_REQUEST,'req',$text);
			$text = lang::out_replace($_REQUEST,'REQ',$text);
			$text = lang::out_replace($_POST,'post',$text);
			$text = lang::out_replace($_POST,'POST',$text);
			$text = lang::out_replace($_GET,'get',$text);
			$text = lang::out_replace($_GET,'GET',$text);
			$text = lang::out_replace($_ENV['HEAD'],'head',$text);
			$text = lang::out_replace($_ENV['HEAD'],'HEAD',$text);
			$text = lang::out_replace($_ENV['CONF'],'conf',$text);
			$text = lang::out_replace($_ENV['CONF'],'CONF',$text);
			$text = lang::out_replace($_ENV['SITE'],'site',$text);
			$text = lang::out_replace($_ENV['SITE'],'SITE',$text);
			$text = lang::out_replace($_ENV['LANG'],'lang',$text);
			$text = lang::out_replace($_ENV['LANG'],'LANG',$text);
			$text = lang::out_replace($_ENV['LANG'],false,$text);
			$text = lang::out_replace($_ENV['FIX'],'fix',$text);
			$text = lang::out_replace($_ENV['FIX'],'FIX',$text);
		} else if(is_array($text)) {
			$names = array_keys($text);
			for ($a=0;$a<count($names);$a++) {
				$text[$names[$a]] = lang::out($text[$names[$a]]);
			}
		}
		return $text;
	}
	
	static function load_file($path) { $ini_array = false;
		if($_ENV['SiteStart']=='HTML' OR $_ENV['SiteStart']=='AJAX' OR $_ENV['SiteStart']=='JSON' OR $_ENV['SiteStart']=='1') {
			if(is_file($path)) {
				$ini_array = Ini_Struct::parse($path, true);
			} else if(is_file(substr($path,0,-6).'hu.ini')) {
				$ini_array = Ini_Struct::parse(substr($path,0,-6).'hu.ini', true);
			}
			if($ini_array) {
				$_ENV = ((function_exists('array_replace_recursive'))?(array_replace_recursive($_ENV, $ini_array)):(array_merge_recursive($_ENV, $ini_array)));
			}
		}
	}
	
}

function out_lang($text) { return lang::out($text); }
function load_lang_file($path) { return lang::load_file($path); }

function SelectLang($lang) {
	$_selected = false;
	if(is_file(DOCUMENT_ROOT.'#dic/'.(strtolower($lang)).'.ini')) {
		$_SESSION['LANG'] = strtolower($lang);
	} else {
		$_SESSION['LANG'] = 'hu';
	}
}

if(isset($_REQUEST['lang'])) {
	SelectLang($_REQUEST['lang']);
} else if(strlen($_ENV['REURL'][1]) == 2) {
	SelectLang($_ENV['REURL'][1]);
} else {
	SelectLang($_SESSION['LANG']);
}



if($_ENV['SiteStart']=='HTML' OR $_ENV['SiteStart']=='AJAX' OR $_ENV['SiteStart']=='JSON' OR $_ENV['SiteStart']=='1') {
	/* Szótár fájlok lekérése, nyelvek beazonosítása */
	if(is_dir(DOCUMENT_ROOT.'#dic')) {
		if($_dh = opendir(DOCUMENT_ROOT.'#dic')) {
			$_ENV['LANGS'] = Array();
			while(($_file = readdir($_dh)) !== false) {
				if(filetype(realpath(DOCUMENT_ROOT.'#dic/'.$_file))=='file'
					AND strlen($_file)==6
					AND substr($_file,-4)=='.ini'
					AND substr($_file,0,1)!='.'
					AND substr($_file,0,1)!='!'
					AND substr($_file,0,1)!='#') {
					$_ENV['LANGS'][] = substr($_file,0,2);
				}
			}
			closedir($_dh);
			if(!is_array($_ENV['LANG']['ENABLED_LANG']) OR !count($_ENV['LANG']['ENABLED_LANG'])>=1) { $_ENV['LANG']['ENABLED_LANG'] = $_ENV['LANGS']; }
		}
	}
	if($_SESSION['LANG']) {
		load_lang_file(DOCUMENT_ROOT.'#dic/'.(strtolower($_SESSION['LANG'])).'.ini');
		$_ENV['HEAD']['REQUEST_URI'] = str_replace('/'.($_SESSION['LANG']).'/', '', $_SERVER['REQUEST_URI']);
	}
}
?>