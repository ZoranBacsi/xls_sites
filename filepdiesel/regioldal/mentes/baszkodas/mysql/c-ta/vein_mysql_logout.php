<?php
session_start();
session_unset();
//változók kigyilkolása
session_destroy();
//session megszüntetése
header("Location: vein_mysql_login.php");
?>