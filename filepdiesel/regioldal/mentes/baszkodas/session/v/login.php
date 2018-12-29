<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu" lang="hu">
<head>
	<title>login baszkódás</title>
	<meta id="Author" content="muphrid" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta id="Description" content="login" />
	<link rel="stylesheet" href="login.css" type="text/css" />
</head>
<body>

<?php
if (isset($_POST['mehet'])) {
	$host = "localhost";
	$user = "root";
	$db = "muphrid";
	
	$kapcsolat = mysql_connect($host, $user) or die ("Nem tudok csatlakozni az adatbázishoz...");
	mysql_select_db("muphrid") or die ("Nem sikerült kiválasztani az adatbázist...");

	$query = "SELECT * FROM passwd WHERE user = '" . $_POST['user'] . "' AND passwd = '" . md5($_POST['passwd']) . "'";
	$eredmeny = mysql_query($query, $kapcsolat);
	if (mysql_num_rows($eredmeny) === 1) {
		$row = mysql_fetch_assoc($eredmeny);
		session_start();
		$_SESSION['user'] = $row['user'];
		header("Location: admin.php");
	}
	mysql_close($kapcsolat);
	mysql_free_result($eredmeny);
} else {
?>

	<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
		<div>
			<label for="user">Username: </label>
			<input type="text" name="user" id="user" />
		</div>
		<div>
			<label for="passwd">Password: </label>
			<input type="password" name="passwd" id="passwd" />
		</div>
		<div>
			<input type="submit" name="mehet" id="mehet" />
		</div>
	</form>
</body>
</html>

<?php ;} ?>