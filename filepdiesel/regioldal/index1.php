<?php

/*Névdeklaráló: Ez a cucc csinálja a logo és a fõablak közti neveket*/

	  $menu = $_GET['menu'];
	  if ($menu=="") $menu="kezdolap";

	  $db['kezdolap']['html']="mozgo.html";
	  $db['kezdolap']['menunev']="Kezdõlap";
	  $db['kezdolap']['szulo']="null";
	  $db['kezdolap']['sargacucc']="Kezdõlap megjelenítése";

	  $db['cegtortenet']['html']="tortenet.html";
	  $db['cegtortenet']['menunev']="A cég története";
	  $db['cegtortenet']['szulo']="null";
	  $db['cegtortenet']['sargacucc']="A cég története";

	  $db['tevekenyseg']['html']="tevekenyseg.html";
	  $db['tevekenyseg']['menunev']="Tevékenységek";
	  $db['tevekenyseg']['szulo']="null";
	  $db['tevekenyseg']['sargacucc']="Tevékenységek megtekintése";

	  $db['linkek']['html']="linkek.html";
	  $db['linkek']['menunev']="Linkek";
	  $db['linkek']['szulo']="null";
	  $db['linkek']['sargacucc']="Linkek megtekintése";


	  /*BOSCH*/

	  $db['bosch']['html']="_bosch.html";
	  $db['bosch']['menunev']="Bosch";
	  $db['bosch']['szulo']="tevekenyseg";
	  $db['bosch']['sargacucc']="Bosch termékek";

	  $db['boschforgo']['html']="bosch/_forgo.html";
	  $db['boschforgo']['menunev']="Forgóelosztós adagolók";
	  $db['boschforgo']['szulo']="bosch";

	  $db['boschforgomech']['html']="bosch/forgomech.html";
	  $db['boschforgomech']['menunev']="Mechanikus szabályozás";
	  $db['boschforgomech']['szulo']="boschforgo";

	  $db['boschforgoel']['html']="bosch/forgoel.html";
	  $db['boschforgoel']['menunev']="Elektronikus szabályozás";
	  $db['boschforgoel']['szulo']="boschforgo";

	  $db['boschsoros']['html']="bosch/_soros.html";
	  $db['boschsoros']['menunev']="Soros rendszerû adagolók";
	  $db['boschsoros']['szulo']="bosch";

	  $db['boschsorosmech']['html']="bosch/sorosmech.html";
	  $db['boschsorosmech']['menunev']="Mechanikus szabályozás";
	  $db['boschsorosmech']['szulo']="boschsoros";

	  $db['boschsorosel']['html']="bosch/sorosel.html";
	  $db['boschsorosel']['menunev']="Elektronikus szabályozás";
	  $db['boschsorosel']['szulo']="boschsoros";

	  $db['boschcr']['html']="bosch/_cr.html";
	  $db['boschcr']['menunev']="Common Rail szivattyúk";
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
	  $db['boschpde']['menunev']="PDE-adagoló porlasztó egység";
	  $db['boschpde']['szulo']="bosch";


	  /*ZEXEL*/

	  $db['zexel']['html']="_zexel.html";
	  $db['zexel']['menunev']="Zexel";
	  $db['zexel']['szulo']="tevekenyseg";
	  $db['zexel']['sargacucc']="Zexel termékek";

	  $db['zexelforgo']['html']="zexel/_forgo.html";
	  $db['zexelforgo']['menunev']="Forgóelosztós rendszerû adagolók";
	  $db['zexelforgo']['szulo']="zexel";

	  $db['zexelforgomech']['html']="zexel/forgomech.html";
	  $db['zexelforgomech']['menunev']="Mechanikus szabályozás";
	  $db['zexelforgomech']['szulo']="zexelforgo";

	  $db['zexelforgoel']['html']="zexel/forgoel.html";
	  $db['zexelforgoel']['menunev']="Elektronikus szabályozás";
	  $db['zexelforgoel']['szulo']="zexelforgo";

	  $db['zexelvrz']['html']="zexel/_vrz.html";
	  $db['zexelvrz']['menunev']="VRZ-radiál dugattyús rendszerû adagolók";
	  $db['zexelvrz']['szulo']="zexel";

	  $db['zexelsoros']['html']="zexel/_soros.html";
	  $db['zexelsoros']['menunev']="Soros rendszerû adagolók";
	  $db['zexelsoros']['szulo']="zexel";


	  /*DELPHI-LUCAS*/

	  $db['delphi']['html']="_delphi.html";
	  $db['delphi']['menunev']="Delphi-Lucas";
	  $db['delphi']['szulo']="tevekenyseg";
	  $db['delphi']['sargacucc']="Delphi-Lucas termékek";

	  $db['delphimech']['html']="delphi/_mech.html";
	  $db['delphimech']['menunev']="Forgóelosztós rendszerû, mechanikus szabályozású adagolók";
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
	  $db['delphiel']['menunev']="Forgóelosztós rendszerû, elektronikus szabályozású adagolók";
	  $db['delphiel']['szulo']="delphi";

	  $db['delphieldpcn']['html']="delphi/dpcn.html";
	  $db['delphieldpcn']['menunev']="DPCN";
	  $db['delphieldpcn']['szulo']="delphiel";

	  $db['delphielepicin']['html']="delphi/epicin.html";
	  $db['delphielepicin']['menunev']="Epic Indirekt befecskendezéses rendszerû";
	  $db['delphielepicin']['szulo']="delphiel";

	  $db['delphielepicdi']['html']="delphi/epicdi.html";
	  $db['delphielepicdi']['menunev']="Epic Direkt befecskendezéses rendszerû";
	  $db['delphielepicdi']['szulo']="delphiel";
		
	  /*SIEMENS*/
	  $db['siemens']['html'] = "_siemens.html";
	  $db['siemens']['menunev'] = "Siemens";
	  $db['siemens']['szulo'] = "tevekenyseg";
	  $db['siemens']['sargacucc'] = "Siemens termékek";

	  /*DENSO*/

	  $db['denso']['html']="_denso.html";
	  $db['denso']['menunev']="Denso";
	  $db['denso']['szulo']="tevekenyseg";
	  $db['denso']['sargacucc']="Denso termékek";

	  $db['densoforgo']['html']="denso/_forgo.html";
	  $db['densoforgo']['menunev']="Forgóelosztós rendszerû adagolók";
	  $db['densoforgo']['szulo']="denso";

	  $db['densoforgomech']['html']="denso/forgomech.html";
	  $db['densoforgomech']['menunev']="Mechanikus szabályozás";
	  $db['densoforgomech']['szulo']="densoforgo";

	  $db['densoforgoel']['html']="denso/forgoel.html";
	  $db['densoforgoel']['menunev']="Elektronikus szabályozás";
	  $db['densoforgoel']['szulo']="densoforgo";

	  $db['densosoros']['html']="denso/_sormech.html";
	  $db['densosoros']['menunev']="Soros rendszerû mechanikus adagoló";
	  $db['densosoros']['szulo']="denso";

	  $db['densocr']['html']="denso/_cr.html";
	  $db['densocr']['menunev']="Common Rail szivattyúk";
	  $db['densocr']['szulo']="denso";

	  $db['densocrhp2']['html']="denso/hp2.html";
	  $db['densocrhp2']['menunev']="HP-2";
	  $db['densocrhp2']['szulo']="densocr";

	  $db['densocrhp3']['html']="denso/hp3.html";
	  $db['densocrhp3']['menunev']="HP-3";
	  $db['densocrhp3']['szulo']="densocr";


	  /*PORLASZTÓK*/

	  $db['porlasztok']['html']="_porlasztok.html";
	  $db['porlasztok']['menunev']="Porlasztók";
	  $db['porlasztok']['szulo']="tevekenyseg";
	  $db['porlasztok']['sargacucc']="Porlasztók megtekintése";

	  $db['porlasztokmech']['html']="porlasztok/_mechanikus.html";
	  $db['porlasztokmech']['menunev']="Mechanikus porlasztók";
	  $db['porlasztokmech']['szulo']="porlasztok";

	  $db['porlasztokcr']['html']="porlasztok/_cr.html";
	  $db['porlasztokcr']['menunev']="Common Rail porlasztók";
	  $db['porlasztokcr']['szulo']="porlasztok";

  	  $db['porlasztokcrbosch']['html']="porlasztok/bosch.html";
	  $db['porlasztokcrbosch']['menunev']="Bosch porlasztók";
	  $db['porlasztokcrbosch']['szulo']="porlasztokcr";

	  $db['porlasztokcrdelphi']['html']="porlasztok/delphi.html";
	  $db['porlasztokcrdelphi']['menunev']="Delphi-Lucas porlasztók";
	  $db['porlasztokcrdelphi']['szulo']="porlasztokcr";

	  $db['porlasztokcrdenso']['html']="porlasztok/denso.html";
	  $db['porlasztokcrdenso']['menunev']="Denso porlasztók";
	  $db['porlasztokcrdenso']['szulo']="porlasztokcr";

	  $db['porlasztokcrsiemens']['html']="porlasztok/siemens.html";
	  $db['porlasztokcrsiemens']['menunev']="Siemens porlasztók";
	  $db['porlasztokcrsiemens']['szulo']="porlasztokcr";

	  $db['crvizsgalo']['html']="porlasztok/_crvizsgalo.html";
	  $db['crvizsgalo']['menunev']="Cr porlasztó vizsgáló";
	  $db['crvizsgalo']['szulo']="porlasztok";

	  $db['crellenorzo']['html']="porlasztok/_crellenorzo.html";
	  $db['crellenorzo']['menunev']="Cr porlasztók gyári ellenõrzõ berendezései";
	  $db['crellenorzo']['szulo']="porlasztok";




	  $db['jav1']['html']="1_javitogep.html";
	  $db['jav1']['menunev']="Hartridge Próbapad";
	  $db['jav1']['szulo']="tevekenyseg";
	  $db['jav1']['sargacucc']="Hartridge Próbapad megtekintése";

	  $db['jav2']['html']="2_javitogep.html";
	  $db['jav2']['menunev']="Bosch Próbapad";
	  $db['jav2']['szulo']="tevekenyseg";
	  $db['jav2']['sargacucc']="Bosch Próbapad megtekintése";

	  $db['arajanlat']['html']="arajanlat.html";
	  $db['arajanlat']['menunev']="Árajánlat";
	  $db['arajanlat']['szulo']="tevekenyseg";
	  $db['arajanlat']['sargacucc']="Árajánlat megtekintése";

	  $db['mindennap']['html']="mindennap.html";
	  $db['mindennap']['menunev']="Mindennapjaink";
	  $db['mindennap']['szulo']="tevekenyseg";
	  $db['mindennap']['sargacucc']="Mindennapjaink";

	  
	  $db['kapcsolat']['html']="kapcsolat.html";
	  $db['kapcsolat']['menunev']="Kapcsolat";
	  $db['kapcsolat']['szulo']="null";
	  $db['kapcsolat']['sargacucc']="Kapcsolat a szervizzel";

	  $db['megkozelites']['html']="megkozelites.html";
	  $db['megkozelites']['menunev']="Megközelítés";
	  $db['megkozelites']['szulo']="null";
	  $db['megkozelites']['sargacucc']="A szervizek megközelítése";

	  $db['szfehervar']['html']="szfehervar.html";
	  $db['szfehervar']['menunev']="Székesfehérvári telep";
	  $db['szfehervar']['szulo']="megkozelites";
	  $db['szfehervar']['sargacucc']="Székesfehérvári telep";

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

	<!--A SCRIPT-ben lévõ cucc kell a képváltáshoz a menüben. Itt van deklarálva a 2 kép-->

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

