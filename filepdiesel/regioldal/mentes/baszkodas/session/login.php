<form name="admin" method="post" action="">
 <input type="text" name="username" size="12" maxlength="10"><br>
 <input type="password" name="pass" size="12" maxlength="10"><br> 
 <input type="submit" name="ok" value="mehet">
</form>
<?php
if (isset($_POST["ok"]))
{
require ('kapcs.inc.php');
$sql="SELECT * FROM users WHERE username='".$_POST["username"]."' AND
      pass='".md5($_POST["pass"])."'";
$query=pg_exec($connect, $sql);
if (pg_num_rows($query)===1)
 {
  $adatok=pg_fetch_assoc($query);
  session_set_cookie_params(60);
  session_start();
  $_SESSION["username"]=$adatok["username"];
  $_SESSION["level"]=$adatok["level"];
  if ($adatok["level"]<2)
   {
    print "<a href=\"admin.php\">Admin oldal</a><br>";
   }
    print "<a href=\"user.php\">User oldal</a><br><br>";
    print "<a href=\"logout.php\">Kijelentkezes</a><br>";
 }
}
?>
