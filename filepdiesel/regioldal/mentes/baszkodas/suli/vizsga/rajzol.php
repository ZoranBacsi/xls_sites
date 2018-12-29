<?php
header("Content-type: image/png");
$kep = imagecreate(500, 200);
$feher = imagecolorallocate($kep, 255, 255, 230);
$fekete = imagecolorallocate($kep, 0, 0, 0);
$piros = imagecolorallocate($kep, 255, 0, 0);
imageline($kep, 50, 10, 50, 190, $fekete);
imageline($kep, 10, 150, 490, 150, $fekete);
//	Legyen itt egy ciklus, ami a $_GET tömbből kiszedett számot számjegyeire bontja, vagyis ugyanaz, ami levizsgálta az index.php-ben
$file = 'file';
$handle = fopen($file, "r");
$szam = fgets($handle);
fclose($handle);
$x = 50;
$veg = strlen($szam);
for ($a=0; $a<$veg; $a++)
{
    $elemek[$a] = substr($szam, $a, 1);
    if ($elemek[$a] == 0) $elemek[$a] = 149;
    if ($elemek[$a] == 1) $elemek[$a] = 119;
    imageline($kep, $x, $elemek[$a], $x+30, $elemek[$a], $piros);
    if ($a>0)
    {
	imageline($kep, $x, $elemek[$a-1], $x, $elemek[$a], $piros);
    }
    $x = $x+30;
}
imagepng($kep);
?>
