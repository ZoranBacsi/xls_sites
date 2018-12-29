<?php
session_start();
if(isset($_SESSION['user']))
{
	session_set_cookie_params(60);
?>
admin
<?php } else { print "Nincs jogod a belépéshez!"; }
?>

