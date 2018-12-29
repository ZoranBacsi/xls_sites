<?php

/*N�vdeklar�l�: Ez a cucc csin�lja a logo �s a f�ablak k�zti neveket*/

	  $menu = $_GET['menu'];
	  if ($menu=="") $menu="kezdolap";

	  $db['kezdolap']['html']="mozgo.html";
	  $db['kezdolap']['menunev']="Kezd�lap";
	  $db['kezdolap']['szulo']="null";
	  $db['kezdolap']['sargacucc']="Kezd�lap megjelen�t�se";

	  $db['cegtortenet']['html']="tortenet.html";
	  $db['cegtortenet']['menunev']="A c�g t�rt�nete";
	  $db['cegtortenet']['szulo']="null";
	  $db['cegtortenet']['sargacucc']="A c�g t�rt�nete";

	  $db['tevekenyseg']['html']="tevekenyseg.html";
	  $db['tevekenyseg']['menunev']="Tev�kenys�gek";
	  $db['tevekenyseg']['szulo']="null";
	  $db['tevekenyseg']['sargacucc']="Tev�kenys�gek megtekint�se";

	  $db['linkek']['html']="linkek.html";
	  $db['linkek']['menunev']="Linkek";
	  $db['linkek']['szulo']="null";
	  $db['linkek']['sargacucc']="Linkek megtekint�se";


	  /*BOSCH*/

	  $db['bosch']['html']="_bosch.html";
	  $db['bosch']['menunev']="Bosch";
	  $db['bosch']['szulo']="tevekenyseg";
	  $db['bosch']['sargacucc']="Bosch term�kek";

	  $db['boschforgo']['html']="bosch/_forgo.html";
	  $db['boschforgo']['menunev']="Forg�eloszt�s adagol�k";
	  $db['boschforgo']['szulo']="bosch";

	  $db['boschforgomech']['html']="bosch/forgomech.html";
	  $db['boschforgomech']['menunev']="Mechanikus szab�lyoz�s";
	  $db['boschforgomech']['szulo']="boschforgo";

	  $db['boschforgoel']['html']="bosch/forgoel.html";
	  $db['boschforgoel']['menunev']="Elektronikus szab�lyoz�s";
	  $db['boschforgoel']['szulo']="boschforgo";

	  $db['boschsoros']['html']="bosch/_soros.html";
	  $db['boschsoros']['menunev']="Soros rendszer� adagol�k";
	  $db['boschsoros']['szulo']="bosch";

	  $db['boschsorosmech']['html']="bosch/sorosmech.html";
	  $db['boschsorosmech']['menunev']="Mechanikus szab�lyoz�s";
	  $db['boschsorosmech']['szulo']="boschsoros";

	  $db['boschsorosel']['html']="bosch/sorosel.html";
	  $db['boschsorosel']['menunev']="Elektronikus szab�lyoz�s";
	  $db['boschsorosel']['szulo']="boschsoros";

	  $db['boschcr']['html']="bosch/_cr.html";
	  $db['boschcr']['menunev']="Common Rail szivatty�k";
	  $db['boschcr']['szulo']="bosch";

	  $db['boschcrcp1']['html']="bosch/cp1.html";
	  $db['boschcrcp1']['menunev']="CP-1";
	  $db['boschcrcp1']['szulo']="boschcr";

	  $db['boschcrcp2']['html']="bosch/cp2.html";
	  $db['boschcrcp2']['menunev']="CP-2";
	  $db['boschcrcp2']['szulo']="boschcr";

	  $db['boschcrcp3']['html']="bosch/cp3.html";
	  $db['boschcrcp3']['menunev']="CP-3";
	  $db['boschcrcp3']['szulo']="boschcr";

	  $db['boschpde']['html']="bosch/_pde.html";
	  $db['boschpde']['menunev']="PDE-adagol� porlaszt� egys�g";
	  $db['boschpde']['szulo']="bosch";


	  /*ZEXEL*/

	  $db['zexel']['html']="_zexel.html";
	  $db['zexel']['menunev']="Zexel";
	  $db['zexel']['szulo']="tevekenyseg";
	  $db['zexel']['sargacucc']="Zexel term�kek";

	  $db['zexelforgo']['html']="zexel/_forgo.html";
	  $db['zexelforgo']['menunev']="Forg�eloszt�s rendszer� adagol�k";
	  $db['zexelforgo']['szulo']="zexel";

	  $db['zexelforgomech']['html']="zexel/forgomech.html";
	  $db['zexelforgomech']['menunev']="Mechanikus szab�lyoz�s";
	  $db['zexelforgomech']['szulo']="zexelforgo";

	  $db['zexelforgoel']['html']="zexel/forgoel.html";
	  $db['zexelforgoel']['menunev']="Elektronikus szab�lyoz�s";
	  $db['zexelforgoel']['szulo']="zexelforgo";

	  $db['zexelvrz']['html']="zexel/_vrz.html";
	  $db['zexelvrz']['menunev']="VRZ-radi�l dugatty�s rendszer� adagol�k";
	  $db['zexelvrz']['szulo']="zexel";

	  $db['zexelsoros']['html']="zexel/_soros.html";
	  $db['zexelsoros']['menunev']="Soros rendszer� adagol�k";
	  $db['zexelsoros']['szulo']="zexel";


	  /*DELPHI-LUCAS*/

	  $db['delphi']['html']="_delphi.html";
	  $db['delphi']['menunev']="Delphi-Lucas";
	  $db['delphi']['szulo']="tevekenyseg";
	  $db['delphi']['sargacucc']="Delphi-Lucas term�kek";

	  $db['delphimech']['html']="delphi/_mech.html";
	  $db['delphimech']['menunev']="Forg�eloszt�s rendszer�, mechanikus szab�lyoz�s� adagol�k";
	  $db['delphimech']['szulo']="delphi";

	  $db['delphimechdpa']['html']="delphi/dpa.html";
	  $db['delphimechdpa']['menunev']="DPA";
	  $db['delphimechdpa']['szulo']="delphimech";

	  $db['delphimechdps']['html']="delphi/dps.html";
	  $db['delphimechdps']['menunev']="DPS";
	  $db['delphimechdps']['szulo']="delphimech";

	  $db['delphimechdpc']['html']="delphi/dpc.html";
	  $db['delphimechdpc']['menunev']="DPC";
	  $db['delphimechdpc']['szulo']="delphimech";

	  $db['delphiel']['html']="delphi/_el.html";
	  $db['delphiel']['menunev']="Forg�eloszt�s rendszer�, elektronikus szab�lyoz�s� adagol�k";
	  $db['delphiel']['szulo']="delphi";

	  $db['delphieldpcn']['html']="delphi/dpcn.html";
	  $db['delphieldpcn']['menunev']="DPCN";
	  $db['delphieldpcn']['szulo']="delphiel";

	  $db['delphielepicin']['html']="delphi/epicin.html";
	  $db['delphielepicin']['menunev']="Epic Indirekt befecskendez�ses rendszer�";
	  $db['delphielepicin']['szulo']="delphiel";

	  $db['delphielepicdi']['html']="delphi/epicdi.html";
	  $db['delphielepicdi']['menunev']="Epic Direkt befecskendez�ses rendszer�";
	  $db['delphielepicdi']['szulo']="delphiel";
		
	  /*SIEMENS*/
	  $db['siemens']['html'] = "_siemens.html";
	  $db['siemens']['menunev'] = "Siemens";
	  $db['siemens']['szulo'] = "tevekenyseg";
	  $db['siemens']['sargacucc'] = "Siemens term�kek";

	  /*DENSO*/

	  $db['denso']['html']="_denso.html";
	  $db['denso']['menunev']="Denso";
	  $db['denso']['szulo']="tevekenyseg";
	  $db['denso']['sargacucc']="Denso term�kek";

	  $db['densoforgo']['html']="denso/_forgo.html";
	  $db['densoforgo']['menunev']="Forg�eloszt�s rendszer� adagol�k";
	  $db['densoforgo']['szulo']="denso";

	  $db['densoforgomech']['html']="denso/forgomech.html";
	  $db['densoforgomech']['menunev']="Mechanikus szab�lyoz�s";
	  $db['densoforgomech']['szulo']="densoforgo";

	  $db['densoforgoel']['html']="denso/forgoel.html";
	  $db['densoforgoel']['menunev']="Elektronikus szab�lyoz�s";
	  $db['densoforgoel']['szulo']="densoforgo";

	  $db['densosoros']['html']="denso/_sormech.html";
	  $db['densosoros']['menunev']="Soros rendszer� mechanikus adagol�";
	  $db['densosoros']['szulo']="denso";

	  $db['densocr']['html']="denso/_cr.html";
	  $db['densocr']['menunev']="Common Rail szivatty�k";
	  $db['densocr']['szulo']="denso";

	  $db['densocrhp2']['html']="denso/hp2.html";
	  $db['densocrhp2']['menunev']="HP-2";
	  $db['densocrhp2']['szulo']="densocr";

	  $db['densocrhp3']['html']="denso/hp3.html";
	  $db['densocrhp3']['menunev']="HP-3";
	  $db['densocrhp3']['szulo']="densocr";


	  /*PORLASZT�K*/

	  $db['porlasztok']['html']="_porlasztok.html";
	  $db['porlasztok']['menunev']="Porlaszt�k";
	  $db['porlasztok']['szulo']="tevekenyseg";
	  $db['porlasztok']['sargacucc']="Porlaszt�k megtekint�se";

	  $db['porlasztokmech']['html']="porlasztok/_mechanikus.html";
	  $db['porlasztokmech']['menunev']="Mechanikus porlaszt�k";
	  $db['porlasztokmech']['szulo']="porlasztok";

	  $db['porlasztokcr']['html']="porlasztok/_cr.html";
	  $db['porlasztokcr']['menunev']="Common Rail porlaszt�k";
	  $db['porlasztokcr']['szulo']="porlasztok";

  	  $db['porlasztokcrbosch']['html']="porlasztok/bosch.html";
	  $db['porlasztokcrbosch']['menunev']="Bosch porlaszt�k";
	  $db['porlasztokcrbosch']['szulo']="porlasztokcr";

	  $db['porlasztokcrdelphi']['html']="porlasztok/delphi.html";
	  $db['porlasztokcrdelphi']['menunev']="Delphi-Lucas porlaszt�k";
	  $db['porlasztokcrdelphi']['szulo']="porlasztokcr";

	  $db['porlasztokcrdenso']['html']="porlasztok/denso.html";
	  $db['porlasztokcrdenso']['menunev']="Denso porlaszt�k";
	  $db['porlasztokcrdenso']['szulo']="porlasztokcr";

	  $db['porlasztokcrsiemens']['html']="porlasztok/siemens.html";
	  $db['porlasztokcrsiemens']['menunev']="Siemens porlaszt�k";
	  $db['porlasztokcrsiemens']['szulo']="porlasztokcr";

	  $db['crvizsgalo']['html']="porlasztok/_crvizsgalo.html";
	  $db['crvizsgalo']['menunev']="Cr porlaszt� vizsg�l�";
	  $db['crvizsgalo']['szulo']="porlasztok";

	  $db['crellenorzo']['html']="porlasztok/_crellenorzo.html";
	  $db['crellenorzo']['menunev']="Cr porlaszt�k gy�ri ellen�rz� berendez�sei";
	  $db['crellenorzo']['szulo']="porlasztok";




	  $db['jav1']['html']="1_javitogep.html";
	  $db['jav1']['menunev']="Hartridge Pr�bapad";
	  $db['jav1']['szulo']="tevekenyseg";
	  $db['jav1']['sargacucc']="Hartridge Pr�bapad megtekint�se";

	  $db['jav2']['html']="2_javitogep.html";
	  $db['jav2']['menunev']="Bosch Pr�bapad";
	  $db['jav2']['szulo']="tevekenyseg";
	  $db['jav2']['sargacucc']="Bosch Pr�bapad megtekint�se";

	  $db['arajanlat']['html']="arajanlat.html";
	  $db['arajanlat']['menunev']="�raj�nlat";
	  $db['arajanlat']['szulo']="tevekenyseg";
	  $db['arajanlat']['sargacucc']="�raj�nlat megtekint�se";

	  $db['mindennap']['html']="mindennap.html";
	  $db['mindennap']['menunev']="Mindennapjaink";
	  $db['mindennap']['szulo']="tevekenyseg";
	  $db['mindennap']['sargacucc']="Mindennapjaink";

	  
	  $db['kapcsolat']['html']="kapcsolat.html";
	  $db['kapcsolat']['menunev']="Kapcsolat";
	  $db['kapcsolat']['szulo']="null";
	  $db['kapcsolat']['sargacucc']="Kapcsolat a szervizzel";

	  $db['megkozelites']['html']="megkozelites.html";
	  $db['megkozelites']['menunev']="Megk�zel�t�s";
	  $db['megkozelites']['szulo']="null";
	  $db['megkozelites']['sargacucc']="A szervizek megk�zel�t�se";

	  $db['szfehervar']['html']="szfehervar.html";
	  $db['szfehervar']['menunev']="Sz�kesfeh�rv�ri telep";
	  $db['szfehervar']['szulo']="megkozelites";
	  $db['szfehervar']['sargacucc']="Sz�kesfeh�rv�ri telep";

	  $db['budapest']['html']="budapest.html";
	  $db['budapest']['menunev']="Budapesti telep";
	  $db['budapest']['szulo']="megkozelites";
	  $db['budapest']['sargacucc']="Budapesti telep";

