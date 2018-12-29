<?php
$r = 1;
$g = 2;
$b = 3;

if ($r<=255 AND $g<=255 AND $b<=255) {

function atvalt ($a) {
    
    if ($a<=15) {
	$b=sprintf("%02X", $a);
    }
    
    else {
	$b=sprintf("%X", $a);
    }
}
print "#".atvalt($r).atvalt($g).atvalt($b);
    
}

else {
    print("adjál meg normális számokat...");
}


?>