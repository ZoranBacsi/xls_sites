<?php 
    $a=$_POST["a_oldal"];
    $b=$_POST["b_oldal"];
    $c=$_POST["c_oldal"];
    
    $d = (int) $a
    if
    if ($a>0 and $b>0 and $c>0)
    {
	if ($a+$b>$c and $a+$c>$b and $b+$c>$a)
	{
	    print("A háromszög megszerkeszthető!");
	}
	else
	{
	    print("A háromszög nem szerkeszthető meg!");
	}
    }
    else
    {
	print("Legyen inkább pozitív...");
    }
 ?>