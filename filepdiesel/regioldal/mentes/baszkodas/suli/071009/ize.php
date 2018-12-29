<?php
function megnovel_ertek ($szam) {
  $szam++;
  }
  function megnovel_cim (&$szam) {
    $szam++;
    }
    $szam = 13;
    echo "Az eredeti szám: $szam<br>";
    megnovel_ertek($szam);
    echo "Az érték szerinti paraméterátadás után az
       eredeti szám: $szam<br>";
       megnovel_cim($szam);
       echo "Az cim szerinti paraméterátadás után az
          eredeti szám: $szam<br>";
?>	  