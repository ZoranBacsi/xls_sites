<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

echo'<h1 class="webaruhaz_kategoriak">Kategóriák:</h1>';
$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `shop_kategoria` WHERE `k_p_id`="1000" AND `k_statusz`="A" ORDER BY `k_sorszam`');
if(mysqli_num_rows($con)>0) {
	echo'
		<div class="webaruhaz_kateg_list">';
	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
		$kis_kep = WebaruhazKep('terk_{'.($sor['k_id']).'}','kep_kozepes');
		$nagy_kep = WebaruhazKep('terk_{'.($sor['k_id']).'}','kep_nagy');
		$kateg_url = fPath('/'.(WebaruhazKategFaURL($sor['k_p_id'])).($sor['k_reurl']).'/');
		$kateg_pic = (($kis_kep)?(fPath('/'.($kis_kep))):('/images/default.jpg'));
		echo'
			<div class="webaruhaz_kateg_list_item" onclick="LoadPage(\''.$kateg_url.'\');">
				<a class="Pic" title="'.($sor['t_nev']).'" href="'.$kateg_url.'"><span style="background-image: url(\''.($kateg_pic).'\');"></span></a>
				<h3>'.($sor['k_nev']).'</h3>
			</div>';
	}
	echo'</div>';
}


?>