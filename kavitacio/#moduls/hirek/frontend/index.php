<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('hirek',false);
$_ENV['MODS']['PURL'] = rPath('hirek',true);

if($_ENV['HIR']['hir_id']>0) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` WHERE `hir_status`="A" AND `hir_id`="'.($_ENV['HIR']['hir_id']).'" LIMIT 1');
	if($sor=mysqli_fetch_array($con)) {
		echo'
			<h1 class="cim">'.($sor['hir_nev']).'</h1>
			<div class="HirekPage">
				<div class="HirekPageText">'.out_html($sor['hir_leiras']).'</div>
				<div class="HirekPageFoot">'.(date('Y-m-d',strtotime($sor['hir_date']))).'<a class="vissza" href="/hirek/">&#171; Vissza</a></div>
			</div>';
	}
} else {
	echo'<h1>Hírek / Aktualitások</h1>';
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` WHERE `hir_status`="A" ORDER BY `hir_date` DESC LIMIT 100');
	if(mysqli_num_rows($con)) {
		while($sor=mysqli_fetch_array($con)) {
			echo'
				<div class="HirekList">
					<div class="HirekListTitle"><a href="/hirek/'.($sor['hir_reurl']).'/">'.($sor['hir_nev']).'</a></div>
					<div class="HirekListText">'.(out_html(($sor['hir_rovidleiras'])?($sor['hir_rovidleiras']):($sor['hir_leiras']))).'</div>
					<div class="HirekListFoot">'.(date('Y-m-d',strtotime($sor['hir_date']))).'<a class="bovebben" href="/hirek/'.($sor['hir_reurl']).'/">Bővebben &#187;</a></div>
				</div>';
		}
	} else {
		echo'<div style="text-align:center; margin: 50px; font-size: 16px; font-weight: bold;">Nincsenek feltöltve hírek!</div>';
	}
}

?>