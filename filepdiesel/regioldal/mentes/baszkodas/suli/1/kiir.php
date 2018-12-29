<?php
    $veznev=$_GET["mezo1"];
    $kernev=$_GET["mezo2"]; 
    if ($_GET["udvozles"])
    {
	print ("Üdvözlünk, kedves" . " " . $veznev . " " . $kernev . "!");
    }
    else {
	print("Nincs üdvözlés");
    }
?>