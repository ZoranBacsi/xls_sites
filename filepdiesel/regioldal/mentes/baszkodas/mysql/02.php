<?php
header('Content-Type: text/html; charset=utf-8');
$kapcsolat = mysql_connect('localhost', 'root') or die ("Nem tudok csatlakozni");
mysql_select_db("proba") or die ("Nem sikerült kiválasztani az adatbázist");

$query = "CREATE TABLE tabla (id int(6) NOT NULL AUTO_INCREMENT KEY, username varchar(10) NOT NULL, password varchar(10) NOT NULL)";
mysql_query($query) or die ("Hiba");
?>