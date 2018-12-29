<?php
$input = '<script>alert("Béna Föhnwelle-frizurám van, ezért webhelyeket török fel");</script>';
echo htmlspecialchars($input) . '<br />';
echo htmlentities($input);
?>
