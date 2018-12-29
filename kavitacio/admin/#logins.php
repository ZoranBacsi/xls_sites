<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_CookiePassword='xWhJ2g%$1x'; // /js/tiny_mce/plugins/tinybrowser/config_tinybrowser.php -ba is megadni!
$_ENV['LMSG'] = '';
if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "sessions"'))) {
	/* Felhasználó adatok olvasása adatbázisból */
	$con = mysqli_query($_ENV['MYSQLI'],'
					SELECT *
					FROM `sessions`
					LEFT JOIN `admin_users`
						ON `ss_aid`=`u_id`
					WHERE `ss_aid`=`u_id`
						AND `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
						AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"
						AND `u_status`="A"
					LIMIT 1');
	if(mysqli_num_rows($con)>0) {
		$_ENV['USER'] = mysqli_fetch_array($con,MYSQLI_ASSOC);
		mysqli_query($_ENV['MYSQLI'],'
				UPDATE `sessions`
				SET `ss_date`=now()
				WHERE `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
					AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"');
		setcookie(md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'].date('Ymd')), md5($_SERVER['REMOTE_ADDR'].$_CookiePassword.$_SERVER['DOCUMENT_ROOT'].date('Ymd')), time()+(3600*3), '/');
		$_SESSION[md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'].date('Ymd'))] = md5($_SERVER['REMOTE_ADDR'].$_CookiePassword.$_SERVER['DOCUMENT_ROOT'].date('Ymd'));
	} unSet($con);

	/* Bejelentkezés adatainak ellenőrzése */
	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `sessions` WHERE `ss_uagent`="ERR" AND `ss_date` < ( NOW() - INTERVAL 15 MINUTE )');
	if($_REQUEST['login'] AND $_REQUEST['luser'] AND $_REQUEST['lpass']) {
		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `sessions` WHERE ( `ss_ip`="'.(in_text($_REQUEST['REMOTE_ADDR'])).'" OR `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'" ) AND `ss_uagent`="ERR" LIMIT 15');
		if(mysqli_num_rows($con)<15) {
			$con = mysqli_query($_ENV['MYSQLI'],'
							SELECT *
							FROM `admin_users`
							WHERE `u_user`="'.(in_text($_REQUEST['luser'])).'"
								AND `u_pass`="'.(md5(in_text($_REQUEST['lpass']))).'"
								AND `u_status`="A"
							LIMIT 1');
			if(mysqli_num_rows($con)>0) {
				$sor = mysqli_fetch_array($con,MYSQLI_ASSOC);
				if($_ENV['USER']['ss_uid']>0 OR $_ENV['USER']['ss_aid']>0) {
					mysqli_query($_ENV['MYSQLI'],'
						UPDATE `sessions`
						SET `ss_aid`="'.($sor['u_id']).'",
								`ss_uagent`="'.($_SERVER['HTTP_USER_AGENT']).'"
						WHERE `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
							AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"');
				} else {
					mysqli_query($_ENV['MYSQLI'],'
						INSERT INTO `sessions`
							( `ss_aid`, `ss_phpsessid`, `ss_ip`, `ss_uagent`, `ss_date` )
						VALUES
							( "'.($sor['u_id']).'", "'.($_REQUEST['PHPSESSID']).'", "'.($_SERVER['REMOTE_ADDR']).'", "'.($_SERVER['HTTP_USER_AGENT']).'", now() )');
				}
				mysqli_query($_ENV['MYSQLI'],'UPDATE `admin_users` SET `u_ldate`=now() WHERE `u_id`="'.($sor['u_id']).'" LIMIT 1');
				$con = mysqli_query($_ENV['MYSQLI'],'
					SELECT *
					FROM `sessions`
					LEFT JOIN `admin_users`
						ON `ss_aid`=`u_id`
					WHERE `ss_aid`=`u_id`
						AND `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
						AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"
						AND `u_status`="A"
					LIMIT 1');
				if(mysqli_num_rows($con)>0) {
					$_ENV['USER'] = mysqli_fetch_array($con,MYSQLI_ASSOC);
					mysqli_query($_ENV['MYSQLI'],'
						UPDATE `sessions`
						SET `ss_date`=now()
						WHERE `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
							AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"');
				}
			} else {
				mysqli_query($_ENV['MYSQLI'],'
					INSERT INTO `sessions`
						( `ss_phpsessid`, `ss_ip`, `ss_uagent`, `ss_date` )
					VALUES
						( "'.($_REQUEST['PHPSESSID']).'", "'.($_SERVER['REMOTE_ADDR']).'", "ERR", now() )');
				$_ENV['LMSG'] = '{admin_user_login_error}';
			}
		} else {
			$_ENV['LMSG'] = '{admin_user_login_wait}';
		}
	}

	if($_REQUEST['logout']) {
		if($_ENV['USER']['ss_uid']>0) {
			mysqli_query($_ENV['MYSQLI'],'
				UPDATE `sessions`
				SET `ss_aid`="0"
				WHERE `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
					AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"');
		} else {
			mysqli_query($_ENV['MYSQLI'],'
				DELETE FROM `sessions`
				WHERE `ss_phpsessid`="'.($_REQUEST['PHPSESSID']).'"
					AND `ss_ip`="'.($_SERVER['REMOTE_ADDR']).'"');
			unSet($_ENV['USER']);
		}
		setcookie(md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'].date('Ymd')), false, time()-86400, '/');
		$_SESSION[md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'].date('Ymd'))] = false;
		unSet($_SESSION[md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'].date('Ymd'))]);
	}

	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `sessions` WHERE `ss_date` < ( NOW() - INTERVAL 1 DAY )');
} else {
	$_ENV['LMSG'] = '{admin_user_login_notinst}';
}
if($_ENV['LMSG']) {
	$_ENV['jSon']['SitePage'] = false;
	$_ENV['jSon']['LoginAlert'] = $_ENV['LMSG'];
}

if($_ENV['USER']['u_id']>0) {
	$_ENV['HEAD']['user_date'] = date('Y-m-d H:i',strtotime($_ENV['USER']['u_ldate']));
	$_ENV['HEAD']['user_nev'] = $_ENV['USER']['u_nev'];
	$_ENV['HEAD']['user_name'] = $_ENV['USER']['u_user'];
	$_ENV['HEAD']['user_mail'] = $_ENV['USER']['u_mail'];
	$_ENV['HEAD']['user_tel'] = $_ENV['USER']['u_tel'];
	$_ENV['HEAD']['user_id'] = $_ENV['USER']['u_id'];
}
?>