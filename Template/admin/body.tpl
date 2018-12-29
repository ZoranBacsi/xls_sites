
		<table class="maintable" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td class="main_left">
						<div class="SiteMaxWidth">
						<div class="admin_cim">
							<?php
								print(($_ENV['USER']['u_id']>0)?('{admin_user_logined} <a href="?logout=1" class="LogOut">{admin_user_logout}</a>'):('{admin_user_login}'));
							?>
						</div>
						<?php
							$admin_image = '/themes/'.($_ENV['CONF']['THEME']).'/images/admin_logo.png';
							if(!is_file(DOCUMENT_ROOT.$admin_image)) { $admin_image = '/admin/pic/favico.png'; }
							print(
								(($_ENV['USER']['ss_phpsessid']==$_REQUEST['PHPSESSID'] AND $_ENV['USER']['ss_aid']>0))
								?('
										<img src="'.($admin_image).'" style="max-height: 90px; float: left; margin-left: 10px;">
										<div class="adminMenuBox">'.join('</div><div class="adminMenuBox">',$_ENV['MOD_MENU']).'</div>')
								:('
										<form class="LoginForm" name="login" action="?login=1" method="post" onsubmit="$(\'#MyBody\').attr(\'edited\',null);">
											<h2 style="text-align: center;">{admin_user_login}</h2>
											<table style="margin:auto;">
												<tr>
													<td style="text-align: center;">
														{admin_user_login_user}:<br />
														<input type="text" class="text" name="luser" value="'.(in_text($_POST['luser'])).'" title="{admin_user_login_user}" style="width: 160px;"/>
													</td>
												</tr>
												<tr>
													<td style="text-align: center;">
														{admin_user_login_pass}:<br />
														<input type="password" class="text" name="lpass" value="'.(in_text($_POST['lpass'])).'" title="{admin_user_login_pass}" style="width: 160px;"/>
													</td>
												</tr>
												<tr>
													<td style="text-align: center;">
														<input class="admin_btn" type="submit" value="{admin_user_login_button}" title="{admin_user_login_button}" onclick="$(\'#MyBody\').attr(\'edited\',null);"/>
													</td>
												</tr>
											</table>
											<div style="text-align:center;font-size:12px;margin-top:10px;">{admin_user_login_info}</div>
											<div id="LoginAlert">'.($_ENV['LMSG']).'</div>
										</form>
										<br/>')); ?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="main_center">
						<div class="SiteMaxWidth">
<?php
				/* Tartalom betöltése! */
				if($_ENV['SYSTEM']['PAGE']) { print($_ENV['SYSTEM']['PAGE']); } else {
					if(is_file(str_replace(Array('{','}'),'',$_ENV['SITE']['MPHPWF'])) OR is_file(str_replace('//','/',MODUL_ROOT.'/'.$_ENV['SITE']['MPATH'].$_ENV['SITE']['MPHPAF']))) {
						if(strstr($_ENV['SITE']['MPHPAF'],'{')) {
							if(is_file(str_replace('//','/',str_replace(Array('{','}'),'',$_ENV['SITE']['MPHPAF'])))) {
								include(str_replace('//','/',str_replace(Array('{','}'),'',$_ENV['SITE']['MPHPAF'])));
							}
						} else {
							if(is_file(str_replace('//','/',MODUL_ROOT.'/'.$_ENV['SITE']['MPATH'].$_ENV['SITE']['MPHPAF']))) {
								include(str_replace('//','/',MODUL_ROOT.'/'.$_ENV['SITE']['MPATH'].$_ENV['SITE']['MPHPAF']));
							}
						}
					} else if(strstr($_ENV['SITE']['MPATH'],'{')) {
						if(is_file(str_replace('//','/',DOCUMENT_ROOT.str_replace(Array('{','}'),'/',$_ENV['SITE']['MPATH']).$_ENV['SITE']['DIRECT_FILE']))) {
							include(str_replace('//','/',DOCUMENT_ROOT.str_replace(Array('{','}'),'/',$_ENV['SITE']['MPATH']).$_ENV['SITE']['DIRECT_FILE']));
						}
					}
				}
				/***********************/
?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
