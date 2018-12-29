<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV=Array(); $_ENV['SiteStart']=1;

include(realpath('../#config.php'));
include(realpath(DOCUMENT_ROOT.'/admin/#functions.php'));

/* HTML Header */
header('Content-type: text/html; charset=utf-8');
header('Content-disposition: inline; filename="reurl_jsc.php"');
header('Content-Language: '.($_ENV['HEAD']['LANG']));
webCache(-1);

if($_ENV['USER']['ss_phpsessid']==$_REQUEST['PHPSESSID'] AND $_ENV['USER']['ss_aid']>0) {
	if($_POST['table'] AND $_POST['reurl']) {
		if(function_exists($_ENV['CONF']['ReURLcontrols'][in_text($_POST['table'])])) {
			$ctr = $_ENV['CONF']['ReURLcontrols'][in_text($_POST['table'])](in_text($_POST['reurl']),in_text($_POST['table']),in_text($_POST['id']),in_text($_POST['pid']));
			print(($ctr)?(1):(0)); exit();
		} else {
			$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `reurl` WHERE `ru_reurl`="'.(in_text($_POST['reurl'])).'" AND !( `ru_elem_id`="'.(in_text($_POST['rid'])).'" ) LIMIT 1');
			if(mysqli_num_rows($con)>0) { print(1); exit(); }
		}
	}
	print(0);
}
?>