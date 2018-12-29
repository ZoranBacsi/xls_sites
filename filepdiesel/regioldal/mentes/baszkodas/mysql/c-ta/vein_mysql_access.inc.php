<?php
function dbkapcs()
{
 $host="localhost";
 $user="c-ta";
 $pass="12345";
 $db="proba";
 global $kapcs;
 $kapcs=mysql_connect($host,$user,$pass) or die("Adatbázis hiba");
 mysql_select_db($db);
 return $kapcs;
}
?>
