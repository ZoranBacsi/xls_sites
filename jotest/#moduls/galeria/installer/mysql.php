<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_MySQL = NULL;
$_MySQL = Array();

$table = 'galeria';
$_MySQL[$table] = Array();
$_MySQL[$table][] = "
	CREATE TABLE IF NOT EXISTS `".$table."` (
		`gal_id` bigint(20) NOT NULL auto_increment,
		`gal_p_id` bigint(20) NOT NULL,
		`gal_level` int(4) NOT NULL,
		`gal_sorsz` int(4) NOT NULL,
		`gal_status` char(1) NOT NULL,
		`gal_reurl` varchar(255) NOT NULL,
		`gal_defkep` int(11) NOT NULL,
		`gal_cim` varchar(255) NOT NULL,
		`gal_cim_en` varchar(255) NOT NULL,
		`gal_cim_de` varchar(255) NOT NULL,
		`gal_title` varchar(255) NOT NULL,
		`gal_keyw` varchar(255) NOT NULL,
		`gal_desc` varchar(255) NOT NULL,
		`gal_text` longtext NOT NULL,
		`gal_date` datetime NOT NULL default '0000-00-00 00:00:00',
		PRIMARY KEY  (`gal_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
TableControl($table,$_MySQL[$table]);

$table = 'modul';
$con = mysqli_query($_ENV['MYSQLI'],"SELECT * FROM `".$table."` WHERE `mod_path`='galeria' LIMIT 1");
if(!mysqli_num_rows($con)>0) {
	mysqli_query($_ENV['MYSQLI'],"
		INSERT INTO `".$table."` (`mod_id`, `mod_nev`, `mod_path`, `mod_index`) VALUES
			(NULL, 'Galéria', 'galeria', '600');");
	$modul_id=mysqli_insert_id($_ENV['MYSQLI']);

	mysqli_query($_ENV['MYSQLI'],"
		INSERT INTO `reurl` (`ru_id`, `ru_modul`, `ru_reurl`) VALUES
			(NULL, '".($modul_id)."', 'galeria');");
	
		/* Beállítások */
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config_pack`
			( `cfp_index`, `cfp_pref`, `cfp_name`, `cfp_date` )
				VALUES
			( "1100", "gal-kepr", "Galéria beállítás", now() )');
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config`
			( `cf_pack`, `cf_name`, `cf_code`, `cf_value`, `cf_type`, `cf_set`, `cf_date` )
				VALUES
			( "gal-kepr", "Galériák maximuma", "galMax", "50", "number", "1|3", now() ),
			( "gal-kepr", "Képek maximuma", "galMaxKep", "100", "number", "1|3", now() ),
			( "gal-kepr", "Képek cimkézése", "galCimke", "Igen", "select", "Igen|Nem", now() ),
			( "gal-kepr", "Képek sorba rendezése", "galSorsz", "Igen", "select", "Igen|Nem", now() ),
			( "gal-kepr", "Album kép választás", "galAlbum", "Nem", "select", "Igen|Nem", now() ),
			( "gal-kepr", "Nagy kép<br/>max széllesége", "galKepNagyWidth", "1600", "number", "2|4", now() ),
			( "gal-kepr", "Nagy kép<br/>max magassága", "galKepNagyHeight", "1600", "number", "2|4", now() ),
			( "gal-kepr", "Közepes kép<br/>max széllesége", "galKepKozepesWidth", "360", "number", "2|4", now() ),
			( "gal-kepr", "Közepes kép<br/>max magassága", "galKepKozepesHeight", "360", "number", "2|4", now() )');
}

$_MySQL = NULL;
?>