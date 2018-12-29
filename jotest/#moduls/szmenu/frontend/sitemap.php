<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('szmenu/frontend',false);
$_ENV['MODS']['PURL'] = rPath('szmenu/frontend',true);

function SzerkMenuSiteMap($parent,$i) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szmenu` WHERE `szm_status`="A" AND `szm_mod`!="L" AND `szm_k_id`="'.($parent).'" ORDER BY `szm_sorsz`');
	while($sor = mysqli_fetch_array($con)) {
		if(strlen($sor['szm_reurl'])>2) {
			$url = MenuFa($sor['szm_id']).'/';
			$url = str_replace('/index/','/',$url);
			$out .= ('
			<url>
				<loc>http://'.fPath($_SERVER['HTTP_HOST'].$url).'</loc>
				<lastmod>'.(date('Y-m-d\TH:i:s\Z',strtotime($sor['szm_date']))).'</lastmod>
				<changefreq>always</changefreq>
				<priority>'.(($i>0)?('0.'.(10-$i).'00'):('1.000')).'</priority>
			</url>');
		}
		$out .= SzerkMenuSiteMap($sor['szm_id'],($i+1));
	}
	return $out;
}

function SzerkPageSiteMap($parent,$i) {
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szpage` WHERE `szp_status`="A" ORDER BY `szp_date` DESC');
	while($sor = mysqli_fetch_array($con)) {
		$out .= ('
		<url>
			<loc>http://'.fPath($_SERVER['HTTP_HOST'].'/'.($sor['szp_reurl']).'/').'</loc>
			<lastmod>'.(date('Y-m-d\TH:i:s\Z',strtotime($sor['szp_date']))).'</lastmod>
			<changefreq>always</changefreq>
			<priority>'.(($i>0)?('0.'.(10-$i).'00'):('1.000')).'</priority>
		</url>');
	}
	return $out;
}

$_ENV['SITE']['SITEMAP'] .= SzerkMenuSiteMap(0,-1);
$_ENV['SITE']['SITEMAP'] .= SzerkPageSiteMap(0,1);

?>