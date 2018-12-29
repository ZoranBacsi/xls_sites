<?php
header('Content-Type: text/html; charset=utf-8');
$kapcsolat = mysql_connect('localhost', 'root') or die ("Nem tudok csatlakozni");
mysql_select_db("proba") or die ("Nem sikerült kiválasztani az adatbázist");

$query = "SELECT * FROM tabla";

$eredmeny = mysql_query($query);

 while($sor=mysql_result($eredmeny))
  {
   print $sor["id"] . "\n";
   print $sor["username"] . "\n";
   print $sor["password"] . "\n";
  }

?>