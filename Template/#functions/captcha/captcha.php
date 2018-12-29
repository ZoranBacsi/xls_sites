<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
error_reporting(0);
$fon_face = str_replace('//','/',FUNCTIONS_ROOT.'/captcha/ttf/VTC-LiquorCrystalDisplay.ttf');
$text = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9');
$texts = null;
for($a=0;$a<5;$a++) { $texts .= $text[rand(0,(count($text)-1))].' '; }
setcookie(md5(str_replace(' ','',$texts).md5($_SERVER['REMOTE_ADDR'])), md5(str_replace(' ','',$texts).$_SERVER['REMOTE_ADDR']), time()+(60*60*24), '/');
mysqli_query($_ENV['MYSQLI'],'DELETE FROM `captcha` WHERE `time` < DATE_ADD(NOW(), INTERVAL -1 HOUR) ');
mysqli_query($_ENV['MYSQLI'],'INSERT INTO `captcha` ( `ip`, `key`, `value`, `time` ) VALUES ( "'.($_SERVER['REMOTE_ADDR']).'", "'.(md5(str_replace(' ','',$texts).md5($_SERVER['REMOTE_ADDR']))).'", "'.(str_replace(' ','',$texts)).'", now() )');
$im = @imagecreate(300,80); //kép generálása
imagecolorallocatealpha($im,235,227,206,127); //háttérszín
$text_color = imagecolorallocate($im, rand(0,90), rand(0,90), rand(0,90)); //szöveg szín
if(is_file($fon_face)) {
	imagettftext($im, 40, 0, 25, 55, $text_color, $fon_face, $texts); //méret szög xstart ystart szin ttf text
} else {
	imagestring($im, 5, 110, 35, $texts, $text_color);
}
header('Content-Type: image/png');
imagepng($im);
imagedestroy($im);
?>