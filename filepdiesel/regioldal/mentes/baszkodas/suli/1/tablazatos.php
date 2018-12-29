<?php 
$sor=$_POST["sor"];
$oszlop=$_POST["oszlop"];
print("<body style='background-color: gray'>");
print("<center>");
print("<table border style='background-color: gray; color: white' >");
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
print("</table>");
print("</center>");
print("</body>");
?>