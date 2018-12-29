<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV = Array(); $_ENV['SiteStart'] = 'JS';
error_reporting(0);
set_time_limit(300);
$_CookiePassword='xWhJ2g%$1x'; // /admin/login.php -ba is megadni!
$_scrip_filename = explode('/',$_SERVER["SCRIPT_FILENAME"]);
$_cookie_name = md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'].date('Ymd'));
$_cookie_value = md5($_SERVER['REMOTE_ADDR'].$_CookiePassword.$_SERVER['DOCUMENT_ROOT'].date('Ymd'));
//if($_COOKIE[$_cookie_name] != $_cookie_value AND !strstr(end($_scrip_filename),'upload_') AND !strstr(end($_scrip_filename),'.js.php')) { exit(); }

/* DocumentRoot */
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../../../').'/';
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
include(realpath(DOCUMENT_ROOT.'/#parse_ini.php'));
$ini_file = realpath(DOCUMENT_ROOT.'/#config.ini');

if(is_file($ini_file)) {
	$ini_array = Ini_Struct::parse($ini_file);
	if($ini_array) { $_ENV = ((function_exists('array_replace_recursive'))?(array_replace_recursive($_ENV, $ini_array)):(array_merge_recursive($_ENV, $ini_array))); }
}

/* MySQLi Kapcsolat */
if(!$_ENV['MYSQLI'] = mysqli_connect($_ENV['CONF']['SQL']['HOST'],$_ENV['CONF']['SQL']['USER'],$_ENV['CONF']['SQL']['PASS'])) die ('<b>MySQL CONNECT HIBA!</b>');
if(!mysqli_select_db($_ENV['MYSQLI'],$_ENV['CONF']['SQL']['DB'])) die ('<b>MySQL DB HIBA!</b>');
mysqli_query($_ENV['MYSQLI'],'SET NAMES utf8');
$_ENV['sql'] = $_ENV['SQL'] = $_ENV['mysql'] = $_ENV['MySQL'] = $_ENV['MYSQL'] = $_ENV['mysqli'] = $_ENV['MySQLi'] = $_ENV['MYSQLI'];

$con = mysqli_query($_ENV['MYSQLI'],'
	SELECT *
	FROM `sessions`
	LEFT JOIN `admin_users`
		ON `ss_aid`=`u_id`
	WHERE `ss_aid`=`u_id`
		AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"
		AND `u_status`="A"
	LIMIT 1');

if(mysqli_num_rows($con)==0 AND !strstr(end($_scrip_filename),'.js.php')) { exit(); }

function remove_accent($str) {
	$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','Ļ','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','Ż','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǎ','ǎ','Ǐ','ǐ','Ǒ','ǒ','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ǻ','ǻ','Ǽ','ǽ','Ǿ','ǿ');
	$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
	return str_replace($a, $b, $str);
}
function upload_string($str) {
	$str = strtolower(preg_replace(array('/[^a-zA-Z0-9\-\.\/\_ -]/','/[ -]+/','/^-|-$/'), array('-','-','-'), remove_accent($str)));
	for($a=0;(strstr($str,'--') AND $a<100);$a++) { $str = str_replace('--','-',$str); }
	return $str;
}

$tinybrowser = array();
$tinybrowser['language'] = 'hu';
$tinybrowser['integration'] = 'tinymce'; // Possible values: 'tinymce','fckeditor'
$tinybrowser['docroot'] = rtrim($_SERVER['DOCUMENT_ROOT'],'/');
$tinybrowser['unixpermissions'] = 0755;

$tinybrowser['path']['image'] = '/files/images/'; // Image files location - also creates a '_thumbs' subdirectory within this path to hold the image thumbnails
$tinybrowser['path']['media'] = '/files/media/'; // Media files location
$tinybrowser['path']['file']  = '/files/files/'; // Other files location

$tinybrowser['link']['image'] = $tinybrowser['path']['image']; // Image links
$tinybrowser['link']['media'] = $tinybrowser['path']['media']; // Media links
$tinybrowser['link']['file']  = $tinybrowser['path']['file']; // Other file links

$tinybrowser['maxsize']['image'] = 0; // Image file maximum size
$tinybrowser['maxsize']['media'] = 0; // Media file maximum size
$tinybrowser['maxsize']['file']  = 0; // Other file maximum size

// Image automatic resize on upload (0 is no resize)
$tinybrowser['imageresize']['width']  = 1200;
$tinybrowser['imageresize']['height'] = 1000;

$tinybrowser['thumbsrc'] = 'path'; // Possible values: path, link

// Image thumbnail size in pixels
$tinybrowser['thumbsize'] = 80;

// Image and thumbnail quality, higher is better (1 to 99)
$tinybrowser['imagequality'] = 90; // only used when resizing or rotating
$tinybrowser['thumbquality'] = 90;

// Date format, as per php date function
$tinybrowser['dateformat'] = 'd/m/Y H:i';

// Permitted file extensions
$tinybrowser['filetype']['image'] = '*.jpg, *.jpeg, *.gif, *.png'; // Image file types
$tinybrowser['filetype']['media'] = '*.swf, *.dcr, *.mov, *.qt, *.mpg, *.mp3, *.mp4, *.mpeg, *.avi, *.wmv, *.wm, *.asf, *.asx, *.wmx, *.wvx, *.rm, *.ra, *.ram'; // Media file types
$tinybrowser['filetype']['file']  = '*.*'; // Other file types

// Prohibited file extensions
$tinybrowser['prohibited'] = array('php','php3','php4','php5','phps','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi','sh','py','asa','asax','config','com','inc');

// Default file sort
$tinybrowser['order']['by']   = 'name'; // Possible values: name, size, type, modified
$tinybrowser['order']['type'] = 'asc'; // Possible values: asc, desc

// Default image view method
$tinybrowser['view']['image'] = 'thumb'; // Possible values: thumb, detail

// File Pagination - split results into pages (0 is none)
$tinybrowser['pagination'] = 0;

// TinyMCE dialog.css file location, relative to tinybrowser.php (can be set to absolute link)
$tinybrowser['tinymcecss'] = '../../themes/advanced/skins/default/dialog.css';

// TinyBrowser pop-up window size
$tinybrowser['window']['width']  = 770;
$tinybrowser['window']['height'] = 480;

// Assign Permissions for Upload, Edit, Delete & Folders
$tinybrowser['allowupload']  = true;
$tinybrowser['allowedit']    = true;
$tinybrowser['allowdelete']  = true;
$tinybrowser['allowfolders'] = true;

// Clean filenames on upload
$tinybrowser['cleanfilename'] = true;

// Set default action for edit page
$tinybrowser['defaultaction'] = 'delete'; // Possible values: delete, rename, move

// Set delay for file process script, only required if server response is slow
$tinybrowser['delayprocess'] = 0; // Value in seconds
?>
