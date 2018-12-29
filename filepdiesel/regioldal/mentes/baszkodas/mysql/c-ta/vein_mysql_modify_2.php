<HEAD> <meta name="content" content="text/html; charset=utf-8"> </HEAD>
<?php
 require("vein_mysql_access.inc.php");
 dbkapcs();
 $query="SELECT * FROM szemely WHERE szigszam='$_GET[szigszam]'";
 $eredmeny=mysql_query($query);
 $szemely=mysql_fetch_array($eredmeny);

 if (isset($_POST["modosit"]))
  {
   $query="UPDATE szemely SET veznev='$_POST[veznev]', kernev='$_POST[kernev]', irszam='$_POST[irszam]', telepules='$_POST[telepules]', utca='$_POST[utca]', szuldat='$_POST[szuldat]', nem='$_POST[nem]' WHERE szigszam='$_POST[szigszam]'";
   mysql_query($query) or die('Hiba');
   echo "Módostás volt";    
  }
 else
  {
//   echo "Ilyen nem lehet :)";
  } 
  
?>

<FORM action="" name="modositas" method="post">
 <TABLE><TR>
 <TR><TD>Személyi igazlvány száma:</TD><TD><INPUT type="text" name="szigszam" size="8" maxlength="8" value="<?php echo $szemely['szigszam'] ?>" readonly></TD></TR>
 <TR><TD>Vezetéknév:</TD><TD><INPUT type="text" name="veznev" size="30" maxlength="30" value="<?php echo $szemely['veznev'] ?>"></TD></TR>
 <TR><TD>Keresztnév:</TD><TD><INPUT type="text" name="kernev" size="30" maxlength="30" value="<?php echo $szemely['kernev'] ?>"></TD></TR>
 <TR><TD>Irányítószám:</TD><TD><INPUT type="text" name="irszam" size="4" maxlength="4" value="<?php echo $szemely['irszam'] ?>"></TD></TR> 
 <TR><TD>Település:</TD><TD><INPUT type="text" name="telepules" size="20" maxlength="20" value="<?php echo $szemely['telepules'] ?>"></TD></TR>
 <TR><TD>Utca, házszám:</TD><TD><INPUT type="text" name="utca" size="40" maxlength="40" value="<?php echo $szemely['utca'] ?>"></TD></TR>
 <TR><TD>Születési dátum:</TD><TD><INPUT type="text" name="szuldat" size="10" maxlength="10" value="<?php echo $szemely['szuldat'] ?>"></TD></TR>
 <TR><TD>Nem:</TD><TD>Férfi <INPUT type="radio" name="nem" value="f" <?php if($szemely["nem"]=="f") echo "checked"; ?>>Nő <INPUT type="radio" name="nem" value="n" <?php if($szemely["nem"]=="n") echo "checked"; ?>></TD></TR>
 </TABLE>
 <INPUT type="hidden" name="szigszam" value="<?php echo $szemely['szigszam'] ?>">
 <INPUT type="submit" name="modosit" value="Módosítás">
</FORM>