/*Névmegjelenítõ: a logo és a fõablak közt megjeleníti a struktúrát*/
	nav($db,$menu);
?>

<hr color="white" width="90%">
  <TR><TD VALIGN="top">

	<!--MENÜ-->

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

   	  <TR class="menu" HEIGHT="30"><TH TITLE="e-mail küldése"><A class="menu" href="mailto: filepdiesel@invitel.hu">
	    	<IMG src="img/level.gif" name="level" BORDER=0 
			onMouseOver="changeImg('level',kep2)"
	        onMouseOut="changeImg('level',kep1)"></A>
  </TABLE>
 

<TD VALIGN="top">
  

	<!--FÕABLAK-->

  <TABLE class="szoveg" BORDER=0 ALIGN="right" TITLE="Filep Diesel&copy" CELLPADDING="10">
    <COLGROUP>
      <COL WIDTH="585">
    <TBODY>
      <TR><TD>

   <?php

	/*Ez a cucc illeszti be a fõablakba az oldalakat*/
	  include $db[$menu]['html'];

	  ?>

 
  </TABLE>
        <TR HEIGHT="20"><TD COLSPAN="2" class="jobb"><A class="masik" href="javascript: history.back()" TITLE="Vissza az elõzõ lapra">Vissza</A> <A class="masik" href="#top" TITLE="Ugrás a lap tetejére">Lap tetejére</A>


</TABLE>
</center>
</BODY>
</HTML>