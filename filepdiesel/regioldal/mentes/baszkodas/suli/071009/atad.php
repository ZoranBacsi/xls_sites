<?php
$a=2;
$b=3;

function ize (&$a, &$b) {
    $a=$a+$b;
}

function bigyo ($a, $b) {
    $a=$a+$b;
}

ize ($a, $b);
print $a;

print("<br>");

bigyo ($a, $b);
print $a;
    
?>