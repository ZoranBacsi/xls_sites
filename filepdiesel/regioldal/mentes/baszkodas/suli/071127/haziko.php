<?php
header("Content-type: image/png");
$kep = imagecreate(600, 400);
$fekete = imagecolorallocate($kep, 0, 0, 0);
$feher = imagecolorallocate($kep, 255, 255, 255);
imagefilledrectangle($kep, 260, 320, 340, 398, $feher);
$narancs = imagecolorallocate($kep, 255, 135, 60);
imagefilledrectangle($kep, 322, 270, 332, 315, $narancs);
imagefilledrectangle($kep, 320, 265, 334, 270, $narancs);
$pontok = array(260, 320, 340, 320, 300, 250);
$piros = imagecolorallocate($kep, 255, 0, 0);
imagefilledpolygon($kep, $pontok, 3, $piros);
imagerectangle($kep, 290, 370, 310, 398, $fekete);

imagepng($kep);
?>
