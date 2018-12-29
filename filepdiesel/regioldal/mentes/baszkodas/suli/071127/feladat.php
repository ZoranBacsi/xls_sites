<?php
header("Content-type: image/png");
$osztasmeret = 20;
$osztasszam = 20;
$a = $osztasszam * $osztasmeret;
$kep = imagecreate($a, $a);
$fekete = imagecolorallocate($kep, 0, 0, 0);
$feher = imagecolorallocate($kep, 255, 255, 255);
$piros = imagecolorallocate($kep, 255, 0, 0);
imageline($kep, $a/2, 0, $a/2, $a, $feher);
imageline($kep, 0, $a/2, $a, $a/2, $feher);

for ($c=0; $c<=9; $c++)
{
    //bal felso
    imageline($kep, $c*$osztasmeret, $a/2, $a/2, $a/2-($c+1)*$osztasmeret, $feher);
    //jobb felso
    imageline($kep, $a/2, $c*$osztasmeret, $a/2+($c+1)*$osztasmeret, $a/2, $feher);
    //bal also
    imageline($kep, $c*$osztasmeret, $a/2, $a/2, $a/2+($c+1)*$osztasmeret, $feher);
    //jobb also
    imageline($kep, $a/2, $a-$c*$osztasmeret, $a/2+($c+1)*$osztasmeret, $a/2, $feher);
}

imagepng($kep);
?>
