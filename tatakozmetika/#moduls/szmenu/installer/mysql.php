<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
	$_MySQL = NULL;
	$_MySQL = Array();

	$table = 'szmenu';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".$table."` (
			`szm_id` int(10) NOT NULL auto_increment,
			`szm_auid` int(10) NOT NULL,
			`szm_k_id` int(10) NOT NULL,
			`szm_level` int(10) NOT NULL,
			`szm_sorsz` int(10) NOT NULL,
			`szm_status` char(1) NOT NULL,
			`szm_public` char(1) NOT NULL,
			`szm_private_kategs` varchar(128) NOT NULL,
			`szm_mod` char(1) NOT NULL,
			`szm_tipus` char(1) NOT NULL,
			`szm_gal` int(10) NOT NULL,
			`szm_reurl` varchar(255) NOT NULL,
			`szm_link` varchar(255) NOT NULL,
			`szm_href` text NOT NULL,
			`szm_target` int(1) NOT NULL,
			`szm_cim` varchar(128) NOT NULL,
			`szm_index` char(1) NOT NULL,
			`szm_h1` varchar(255) NOT NULL,
			`szm_title` varchar(255) NOT NULL,
			`szm_keyw` varchar(255) NOT NULL,
			`szm_desc` text NOT NULL,
			`szm_text` mediumtext NOT NULL,
			`szm_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`szm_id`),
			KEY `szm_k_id` (`szm_k_id`),
			KEY `szm_sorsz` (`szm_sorsz`),
			KEY `szm_status` (`szm_status`),
			KEY `szm_reurl` (`szm_reurl`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'szpage';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".$table."` (
			`szp_id` int(10) NOT NULL auto_increment,
			`szp_auid` int(10) NOT NULL,
			`szp_status` char(1) NOT NULL,
			`szp_public` char(1) NOT NULL,
			`szp_gal` int(10) NOT NULL,
			`szp_reurl` varchar(255) NOT NULL,
			`szp_cim` varchar(128) NOT NULL,
			`szp_index` char(1) NOT NULL,
			`szp_h1` varchar(255) NOT NULL,
			`szp_title` varchar(255) NOT NULL,
			`szp_keyw` varchar(255) NOT NULL,
			`szp_desc` text NOT NULL,
			`szp_rtext` mediumtext NOT NULL,
			`szp_text` mediumtext NOT NULL,
			`szp_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`szp_id`),
			KEY `szp_status` (`szp_status`),
			KEY `szp_reurl` (`szp_reurl`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'szmp';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".$table."` (
			`szmp_id` int(10) NOT NULL auto_increment,
			`szmp_sorsz` int(3) NOT NULL,
			`szmp_m_id` int(10) NOT NULL,
			`szmp_p_id` int(10) NOT NULL,
			`szmp_status` char(1) NOT NULL,
			PRIMARY KEY  (`szmp_id`),
			UNIQUE KEY `szmp_m_id` (`szmp_m_id`,`szmp_p_id`),
			KEY `szmp_sorsz` (`szmp_sorsz`),
			KEY `szmp_status` (`szmp_status`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'modul';
	$con = mysqli_query($_ENV['MYSQLI'],"SELECT * FROM `".$table."` WHERE `mod_path`='szmenu' LIMIT 1");
	if(!mysqli_num_rows($con)>0) {
		mysqli_query($_ENV['MYSQLI'],"
			INSERT INTO `".$table."` (`mod_id`, `mod_nev`, `mod_path`, `mod_index`) VALUES
				(NULL, 'Szerkeszthető menű', 'szmenu', '900');");
		$modul_id=mysqli_insert_id($_ENV['MYSQLI']);

		mysqli_query($_ENV['MYSQLI'],"
			INSERT INTO `szmenu` (`szm_id`, `szm_sorsz`, `szm_reurl`, `szm_level`, `szm_k_id`, `szm_public`, `szm_mod`, `szm_tipus`, `szm_status`, `szm_link`, `szm_date`) VALUES
				(1, 1, 'hu', '0', '0', 'N', 'M', 'N', 'A', 'Magyar menü', '0000-00-00 00:00:00'),
				(2, 2, 'en', '0', '0', 'N', 'M', 'N', 'A', 'Angol menü', '0000-00-00 00:00:00'),
				(3, 3, 'de', '0', '0', 'N', 'M', 'N', 'A', 'Német menü', '0000-00-00 00:00:00'),
				(4, 4, 'it', '0', '0', 'N', 'M', 'N', 'A', 'Olasz menü', '0000-00-00 00:00:00'),
				(5, 5, 'ru', '0', '0', 'N', 'M', 'N', 'A', 'Orosz menü', '0000-00-00 00:00:00'),
				(6, 6, 'ro', '0', '0', 'N', 'M', 'N', 'A', 'Román menü', '0000-00-00 00:00:00'),
				(7, 7, 'sk', '0', '0', 'N', 'M', 'N', 'A', 'Szlovák menü', '0000-00-00 00:00:00'),
				(8, 8, 'jp', '0', '0', 'N', 'M', 'N', 'A', 'Japán menü', '0000-00-00 00:00:00'),
				(11, 1, 'hu', '0', '0', 'N', 'M', 'N', 'A', 'Magyar menü 2.', '0000-00-00 00:00:00'),
				(12, 2, 'en', '0', '0', 'N', 'M', 'N', 'A', 'Angol menü 2.', '0000-00-00 00:00:00'),
				(13, 3, 'de', '0', '0', 'N', 'M', 'N', 'A', 'Német menü 2.', '0000-00-00 00:00:00'),
				(14, 4, 'it', '0', '0', 'N', 'M', 'N', 'A', 'Olasz menü 2.', '0000-00-00 00:00:00'),
				(15, 5, 'ru', '0', '0', 'N', 'M', 'N', 'A', 'Orosz menü 2.', '0000-00-00 00:00:00'),
				(16, 6, 'ro', '0', '0', 'N', 'M', 'N', 'A', 'Román menü 2.', '0000-00-00 00:00:00'),
				(17, 7, 'sk', '0', '0', 'N', 'M', 'N', 'A', 'Szlovák menü 2.', '0000-00-00 00:00:00'),
				(18, 8, 'jp', '0', '0', 'N', 'M', 'N', 'A', 'Japán menü 2.', '0000-00-00 00:00:00');");

		/* Beállítások */
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config_pack`
			( `cfp_index`, `cfp_pref`, `cfp_name`, `cfp_date` )
				VALUES
			( "9900", "szm-menu", "Szerk.Menü beállítások", now() )
		');
		
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config`
			( `cf_pack`, `cf_name`, `cf_code`, `cf_value`, `cf_type`, `cf_set`, `cf_date` )
				VALUES
			( "szm-menu", "Menü szintek", "szmMaxLevel", "1", "number", "1|2", now() ),
			( "szm-menu", "Első szinten maximum", "szmMaxFirstLevel", "999", "number", "1|3", now() ),
			( "szm-menu", "Külső URL", "szmKulsoURL", "Igen", "select", "Igen|Nem", now() ),
			( "szm-menu", "Fájl letöltés", "szmFileLetolt", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Almenü típusok", "szmType", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Reg. köt mód", "szmRegKot", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Galéria társítás", "szmGalTarsit", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Szerk. oldalak", "szmSzerkOldal", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Szerk. Röv. oldalak", "szmSzerkRovOldal", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Szerk. Cikk oldalak", "szmSzerkCikkOldal", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Menü kép", "szmMenuKep", "Nem", "select", "Igen|Nem", now() ),
			( "szm-menu", "Menü kép helye", "szmMenuKepMod", "Icon", "select", "Icon|Background", now() )
		');
	}

	$_MySQL = NULL;
?>