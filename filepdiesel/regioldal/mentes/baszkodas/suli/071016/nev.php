<?php
$nev = "Gipsz Jakab";
$veznev = substr($nev, 0, strpos($nev, " "));
$kernev = substr($nev, strpos($nev, " ")+1);
print $veznev." ".$kernev;  
?>