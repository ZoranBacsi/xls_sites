<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_ENV['HEAD']['INDEX'] = 'N';
echo'<h2>Termékek</h2>';
$szures = ' ';
$_ENV['WEBARUHAZ']['LAPOZO_SQL'] = '
	SELECT *
	FROM `shop_tk`
	LEFT JOIN `shop_termek`
		ON `tk_t_id`=`t_id`
	WHERE `tk_statusz`="A"
		AND `tk_k_id` > 0
		'.($szures).'
	ORDER BY '.(($_SESSION['orderby_mod']=='NEV')?('`t_nev`'):('`t_kisar`')).' '.(($_SESSION['orderby_irany']=='DESC')?('DESC'):('ASC')).', `tk_sorszam`';
$con = mysqli_query($_ENV['MYSQLI'],$_ENV['WEBARUHAZ']['LAPOZO_SQL'].' LIMIT '.(($_REQUEST['db_tol']>0)?($_REQUEST['db_tol']):(0)).','.$_ENV['WEBARUHAZ']['LIMIT']);
if(mysqli_num_rows($con)>0) {
	echo'<div class="ProductList">'.(WebAruhazTermekLista($szures)).'</div>';
}

?>