<?php /* Készítő: H.Tibor */ if(!($_ENV['SiteStart']) OR !($_ENV['USER']['ss_aid']>0)) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }	/* Oldal törlése */	if($_REQUEST['hMode']=='szpDel') {		$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szpage` WHERE `szp_id`="'.($_REQUEST['szpid']).'" LIMIT 1');		if($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $del_sorsz = $sor['szp_sorsz']; } unSet($sor); unSet($con);		if(szpDel($_REQUEST['szpid'])) {			echo'<script type="text/javascript">AddAlert("ok","Oldal törölve!");</script>';		} else {			echo'<script type="text/javascript">AddAlert("no","Oldal törölése sikertelen!");</script>';		}	}	/* Oldal/kategória listázása */	echo'		<h1 class="cim">{szm_szmenu_cim}</h1>		<div class="pozicio"><a href="?oldal='.($oldal).'&amp;mode='.($mode).'">{menu_szmenu_pages}</a> &#187;</div>';	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `szpage` ORDER BY `szp_cim`');			echo'					<a class="new_link" href="?oldal='.($_REQUEST['oldal']).'&amp;mode='.($_REQUEST['mode']).'&amp;xMode=szpNew">{szp_uj_oldal}...</a><br/>';	$_oldalDarab = mysqli_num_rows($con);	if($_oldalDarab>0) {			/* Menü pontok listázása */	echo'<br/>	<h3>{szp_oldalak_cim}:</h3>		<table class="table" width="100%" cellspacing="0" cellpadding="3" border="0">			<tbody>				<tr class="fejlec">					<th width="25">#</th>					<th width="40">St.</th>					<th>{cim}</th>					<th class="admin_btn">{modosit}</th>					<th class="admin_btn">{torol}</th>				</tr>';	$n=0;	while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) { $n++;		echo'				<tr>					<td>'.($sor['szp_id']).'.</td>					<td>'.(($sor['szp_status']=='A')?('<font color="#0000CC">{aktiv}</font>'):('<font color="#CC0000">{inaktiv}</font>')).'</td>					<td>'.($sor['szp_cim']).'</td>					<td>						<input class="admin_btn" type="button" value="{modosit}" onclick="LoadPage(\'?oldal='.($_REQUEST['oldal']).'&mode='.($_REQUEST['mode']).'&szpid='.($sor['szp_id']).'&xMode=szpMod\');"/>					</td>					<td>						<input class="admin_btn" type="button" value="{torol}" onclick="if(confirm(\'{szp_torol_confirm}\')) { LoadPage(\'?oldal='.($_REQUEST['oldal']).'&mode='.($_REQUEST['mode']).'&szpid='.($sor['szp_id']).'&hMode=szpDel\'); } else { return false; }" />					</td>				</tr>';	}	echo'			</tbody>		</table>	<hr/>';		}	unSet($con); unSet($sor);?>