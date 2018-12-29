<div id="pcrmenu">
	<ul>
		<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokcr&amp;altip=pcrbosch">Bosch</a></li>
		<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokcr&amp;altip=pcrdelphi">Delphi-Lucas</a></li>
		<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokcr&amp;altip=pcrdenso">Denso</a></li>
		<li><a class="" href="index.php?menu=tevekenyseg&amp;almenu=porlasztok&amp;tip=porlasztokcr&amp;altip=pcrsiemens">Siemens</a></li>
	</ul>
</div>
<div id="pcrcontent">
	<?php
	$db['pcrbosch']['html'] = "pcr/bosch.html";
	$db['pcrdelphi']['html'] = "pcr/delphi.html";
	$db['pcrdenso']['html'] = "pcr/denso.html";
	$db['pcrsiemens']['html'] = "pcr/siemens.html";



	if (isset($_GET['altip'])) {
		$altip = $_GET['altip'];
		require_once $db[$altip]['html'];
	}
	?>
</div>