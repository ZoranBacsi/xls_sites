<?php

header('Content-Type: text/html; charset=utf-8');

$a = 1;
$b = 100;

print "<pre>";

$paros = 0;

for (; $a<$b; $a++) {
	if ($a%2 == 0) {
		print "$a\n";
		$paros = 1;
	}
}

if ($paros != 1) print "nincs páros\n";

print "</pre>";

?>