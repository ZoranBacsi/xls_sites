<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu" lang="hu">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Filepdiesel, Filep, diesel, service, center, diesel service, diesel center, szerviz, Filep Diesel Service, Filep Diesel Szerviz, Filep Diesel Center" />
		<meta name="description" lang="hu" content="diesel adagolók bevizsgálása, javítása, diesel diagnosztikai vizsgálat, diesel porlasztók bevizsgálása, javítása" />
		<title>Filep Diesel Center &copy;</title>
		<!--[if lte IE 6]>
			<script type="text/javascript">
				window.location = "http://www.microsoft.com/windows/downloads/ie/getitnow.mspx"
			</script>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="filepdiesel.css" />
		<style type="text/css">
			@import url(almenu.css);
		</style>
		<meta name="author" content="muphrid" />
	</head>

<?php

require_once("db.php");

if (isset($_GET['altip'])) {
	$altip = $_GET['altip'];
	$inc = $db[$altip]['html'];
	$cim = $db[$altip]['cim'];

}else if (isset($_GET['tip'])) {
	$tip = $_GET['tip'];
	$inc = $db[$tip]['html'];
	$cim = $db[$tip]['cim'];

} else if (isset($_GET['almenu'])) {
	$almenu = $_GET['almenu'];
	$inc = $db[$almenu]['html'];
	$cim = $db[$almenu]['cim'];

} else if (isset($_GET['menu'])) {
	$menu = $_GET['menu'];
	$inc = $db[$menu]['html'];
	$cim = $db[$menu]['cim'];
} else {
	$menu = "cegtortenet";
	$inc = $db[$menu]['html'];
	$cim = $db[$menu]['cim'];
}

?>

	<body>
		<div id="container">
			<div id="header">
				<img src="img/logo.png" alt="FILEPdiesel" />
			</div>
			<div id="menu">
				<?php
				require_once("menu.php");
				?>
			</div>
			<?php
			if (isset($_GET['menu']) && $_GET['menu'] == "tevekenyseg") {
			?>
			<div id="almenu">
			<?php
				require_once("almenu.php");
			?>
			</div>
			<?php
			}
			?>
			<div id="content">
				<div id="c_top">
					<h1><?php print $cim; ?></h1>
				</div>
				<div id="c_inc">
					<?php
					include $inc;
					?>
				</div>
				<div id="c_bottom">
				</div>
			</div>
			<div id="footer">
				muphrid&copy; 2007-2009
			</div>
		</div>
	</body>
</html>