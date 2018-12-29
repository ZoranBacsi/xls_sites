<HTML>
<HEAD>
 <TITLE>Szám értékének kitalálása</TITLE>
</HEAD>
<BODY>
<FORM action="" method="post" name="urlap">
Tipp: <INPUT type="text" name="tipp"><BR>
<?php
if (isset($_POST["gondolt"])) 
{
// print "Kérem a számot!";
 if ($_POST['tipp']===$_POST['gondolt']) print "Nyert";
 print "<INPUT type=\"hidden\" name=\"gondolt\" value=\"$_POST[gondolt]\"><BR>"; 
}
else
{
 $a=rand(1,10);
 print "<INPUT type=\"hidden\" name=\"gondolt\" value=\"$a\"><BR>";
}
?>
<INPUT type="submit" value="Mehet"><BR>
</FORM>
</BODY>
</HTML>