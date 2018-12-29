<?php
header("Content-type: image/png");
$kep = imagecreate(400, 400);

$feher = imagecolorallocate($kep, 255, 255, 250);

if ($_GET['szin'] == "fekete") $szin = imagecolorallocate($kep, 0, 0, 0);
if ($_GET['alapszin'] == "fekete") $alapszin = imagecolorallocate($kep, 0, 0, 0);
if ($_GET['szin'] == "piros") $szin = imagecolorallocate($kep, 255, 0, 0);
if ($_GET['alapszin'] == "piros") $alapszin = imagecolorallocate($kep, 255, 0, 0);
if ($_GET['szin'] == "kek") $szin = imagecolorallocate($kep, 0, 0, 255);
if ($_GET['alapszin'] == "kek") $alapszin = imagecolorallocate($kep, 0, 0, 255);
if ($_GET['szin'] == "zold") $szin = imagecolorallocate($kep, 0, 255, 0);
if ($_GET['alapszin'] == "zold") $alapszin = imagecolorallocate($kep, 0, 255, 0);
if ($_GET['szin'] == "sarga") $szin = imagecolorallocate($kep, 255, 255, 0);
if ($_GET['alapszin'] == "sarga") $alapszin = imagecolorallocate($kep, 255, 255, 0);
if ($_GET['szin'] == "narancs") $szin = imagecolorallocate($kep, 255, 128, 0);
if ($_GET['alapszin'] == "narancs") $alapszin = imagecolorallocate($kep, 255, 128, 0);

imagefill($kep, 1, 1, $alapszin);

$darab = $_GET['darab'];

for ($i = 1; $i <= $darab; $i++)
{
if ($_GET['alak'] == "kor")
{
    $x = rand(40, 360);
    $y = rand(40, 360);
    $r = rand(10, 40);
    imagefilledellipse($kep, $x, $y, $r, $r, $szin);
}

if ($_GET['alak'] == "teglalap")
{
    $kezd_x = rand(1, 360);
    $kezd_y = rand(1, 360);
    $a = rand(10, 20);
    $b = 2 * $a;
    imagefilledrectangle($kep, $kezd_x, $kezd_y, $kezd_x+$b, $kezd_y+$a, 
$szin);
}

if ($_GET['alak'] == "negyzet")
{
    $kezd_x = rand(2, 360);
    $kezd_y = rand(2, 360);
    $a = rand(10, 20);
    imagefilledrectangle($kep, $kezd_x, $kezd_y, $kezd_x+$a, $kezd_y+$a, 
$szin);
}
}
$nev = $_GET['nev'];
imagestring($kep, 2, 1, 1, $nev, $feher);
imagepng($kep);
?>
