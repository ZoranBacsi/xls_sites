<html>
<head>
    <title>
	Ulapos
    </title>
</head>
<body>
<php 

if (isset($_POST['mehet']))
    {
	    
?>
<form name="urlapos" action=" <?php print $_SERVER['PHP_SELF']; ?> " method="post">
    <table>
    <php
	function nevcsekk($b) {
	    if (isset($b) AND strlen($b)>1) {
		return(true);
	    } else return(false);
	}
    ?>
    <php if (nevcsekk($_POST['veznev'])) { ?>
    <tr>
	<td>
	    Vezeteknev:
	</td>
	<td> 
	    <input type="text" name="veznev" size="20" value="<php print strip_tags($_POST['veznev']); ?>" />
	</td>
    </tr>
    <php } else { ?>
    <tr>
	<td>
	    <font color="red">Vezeteknev:</font>
	</td>
	<td> 
	    <input type="text" name="veznev" size="20" /><font color="red">A vezeteknev megadasa kotelezo!</font>
	</td>
    </tr>
    <php }; ?>
    <php if (nevcsekk($_POST['kernev'])) { ?>
    <tr>
	<td>
	    Keresztnev:
	</td>
	<td>
	     <input type="text" name="kernev" size="20" value="<php print strip_tags($_POST['kernev']); ?>" />
	</td>
    </tr>
    <php } else { ?>
    <tr>
	<td>
	    <font color="red">Keresztnev:</font>
	</td>
	<td>
	     <input type="text" name="kernev" size="20" /><font color="red">A keresztnev megadasa kotelezo!</font>
	</td>
    </tr>
    <php }; ?>
    <php if (isset($_POST['nem'])) { ?>
    <tr>
	<td>
	    Nem:
	</td>
	<td>
	    <input type="radio" name="nem" value="ferfi" <php if ($_POST['nem']=="ferfi") print "checked"; ?> /> Ferfi <input type="radio" name="nem" value="no" <?php if ($_POST['nem']=="no") print "checked"; ?> /> No<br />
	</td>
    </tr>
    <php } else { ?>
    <tr>
	<td>
	    <font color="red">Nem:</font>
	</td>
	<td>
	    <font color="red"><input type="radio" name="nem" value="ferfi" /> Ferfi <input type="radio" name="nem" value="no" />No<br />Jelold be!!!</font>
	</td>
    </tr>
    <php }; ?>
    <php
	function telefoncsekk($a) {
	    if (isset($a) AND strlen($a)=="7" AND is_numeric($a)) {
		return(true);
	    } else return(false);
	}
    ?>
    <php if (telefoncsekk($_POST['telefon'])) { ?>
    <tr>
	<td>
	    Telefonszam:
	</td>
	<td>
	     <select name="korzet">
	        <option value="20" <php if ($_POST['korzet']=="20") print "selected"; ?> >20</option>
		<option value="30" <php if ($_POST['korzet']=="30") print "selected"; ?> >30</option>
		<option value="70" <php if ($_POST['korzet']=="70") print "selected"; ?> >70</option>
	    </select> 
	    <input type="text" name="telefon" size="10" maxlength="7" value="<?php print $_POST['telefon'] ?> " />
	</td>
    </tr>
    <php } else { ?>
    <tr>
	<td>
	    <font color="red">Telefonszam:</font>
	</td>
	<td>
	     <select name="korzet">
	        <option value="20" <php if ($_POST['korzet']=="20") print "selected"; ?> >20</option>
		<option value="30" <php if ($_POST['korzet']=="30") print "selected"; ?> >30</option>
		<option value="70" <php if ($_POST['korzet']=="70") print "selected"; ?> >70</option>
	    </select> 
	    <input type="text" name="telefon" size="10" maxlength="7" /><br />
	    <font color="red">Hibas adat!</font>
	</td>
    </tr>
    </font>
    <php }; ?>
    <tr>
	<td>
	    Kedvenc szin(ek):
	</td>
	<td>
	     <input type="checkbox" name="szin1" <php if (isset($_POST['szin1'])) print "checked"; ?> /> Piros
	     <input type="checkbox" name="szin2" <php if (isset($_POST['szin2'])) print "checked"; ?> /> Kek
	     <input type="checkbox" name="szin3" <php if (isset($_POST['szin3'])) print "checked"; ?> /> Zold
	</td>
    </tr>
    <tr>
	<td>
	    Jelszo:
	</td>
	<td>
	     <input type="password" name="jelszo" size="20" /><br />
	</td>
    </tr>
    <tr>
	<td>
	    <input type="submit" value="Mehet" name="mehet" />
	</td>
    </tr>
    </table>
    </form>
    
<php

    if (nevcsekk($_POST['veznev']) AND nevcsekk($_POST['kernev']))
	print "Nev: " . strip_tags($_POST['veznev']) . " " . strip_tags($_POST['kernev']);
    else print "<i>Nev:</i>";
    
    print"<br>";
	
    if (isset($_POST['nem'])) { 
	print "Nem: ";
	if ($_POST['nem']=="ferfi") print "Ferfi";
	else print "No";
    } else print "<i>Nem:</i>";
    
    print "<br>";
    
    if (telefoncsekk($_POST['telefon'])) print "Telefon: " . $_POST['korzet'] . "/" . substr($_POST['telefon'],0,3) . "-" . substr($_POST['telefon'],3,4);
    else print "<i>Telefon:</i>";
    
    print "<br>";
	
    if (isset($_POST['szin1']) OR isset($_POST['szin2']) OR isset($_POST['szin3']))
    {
	print "Kedvenc szin: ";
		
	if (isset($_POST['szin1'])) print "Piros ";
	if (isset($_POST['szin2'])) print "Kek ";
	if (isset($_POST['szin3'])) print "Zod ";
    } else print "<i>Nincs kedvenc szin</i>";

} else {

?>
<form name="urlapos" action=" <php print $_SERVER['PHP_SELF'];  ?> " method="post">
    <table>
    <tr>
	<td>
	    Vezeteknev:
	</td>
	<td> 
	    <input type="text" name="veznev" size="20" />
	</td>
    </tr>
    <tr>
	<td>
	    Keresztnev:
	</td>
	<td>
	     <input type="text" name="kernev" size="20" />
	</td>
    </tr>
    <tr>
	<td>
	    Nem:
	</td>
	<td>
	     <input type="radio" name="nem" value="ferfi" /> Ferfi <input type="radio" name="nem" value="no" /> No<br />
	</td>
    </tr>
    <tr>
	<td>
	    Telefonszam:
	</td>
	<td>
	     <select name="korzet">
	        <option value="20">20</option>
		<option value="30">30</option>
		<option value="70">70</option>
	    </select> 
	    <input type="text" name="telefon" size="10" maxlength="7" />
	</td>
    </tr>
    <tr>
	<td>
	    Kedvenc szin(ek):
	</td>
	<td>
	     <input type="checkbox" name="szin1" /> Piros
	     <input type="checkbox" name="szin2" /> Kek
	     <input type="checkbox" name="szin3" /> Zold
	</td>
    </tr>
    <tr>
	<td>
	    Jelszo:
	</td>
	<td>
	     <input type="password" name="jelszo" size="20" /><br />
	</td>
    </tr>
    <tr>
	<td>
	    <input type="submit" value="Mehet" name="mehet" />
	</td>
    </tr>
    </table>
    </form>
<php
}
?>
</body>
</html>