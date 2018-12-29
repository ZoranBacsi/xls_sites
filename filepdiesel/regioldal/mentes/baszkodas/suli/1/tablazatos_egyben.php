<?php 
if (isset($_POST["oszlop"]) && isset($_POST["sor"]))
{
$sor=$_POST["sor"];
$oszlop=$_POST["oszlop"];
print("<body style='background-color: gray'>");
print("<center>");
print("<table border style='background-color: gray; color: white'>");
$k=0;
for ($i=1; $sor>=$i; $i++)
{
    print("<tr>");
	for ($j=1; $oszlop>=$j; $j++, $k++)
	{
	    print("<td>");
	    print("$k");
	    print("</td>");
	}
    print("</tr>");
}
}
print("</table>");
print("</center>");
print("</body>");
?>

<html>
<head>
    <title>
	táblázatos bekérős
    </title>
</head>
<body style="background-color: gray; color: white">
    <form name="tablazatos" action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
	Sorok száma: <input type="text" name="sor" size="10"><br>
	Oszlopok száma: <input type="text" name="oszlop" size="10"><br>
	<input type="submit" value="Mehet">
    </form>
</body>
</html>