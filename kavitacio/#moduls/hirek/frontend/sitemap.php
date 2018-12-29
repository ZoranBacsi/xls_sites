<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }

function SiteMapHirek() { $out = null;
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `hirek` WHERE `hir_status`="A" ORDER BY `hir_date` DESC');
	$n=0;
	while($sor=mysqli_fetch_array($con)) {
		if($sor['hir_reurl']) {
			$out .= '
			<url>
				<loc>http://'.(str_replace(Array('/index.html','//'),'/',(($_SERVER['HTTP_HOST']).'/hirek/'.($sor['hir_reurl'])))).'/</loc>
				<lastmod>'.(date('Y-m-d\TH:i:s\Z',strtotime($sor['hir_date']))).'</lastmod>
				<changefreq>always</changefreq>
				<priority>'.(number_format((1-((($lev>0)?($lev):(1))/100)-($n/10000)), 4, '.', '')).'</priority>
			</url>';
			$n++;
		}
	}
	return $out;
}

$_ENV['SITE']['SITEMAP'] .= SiteMapHirek();
?>