/*Itt van a LINK!!!*/

function nav(&$db, $id) {
	if ($db[$id]['szulo']!="null") nav($db,$db[$id]['szulo']);

	?>
	<A class="felso" href="index1.php?menu=<?php echo $id;?>">
	<?php echo $db[$id]['menunev'];?></A>
	<?php
}

function ose($os, $gyerek, &$db) {
	$r=false;

	while ($gyerek!="null") {
		if ($os==$db[$gyerek]['szulo']) $r=true;
		$gyerek=$db[$gyerek]['szulo'];
	}

	return $r;
}

?>

<HTML>
<HEAD>
	<meta http-equiv="content-type"
		content="text/html;
		charset=windows-1250">

  <TITLE>Filep Diesel&copy</TITLE>
  <LINK rel="stylesheet" href="filep_css_0.css">
  <style type="text/css">
	#siemens {
		border: 2px solid white;
	}
	#siemens:hover {
		border: 2px solid black;
	}
	#linkek img {
		border: 2px solid #E0EAF4;
	}
	#linkek img:hover {
		border: 2px solid black;
	}
  </style>

  <meta name="author" content="zuzu">
  <meta name="keywords" content="Filep","Filepdiesel","filepdiesel","filep","diesel","dieselservice","dieselszerviz" >

	<!--A SCRIPT-ben l�v� cucc kell a k�pv�lt�shoz a men�ben. Itt van deklar�lva a 2 k�p-->

  <SCRIPT language="JavaScript1.1">
    kep1 = new Image();
    kep1.src = 'img/level.gif';
    kep2 = new Image();
    kep2.src = 'img/level1.gif';

	kep3 = new Image();
    kep3.src = 'img/kishartridge0.jpg';
    kep4 = new Image();
    kep4.src = 'img/kishartridge.jpg';

	kep5 = new Image();
    kep5.src = 'img/kisbosch0.jpg';
    kep6 = new Image();
    kep6.src = 'img/kisbosch.jpg';


	k1 = new Image();
	k1.src = 'img/boschlogo.jpg';
	k2 = new Image();
	k2.src = 'img/boschlogo1.jpg';

	k3 = new Image();
	k3.src = 'img/zexellogo.jpg';
	k4 = new Image();
	k4.src = 'img/zexellogo1.jpg';

	k5 = new Image();
	k5.src = 'img/delphilogo.jpg';
	k6 = new Image();
	k6.src = 'img/delphilogo1.jpg';

	k7 = new Image();
	k7.src = 'img/densologo.jpg';
	k8 = new Image();
	k8.src = 'img/densologo1.jpg';

	b1 = new Image();
	b1.src = 'img/bpkicsi0.jpg';
	b2 = new Image();
	b2.src = 'img/bpkicsi1.jpg';

	sz1 = new Image();
	sz1.src = 'img/szfvkicsi0.jpg';
	sz2 =  new Image();
	sz2.src = 'img/szfvkicsi1.jpg';


	function changeImg(cImg,ref) {document.images[cImg].src = ref.src}

  </SCRIPT>

