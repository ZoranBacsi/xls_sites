<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('galeria/backend',false);
$_ENV['MODS']['PURL'] = rPath('galeria/backend',true);

function status($pid) { $out=NULL;
	if($pid>0) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `galeria` WHERE `gal_id`="'.($pid).'" LIMIT 1');
		$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
		$out .= '<a class="new_link" href="?oldal='.($_REQUEST['oldal']).'&amp;kipid='.($sor['gal_id']).'&level='.($_REQUEST['level']).'">'.($sor['gal_cim']).' &#187;</a> ';
		$out .= status($sor['gal_p_id']);
	}
	return $out;
}

if(!$_REQUEST['xMode']) {
	/* Albumok listázása */
	include($_ENV['MODS']['PATH'].'/album-listazas.php');
} else if($_REQUEST['xMode'] == 'edit') {
	/* Album készítése szerkesztése */
	include($_ENV['MODS']['PATH'].'/album-adatlap.php');
}
?>