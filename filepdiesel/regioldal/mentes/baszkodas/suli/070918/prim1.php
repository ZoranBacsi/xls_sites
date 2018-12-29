<?php
$a = 1;
$b = 200;
if ($a>$b) 
{
 $c=$a;
 $a=$b;
 $b=$c;
}

for ($a;$a<$b;$a++){
 if ($a==2) print "$a<br>";
  for ($j=2;$j<$a;$j++){
   if ($a%$j == 0) break; 
   if ($a==$j+1) print "$a<br>";
  }
}
?>
