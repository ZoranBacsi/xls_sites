<?php
$szam="36-20)/946-75-55";
$szam=preg_replace("/[^0-9]/","",$szam);
print $szam;
print "<br>";
if ("36"==substr($szam,0,2)) {
    $korzet=substr($szam,2,2);
    $elso=substr($szam,4,3);
    $masodik=substr($szam,7,4);
    print "+36" . $korzet . "/" . $elso . "-" . $masodik;
}
?>