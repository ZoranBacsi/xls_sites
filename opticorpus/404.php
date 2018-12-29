<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['HEAD']['TITLE'] = $_ENV['LANG']['SITE404'];
$_ENV['HEAD']['DESCRIPTION'] = '';
$_ENV['HEAD']['KEYWORDS'] = '';
?>
<h1>{lang:site404}</h1>
<div style="text-align:center;"><img src="/images/404.png" alt="{lang:site404}" style="margin:auto;" /></div>