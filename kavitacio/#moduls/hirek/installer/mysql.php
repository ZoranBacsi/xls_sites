<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
	$_MySQL = NULL;
	$_MySQL = Array();

	$table = 'hirek';
	$_MySQL[$table] = Array();
	$_MySQL[$table][] = "
		CREATE TABLE IF NOT EXISTS `".$table."` (
			`hir_id` bigint(20) NOT NULL auto_increment,
			`hir_torol` int(1) NOT NULL,
			`hir_lang` char(8) NOT NULL,
			`hir_sorszam` int(3) NOT NULL,
			`hir_status` char(1) NOT NULL,
			`hir_nev` varchar(255) NOT NULL,
			`hir_reurl` varchar(255) NOT NULL,
			`hir_h1` varchar(255) NOT NULL,
			`hir_title` varchar(255) NOT NULL,
			`hir_keyw` varchar(255) NOT NULL,
			`hir_desc` varchar(255) NOT NULL,
			`hir_rovidleiras` text NOT NULL,
			`hir_leiras` longtext NOT NULL,
			`hir_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`hir_id`),
			KEY `hir_sorszam` (`hir_sorszam`),
			KEY `hir_status` (`hir_status`),
			KEY `hir_lang` (`hir_lang`),
			KEY `hir_date` (`hir_date`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;";
	TableControl($table,$_MySQL[$table]);

	$table = 'modul';
	$con = mysqli_query($_ENV['MYSQLI'],"SELECT * FROM `".$table."` WHERE `mod_path`='hirek' LIMIT 1");
	if(!mysqli_num_rows($con)>0) {
		mysqli_query($_ENV['MYSQLI'],"
			INSERT INTO `".$table."` (`mod_id`, `mod_nev`, `mod_path`, `mod_index`) VALUES
				(NULL, 'Hírek', 'hirek', '900');");
		$modul_id=mysqli_insert_id($_ENV['MYSQLI']);

		mysqli_query($_ENV['MYSQLI'],"
			INSERT INTO `reurl` (`ru_id`, `ru_modul`, `ru_reurl`) VALUES
				(NULL, '".($modul_id)."', 'hirek');");
		
		/* Beállítások */
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config_pack`
			( `cfp_index`, `cfp_pref`, `cfp_name`, `cfp_date` )
				VALUES
			( "9800", "hir-conf", "Hírek beállításai", now() )
		');
		
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config`
			( `cf_pack`, `cf_name`, `cf_code`, `cf_value`, `cf_type`, `cf_set`, `cf_date` )
				VALUES
			( "hir-conf", "Hírcsoport szintek", "hirMaxLevel", "1", "number", "1|2", now() ),
			( "hir-conf", "Aktualis hírek db", "hirMaxLevel", "10", "number", "1|3", now() ),
			( "hir-conf", "Rövid hírek", "hirRovidHir", "Nem", "select", "Igen|Nem", now() ),
			( "hir-conf", "Reg. köt mód", "hirRegKot", "Nem", "select", "Igen|Nem", now() ),
			( "hir-conf", "Galéria társítás", "hirGalTarsit", "Nem", "select", "Igen|Nem", now() )
		');
	}

	$_MySQL = NULL;
?>