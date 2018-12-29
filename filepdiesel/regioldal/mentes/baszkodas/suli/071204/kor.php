<?php
header("Content-type: image/png");
$kep = imagecreate(600, 400);
$feher = imagecolorallocate($kep, 255, 255, 255);
$kek = imagecolorallocate($kep, 0, 0, 255);
for ($i = 1; $i <= 10; $i++)
    {
	$szamok[$i-1] = rand(1, 100);
    }
$osszeg = array_sum($szamok);
$egyseg = 360/$osszeg;
$kezdo = 0;
for ($k = 1; $k <= 10; $k++)
    {
	$szin = imagecolorallocate($kep, rand(0,255), rand(0,255), rand(0,255));
	$veg = $szamok[$k-1]*$egyseg + $kezdo;
	imagefilledarc($kep, 150, 150, 200, 200, $kezdo, $veg, $szin, 0);
	$kezdo = $veg;
    }
imagepng($kep);
?>