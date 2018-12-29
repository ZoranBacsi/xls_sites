<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

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

/* Statikus lapokhoz definiálni a PageURL -t. */
$_ENV['PAGE_URL'] = join('/',$_ENV['REURL']);

/* Adatbázis készítő script */
if($_ENV['REURL'][1]=='installer' OR $_ENV['REURL'][1]=='installer.html'
OR $_ENV['REURL'][1]=='installer.php' OR parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH)=='/installer.php') {
	ob_start();
	include(realpath(DOCUMENT_ROOT.'/#installer.php'));
		$_ENV['SITE']['PAGE'] = ob_get_contents();
	ob_end_clean();
	$_ENV['REURL'] = Array();
}

/* Modul rendszerhez default modul meghatározása, URL értelmezése */
$_ENV['parentReurl'] = ((count($_ENV['REURL'])>=3)?($_ENV['REURL'][count($_ENV['REURL'])-2]):($_SESSION['LANG']));
if(!$_ENV['CONF']['def_modul']) { $_ENV['CONF']['def_modul'] = 'szmenu'; }
if(!$_ENV['REURL'][1]) { $_ENV['REURL'][1]=$_ENV['CONF']['def_modul']; $_ENV['REURL'][2]='index'; }

if($_SERVER['MYSQLI']) {
	/* Funkciók betöltése */
	if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "modul"'))) {
		$mcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `modul` ORDER BY `mod_index` DESC');
		while($msor=mysqli_fetch_array($mcon,MYSQLI_ASSOC)) {
			/* Modul Globális funkciói */
			if(is_file(realpath(MODULS_ROOT.'/'.$msor['mod_path'].'/func.php'))) {
				include(realpath(MODULS_ROOT.'/'.$msor['mod_path'].'/func.php'));
			}
			/* Modul Frontend funkciói */
			if(is_file(realpath(MODULS_ROOT.'/'.$msor['mod_path'].'/frontend/func.php'))) {
				include(realpath(MODULS_ROOT.'/'.$msor['mod_path'].'/frontend/func.php'));
			}
		}
	}

	if($_ENV['SiteStart']=='HTML' OR $_ENV['SiteStart']=='AJAX' OR $_ENV['SiteStart']=='JSON' OR $_ENV['SiteStart']=='1') {

		/* Statikus Oldalk betöltése */
		if(!(strlen($_ENV['SITE']['PAGE'])>0)) {
			ob_start();
				if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "modul"')) AND !(strlen($_ENV['SITE']['PAGE'])>0)) {
					$con = mysqli_query($_ENV['MYSQLI'],'
							SELECT *
							FROM `modul`
							WHERE `mod_path`="default"
							LIMIT 1');
					if(mysqli_num_rows($con)>0) {
						$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
						if($sor['mod_h1_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['H1'] = out_header($sor['mod_h1_'.(strtolower($_SESSION['LANG']))],'H1'); }
						else if($sor['mod_h1']) { $_ENV['HEAD']['H1'] = out_header($sor['mod_h1'],'H1'); }
						if($sor['mod_title_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['TITLE'] = out_header($sor['mod_title_'.(strtolower($_SESSION['LANG']))],'TITLE'); }
						else if($sor['mod_title']) { $_ENV['HEAD']['TITLE'] = out_header($sor['mod_title'],'TITLE'); }
						if($sor['mod_keyw_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['mod_keyw_'.(strtolower($_SESSION['LANG']))],'KEYWORDS'); }
						else if($sor['mod_keyw']) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['mod_keyw'],'KEYWORDS'); }
						if($sor['mod_desc_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['mod_desc_'.(strtolower($_SESSION['LANG']))],'DESCRIPTION'); }
						else if($sor['mod_desc']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['mod_desc'],'DESCRIPTION'); }
					}
				}
				if(is_file(PAGEAS_ROOT.($_ENV['PAGE_URL']).'.php')) {
					include(PAGEAS_ROOT.($_ENV['PAGE_URL']).'.php');
				} else if(is_file(PAGEAS_ROOT.($_ENV['PAGE_URL']).'/index.php')) {
					include(PAGEAS_ROOT.($_ENV['PAGE_URL']).'/index.php');
				}
				$_ENV['SITE']['PAGE'] = ob_get_contents();
			ob_end_clean();
		}

		/* Moduláris oldalak betöltés */
		if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "modul"')) AND !(strlen($_ENV['SITE']['PAGE'])>0)) {

			/* Rövid URL kiértékelése */
			if($_ENV['REURL'][1]) {
				$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `modul` WHERE `mod_path`="'.(in_text($_ENV['REURL'][1])).'" LIMIT 1');
				if(mysqli_num_rows($con)==0 AND $_ENV['REURL'][2]) {
					$con = mysqli_query($_ENV['MYSQLI'],'
									SELECT `modul`.*
									FROM `reurl` AS `a`
									LEFT JOIN `reurl` AS `p`
										ON `p`.`ru_modul`=`a`.`ru_modul`
									LEFT JOIN `modul`
										ON `mod_id`=`a`.`ru_modul`
									WHERE `mod_id`=`a`.`ru_modul`
										AND `p`.`ru_modul`=`a`.`ru_modul`
										AND `p`.`ru_reurl`="'.($_ENV['parentReurl']).'"
										AND `a`.`ru_reurl`="'.(end($_ENV['REURL'])).'"
										AND `a`.`ru_modul`>0
										AND `p`.`ru_modul`>0
									LIMIT 1');
				} if(mysqli_num_rows($con)==0 AND !$_ENV['REURL'][2]) {
					$con = mysqli_query($_ENV['MYSQLI'],'
									SELECT `modul`.*
									FROM `reurl`
									LEFT JOIN `modul`
										ON `mod_id`=`ru_modul` AND `mod_path`="'.($_ENV['CONF']['def_modul']).'"
									WHERE `ru_modul`=`ru_modul`
										AND `mod_path`="'.($_ENV['CONF']['def_modul']).'"
										AND `ru_reurl`="'.(end($_ENV['REURL'])).'"
										AND `ru_modul`>0
									LIMIT 1');
				}
				if(mysqli_num_rows($con)==0) {
					$con = mysqli_query($_ENV['MYSQLI'],'
									SELECT `modul`.*
									FROM `reurl`
									LEFT JOIN `modul`
										ON `mod_id`=`ru_modul`
									WHERE `ru_reurl`="'.(end($_ENV['REURL'])).'"
										AND `ru_modul`>0
									LIMIT 1');
				}
				if(mysqli_num_rows($con)>0) {
					$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
					$_ENV['SYSTEM']['MODUL'] = $sor['mod_id'];
					$_ENV['SYSTEM']['MPATH'] = $sor['mod_path'].'/frontend/';
					$_ENV['SYSTEM']['MPHPWF'] = '/index.php';
					$_ENV['SYSTEM']['CONSTURE'] = $sor['mod_path'].'_ReUrlConstrue';
					if($sor['ru_h1']) { $_ENV['HEAD']['H1'] = out_header($sor['ru_h1'],'H1'); }
					else if($sor['mod_h1_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['H1'] = out_header($sor['mod_h1_'.(strtolower($_SESSION['LANG']))],'H1'); }
					else if($sor['mod_h1']) { $_ENV['HEAD']['H1'] = out_header($sor['mod_h1'],'H1'); }
					if($sor['ru_title']) { $_ENV['HEAD']['TITLE'] = out_header($sor['ru_title'],'TITLE'); }
					else if($sor['mod_title_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['TITLE'] = out_header($sor['mod_title_'.(strtolower($_SESSION['LANG']))],'TITLE'); }
					else if($sor['mod_title']) { $_ENV['HEAD']['TITLE'] = out_header($sor['mod_title'],'TITLE'); }
					if($sor['ru_keyw']) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['ru_keyw'],'KEYWORDS'); }
					else if($sor['mod_keyw_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['mod_keyw_'.(strtolower($_SESSION['LANG']))],'KEYWORDS'); }
					else if($sor['mod_keyw']) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['mod_keyw'],'KEYWORDS'); }
					if($sor['ru_desc']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['ru_desc'],'DESCRIPTION'); }
					else if($sor['mod_desc_'.(strtolower($_SESSION['LANG']))]) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['mod_desc_'.(strtolower($_SESSION['LANG']))],'DESCRIPTION'); }
					else if($sor['mod_desc']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['mod_desc'],'DESCRIPTION'); }
					if(function_exists($_ENV['SYSTEM']['CONSTURE'])) { $_ENV['SYSTEM']['CONSTURE'](); }
				}

				ob_start();
					/* Tartalom betöltése! */
					if($_ENV['SYSTEM']['PAGE']) { print($_ENV['SYSTEM']['PAGE']); } else {
						if(is_file(realpath(MODULS_ROOT.'/'.$_ENV['SYSTEM']['MPATH'].$_ENV['SYSTEM']['MPHPWF']))) {
							include(realpath(MODULS_ROOT.'/'.$_ENV['SYSTEM']['MPATH'].$_ENV['SYSTEM']['MPHPWF']));
						}
					}
					/***********************/
					$_ENV['SITE']['PAGE'] = ob_get_contents();
				ob_end_clean();
			}
		}

		/* Nincs találat 404! */
	if(!(strlen($_ENV['SITE']['PAGE'])>0) AND !($_ENV['SYSTEM']['MODUL'])) {
		if($_ENV['SiteStart']!='AJAX' AND $_ENV['SiteStart']!='JSON') {
			header('HTTP/1.0 404 Not Found',$replace=false,404);
		}
		ob_start();
			include(DOCUMENT_ROOT.'/404.php');
			$_ENV['SITE']['PAGE'] = ob_get_contents();
		ob_end_clean();
	} else if(!(strlen($_ENV['SITE']['PAGE'])>0)) { $_ENV['HEAD']['INDEX'] = 'N'; }

		if(!$_ENV['HEAD']['H1']) { $_ENV['HEAD']['H1'] = $_ENV['HEAD']['TITLE']; }

	}
	
}

if(!$_COOKIE['cookiePolicy']) {
	header_remove('Set-Cookie');
	$_ENV['SITE']['sysCookieAlert'] .= '<div id="cookiePolicy"><div id="cookiePolicycontent">{cookiePolicyText}<input type="button" id="cookiePolicybutton" value="{cookiePolicyButton}" onclick="cookiePolicy(1);" /></div></div>';
}
?>