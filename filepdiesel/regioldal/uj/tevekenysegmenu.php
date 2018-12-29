<?php
if ($_GET['almenu'] == "bosch") {
?>

<ul id="boschmenu">
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=bosch&amp;tip=boschforgo">Forgóelosztós rendszerű adagolók</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=bosch&amp;tip=boschsoros">Soros rendszerű adagolók</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=bosch&amp;tip=boschcr">Cr. magasnyomású szivattyúk</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=bosch&amp;tip=boschpde">PDE-adagoló porlasztó egység</a></li>
</ul>

<?php
;} else if ($_GET['almenu'] == "zexel") {
?>

<ul id="zexelmenu">
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=zexel&amp;tip=zexelforgo">Forgóelosztós rendszerű porlasztók</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=zexel&amp;tip=zexelvrz">VRZ-radiál dugattyús rendszerű adagolók</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=zexel&amp;tip=zexelsoros">Soros rendszerű adagolók</a></li>
</ul>

<?php
;} else if ($_GET['almenu'] == "porlasztok") {
?>

<ul id="porlasztokmenu">
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokmechanikus">Mechanikus porlasztók</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokcr">Cr. porlasztók</a></li>
	<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokcrvizsgalo">Cr. porlasztó vizsgáló</a></li>
</ul>

<?php
;}
?>