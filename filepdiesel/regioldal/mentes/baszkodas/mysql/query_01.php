<?php
header('Content-Type: text/html; charset=utf-8');

if (function_exists('mysql_set_charset') === false) {
	function mysql_set_charset($charset, $link_identifier = null)
    {
        if ($link_identifier == null) {
            return mysql_query('SET CHARACTER SET "'.$charset.'"');
        } else {
            return mysql_query('SET CHARACTER SET "'.$charset.'"', $link_identifier);
        }
    }
}

if ($db = @mysql_connect('localhost', 'root')) {
	mysql_set_charset('utf8', $db);
	mysql_select_db('muphrid', $db);
	echo "Oké";

	$result = mysql_query('SELECT * FROM blog ORDER BY datum DESC', $db);
	while ($row = mysql_fetch_assoc($result)) {
		print "dátum: " . $row['datum'] . "idő: " . $row['ido'] . "bejegyzés: " . $row['bejegyzes'] . "<br>";
	}
	mysql_free_result($result);
	mysql_close($db);
} else {
	echo "Nem oké";
}
?>