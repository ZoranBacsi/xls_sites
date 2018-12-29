<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

class tpl {
	static function load($tpl,$ins=Array()) { $out = '';
		$obStarted = ob_get_level();
		ob_start();
			$_tpl = $_ENV['CONF']['themePath'].'/'.basename($tpl);
			$xtpl = $_ENV['MODS']['PATH'].'/'.basename($tpl);
			if(is_file(realpath($tpl))) {
				include(realpath($tpl)); /* Direct File */
			} else if(is_file(realpath($_tpl))) {
				include(realpath($_tpl)); /* Theme File */
			} else if(is_file(realpath($xtpl))) {
				include(realpath($xtpl)); /* Modul File */
			}
			$out = out_site(ob_get_contents());
		if($obStarted>2) {
			// ob_end_flush();
			ob_end_clean();
		} else {
			ob_end_clean();
		}
		if(count($ins)>0) {
			$out = tpl_replace($ins, 'fix', $out);
			$out = tpl_replace($ins, 'ins', $out);
			$out = tpl_replace($ins, 'out', $out);
			$out = tpl_replace($ins, false, $out);
		}
		ob_start();
			print($out);
			$out = out_site(ob_get_contents());
		if($obStarted>2) {
			ob_end_flush();
		} else {
			ob_end_clean();
		}
		return $out;
	}
}

function tplLoad($tpl,$ins=Array()) { tpl::load($tpl,$ins); }
function tpl_load($tpl,$ins=Array()) { tpl::load($tpl,$ins); }

function tplReplace($tomb,$pref,$text) { return lang::out_replace($tomb,$pref,$text); }
function tpl_replace($tomb,$pref,$text) { return lang::out_replace($tomb,$pref,$text); }

?>