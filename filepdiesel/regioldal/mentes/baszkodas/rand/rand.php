<?php
header('Content-Type: text/html; charset=utf-8');
print "Dolláregy" . $rand = rand(1, 9);
print "<br />";
for ($i=0; $i<7; $i++) {
	$rand = $rand . rand(0, 9);
}
print "A kész kód:" . $rand;
?>