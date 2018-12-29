<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }
$_ENV['MODS'] = Array();
$_ENV['MODS']['PATH'] = rPath('fejlec_kepek/frontend',false);
$_ENV['MODS']['PURL'] = rPath('fejlec_kepek/frontend',true);
$_ENV['HEAD']['CSS'][] = $_ENV['MODS']['PURL'].'/style.css';
$_ENV['F_KEP'] = Array();
$_ENV['F_KEP']['PATH'] = fPath('/files/fejlec_kepek/');
$_ENV['F_KEP']['fPATH'] = fPath(DOCUMENT_ROOT.$_ENV['F_KEP']['PATH']);

$_StepTime = 3; // másodperc
$_KepWidth = 672; // px
$_KepHeight = 394; // px

$_kepek = Array();
$con=mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `fejlec_kepek` ORDER BY `fk_sorszam`');
while($sor=mysqli_fetch_array($con,MYSQLI_ASSOC)) {
	$_kepek[] = ($_ENV['F_KEP']['PATH']).($sor['fk_kep_nagy']);
	$_urls[] = (($sor['fk_url'])?($sor['fk_url']):('#'));
}
if(!count($_kepek)) { $_kepek[] = '/themes/'.$_ENV['CONF']['THEME'].'/images/default-kepvalto.jpg'; $_urls[] = '#'; }

$_ENV['FejlecKep'] = '
	<div class="advanced-slider" id="slider">';
	for($a=0;$a<count($_kepek);$a++) {
		$_ENV['FejlecKep'] .= '<img class="image" src="'.($_kepek[$a]).'" alt="'.(in_text($_ENV['HEAD']['TITLE'])).'" '.(($_urls[$a]!='#')?('onclick="location.href=\''.($_urls[$a]).'\';" style="cursor:pointer;"'):('')).' width="'.($_KepWidth).'" height="'.($_KepHeight).'"/>';
	}
$_ENV['FejlecKepNoArrow'] .= '
	</div>
	<style>
		#slider {position:relative; width:'.($_KepWidth).'px; height:'.($_KepHeight).'px; background:url(/js/nivoslider/loading.gif) #efe9d1 no-repeat 50% 50%; overflow: hidden;}
		#slider img {position:absolute; top:0px; left:0px; display: none;}
		#slider a {border:0; display:none;}
		.nivo-directionNav a { display: none; }
		.nivo-prevNav { display: none; }
		.nivo-nextNav { display: none; }
		.nivo-controlNav { display: none; }
		.nivo-controlNav a {display: none; }
	</style>
	<script type="text/javascript">
		//<!--
		$(document).ready(function() {
			$("#slider").nivoSlider({
				//effect:"fade", // Specify sets like: "fold,fade,sliceDown"
				pauseTime:'.(1000*$_StepTime).', // How long each slide will show
				directionNav:true, // Next & Prev navigation
				directionNavHide:false, // Only show on hover
				controlNav:true, // 1,2,3... navigation
				prevText: "Prev", // Prev directionNav text
				nextText: "Next" // Next directionNav text
			});
		});
		//-->
	</script>
';
$_ENV['FejlecKepArrow'] .= '
	</div>
	<style>
		#slider {position:relative; width:'.($_KepWidth).'px; height:'.($_KepHeight).'px; background:url(/js/nivoslider/loading.gif) #efe9d1 no-repeat 50% 50%; overflow: hidden;}
		#slider img {position:absolute; top:0px; left:0px; display: none;}
		#slider a {border:0; display:block;}

		/* Direction nav styles (e.g. Next & Prev) */
		.nivo-directionNav a {display:block; width:30px; height:30px; text-indent:-9999px; border:0; top: '.(($_KepHeight-30)/2).'px; position: absolute; z-index: 99;}
		.nivo-prevNav {left:5px; background: url(/js/nivoslider/arrow-prev.png) no-repeat;}
		.nivo-nextNav { right:5px; background: url(/js/nivoslider/arrow-next.png) no-repeat;}
		a:hover.nivo-prevNav {background: url(/js/nivoslider/arrow-prev-hover.png) no-repeat;}
		a:hover.nivo-nextNav {background: url(/js/nivoslider/arrow-next-hover.png) no-repeat;}
		/* Control nav styles (e.g. 1,2,3...) */
		.nivo-controlNav {position:absolute; left:0px; top: '.($_KepHeight-50).'px; z-index: 99; width:100%; text-align: center;}
		.nivo-controlNav a {display: inlin-block; background:url(/js/nivoslider/dot.png) no-repeat; border:0; padding: 10px; color: transparent; font-size: 0px; }
		.nivo-controlNav a.active {background:url(/js/nivoslider/dot-hover.png) no-repeat;}
	</style>
	<script type="text/javascript">
		//<!--
		$(document).ready(function() {
			$("#slider").nivoSlider({
				effect:"fade", // Specify sets like: "fold,fade,sliceDown"
				pauseTime:'.(1000*$_StepTime).', // How long each slide will show
				directionNav:true, // Next & Prev navigation
				directionNavHide:false, // Only show on hover
				controlNav:true, // 1,2,3... navigation
				prevText: "Prev", // Prev directionNav text
				nextText: "Next" // Next directionNav text
			});
		});
		//-->
	</script>
';
$_ENV['SITE']['FejlecKep'] = $_ENV['FejlecKep'].$_ENV['FejlecKepArrow'];
$_ENV['SITE']['FejlecKep'] = $_ENV['FejlecKep'].$_ENV['FejlecKepNoArrow'];
?>