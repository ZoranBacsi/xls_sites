<html>
<head>
    <title>
	file
    </title>
</head>
<body>
    <form enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?> " name="urlap" method="post">
	<p><input type="file" name="feltolt"></p>
	<p><input type="submit" name="ok" value="oké, feltöltöm"></p>
    </form>
</body>
</html>
<?php
if (isset($_FILES['feltolt']))
    {
	print "Név: " .  $_FILES['feltolt']['name'] . "<br>";
	print "Méret: " . $_FILES['feltolt']['size'] . "<br>";
	print "Ideiglenes név: " . $_FILES['feltolt']['tmp_name'] . "<br>";
	print "Típus: " . $_FILES['feltolt']['type'] . "<br>";
	print "Hiba: " . $_FILES['feltolt']['error'] . "<br>";
    }

if ($_FILES['feltolt']['error']) print "Hiba: " . $_FILES['feltolt']['error'] . "<br>";
else
    {
	$forras=$_FILES['feltolt']['tmp_name'];
	$cel="feltoltes/" . $_FILES['feltolt']['name'];
	move_uploaded_file($forras,$cel);
    }

if (substr($_FILES['feltolt']['type'],0,5)=="image")
    {
	print "<img src=\"feltoltes/" . $_FILES['feltolt']['name'] . "\">";
    }
?>