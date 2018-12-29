<?php
session_start();
if(isset($_SESSION["username"]) AND $_SESSION["level"]<2)
{
?>
<form name="admin" method="post" action="">
 <input type="text" name="username" size="12" maxlength="10"><br>
 <input type="password" name="pass" size="12" maxlength="10"><br> 
 <select name="level">
  <option value="2">User</option>
  <option value="1">Admin</option>
 </select>
 <input type="submit" name="ok" value="mehet">
</form>
<?php
if (isset($_POST["ok"]))
{
require ('kapcs.inc.php');
$sql="SELECT * FROM users WHERE username='".$_POST["username"]."'";
$query=pg_exec($connect, $sql);
if (pg_num_rows($query)===0)
 {
  $sql="INSERT INTO users VALUES ( '".$_POST["username"]."', 
   '".md5($_POST["pass"])."', ".$_POST["level"].")";
  pg_exec($connect, $sql);
 }
else print "Már létező username!"; 
}
}
else header('Location: login.php');
?>