</HEAD>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////B/O/D/Y/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<body>

<center>
<!--LOGO-->

<TABLE class="nagy" TITLE="Filep Diesel&copy" CELLPADDING=0 cellspacing="0">
  <COLGROUP>
      <COL WIDTH="140">
  <COLGROUP>
      <COL WIDTH="610">
	<TR class="jobb"><TD colspan="2"><IMG src="img/logo.jpg" WIDTH="100%">
	<TR class="jobb" HEIGHT="40"><TD colspan="2"><hr color="white" width="75%">

<?php

/*N�vmegjelen�t�: a logo �s a f�ablak k�zt megjelen�ti a strukt�r�t*/
	nav($db,$menu);
?>

<hr color="white" width="90%">
  <TR><TD VALIGN="top">

	<!--MEN�-->

  <TABLE TITLE="Filep Diesel&copy" WIDTH="100%" CELLPADDING="0">
    <COLGROUP>
      <COL WIDTH="100%">
    <TBODY>
      <?php
       foreach ($db as $oldalkulcs => $oldal) if ($oldal['szulo']=="null") { ?>
		  
		  <TR class="menu">
		  <TH HEIGHT="30" TITLE="<?php echo $oldal['sargacucc'];?>">
		  <A class="menu" href="index1.php?menu=<?php echo $oldalkulcs;?>">
		  <?php echo $oldal['menunev'];?></A>

          <?php
		  if (($oldalkulcs==$menu) || ose($oldalkulcs, $menu, $db))
		  foreach ($db as $aloldalkulcs => $aloldal) if ($aloldal['szulo']==$oldalkulcs) { 
		  ?>

			  <TR class="al">
			  <TH TITLE="<?php echo $aloldal['sargacucc'];?>">
			  <A class="almenu" href="index1.php?menu=<?php echo $aloldalkulcs;?>">
			  <?php echo $aloldal['menunev'];?></A>

			  <?php
		  }

      }
     ?>

   	  <TR class="menu" HEIGHT="30"><TH TITLE="e-mail k�ld�se"><A class="menu" href="mailto: filepdiesel@invitel.hu">
	    	<IMG src="img/level.gif" name="level" BORDER=0 
			onMouseOver="changeImg('level',kep2)"
	        onMouseOut="changeImg('level',kep1)"></A>
  </TABLE>
 

<TD VALIGN="top">
  

	<!--F�ABLAK-->

  <TABLE class="szoveg" BORDER=0 ALIGN="right" TITLE="Filep Diesel&copy" CELLPADDING="10">
    <COLGROUP>
      <COL WIDTH="585">
    <TBODY>
      <TR><TD>

   <?php

	/*Ez a cucc illeszti be a f�ablakba az oldalakat*/
	  include $db[$menu]['html'];

	  ?>

 
  </TABLE>
        <TR HEIGHT="20"><TD COLSPAN="2" class="jobb"><A class="masik" href="javascript: history.back()" TITLE="Vissza az el�z� lapra">Vissza</A> <A class="masik" href="#top" TITLE="Ugr�s a lap tetej�re">Lap tetej�re</A>


</TABLE>
</center>
</BODY>
</HTML>