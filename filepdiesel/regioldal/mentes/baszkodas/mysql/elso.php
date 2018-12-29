<?php
/*$_MYSQL['HOST'] = "localhost"; // MySQL host
$_MYSQL['USER'] = "muphrid"; // MySQL felhasználónév
$_MYSQL['PASSWORD'] = "csokika"; // MySQL jelszó
$_MYSQL['DB'] = "search"; // MySQL adatbázis
 
$_CONF['TABLA'] = "hirek"; // Amelyik táblában akarunk keresni 
$_CONF['MEZO'] = "uzenet"; // Abba egy bizonyos mezõ amelyben keresünk

$user="username";
$password="password";
$database="database";
mysql_connect(localhost,$user,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="CREATE TABLE contacts (id int(6) NOT NULL auto_increment,first varchar(15) NOT NULL,last varchar(15) NOT NULL,phone varchar(20) NOT NULL,mobile varchar(20) NOT NULL,fax varchar(20) NOT NULL,email varchar(30) NOT NULL,web varchar(30) NOT NULL,PRIMARY KEY (id),UNIQUE id (id),KEY id_2 (id))";
mysql_query($query);
mysql_close();*
?>

<?php
	header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('localhost', 'root')
        or die ("Nem lehet csatlakozni");
	$query = "CREATE DATABASE proba";
    if (mysql_query($query)) {
        print ("Az adatbázist létrehoztam\n");
    } else {
        printf ("Hiba az adatbázis létrehozásakor: %s\n", mysql_error ());
    }
?>