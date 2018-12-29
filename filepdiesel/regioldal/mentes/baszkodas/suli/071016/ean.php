<?php
$kod=$_POST["kod"];
if (strlen($kod) == 13) {

    if (is_numeric($kod)) {
    
	$paritas=$kod[12];
    
	$a=0;
	for ($i=0; $i<=10; $i=$i+2) {
	    $a=$a+$kod[$i];
	}
    
        $b=0;
	for ($j=1; $j<=11; $j=$j+2) {
	    $b=$b+($kod[$j]*3);
	}
    
	if ($paritas == 10-(($a+$b)%10)) print ("Helyes a kód");
	else print ("A kód paritásértéke nem megfelelő");
    }
    
    else print "Számokat kellene megadni...";
}

else print ("Nem jó hosszúságú kódot adtál meg!");
?>