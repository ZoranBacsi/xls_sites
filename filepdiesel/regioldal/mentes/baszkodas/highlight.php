<?php
highlight_string("<?php phpinfo(); ?>");
highlight_string('<?php header("Content-Type: text/html; charset=utf-8");

//	a $szoveg cseréjéért felelős függvény
function csere ($a)
				{
					$a = ereg_replace("&lt;p&gt;", "<p>", $a);
					$a = ereg_replace("&lt;/p&gt;", "</p>", $a);
					$a = ereg_replace("&lt;em&gt;", "<em>", $a);
					$a = ereg_replace("&lt;/em&gt;", "</em>", $a);
					$a = ereg_replace("&lt;cite&gt;", "<cite>", $a);
					$a = ereg_replace("&lt;/cite&gt;", "</cite>", $a);
					return ($a);
				} ?>');
?>
