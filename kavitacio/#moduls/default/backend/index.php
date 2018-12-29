<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('default/backend',false);
$_ENV['MODS']['PURL'] = rPath('default/backend',true);

if($_REQUEST['mode']=='admin-users') {
	/* Admin felhasználok kezelése */
	include($_ENV['MODS']['PATH'].'/admin-users.php');
} elseif($_REQUEST['mode']=='default-meta') {
	/* Alapértelmezett metaadatok. */
	include($_ENV['MODS']['PATH'].'/default-meta.php');
} elseif($_REQUEST['mode']=='sys-config') {
	/* Rednszerbeállítások */
	include($_ENV['MODS']['PATH'].'/sys-config.php');
} elseif($_REQUEST['mode']=='maps') {
	/* Google térképek */
	include($_ENV['MODS']['PATH'].'/maps.php');
} elseif($_REQUEST['mode']=='forms') {
	/* Form készítő */
	include($_ENV['MODS']['PATH'].'/forms.php');
} else {
	echo'<h1>Admin Panel</h1>';
}
?>