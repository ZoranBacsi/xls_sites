<?php
$input = '<script>alert("B�na F�hnwelle-frizur�m van, ez�rt webhelyeket t�r�k fel");</script>';
echo htmlspecialchars($input) . '<br />';
echo htmlentities($input);
?>
