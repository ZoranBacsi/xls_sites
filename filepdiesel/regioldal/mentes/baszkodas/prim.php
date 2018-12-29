<?php
header('Content-Type: text/html; charset=utf-8');

$a = 1;
$b = 100;

print "<pre>";

for (; $a < $b; $a++) {
	$k = 0;
	for ($p = 1; $p <= sqrt($a); $p++) {
		if ($a%$p == 0) {
			$k++;
		}
	}
	if ($k <= 1) print "$a\n";
}

print "</pre>";

?>