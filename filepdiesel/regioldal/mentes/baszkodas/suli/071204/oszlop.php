<?php
header("Content-type: image/png");
$szam = 20;
$szeles = 20;
$kep = imagecreate($szam * $szeles + $szeles * 20, 400);
$feher = imagecolorallocate($kep, 255, 255, 255);
$piros = imagecolorallocate($kep, 255, 0, 0);
$fekete = imagecolorallocate($kep, 0, 0, 0);
$bfx = 20;
$jax = 40;
for ($i = 1; $i <= $szam; $i++)
    {
	$random = rand(0,100);
	imagefilledrectangle($kep, $bfx, 140-$random, $jax, 140, $piros);
	if ($random < 10) imagestring($kep, 2, $bfx + 8, 150, $random, $fekete);
	if ($random >= 10) imagestring($kep, 2, $bfx + 5, 150, $random, $fekete);
	$bfx = $bfx + 30;
	$jax = $jax + 30;
    }
imagepng($kep);
?>