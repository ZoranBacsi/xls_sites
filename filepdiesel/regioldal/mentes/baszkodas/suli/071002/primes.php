<?php 
$a=2;
$b=250;

$prim = array_fill(0,$b,TRUE);

for ($i=2; $i<$b;$i++)
{
    for ($j=2; $j*$i<$b; $j++)
	$prim[$i*$j]=false;
}

for ($i=$a; $i<$b; $i++)
if ($prim[$i]) $prim1[]=$i;
/*
print ("<pre>");
print_r ($prim1);
print ("</pre>");
*/
function primtenyezos($k, $prim1)
{
print "$szam=";
$k=200;
while ($k!=1)
{
    foreach ($prim1 as $prim)
    {
	if ($k % $prim == 0) 
	{
	    $osztok[]=$prim;
	    $k=$k/$prim;
	}
    }
}
return $osztok;
}

print ("<pre>");
print_r ($osztok);
print ("</pre>");

sort($osztok);

print ("<pre>");
print_r ($osztok);
print ("</pre>");
/*
$t = count($osztok);

for ($z=0; $z<$t; $z++)
{
    while ($osztok[$z]!=$osztok[$z+1])
    {
	$szamol[]=$osztok[$z];
	if ($z<5) $z++;
    }
}
print (count($szamol));
*/

for ($i=0; $i<count($osztok); $i++)
{
    $hatvany=1;
    $azonos=true;
    while ($azonos)
    {
	if ($i==count($osztok)-1) break;
	if ($osztok[$i]==$osztok[$i+1]) { $i++; $hatvany++; }
	else $azonos=false;
    }
}



?>