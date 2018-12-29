<HEAD> <meta name="content" content="text/html; charset=utf-8"> </HEAD>

<?php
if (isset($_POST["keres"]))
 {
  require("vein_mysql_access.inc.php");
  dbkapcs();  
  $query="SELECT * FROM szemely WHERE veznev LIKE '%$_POST[keresendo]%'";
  $eredmeny=mysql_query($query);

  if ($sorokszama=mysql_num_rows($eredmeny)>0)
  {
   print "<TABLE><TR>";
   print "<TD WIDTH=100>Szigszám</TD>";
   print "<TD WIDTH=100>Vezetéknév</TD>"; 
   print "<TD WIDTH=100>Keresztnév</TD>";
   print "<TD WIDTH=100>Irányitószám</TD>"; 
   print "<TD WIDTH=100>Település</TD>"; 
   print "<TD WIDTH=150>Utca, házszám</TD>"; 
   print "<TD WIDTH=150>Születési dátum</TD>"; 
   print "<TD WIDTH=100>Nem</TD>";  
   print "</TR>";
  } 
  while($sor=mysql_fetch_array($eredmeny))
  {
   print "<TR>";
   print "<TD><A href='vein_mysql_modify_2.php?szigszam=".$sor["szigszam"]."'>".$sor["szigszam"]."</A></TD>";
   print "<TD>".$sor["veznev"]."</TD>";
   print "<TD>".$sor["kernev"]."</TD>";
   print "<TD>".$sor["irszam"]."</TD>";
   print "<TD>".$sor["telepules"]."</TD>";
   print "<TD>".$sor["utca"]."</TD>";
   print "<TD>".$sor["szuldat"]."</TD>";
   if ($sor["nem"]=="f") print "<TD>Férfi</TD>"; else print "<TD>Nő</TD>";
   print "</TR>";
  }
}

?>

<FORM action="" name="keresourlap" method="post">
 <TABLE><TR>
 <TR><TD>Keresendő kifejezés:</TD><TD><INPUT type="text" name="keresendo"</TD></TR>
 </TABLE>
 <INPUT type="submit" name="keres" value="Keresés">
</FORM>
