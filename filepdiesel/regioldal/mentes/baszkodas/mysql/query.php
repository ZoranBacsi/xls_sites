<?php
//	kapcsolódjunk az adatbázishoz
header('Content-Type: text/html; charset=utf-8');
$kapcsolat = mysql_connect('localhost', 'root') or die ("Nem tudok csatlakozni");
mysql_select_db("muphrid") or die ("Nem sikerült kiválasztani az adatbázist");

$query = "SELECT * FROM blog WHERE 'date' <= '2009-01-01'";
mysql_query($query) or die ("Hiba");
if (mysql_query($query)) print "<p>Sikerült</p>";

$eredmeny = mysql_query($query);
$sor = mysql_fetch_row($eredmeny); 

for ($i=0; $i<count($sor); $i++) {
	print utf8_encode($sor[$i]);
}


mysql_free_result($eredmeny);

/*
$enum_ertek=substr($enum_ertek,6,-2);
$tomb=explode('\',\'',$enum_ertek);
for ($i=0;$i<=count($tomb)-1;$i++)
{
	echo '<option value="'.$tomb[$i].'">'.$tomb[$i].'</option>';
}
*/
?>