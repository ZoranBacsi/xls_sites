<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
//error_reporting(0);
/* INI_Set Beállítások! */
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_path', '/');
ob_start('ob_gzhandler');
session_start();

/* DocumentRoot */
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__)).'/';
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('FUNCTIONS_ROOT',realpath(DOCUMENT_ROOT.'/#functions').'/');
define('PAGEAS_ROOT',realpath(DOCUMENT_ROOT.'/#pages').'/');
define('MODULS_ROOT',realpath(DOCUMENT_ROOT.'/#moduls').'/');

include(realpath(DOCUMENT_ROOT.'/#parse_ini.php'));

$_ENV['SITE'] = $_ENV['CONF'] = $_ENV['HEAD'] = $_ENV['LANG'] = Array();
$_ENV['HEAD']['HOST'] = strtolower($_SERVER['HTTP_HOST']);
$_ENV['CONF']['HOST'] = strtolower($_SERVER['HTTP_HOST']);
$_ENV['HEAD']['URI'] = str_replace(Array('.ajax','.json'),'.html',$_SERVER['REQUEST_URI']);
$_ENV['SITE']['PAGE'] = NULL;

$ini_file = DOCUMENT_ROOT.'/#config.ini';
if(is_file($ini_file)) {
	$ini_array = Ini_Struct::parse($ini_file);
	if($ini_array) { $_ENV = ((function_exists('array_replace_recursive'))?(array_replace_recursive($_ENV, $ini_array)):(array_merge_recursive($_ENV, $ini_array))); }
}

if(!$_ENV['CONF']['THEME'] OR !is_dir(DOCUMENT_ROOT.'/themes/'.$_ENV['CONF']['THEME'])) { $_ENV['CONF']['THEME'] = 'default'; }
$_ENV['CONF']['themePath'] = '/themes/'.$_ENV['CONF']['THEME'];
$_ENV['CONF']['ReLoad'] = 604800;

/* MySQLi Kapcsolat */
if($_ENV['CONF']['SQL']['HOST'] AND $_ENV['CONF']['SQL']['USER'] AND $_ENV['CONF']['SQL']['PASS'] AND $_ENV['CONF']['SQL']['DB']) {
	if($_ENV['MYSQLI'] = mysqli_connect($_ENV['CONF']['SQL']['HOST'],$_ENV['CONF']['SQL']['USER'],$_ENV['CONF']['SQL']['PASS'])) {
		$_SERVER['MYSQLI']=true;
		mysqli_select_db($_ENV['MYSQLI'],$_ENV['CONF']['SQL']['DB']);
		mysqli_query($_ENV['MYSQLI'],'SET NAMES utf8');
		$_ENV['sql'] = $_ENV['SQL'] = $_ENV['mysql'] = $_ENV['MySQL'] = $_ENV['MYSQL'] = $_ENV['mysqli'] = $_ENV['MySQLi'] = $_ENV['MYSQLI'];

		if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "sys_config"'))) {
			$con = mysqli_query($_ENV['MYSQLI'],'
				SELECT *
				FROM `sys_config`
				LEFT JOIN `sys_config_pack`
					ON `cfp_pref` = `cf_pack`
				ORDER BY `cfp_index` DESC, `cf_pack` ASC, `cf_id` ASC');
			while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
				$_ENV['CONF'][$sor['cf_code']]=$sor['cf_value'];
			} unSet($con); unSet($sor);
		}
	}
}

/* e-mail beállítások */
if($_ENV['CONF']['sysMailMode']) { $_ENV['CONF']['MAIL']['MODE'] = $_ENV['CONF']['sysMailMode']; } /* SMTP / PHP */
if($_ENV['CONF']['sysMailName']) { $_ENV['CONF']['MAIL']['NAME'] = $_ENV['CONF']['sysMailName']; }
if($_ENV['CONF']['sysMailAddress']) { $_ENV['CONF']['MAIL']['MAIL'] = $_ENV['CONF']['sysMailAddress']; }

/* SMTP KAPCSOLÓDÁSHOZ! */
$_ENV['CONF']['SMTP']['MYDOMAIN'] = strtolower($_SERVER['HTTP_HOST']);
if($_ENV['CONF']['sysMailSmtpProt']) { $_ENV['CONF']['SMTP']['KAPCSOLAT'] = $_ENV['CONF']['sysMailSmtpProt']; } // tcp, ssl, sslv2, sslv3, tls
if($_ENV['CONF']['sysMailSmtpHost']) { $_ENV['CONF']['SMTP']['SERVER'] = $_ENV['CONF']['sysMailSmtpHost']; }
if($_ENV['CONF']['sysMailSmtpPort']) { $_ENV['CONF']['SMTP']['PORT'] = $_ENV['CONF']['sysMailSmtpPort']; } // 25, 465, 587
if($_ENV['CONF']['sysMailSmtpUser']) { $_ENV['CONF']['SMTP']['USER'] = $_ENV['CONF']['sysMailSmtpUser']; }
if($_ENV['CONF']['sysMailSmtpPass']) { $_ENV['CONF']['SMTP']['PASS'] = $_ENV['CONF']['sysMailSmtpPass']; }
/* SMTP ADAT VÉGE */

?>