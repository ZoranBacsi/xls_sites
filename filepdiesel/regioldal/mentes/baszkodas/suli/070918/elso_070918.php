<?php
/*
$a=-25;
$b=25;
$c=73;
for ($a;$a<=$b;$a++)
{
 if ($a!=0)
  {
   $h=$c/$a;
   print "$h<BR>";
  }
 else
  {
   print "$a-val nem osztunk <BR>";
  } 
}
*/

//A h�romsz�g megszerkeszthet�s�g�nek vizsg�lata

$a=$_POST["a"];
$b=$_POST["b"];
$c=$_POST["c"];

$d = (string) (int) $a;
if ($d===$a) print "A �rt�ke helyes"; else print "A �rt�ke nem helyes";
var_dump($a);
var_dump($d);

if($a>0 && $b>0 && $c>0)
{
 if($a+$b>$c && $a+$c>$b && $b+$c>$a) print "OK"; else print "Nem OK";
}
else print "pozit�v �rt�kekre lenne sz�ks�g";

/*
//a �s b k�z�tt a sz�mok, a sz�mok n�gyzet�nek �s a n�gyzet�sszegek ki�rat�sa h�rom oszlopban

$a=23;
$b=13;
if ($a!=$b)
{
 if ($a>$b)
 {
  $c=$a;
  $a=$b;
  $b=$c;
 } 
$osszeg=0;
print "<TABLE>";
while ($a<=$b)
{
 $osszeg+=$a*$a;
 print "<TR><TD>$a</TD><TD>".$a*$a."</TD><TD>$osszeg</TD></TR>";
 $a++;
}
print "</TABLE>";
}
else print '$a �s $b �rt�ke megyezik';
*/
?>
