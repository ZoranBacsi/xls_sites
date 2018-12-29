<?php
    header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
</head>
<body>
    <form name="adatos" action="rajz.php" method="get">
    Keresztnév: <input type="text" name="nev" size="20"><br>
    Hány db?: <select name="darab">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    </select><br>
    Mit?: <input type="radio" name="alak" value="kor"> Kör <input type="radio" name="alak" 
value="teglalap"> Téglalap <input type="radio" name="alak" 
value="negyzet"> Négyzet<br>
    Színe: <input type="radio" name="szin" value="piros"> Piros <input type="radio" 
name="szin" 
value="sarga"> Sárga <input type="radio" name="szin" value="kek"> 
Kék<br>
    Alapszín: <input type="radio" name="alapszin" value="fekete"> 
Fekete <input type="radio" name="alapszin" 
value="zold"> Zöld <input type="radio" name="alapszin" value="narancs"> 
narancs<br>
    <input type="submit" name="mehet" value="Rajzolj!">
    </form>
</body>
</html>

<?php
/*    if (isset($_POST['mehet']))
    {
	print "<img src=\"rajz.php\">";
    }
*/
?>
