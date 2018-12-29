<?php
header("Content-type: image/png");
$kep = imagecreate(300, 200);
$piros = imagecolorallocate($kep, 255, 0, 0);
$kek = imagecolorallocate($kep, 0, 0, 255);
imageline($kep, 0, 0, 299, 199, $kek);
imageline($kep, 0, 199, 299, 0, $kek);
$zold = imagecolorallocate($kep, 0, 255, 0);
imagefill($kep, 1, 5, $zold);
imagefill($kep, 299, 5, $zold);
$fekete = imagecolorallocate($kep, 0, 0, 0);
imageellipse($kep, 150, 100, 80, 20, $fekete);
imagefilledarc($kep, 50, 100, 50, 50, 0, 270, $fekete, IMG_ARC_PIE);
$hatszog = array(130, 30, 150, 15, 170, 30, 170, 70, 150, 85, 130, 70);
imagefilledpolygon($kep, $hatszog, 6, $fekete);
imagestring($kep, 5, 75, 180, "Ez egy szoveg itt.", $fekete);
imagepng($kep);
?>
