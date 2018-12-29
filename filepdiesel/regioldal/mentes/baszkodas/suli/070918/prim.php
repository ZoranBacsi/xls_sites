<?
$a = 2;
$b = 100;

for(; $a<$b; $a++){
    $k=0;
    for ($p=1; $p<=sqrt($a); $p++){
	if($a%$p==0){
	    $k++;
	}
    }
    if($k<=1){
        echo "$a prim <br>";
    }
}
?>