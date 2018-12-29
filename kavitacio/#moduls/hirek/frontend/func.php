<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('hirek/frontend',false);
$_ENV['MODS']['PURL'] = rPath('hirek/frontend',true);
$_ENV['HEAD']['CSS'][] = $_ENV['MODS']['PURL'].'/style.css';

$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` WHERE `hir_status`="A" AND `hir_reurl`="'.(end($_ENV['REURL'])).'" LIMIT 1');
if(mysqli_num_rows($con)) {
	$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
	if($sor['hir_h1']) { $_ENV['HEAD']['H1'] = out_header($sor['hir_h1'],'H1'); }
	else if($sor['hir_nev']) { $_ENV['HEAD']['H1'] = out_header($sor['hir_nev'],'H1'); }
	if($sor['hir_title']) { $_ENV['HEAD']['TITLE'] = out_header($sor['hir_title'],'TITLE'); }
	else if($sor['hir_nev']) { $_ENV['HEAD']['TITLE'] = out_header($sor['hir_nev'],'TITLE'); }
	if($sor['hir_keyw']) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['hir_keyw'],'KEYWORDS'); }
	else if($sor['hir_nev']) { $_ENV['HEAD']['KEYWORDS'] = out_header($sor['hir_nev'],'KEYWORDS'); }
	if($sor['hir_desc']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['hir_desc'],'DESCRIPTION'); }
	else if($sor['hir_rovidleiras']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['hir_rovidleiras'],'DESCRIPTION'); }
	else if($sor['hir_leiras']) { $_ENV['HEAD']['DESCRIPTION'] = out_header($sor['hir_leiras'],'DESCRIPTION'); }
	$_ENV['HIR'] = $sor;
}

function RovidHirekList() { $out='';
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` WHERE `hir_status`="A" AND LENGTH(`hir_leiras`)>9 ORDER BY `hir_date` DESC LIMIT 5');
	if(mysqli_num_rows($con)) {
		while($sor=mysqli_fetch_array($con)) {
			$out .= '
				<div class="RovidHirekList">
					<div class="RovidHirekListTitle"><a href="/'.($sor['hir_reurl']).'.html">'.($sor['hir_nev']).'</a></div>
					<div class="RovidHirekListText">'.(out_html($sor['hir_rovidleiras'])).'</div>
					<div class="RovidHirekListFoot">'.(date('Y-m-d',strtotime($sor['hir_date']))).'<a class="bovebben" href="/hirek/'.($sor['hir_reurl']).'/">Bővebben &#187;</a></div>
				</div>';
		}
	}
	return $out;
}

$_ENV['RovidHirekList'] = '<h3 class="cim">Hírek</h3>'.RovidHirekList().'<div class="TovabbiHirek"><a href="/hirek/">További híreink &#187;</a></div>';

?>