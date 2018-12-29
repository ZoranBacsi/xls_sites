<html>
<head>
    <title>Ismerösök</title>
</head>
<body>
    <form action="<?php print $_SERVER['PHP_SELF']; ?> " name="urlap" method="post">
	<p>Vezetéknév: <input type="text" name="veznev" size="20"></p>
	<p>Keresztnév: <input type="text" name="kernev" size="20"></p>
	<p>Irányítószám: <input type="text" name="irsz" size="20"></p>
	<p>Város: <input type="text" name="varos" size="20"></p>
	<p>Cím: <input type="text" name="cim" size="20"></p>
	<p>Telefon: <input type="text" name="tel" size="20"></p>
	<p>e-mail: <input type="text" name="mail" size="20"></p>
	<p><input type="submit" name="ok" value="Mehet"></p>
    </form>
    <p>
	<?php
	    if (isset($_POST['ok']))
	    {
		if (strlen($_POST['veznev'])!=0 AND strlen($_POST['kernev'])!=0 AND strlen($_POST['irsz'])!=0 AND strlen($_POST['varos'])!=0 AND strlen($_POST['cim'])!=0 AND strlen($_POST['tel'])!=0 AND strlen($_POST['mail'])!=0)
		{
		    $filename="file/adatok.txt";
		    if ( ! file_exists($filename)) touch ($filename);
		    $adatok=fopen("$filename","a");
		    $text=$_POST['veznev'] . "-" . $_POST['kernev'] . "-" . $_POST['irsz'] . "-" . $_POST['varos'] . "-" . $_POST['cim'] . "-" . $_POST['tel'] . "-" . $_POST['mail'] . "\n";
		    fwrite($adatok,$text);
		    fclose($adatok);
		} else print "<p>" . "Nem adtál meg minden adatot!" . "</p>";
	    }
	?>
    </p>
    <p>
	<?php
	    $filename="file/adatok.txt";
	    if (file_exists($filename))
	    {
		$adatok=fopen("$filename","r");
		while (! feof($adatok))
		{
		    print "<p>" . fgets($adatok) . "</p>";
		}
		fclose($adatok);  
	    }
	?>
    </p>
</body>
</html>