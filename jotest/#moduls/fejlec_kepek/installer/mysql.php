<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_MySQL = NULL;
$_MySQL = Array();

$table = 'fejlec_kepek';
$_MySQL[$table] = Array();
$_MySQL[$table][] = "
	CREATE TABLE IF NOT EXISTS `".$table."` (
		`fk_id` bigint(20) NOT NULL auto_increment,
		`fk_status` char(1) NOT NULL,
		`fk_sorszam` int(3) NOT NULL,
		`fk_kep_nagy` varchar(255) NOT NULL,
		`fk_kep_kicsi` varchar(255) NOT NULL,
		`fk_url` TEXT NOT NULL,
		PRIMARY KEY (`fk_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
TableControl($table,$_MySQL[$table]);

$table = 'modul';
$con = mysqli_query($_ENV['MYSQLI'],"SELECT * FROM `".$table."` WHERE `mod_path`='fejlec_kepek' LIMIT 1");
if(!mysqli_num_rows($con)>0) {
	mysqli_query($_ENV['MYSQLI'],"
		INSERT INTO `".$table."` (`mod_id`, `mod_nev`, `mod_path`, `mod_index`) VALUES
			(NULL, 'Fejléc képek', 'fejlec_kepek', '10' );");
	$modul_id=mysqli_insert_id($_ENV['MYSQLI']);

	mysqli_query($_ENV['MYSQLI'],"
		INSERT INTO `reurl` (`ru_id`, `ru_modul`, `ru_reurl`) VALUES
			(NULL, '".($modul_id)."', 'fejlec_kepek');");
			
		/* Beállítások */
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config_pack`
			( `cfp_index`, `cfp_pref`, `cfp_name`, `cfp_date` )
				VALUES
			( "1000", "fks-kepr", "Fejléc képváltó", now() )');
		mysqli_query($_ENV['MYSQLI'],'
			INSERT INTO `sys_config`
			( `cf_pack`, `cf_name`, `cf_code`, `cf_value`, `cf_type`, `cf_set`, `cf_date` )
				VALUES
			( "fks-kepr", "Képek maximuma", "fksMaxKep", "100", "number", "1|3", now() ),
			( "fks-kepr", "Képek cimkézése", "fksCimke", "Nem", "select", "Igen|Nem", now() ),
			( "fks-kepr", "Képek sorba rendezése", "fksSorsz", "Igen", "select", "Igen|Nem", now() ),
			( "fks-kepr", "Képre hivatkozás", "fksHref", "Igen", "select", "Igen|Nem", now() ),
			( "fks-kepr", "Kép fix széllesége", "fksKepFixWidth", "590", "number", "2|4", now() ),
			( "fks-kepr", "Kép fix magassága", "fksKepFixHeight", "266", "number", "2|4", now() )');
}

$_MySQL = NULL;
?>