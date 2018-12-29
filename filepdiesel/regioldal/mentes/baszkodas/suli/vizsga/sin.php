<?php
header("Content-type: image/png");
$kep = imagecreate(700, 350);
$feher = imagecolorallocate($kep, 255, 255, 230);
$fekete = imagecolorallocate($kep, 0, 0, 0);
$piros = imagecolorallocate($kep, 255, 0, 0);
$zold = imagecolorallocate($kep, 0, 255, 0);
imageline($kep, 50, 10, 50, 290, $fekete);
imageline($kep, 10, 150, 690, 150, $fekete);
//	Legyen itt egy ciklus, ami a $_GET tömbből kiszedett számot számjegyeire bontja, vagyis ugyanaz, ami levizsgálta az index.php-ben
$file = 'file';
$handle = fopen($file, "r");
$szam = fgets($handle);
fclose($handle);
$veg = strlen($szam);
$k = 50;
for ($a=0; $a<$veg; $a++)
{
    $elemek[$a] = substr($szam, $a, 1);
    if ($elemek[$a] == 1)
    {
	for ($i=45; $i<=135; $i++)
	{
    	    imagesetpixel($kep, $k+$i-45, (sin(deg2rad($i*4)))*50+150, $zold);
	}
    }
    if ($elemek[$a] == 0) 
    {
	for ($i=45; $i<=135; $i++)
	{	
	    imagesetpixel($kep, $k+$i-45, (sin(deg2rad($i*4)))*25+150, $zold);
	}
    }
$k = $k + 90;
}
imagepng($kep);
?>
