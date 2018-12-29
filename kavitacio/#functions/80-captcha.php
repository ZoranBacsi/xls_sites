<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',$replace=false,404); header('Location: /'); exit(); }

function captcha_valied($code) {
	mysqli_query($_ENV['MYSQLI'],'DELETE FROM `captcha` WHERE `time` < DATE_ADD(NOW(), INTERVAL -1 HOUR) ');
	$con = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `captcha` WHERE `value` = "'.(in_text($code)).'" AND `ip` = "'.($_SERVER['REMOTE_ADDR']).'" LIMIT 1');
	if(mysqli_num_rows($con)>0) {
		mysqli_query($_ENV['MYSQLI'],'DELETE FROM `captcha` WHERE `value` = "'.(in_text($code)).'" AND `ip` = "'.($_SERVER['REMOTE_ADDR']).'"');
		return true;
	} else { return false; }
}

function captcha_text() {
	$_rand = rand(1000,9999);
	$out = '
		<table border="0" cellaspacing="0" cellpadding="0" style="margin-top: 12px;">
			<tr>
				<td colspan="3">
					<img src="/captcha.png?r='.md5(rand(100000,999999)).'" alt="Loading..." width="300" height="80" style="border:0px;" id="captcha_kep_'.($_rand).'" />
				</td>
			</tr>
			<tr>
				<td style="vertical-align:middle;"><label for="captcha_value" class="formLabel">{captcha_label}:</label></td>
				<td style="vertical-align:middle;">
					<input type="hidden" class="captcha_key" id="captcha_key" value="'.md5($_SERVER['REMOTE_ADDR']).'" />
					<input type="text" name="captcha_value" value="" id="captcha_value" maxlength="8" class="typeCaptcha big kotelezo captcha_value" title="{captcha_value}" style="width:160px;letter-spacing:3px;text-align:center;font-size:16px;" />
					<span class="inputError" style="display:none;">{captcha_hiba}</span>
				</td>
				<td style="vertical-align:middle;"><img src="/images/refresh.png" alt="{captcha_new}" title="{captcha_new}" onclick="$(\'#captcha_kep_'.($_rand).'\').attr(\'src\',\'/captcha.png?rand=\'+Math.random());" style="cursor:pointer;" /></td>
			</tr>
		</table>';
	return $out;
}
?>