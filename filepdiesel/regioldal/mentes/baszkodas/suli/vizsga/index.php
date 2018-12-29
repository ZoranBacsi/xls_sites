<html>
<head>
    <title>ZH</title>
</head>
<body>
    <form name="rajzol" action="<?php print $_SERVER['PHP_SELF'];?> " method="get">
	Ezt a számot rajzoljuk ki: <input type="text" maxlength="8" <?php if (isset($_GET['szam']) AND strlen($_GET['szam'] > 1)) print "value=" . $_GET['szam']; ?>  name="szam" />
	<input type="submit" name="rajzol" />
    </form>
<?php
    if (isset($_GET['rajzol']))
    {
	$szam = $_GET['szam'];
	if (strlen($szam) < 1) {
	    print "<p>Nem írtál be számot!</p>";
	} else {
	    //	Kéne egy ciklus, ami karakterenként egy tömbbe rakja a szám elemeit
	    for ($a=0; $a<=strlen($szam); $a++)
	    {
		$elemek[$a] = substr($szam, $a, 1);
		if ($elemek[$a] != 0 AND $elemek[$a] != 1) print "<p>A megadott szám nem bináris!</p>";
	    }
	    $file = "file";
	    $handle = fopen($file, "w");
	    fwrite($handle, $szam);
	    fclose($handle);
	    print "<img src=\"sin.php\" />";
	}
    }
?>
</body>
</html>