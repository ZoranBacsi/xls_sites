<?php
if (isset($_POST['gomb']))
 { 
  require("vein_mysql_access.inc.php");
  dbkapcs();
  $query="SELECT * FROM auth WHERE username='$_POST[username]' && password=md5('$_POST[password]')";
  $eredmeny=mysql_query($query);  
  if (mysql_num_rows($eredmeny)!=1)
   {
    print "Hibás belépési kísérlet";
   }
  else
   {
    session_start();
    $adatok=mysql_fetch_array($eredmeny);    
    $_SESSION["user"]=$adatok["username"];
    $_SESSION["level"]=$adatok["level"];
    switch($adatok["level"]) 
    {
     //kiíró utasitásokat nélkülözni kell átirányításkor, mert egyébként sem lenne ideje elolvasni senkinek
     case 1: header("Location: vein_mysql_vendeg.php"); break;
     case 2: header("Location: vein_mysql_user.php"); break;     
     case 3: header("Location: vein_mysql_admin.php"); break; 
    }
   } 
 }
?>

<HTML>
<HEAD> <meta name="content" content="text/html; charset=utf-8"> </HEAD>
<BODY>
<FORM action="" method="post" name="login">
 <TABLE>
 <TR><TD>Felhasználó név:</TD><TD><INPUT type="text" name="username" size="8" maxlength="20"></TD></TR>
 <TR><TD>Jelszó</TD><TD><INPUT type="password" name="password" size="8" maxlength="20"> </TD></TR>
 <TR><TD COLSPAN="2"><INPUT type="submit" name="gomb" caption="mehet"></TD></TR>
 </TABLE> 
</FORM>
</BODY>
