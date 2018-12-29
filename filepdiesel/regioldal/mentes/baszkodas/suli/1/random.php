<html>
<head>
    <title>
	Randomcucc
    </title>
</head>
<body>
    <form name="random" action"<?php print $_SERVER['PHP_SELF']; ?>" method="post">
    Tipp: <input type="text" size="10" name="tipp">

<?php 
if (isset($_POST["tipp"]))
{
    $tipp=$_POST["tipp"];

    if ($a==$tipp)
    {
	print("Ügyes vagy, eltaláltad! :)");
    }
    
    else
    {
	print("Nem talált, tippelj tovább!");
    }
    
}
else
{
    $a=rand(1,10);
    
}
?>
    <input type="submit" value="Ez a tippem"><br><br>
    </form>
</body>
</html>