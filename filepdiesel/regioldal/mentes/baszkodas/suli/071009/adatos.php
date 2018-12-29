<?php
$veznev=$_POST["veznev"];
$kernev=$_POST["kernev"];
$mobil=$_POST["mobil"];

function nev ($a) {
    if (strlen($a)<3) {
	return(false);
    }
    
    else {
	return(true);
    }
}

function tel ($mobil) {
    if (($mobil[3]=="2" OR $mobil[3]=="3" OR $mobil[3]=="7") AND strlen($mobil)=="12") {
	return(true);
    }
    
    else {
	return(false);
    }
}

if ($veznev AND $kernev AND $mobil) {
    
    if (nev($veznev) AND nev($kernev) AND tel($mobil)) print("Helyes adatok");
    else print("Hibás adatot adtál meg!");
}

else {
    print("Nem töltöttél ki minden mezőt!");
}
?>