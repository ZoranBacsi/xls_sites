<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['HEAD']['TITLE'] = 'Keresés';
//$_ENV['HEAD']['DESCRIPTION'] = '';
//$_ENV['HEAD']['KEYWORDS'] = '';
include(MODULS_ROOT.'/webaruhaz/frontend/keres.php');
?>