<HEAD> <meta name="content" content="text/html; charset=utf-8"> </HEAD>



<form action="" method="post">
 Végzettség: <select name="vegzettseg">
  <option value="Mind">Mind</option>
    <?php
     require("vein_mysql_access.inc.php");
     dbkapcs();
     $query="SHOW COLUMNS FROM szemely LIKE 'vegzettseg'";
     $eredmeny=mysql_query($query);
     $sor=mysql_fetch_row($eredmeny); 
     $enum_ertek=$sor[1];
     $enum_ertek=substr($enum_ertek,6,-2);
     $tomb=explode('\',\'',$enum_ertek);
     for ($i=0;$i<=count($tomb)-1;$i++)
     {
      echo '<option value="'.$tomb[$i].'">'.$tomb[$i].'</option>';
     }
  ?>
 </select>
 <input type="submit">
</form>

<?php

if (isset($_POST['vegzettseg']))
{
 if ($_POST['vegzettseg']=="Mind") $where="";
 else $where="WHERE vegzettseg='".$_POST['vegzettseg']."' ";
}
else $where="";
$query="SELECT * FROM szemely ".$where."ORDER BY veznev ASC";
//print $query;
$eredmeny=mysql_query($query);

if ($sorokszama=mysql_num_rows($eredmeny)>0)
{
 print "<TABLE><TR>";
 print "<TD>Személyi igazolvány száma</TD>";
 print "<TD>Vezetéknév</TD>"; 
 print "<TD>Keresztnév</TD>";
 print "<TD>Irányitószám</TD>"; 
 print "<TD>Település</TD>"; 
 print "<TD>Utca, házszám</TD>"; 
 print "<TD>Születési dátum</TD>"; 
 print "<TD>Nem</TD>";  
 print "<TD>Végzettség</TD>";   
 print "</TR>";
} 
while($sor=mysql_fetch_array($eredmeny))
{
print "<TR>";
print "<TD>".$sor["szigszam"]."</TD>";
print "<TD>".$sor["veznev"]."</TD>";
print "<TD>".$sor["kernev"]."</TD>";
print "<TD>".$sor["irszam"]."</TD>";
print "<TD>".$sor["telepules"]."</TD>";
print "<TD>".$sor["utca"]."</TD>";
print "<TD>".$sor["szuldat"]."</TD>";
if ($sor["nem"]=="f") print "<TD>Férfi</TD>"; else print "<TD>Nő</TD>";
print "<TD align=\"right\">".$sor["vegzettseg"]."</TD>";
//itt kéne levágni az elbaszott abszolut útvonal elejét ...
//echo "<TD><img src='".substr($sor["kep"]."' width='200'></TD>";
print "</TR>";
}
if ($sorokszama=mysql_num_rows($eredmeny)>0) print "</TABLE>";
?>
