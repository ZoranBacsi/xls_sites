<?php /* Készítő: H.Tibor */ unSet($_ENV); $_ENV=Array(); $_ENV['SiteStart']='CAPTCHA';

include(realpath('./#config.php'));
//include(realpath(DOCUMENT_ROOT.'/#functions.php'));
include(realpath(FUNCTIONS_ROOT.'/00-globals.php'));
include(realpath(FUNCTIONS_ROOT.'/captcha/captcha.php'));

?>