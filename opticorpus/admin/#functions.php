<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['SITE']['ADMIN'] = true;
$_ENV['AdminPage'] = 'body';
$_ENV['MOD_MENU'] = Array();

/* Nyilvánoról kikommentelve */
$_ENV['HEAD']['CSS'] = Array();
$_ENV['HEAD']['JAVA'] = Array();
$ini_file = DOCUMENT_ROOT.'/admin/#config.ini';
if(is_file($ini_file)) {
	$ini_array = Ini_Struct::parse($ini_file);
	if($ini_array) { $_ENV = ((function_exists('array_replace_recursive'))?(array_replace_recursive($_ENV, $ini_array)):(array_merge_recursive($_ENV, $ini_array))); }
}

$_ENV['CONF']['htmlTextaInsert'] = Array();
$_ENV['CONF']['ReURLcontrols'] = Array();

/* Funkciók betőltése! */
if(is_dir(FUNCTIONS_ROOT)) {
	if($_dh = opendir(FUNCTIONS_ROOT)) {
		$functions = Array();
		while(($_file = readdir($_dh)) !== false) {
			if(filetype(realpath(FUNCTIONS_ROOT.'/'.$_file))=='file'
				AND substr($_file,-4)=='.php'
				AND substr($_file,0,1)!='.'
				AND substr($_file,0,1)!='!'
				AND substr($_file,0,1)!='#') {
				$functions[] = (realpath(FUNCTIONS_ROOT.'/'.$_file));
			}
		}
		closedir($_dh);
		sort($functions);
		foreach($functions as $includ) { include($includ); }
	}
}

if(!$_REQUEST['oldal']) { $_REQUEST['oldal'] = $_GET['oldal'] = $_POST['oldal'] = $oldal = 'default'; }

load_lang_file(DOCUMENT_ROOT.'/admin/dic/'.(strtolower($_SESSION['LANG'])).'.ini');

function xSorrend($darab,$sorsz) { return sOptions($sorsz,1,$darab); }
function sOptions($n,$s,$e) { $out='';
	for($a=$s;$a<=$e;$a++) { $out .='<option value="'.($a).'"'.(($a==$n)?(' SELECTED'):('')).'>'.($a).'</option>'; }
	return $out;
}

include(realpath(DOCUMENT_ROOT.'/admin/#logins.php'));

if($_ENV['USER']['ss_phpsessid']==$_REQUEST['PHPSESSID'] AND $_ENV['USER']['ss_aid']>0
	AND mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "modul"'))) {
	$modulLoadCon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `modul` GROUP BY `mod_path` ORDER BY `mod_index` DESC');
	while($modulLoadSor=mysqli_fetch_array($modulLoadCon,MYSQLI_ASSOC)) {
		/* Modul Globális funkciói */
		if(is_file(realpath(MODULS_ROOT.'/'.$modulLoadSor['mod_path'].'/func.php'))) {
			include(realpath(MODULS_ROOT.'/'.$modulLoadSor['mod_path'].'/func.php'));
		}
		/* Modul Backend funkciói */
		if(is_file(realpath(MODULS_ROOT.'/'.$modulLoadSor['mod_path'].'/backend/func.php'))) {
			include(realpath(MODULS_ROOT.'/'.$modulLoadSor['mod_path'].'/backend/func.php'));
		}
	}

	/* REDIRECT URL EGYEZTETÉSE ADATBÁZISSAL */
	if($_REQUEST['oldal']) {
		$con = mysqli_query($_ENV['MYSQLI'],'
				SELECT *
				FROM `modul`
				WHERE `mod_path`="'.($_REQUEST['oldal']).'"
				LIMIT 1');
		if(mysqli_num_rows($con)>0) {
			$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
			$_ENV['SITE']['MODUL'] = $sor['mod_id'];
			$_ENV['SYSTEM']['MODUL'] = $sor['mod_id'];
			$_ENV['SYSTEM']['MPATH'] = $sor['mod_path'].'/backend/';
			$_ENV['SYSTEM']['MPHPAF'] = '/index.php';
			$_ENV['HIBA-404']=false;
		}
	}

	ob_start();
		/* Tartalom betöltése! */
		if($_ENV['SYSTEM']['PAGE']) { print($_ENV['SYSTEM']['PAGE']); } else {
			if(is_file(realpath(MODULS_ROOT.'/'.$_ENV['SYSTEM']['MPATH'].$_ENV['SYSTEM']['MPHPAF']))) {
				include(realpath(MODULS_ROOT.'/'.$_ENV['SYSTEM']['MPATH'].$_ENV['SYSTEM']['MPHPAF']));
			}
		}
		/***********************/
		$_ENV['SYSTEM']['PAGE'] = ob_get_contents();
	ob_end_clean();

}

?>