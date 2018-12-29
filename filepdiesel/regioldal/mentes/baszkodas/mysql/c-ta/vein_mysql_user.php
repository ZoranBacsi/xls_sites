<?php
session_start();

//Célszerű az elején letudni (vagy lehet, hogy kell is
//vendég - 1
//user   - 2
//admin  - 3

if ($_SESSION["level"]>=2)
{
 require("vein_mysql_access.inc.php");
 dbkapcs();
 $query="SELECT kep FROM szemely WHERE kep!=''";
 $eredm=mysql_query($query);
 while($sor=mysql_fetch_array($eredm))
 {
  if($sor["kep"]=="NULL")
   {
    echo "nincs kép<br>";
   }
  else
   {
    list($nev, $kiterjesztes)=explode(".",$sor["kep"]);
    if($kiterjesztes == "jpg" || $kiterjesztes == "gif")
     {
      echo "<img src='/tmp/".$sor["kep"]."' width='320'><br>";
     }
    else
     {
      echo "<a href='/tmp/".$sor["kep"]."'>".$sor["kep"]."</a><br>";
     } 
   } 
 }
 print "<BR><A HREF='vein_mysql_logout.php'>Kijelentkezes</A>";
}
else
{
 header("Location: vein_mysql_login.php");
}

?>
