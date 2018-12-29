<?php 
$szam1=$_POST["szam1"];
$szam2=$_POST["szam2"];
function osszeadas ($szam1, $szam2)
    {
	return($szam1+$szam2);
    }
    
function kivonas ($szam1, $szam2)
    {
	return($szam1-$szam2);
    }
    
function szorzas ($szam1, $szam2)
    {
	return($szam1*$szam2);
    }
    
function osztas ($szam1, $szam2)
    {
	return($szam1/$szam2);
    }

if (isset($_POST["osszead"]))
{
$muvelet="osszeadas";
}

if (isset($_POST["kivon"]))
{
$muvelet="kivonas";
}

if (isset($_POST["szoroz"]))
{
$muvelet="szorzas";
}

if (isset($_POST["oszt"]))
{
$muvelet="osztas";
}
print $muvelet($szam1, $szam2);

?>