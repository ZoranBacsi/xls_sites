<HEAD> <meta name="content" content="text/html; charset=utf-8"> </HEAD>

<?php
  print "<FORM action=\"\" name=\"torles\" method=\"get\">";

  require("vein_mysql_access.inc.php");
  dbkapcs();  
  
  if (isset($_POST["torles"]))
   {
    for ($i=0;$i<sizeof($_POST["torlendo"]);$i++)
     {
      $query="DELETE FROM szemely WHERE szigszam='".$_POST["torlendo"][$i]."'";
//      echo $query;
      mysql_query($query) or die("Hiba!");
     }
   }
    
  $query="SELECT * FROM szemely";
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
   print"<TD><INPUT type='checkbox' name='torlendo[]' value='".$sor["szigszam"]."'> Törlendő</TD>";
   print "</TR>";
  }
 
 if ($sorokszama=mysql_num_rows($eredmeny)>0) print "</TABLE>";
 print "<INPUT type=\"submit\" name=\"torles\" value=\"Törlés\">";
 print "</FORM>";
 
?>
