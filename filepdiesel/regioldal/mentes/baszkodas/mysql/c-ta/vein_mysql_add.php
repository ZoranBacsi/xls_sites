<?php
if (isset($_POST["felvisz"]))
 { 
  require("vein_mysql_access.inc.php");
  dbkapcs();
  $query="SELECT count(szigszam) FROM szemely WHERE szigszam='$_POST[szigszam]'";
  $eredmeny=mysql_query($query);
  $num=mysql_fetch_array($eredmeny);
  if ($num["0"]==0)
   {    
   if( disk_free_space("/home/c-ta/public_html/feltoltes")>=$_FILES["kep"]["size"] AND is_uploaded_file($_FILES["kep"]["tmp_name"]))
// if (disk_free_space("/home/c-ta/public_html/feltoltes")>=$_FILES["kep"]["size"])
     {
      //print "Fájlnév: ".$_FILES['feltolt']['name']."<BR>";
      //print "Fájl méret: ".$_FILES['feltolt']['size']."<BR>";
      //print "Átmeneti név: ".$_FILES['feltolt']['tmp_name']."<BR>";
      //if ($_FILES['feltolt']['error']) print "Hiba: ".$_FILES['feltolt']['error']."<BR>";
      if ($_FILES["kep"]["type"] == "image/jpeg" OR $_FILES["kep"]["type"] == "image/gif") { 
       $forras = $_FILES["kep"]["tmp_name"];
       $cel = "/home/c-ta/public_html/feltoltes/".$_FILES["kep"]["name"];
       move_uploaded_file($forras,$cel);
      }
     } 
    $query="INSERT INTO szemely VALUES('$_POST[szigszam]', '$_POST[veznev]', '$_POST[kernev]', '$_POST[irszam]', '$_POST[telepules]', '$_POST[utca]', '$_POST[szuldat]', '$_POST[nem]', '$cel')";
    mysql_query($query) or die('Hiba');
    echo "Felvitel volt";    
   }
  else
   {
    echo "Az adott személy már létezik";
   } 
 }
?>

<FORM action="" name="felvitel" method="post" enctype="multipart/form-data">
 <TABLE><TR>
 <TR><TD>Személyi igazlvány száma:</TD><TD><INPUT type="text" name="szigszam" size="8" maxlength="8"></TD></TR>
 <TR><TD>Vezetéknév:</TD><TD><INPUT type="text" name="veznev" size="30" maxlength="30"></TD></TR>
 <TR><TD>Keresztnév:</TD><TD><INPUT type="text" name="kernev" size="30" maxlength="30"></TD></TR>
 <TR><TD>Irányítószám:</TD><TD><INPUT type="text" name="irszam" size="4" maxlength="4"></TD></TR> 
 <TR><TD>Település:</TD><TD><INPUT type="text" name="telepules" size="20" maxlength="20"></TD></TR>
 <TR><TD>Utca, házszám:</TD><TD><INPUT type="text" name="utca" size="40" maxlength="40"></TD></TR>
 <TR><TD>Születési dátum:</TD><TD><INPUT type="text" name="szuldat" size="10" maxlength="10"></TD></TR>
 <TR><TD>Nem:</TD><TD>Férfi <INPUT type="radio" name="nem" value="f">Nő <INPUT type="radio" name="nem" value="n"></TD></TR>
 <TR><TD>Kép:</TD><TD><INPUT type="file" name="kep" size="30"></TD></TR> 
 </TABLE>
 <INPUT type="submit" name="felvisz" value="Felvitel">
</FORM>
<HTML>
<HEAD><TITLE>Fájlok feltöltése</TITLE></HEAD>
<BODY>

<?php

//<INPUT type="hidden" name="MAX_FILE_SIZE" value="1000000">
?>
