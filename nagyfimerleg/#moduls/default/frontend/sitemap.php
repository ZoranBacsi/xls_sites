<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

/* /#pages mappa SiteMap definiálása */
function OldalakPath($path,$i) {
	$out = ''; $_out = '';
	if(is_dir($path)) {
		if($_dh = opendir($path)) {
			while(($_filename = readdir($_dh)) !== false) {
				if(filetype(realpath($path.'/'.$_filename))=='file'
					AND substr($_filename,-4)=='.tpl'
					AND substr($_filename,0,1)!='.'
					AND substr($_filename,0,1)!='!'
					AND substr($_filename,0,1)!='#') {
				$_ENV['HEAD']['INDEX'] = 'N';
				ob_start();
					$_file = file(realpath($path.'/'.$_filename));
					for($a=0;$a<count($_file);$a++) {
						if(strstr($_file[$a],'$_ENV["HEAD"]["INDEX"]') OR strstr($_file[$a],'$_ENV[\'HEAD\'][\'INDEX\']')) {
							eval($_file[$a]);
						}
					}
					$_page = ob_get_contents();
				ob_end_clean();
					$reurl = str_replace(Array(PAGEAS_ROOT,DOCUMENT_ROOT,'#pages/','//'),'/',($path.'/'.substr($_filename,0,-4)));
					if($reurl!=('/'.$_ENV['SITE']['DEFAULT']) AND $_ENV['HEAD']['INDEX']=='I') {
						$out .= ('
	<url>
		<loc>http://'.fPath((($_SERVER['HTTP_HOST']).'/'.(($reurl==('/'.$_ENV['SITE']['DEFAULT']))?('index'):($reurl)))).'/</loc>
		<lastmod>'.(date('Y-m-d\TH:i:s\Z',filectime(fPath($path.'/'.$_filename)))).'</lastmod>
		<changefreq>always</changefreq>
		<priority>'.(($i>0)?('0.'.(10-$i).'00'):('1.000')).'</priority>
	</url>');
					}
				} else if(substr($_filename,0,1)!='.' AND substr($_filename,0,1)!='!') {
					$_out .= OldalakPath(realpath($path.'/'.$_filename),($i+1));
				}
			}
			closedir($_dh);
		}
	}
	return $out.$_out;
}

$_ENV['SITE']['SITEMAP'] .= OldalakPath(PAGEAS_ROOT,0);

?>