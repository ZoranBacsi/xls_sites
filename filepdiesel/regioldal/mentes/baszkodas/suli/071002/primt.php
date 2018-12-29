<?php
$a = 2;
$e = 200;
$f = 300;
if ($f>$e) $b=$f; else $b=$e;

//Primek meghat�roz�sa

$prim = array_fill(0,$b,TRUE);

for($i=2;$i<$b;$i++)
{
 for ($j=2;$j*$i<$b;$j++)
  $prim[$i*$j]=false;	
}

for($i=$a;$i<$b;$i++)
if ($prim[$i]) $c[]=$i;

//Pr�mt�nyez�s felbont�s
//$szam a pr�mt�nyez�kre bontand� sz�m
//$primek a pr�msz�mokat tartalmaz� t�mb
//$d a visszaadott �rt�k, pr�mt�nyez�k t�mbje

function primtenyezos($szam, $primek)
{
print "$szam=";
while ($szam!=1)
 {
  foreach ($primek as $primtenyezo)
   {
    if ($szam%$primtenyezo==0)
     {
      $d[]=$primtenyezo;
      $szam/=$primtenyezo;
     } 
   }
 }
 return $d;
}


//Az eredm�ny kiirat�sa
//A pr�mt�nyez�k az �tadott $d t�mbben

function kiiratas($d)
{
sort($d);

for ($i=0;$i<count($d);$i++)
{
 $hatvany=1;
 $azonos=true;
 while ($azonos)
  {
   if ($i==count($d)-1) break;
   if ($d[$i]==$d[$i+1]) { $i++; $hatvany++; }
   else $azonos=false;
  }
 print $d[$i]."<sup>$hatvany</sup>";
 if ($i!=count($d)-1) print "*";  
}
print "<BR>";
}

$p1=primtenyezos($e, $c);
kiiratas($p1);
$p2=primtenyezos($f, $c);
kiiratas($p2);

?>
