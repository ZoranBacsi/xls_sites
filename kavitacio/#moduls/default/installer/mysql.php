<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
	$_MySQL = NULL;
	$_MySQL = Array();

	$table = 'sys_config_pack';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`cfp_id` bigint(20) NOT NULL auto_increment,
			`cfp_index` int(4) NOT NULL,
			`cfp_pref` varchar(32) NOT NULL,
			`cfp_name` varchar(64) NOT NULL,
			`cfp_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (`cfp_id`),
			KEY `cfp_pref` (`cfp_pref`),
			KEY `cfp_index` (`cfp_index`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'sys_config';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`cf_id` bigint(20) NOT NULL auto_increment,
			`cf_pack` varchar(32) NOT NULL,
			`cf_code` varchar(32) NOT NULL,
			`cf_name` varchar(64) NOT NULL,
			`cf_type` varchar(32) NOT NULL,
			`cf_set` varchar(250) NOT NULL,
			`cf_value` text NOT NULL,
			`cf_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (`cf_id`),
			KEY `cf_pack` (`cf_pack`),
			KEY `cf_code` (`cf_code`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'modul';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`mod_id` int(10) NOT NULL auto_increment,
			`mod_nev` varchar(64) NOT NULL,
			`mod_path` varchar(32) NOT NULL,
			`mod_index` int(10) NOT NULL,
			`mod_h1` varchar(255) NOT NULL,
			`mod_title` varchar(255) NOT NULL,
			`mod_keyw` varchar(255) NOT NULL,
			`mod_desc` text NOT NULL,
			PRIMARY KEY  (`mod_id`),
			KEY `mod_path` (`mod_path`),
			KEY `mod_index` (`mod_index`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'reurl';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`ru_id` bigint(20) NOT NULL auto_increment,
			`ru_modul` int(10) NOT NULL,
			`ru_status` char(1) NOT NULL default 'I',
			`ru_index` char(1) NOT NULL default 'I',
			`ru_elem_id` varchar(32) NOT NULL,
			`ru_reurl` varchar(255) NOT NULL,
			`ru_mywfile` varchar(255) NOT NULL,
			`ru_myafile` varchar(255) NOT NULL,
			`ru_h1` varchar(255) NOT NULL,
			`ru_title` varchar(255) NOT NULL,
			`ru_keyw` varchar(255) NOT NULL,
			`ru_desc` text NOT NULL,
			`ru_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`ru_id`),
			KEY `ru_modul` (`ru_modul`),
			KEY `ru_index` (`ru_index`),
			KEY `ru_status` (`ru_status`),
			KEY `ru_elem_id` (`ru_elem_id`),
			KEY `ru_reurl` (`ru_reurl`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'captcha';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`ip` varchar(32) NOT NULL,
			`key` varchar(32) NOT NULL,
			`value` varchar(8) NOT NULL,
			`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `ip` (`ip`),
			KEY `key` (`key`),
			KEY `value` (`value`),
			KEY `time` (`time`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'sessions';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`ss_id` bigint(20) NOT NULL auto_increment,
			`ss_aid` bigint(20) NOT NULL,
			`ss_uid` bigint(20) NOT NULL,
			`ss_phpsessid` varchar(32) NOT NULL,
			`ss_ip` varchar(32) NOT NULL,
			`ss_uagent` varchar(255) NOT NULL,
			`ss_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`ss_id`),
			KEY `ss_aid` (`ss_aid`),
			KEY `ss_uid` (`ss_uid`),
			KEY `ss_phpsessid` (`ss_phpsessid`),
			KEY `ss_date` (`ss_date`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'admin_users';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`u_id` bigint(20) NOT NULL auto_increment,
			`u_sys` int(1) NOT NULL,
			`u_admin` int(1) NOT NULL,
			`u_guest` int(1) NOT NULL,
			`u_user` varchar(32) NOT NULL,
			`u_pass` varchar(32) NOT NULL,
			`u_status` char(1) NOT NULL,
			`u_nev` varchar(32) NOT NULL,
			`u_mail` varchar(64) NOT NULL,
			`u_tel` varchar(32) NOT NULL,
			`u_rdate` datetime NOT NULL default '0000-00-00 00:00:00',
			`u_ldate` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`u_id`),
			KEY `u_sys` (`u_sys`),
			KEY `u_admin` (`u_admin`),
			KEY `u_guest` (`u_guest`),
			KEY `u_user` (`u_user`),
			KEY `u_pass` (`u_pass`),
			KEY `u_status` (`u_status`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'kepek';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`kep_id` int(11) NOT NULL auto_increment,
			`kep_modul` varchar(32) NOT NULL,
			`kep_mid` varchar(32) NOT NULL,
			`kep_sorsz` int(11) NOT NULL,
			`kep_cimke` varchar(255) NOT NULL,
			`kep_cimke_en` varchar(255) NOT NULL,
			`kep_cimke_de` varchar(255) NOT NULL,
			`kep_cimke_it` varchar(255) NOT NULL,
			`kep_cimke_ru` varchar(255) NOT NULL,
			`kep_cimke_ro` varchar(255) NOT NULL,
			`kep_cimke_sk` varchar(255) NOT NULL,
			`kep_eredeti` varchar(255) NOT NULL,
			`kep_nagy` varchar(255) NOT NULL,
			`kep_kozepes` varchar(255) NOT NULL,
			`kep_kicsi` varchar(255) NOT NULL,
			`kep_type` varchar(32) NOT NULL,
			`kep_name` varchar(255) NOT NULL,
			`kep_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`kep_id`),
			KEY `kep_modul` (`kep_modul`),
			KEY `kep_mid` (`kep_mid`),
			KEY `kep_sorsz` (`kep_sorsz`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'maps';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`map_id` int(11) NOT NULL auto_increment,
			`map_sorsz` int(11) NOT NULL,
			`map_modul` varchar(32) NOT NULL,
			`map_mid` varchar(32) NOT NULL,
			`map_lati` varchar(32) NOT NULL,
			`map_longi` varchar(32) NOT NULL,
			`map_irsz` varchar(32) NOT NULL,
			`map_varos` varchar(64) NOT NULL,
			`map_utca` varchar(128) NOT NULL,
			`map_cimke` varchar(255) NOT NULL,
			`map_text` text NOT NULL,
			`map_tel` varchar(32) NOT NULL,
			`map_fax` varchar(32) NOT NULL,
			`map_email` varchar(64) NOT NULL,
			`map_web` varchar(64) NOT NULL,
			`map_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`map_id`),
			KEY `map_modul` (`map_modul`),
			KEY `map_mid` (`map_mid`),
			KEY `map_sorsz` (`map_sorsz`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'forms';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`form_id` int(11) NOT NULL auto_increment,
			`form_one` int(1) NOT NULL,
			`form_name` varchar(64) NOT NULL,
			`form_mail` text NOT NULL,
			`form_text` text NOT NULL,
			`form_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`form_id`),
			KEY `form_name` (`form_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'forms_row';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`fr_id` bigint(20) NOT NULL auto_increment,
			`fr_form_id` int(11) NOT NULL,
			`fr_sorsz` int(11) NOT NULL,
			`fr_code` varchar(32) NOT NULL,
			`fr_label` varchar(128) NOT NULL,
			`fr_type` varchar(32) NOT NULL,
			`fr_minlength` int(11) NOT NULL,
			`fr_maxlength` int(11) NOT NULL,
			`fr_required` int(1) NOT NULL,
			`fr_set` text NOT NULL,
			`fr_value` text NOT NULL,
			`fr_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (`fr_id`),
			KEY `fr_form_id` (`fr_form_id`),
			KEY `fr_sorsz` (`fr_sorsz`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);
	
	$table = 'forms_log';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".($table)."` (
			`fl_id` int(11) NOT NULL auto_increment,
			`fl_form_id` int(11) NOT NULL,
			`fl_fr_id` int(11) NOT NULL,
			`fl_ip` varchar(32) NOT NULL,
			`fl_post_hash` varchar(32) NOT NULL,
			`fl_text` text NOT NULL,
			`fl_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`fl_id`),
			KEY `fl_form_id` (`fl_form_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	TableControl($table,$_MySQL[$table]);
	

	$con = mysqli_query($_ENV['MYSQLI'],"SELECT * FROM `modul` WHERE `mod_path`='default' LIMIT 1");
	if(!mysqli_num_rows($con)>0) {
		mysqli_query($_ENV['MYSQLI'],"
			INSERT INTO `modul` ( `mod_nev`, `mod_path`, `mod_index` )
				VALUES ( 'Statikus rendszer', 'default', '9999' );");
		$modul_id=mysqli_insert_id($_ENV['MYSQLI']);

		/* Admin felhasználók */
		mysqli_query($_ENV['MYSQLI'],"
		INSERT INTO `admin_users` (`u_id`, `u_admin`, `u_sys`, `u_guest`, `u_user`, `u_pass`, `u_status`, `u_nev`, `u_mail`, `u_tel`, `u_rdate`, `u_ldate`) VALUES
		(1, 1, 1, '0', 'root', md5('xlsponthu'), 'A', 'root', 'info@domain.hu', '0612345678', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
		(2, 1, 0, '0', 'admin', md5('admin'), 'A', 'Admin', 'info@domain.hu', '0612345678', '0000-00-00 00:00:00', '0000-00-00 00:00:00');");

		/* Beállítások */
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config_pack`
			( `cfp_index`, `cfp_pref`, `cfp_name`, `cfp_date` )
				VALUES
			( "9999", "def-mail", "Email beállítások", now() ),
			( "9998", "def-kepr", "Képek méretezése", now() )');
		
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config`
			( `cf_pack`, `cf_name`, `cf_code`, `cf_value`, `cf_type`, `cf_set`, `cf_date` )
				VALUES
			( "def-mail", "Küldő neve", "sysMailName", "Site Üzemeltetője", "text", "3|32", now() ),
			( "def-mail", "Email címe", "sysMailAddress", "info@domain.hu", "mail", "3|64", now() ),
			( "def-mail", "Küldés módja", "sysMailMode", "PHP", "select", "SMTP|PHP", now() ),
			( "def-mail", "SMTP Protokol", "sysMailSmtpProt", "tcp", "select", "tcp|tls|ssl|sslv2|sslv3", now() ),
			( "def-mail", "SMTP Host", "sysMailSmtpHost", "localhost", "text", "3|64", now() ),
			( "def-mail", "SMTP Port", "sysMailSmtpPort", "25", "number", "2|6", now() ),
			( "def-mail", "SMTP User", "sysMailSmtpUser", "", "text", "0|64", now() ),
			( "def-mail", "SMTP Password", "sysMailSmtpPass", "", "pass", "0|32", now() ),
			( "def-kepr", "Képek mappája", "sysKeprPath", "/files/kepek/", "text", "3|64", now() ),
			( "def-kepr", "Nagy kép fálj vége", "sysKeprNagyAttr", "_l.jpg", "text", "3|32", now() ),
			( "def-kepr", "Nagy kép<br/>max széllesége", "sysKeprNagyWidth", "1600", "number", "2|4", now() ),
			( "def-kepr", "Nagy kép<br/>max magassága", "sysKeprNagyHeight", "1600", "number", "2|4", now() ),
			( "def-kepr", "Közepes kép fálj vége", "sysKeprKozepesAttr", "_m.jpg", "text", "3|32", now() ),
			( "def-kepr", "Közepes kép<br/>max széllesége", "sysKeprKozepesWidth", "360", "number", "2|4", now() ),
			( "def-kepr", "Közepes kép<br/>max magassága", "sysKeprKozepesHeight", "360", "number", "2|4", now() ),
			( "def-kepr", "Kicsi kép fálj vége", "sysKeprKicsiAttr", "_s.jpg", "text", "3|32", now() ),
			( "def-kepr", "Kicsi kép<br/>max széllesége", "sysKeprKicsiWidth", "150", "number", "2|4", now() ),
			( "def-kepr", "Kicsi kép<br/>max magassága", "sysKeprKicsiHeight", "150", "number", "2|4", now() )');
	}

	$_MySQL = NULL;
?>