<?php
header('Content-Type: text/html; charset=utf-8');
$kapcsolat = mysql_connect('localhost', 'root') or die ("Nem tudok csatlakozni");
mysql_select_db("proba") or die ("Nem sikerült kiválasztani az adatbázist");

$query = "INSERT INTO tabla VALUES ('3', 'ocsi', 'labda')";
mysql_query($query) or die ("Hiba");
?>