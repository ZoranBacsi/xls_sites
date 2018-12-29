<?php
header("Content-type: image/png");
$kep = imagecreate(600, 400);
$feher = imagecolorallocate($kep, 255, 255, 255);
$kek = imagecolorallocate($kep, 0, 0, 255);

$fajlnev="adatok";
$handle = fopen($fajlnev, "r") or die ("$fajlnev nem nyitható meg");
$i = 0;
$egyes = 0;
$kettes = 0;
$harmas = 0;
$negyes = 0;
$otos = 0;
  while (! feof($handle)) {
   $szamok[$i] = fgets($handle);
   if ($szamok[$i] == 1) $egyes++;
   if ($szamok[$i] == 2) $kettes++;
   if ($szamok[$i] == 3) $harmas++;
   if ($szamok[$i] == 4) $negyes++;
   if ($szamok[$i] == 5) $otos++;
   $i++;
    }
   fclose($handle);

$tomb = array($egyes, $kettes, $harmas, $negyes, $otos);

$osszeg = array_sum($tomb);
$egyseg = 360/$osszeg;

$kezdo = 0;
for ($k = 1; $k <= 5; $k++)
    {
	$szin = imagecolorallocate($kep, rand(0,255), rand(0,255), rand(0,255));
	$veg = $tomb[$k-1]*$egyseg + $kezdo;
	imagefilledarc($kep, 150, 150, 200, 200, $kezdo, $veg, $szin, 0);
	$kezdo = $veg;
    }
imagepng($kep);
?>