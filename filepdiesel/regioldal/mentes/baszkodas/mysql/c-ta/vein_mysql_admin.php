<HEAD> <meta name="content" content="text/html; charset=utf-8"> </HEAD>
<?php
session_start();
if($_SESSION["level"] >= 3)
{
 if (isset($_POST["upload"]))
 {
  if ( disk_free_space("/tmp") > $_FILES["filename"]["size"] )
  {
   $cel="/tmp/".$_FILES["filename"]["name"];
   move_uploaded_file($_FILES["filename"]["tmp_name"],$cel);
   //tmp_name jól eltárolható fizikai névnek, adatbázisban el kell hozzá tárolni a valódi nevet is, később ez alapján összerendelni.
//   echo "sikeres feltöltés";
   require("vein_mysql_access.inc.php");
   dbkapcs();
   $query="INSERT INTO szemely VALUES('$_POST[szigszam]', '$_POST[veznev]', '$_POST[kernev]', '$_POST[irszam]', '$_POST[telepules]',
    '$_POST[utca]', '$_POST[szuldat]', '$_POST[nem]', '".$_FILES['filename']['name']."')";
// echo $query;    
   mysql_query($query); 
  }
  else
  {
   echo "Nincs elegendő hely";
  }
 }
}
?>
<form name="feltoltes" action="" method="post" enctype="multipart/form-data">
<table>
<tr><td>Személyi igazolvány száma:</td><td><input type="text" name="szigszam" size="30" maxlength="8"></td></tr>
<tr><td>Vezetéknév:</td><td><input type="text" name="veznev" size="30" maxlength="30"></td></tr>
<tr><td>Keresztnév:</td><td><input type="text" name="kernev" size="30" maxlength="30"></td></tr>
<tr><td>Irányítószám:</td><td><input type="text" name="irszam" size="30" maxlength="4"></td></tr>
<tr><td>Település:</td><td><input type="text" name="telepules" size="30" maxlength="20"></td></tr>
<tr><td>Utca:</td><td><input type="text" name="utca" size="30" maxlength="30"></td></tr>
<tr><td>Születési dátum:</td><td><input type="text" name="szuldat" size="30" maxlength="10"></td></tr>
<tr><td>Nem:</td><td>férfi <input type="radio" name="nem" value="f"> nő <input type="radio" name="nem" value="n"></td></tr>
<tr><td>Kép:</td><td><input type="file" name="filename" size="30"></td></tr>
</table>
<input type="submit" value="Feltöltés" name="upload">
</form>

<?php
 print "<BR><A HREF='vein_mysql_logout.php'>Kijelentkezes</A>";
?>

