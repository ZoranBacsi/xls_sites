<?php /* Készítő: Homó Tibor */ if(!$_ENV['SiteStart']) { header('Location: /'); exit(); }
$_SERVER['PASSWORD'] = 'xlsponthu';
if(strtolower($_POST['pass'])==strtolower($_SERVER['PASSWORD'])) { $_SESSION['PASS']=md5($_SERVER['PASSWORD']); }

function TableControl($table,$sql) {
	$con = mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "'.(MySQLi_PREF.$table).'"');
	if(!mysqli_num_rows($con)) {
		for($a=0;$a<count($sql);$a++) {
			mysqli_query($_ENV['MYSQLI'],$sql[$a]);
			$err = mysqli_error($_ENV['MYSQLI']);
			if($err) {
				print('<b>'.$table.':</b> '.$err.'<br/>');
			}
		}
	}
}

echo'
		<style>
			label { display:inline-block; width:100px; }
			input[type="text"] { display:inline-block; width:150px; }
		</style>
		<div style="display:table;width:100%;height:100%;">
			<div style="display:table-row;">
				<div style="display:table-cell;vertical-align:middle;text-align:center;">
					<form action="/installer.html" method="post" style="display:inline-block;">
						<fieldset>
							<legend><h2 style="margin:0px;">Telepítés</h2></legend>
								<div style="display:table;width:100%;">
									<div style="display:table-row;">
										<div style="display:table-cell;vertical-align:top;text-align:left;padding-right:20px;">';

if($_SESSION['PASS']==md5($_SERVER['PASSWORD'])) {
	if(!is_array($_POST['css-js'])) { $_POST['css-js']=Array(); }
	if(!is_array($_ENV['CssJs'])) { $_ENV['CssJs']=Array(); }
	if(!is_array($_POST['moduls'])) { $_POST['moduls']=Array(); }
	$_ENV['moduls'] = Array();
	if($_SERVER['MYSQLI']) {
		if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "modul"'))) {
			$mcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `modul` ORDER BY `mod_index` DESC');
			while($msor=mysqli_fetch_array($mcon,MYSQLI_ASSOC)) {
				$_ENV['moduls'][] = $msor['mod_path'];
			}
		}
	}

	if($_POST['rogzit']==1) {
		/* MySQLi Kapcsolat */
		$_ENV['CONF']['SQL'] = Array();
		$_ENV['CONF']['SQL']['HOST'] = in_text($_POST['conf-sql-host']);
		$_ENV['CONF']['SQL']['USER'] = in_text($_POST['conf-sql-user']);
		$_ENV['CONF']['SQL']['PASS'] = in_text($_POST['conf-sql-pass']);
		$_ENV['CONF']['SQL']['DB'] = in_text($_POST['conf-sql-db']);

		if($_ENV['CONF']['SQL']['HOST'] AND $_ENV['CONF']['SQL']['USER'] AND $_ENV['CONF']['SQL']['PASS'] AND $_ENV['CONF']['SQL']['DB']) {
			if(!$_SERVER['MYSQLI']) { if($_ENV['MYSQLI'] = @mysqli_connect($_ENV['CONF']['SQL']['HOST'],$_ENV['CONF']['SQL']['USER'],$_ENV['CONF']['SQL']['PASS'])) { mysqli_select_db($_ENV['MYSQLI'],$_ENV['CONF']['SQL']['DB']); $_SERVER['MYSQLI'] = true; } }
		}
		if($_SERVER['MYSQLI']) {
			mysqli_query($_ENV['MYSQLI'],'SET NAMES utf8');
			$_ENV['sql'] = $_ENV['SQL'] = $_ENV['mysql'] = $_ENV['MySQL'] = $_ENV['MYSQL'] = $_ENV['mysqli'] = $_ENV['MySQLi'] = $_ENV['MYSQLI'];

			$_ENV['moduls'] = Array();
			if(mysqli_num_rows(mysqli_query($_ENV['MYSQLI'],'SHOW TABLES LIKE "modul"'))) {
				$mcon = mysqli_query($_ENV['MYSQLI'],'SELECT * FROM `modul` ORDER BY `mod_index` DESC');
				while($msor=mysqli_fetch_array($mcon,MYSQLI_ASSOC)) {
					$_ENV['moduls'][] = $msor['mod_path'];
				}
			}

			if($_SERVER['MYSQLI']) {
				if(is_file(MODULS_ROOT.'/default/installer/mysql.php')) {
					include(MODULS_ROOT.'/default/installer/mysql.php');
				}
				for($a=0;$a<count($_POST['moduls']);$a++) {
					if(is_file(MODULS_ROOT.'/'.$_POST['moduls'][$a].'/installer/mysql.php')) {
						include(MODULS_ROOT.'/'.$_POST['moduls'][$a].'/installer/mysql.php');
					}
				}
			}

			if(strlen($_POST['admin-pass'])>3) {
				mysqli_query($_ENV['MYSQLI'],'UPDATE `admin_users` SET `u_pass`="'.md5(in_text($_POST['admin-pass'])).'" WHERE `u_user`="root" LIMIT 1');
			}

		$_conf = "; Készítő: H.Tibor
[CONF]
CONF.SITENAME = '".(in_text(($_POST['conf-sitename'])?($_POST['conf-sitename']):('')))."'
CONF.THEME = '".(in_text(($_POST['conf-theme'])?($_POST['conf-theme']):('default')))."'
CONF.PAGE = 'body'

[CONF - SQL]
CONF.SQL.HOST = '".(in_text(($_POST['conf-sql-host'])?($_POST['conf-sql-host']):('localhost')))."'
CONF.SQL.USER = '".(in_text($_POST['conf-sql-user']))."'
CONF.SQL.PASS = '".(in_text($_POST['conf-sql-pass']))."'
CONF.SQL.DB = '".(in_text($_POST['conf-sql-db']))."'

[CONF - MAIL]
CONF.MAIL.MODE = 'PHP'
CONF.MAIL.NAME = 'Site Admin'
CONF.MAIL.MAIL = 'info@domain.hu'
CONF.SMTP.KAPCSOLAT = 'tcp' ; tcp, ssl, sslv2, sslv3, tls
CONF.SMTP.SERVER = 'localhost' ; localhost, mail.domain.hu
CONF.SMTP.PORT = '25' ; 25, 465, 587
CONF.SMTP.USER = ''
CONF.SMTP.PASS = ''

[HEAD]
HEAD.LANG = '".(in_text(($_POST['head-lang'])?($_POST['head-lang']):('')))."'
HEAD.IMAGE = '/themes/{conf:theme}/images/logo.png'

[HEAD - CSS]
HEAD.CSS[] = '/css-reset.css'
".((in_array('highslide',$_POST['css-js']))?(''):('; '))."HEAD.CSS[] = '/js/highslide/highslide.css'
".((in_array('jqueryui',$_POST['css-js']))?(''):('; '))."HEAD.CSS[] = '/js/jquery-ui.css'
".((in_array('nivoslider',$_POST['css-js']))?(''):('; '))."HEAD.CSS[] = '/js/nivoslider/jquery.nivo.slider.css'
".((in_array('uniform',$_POST['css-js']))?(''):('; '))."HEAD.CSS[] = '/js/uniform/uniform.default.min.css'
HEAD.CSS[] = '/themes/{conf:theme}/fonts/fonts.css' ; Téma Font CSS
HEAD.CSS[] = '/themes/{conf:theme}/css/style.css'

[HEAD - JAVA]
HEAD.JAVA[] = '/js/html5.js'
HEAD.JAVA[] = '/js/jquery.js'
".((in_array('jqueryui',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/jquery-ui.js'
".((in_array('jqcolum',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/jquery.columnizer.js'
".((in_array('uniform',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/uniform/jquery.uniform.min.js'
".((in_array('highslide',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/highslide/highslide.js'
".((in_array('bgpos',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/jquery.backgroundpos.js'
".((in_array('spnav',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/jquery.spasticnav.js'
".((in_array('jqMobil',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/jquery.mobile.js'
HEAD.JAVA[] = '/js/jquery.crypt.js'
".((in_array('nivoslider',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = 'http://{conf:host}/js/nivoslider/jquery.advanced.slider.min.js' ;
".((in_array('nivoslider',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/nivoslider/jquery.nivo.slider.js' ;
HEAD.JAVA[] = '/js/java.js' ; Alap JS funkciók
".((in_array('gmaps',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = 'http://maps.google.com/maps/api/js?sensor=false' ; Google Maps API
".((in_array('gmaps',$_POST['css-js']))?(''):('; '))."HEAD.JAVA[] = '/js/google-maps.js' ; Google Maps funkció
HEAD.JAVA[] = '/themes/{conf:theme}/js/java.js' ; Téma JS

[CONF - CSS-JAVA]
".((in_array('highslide',$_POST['css-js']))?(''):('; '))."CssJs[] = 'highslide'
".((in_array('jqueryui',$_POST['css-js']))?(''):('; '))."CssJs[] = 'jqueryui'
".((in_array('jqcolum',$_POST['css-js']))?(''):('; '))."CssJs[] = 'jqcolum'
".((in_array('uniform',$_POST['css-js']))?(''):('; '))."CssJs[] = 'uniform'
".((in_array('bgpos',$_POST['css-js']))?(''):('; '))."CssJs[] = 'bgpos'
".((in_array('spnav',$_POST['css-js']))?(''):('; '))."CssJs[] = 'spnav'
".((in_array('jqMobil',$_POST['css-js']))?(''):('; '))."CssJs[] = 'jqMobil'
".((in_array('nivoslider',$_POST['css-js']))?(''):('; '))."CssJs[] = 'nivoslider'
".((in_array('gmaps',$_POST['css-js']))?(''):('; '))."CssJs[] = 'gmaps'

[SITE]
SITE.AUTHOR-NAME = '".(in_text(($_POST['author-name'])?($_POST['author-name']):('XLS.HU - Honlapkészítés')))."'
SITE.AUTHOR-TEL = '".(in_text(($_POST['author-tel'])?($_POST['author-tel']):('06-1-220 1498')))."'
SITE.AUTHOR-MAIL = '".(in_text(($_POST['author-mail'])?($_POST['author-mail']):('info@xls.hu')))."'
SITE.AUTHOR-SITE = '".(in_text(($_POST['author-site'])?($_POST['author-site']):('www.xls.hu')))."'";
				fileWrite(DOCUMENT_ROOT.'/#config.ini',$_conf,false);

				/* /.htaccess beállítása */
				$_htaccess_ver = 'Ver. 1.0.0';
				$_docroot_htaccess_file = DOCUMENT_ROOT.'/.htaccess';
				$_docroot_htaccess_open = ((is_file($_docroot_htaccess_file))?(file_get_contents($_docroot_htaccess_file)):(''));
				if(!strstr($_docroot_htaccess_open,$_htaccess_ver)) {
					$_docroot_htaccess = '#  Készítő: H.Tibor, '.($_htaccess_ver).'
'.((is_file(DOCUMENT_ROOT.'/.php.ini'))?('
suPHP_ConfigPath '.realpath(DOCUMENT_ROOT.'/.php.ini').'
<Files .php.ini>
order allow,deny
deny from all
</Files>'):('')).'

'.((is_file(DOCUMENT_ROOT.'/.htpasswd'))?('
AuthType Basic
AuthName "'.(iconv('UTF-8','ISO-8859-2','Jelszóval Védett!')).'"
AuthUserFile '.realpath(DOCUMENT_ROOT.'/.htpasswd').'
require valid-user'):('')).'

DirectoryIndex index.html index.htm index.php index.phtml
AddType application/json .json
AddType text/html .ajax

<Files ~ "\.(cgi|tpl|inc|ini|sql|pl|sh|tmp)$">
	order allow,deny
	deny from all
</Files>

<FilesMatch "\.(htm|html|css|js|php|phtml|json|ajax|ini|inc)$">
	AddDefaultCharset UTF-8
	DefaultLanguage hu-HU
</FilesMatch>

<ifModule mod_headers.c>
	# No Cache
	<FilesMatch "\.(php|json|ajax)$">
		Header set Cache-Control "no-cache, no-store"
		Header unset Last-Modified
	</FilesMatch>
	# 1 Week
	<FilesMatch "\.(html|htm|phtml|css|js|xml|txt)$">
		Header set Cache-Control "max-age=604800, cache"
	</FilesMatch>
	# 1 Month
	<FilesMatch "\.(jpg|jpeg|png|gif|swf)$">
		Header set Cache-Control "max-age=2419200, cache"
	</FilesMatch>
	# 1 Year
	<FilesMatch "\.(ico|pdf|flv|mp4|mp3)$">
		Header set Cache-Control "max-age=29030400, cache"
	</FilesMatch>
</iFModule>

<ifmodule mod_deflate.c>
	#Gzip
	AddOutputFilterByType DEFLATE image/png image/jpeg
	AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css text/javascript
	AddOutputFilterByType DEFLATE application/x-javascript application/javascript application/json
	AddOutputFilterByType DEFLATE application/x-httpd-php
</ifmodule>

<iFModule mod_rewrite.c>
	rewritebase /
	RewriteEngine on

	RewriteCond %{HTTP_HOST} !^www\.
	RewriteCond %{HTTP_HOST} !^m\.
	RewriteRule ^(.*)$ http://www.%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

	RewriteRule ^(robots.txt)$ robots.phtml [QSA]
	RewriteRule ^(sitemap.xml)$ sitemap.phtml [QSA]
	RewriteRule ^(search.xml)$ search.phtml [QSA]
	RewriteRule ^(rss.xml)$ rss.php [QSA]
	RewriteRule ^(javas.js)$ javas.phtml [QSA]
	RewriteRule ^(styles.css)$ styles.phtml [QSA]
	RewriteRule ^(captcha.png)$ captcha.php [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.(js)$ images/no-java.js [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.(css)$ images/no-style.css [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.(jpg|jpeg|png|gif)$ images/noimage.png [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.json$ json.php [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.ajax$ ajax.php [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php [QSA]
</iFModule>';
				if(is_file($_docroot_htaccess_file)) { rename($_docroot_htaccess_file,'/tmp/.htaccess_'.date('Y-m-d_H.i.s')); }
				fileWrite($_docroot_htaccess_file,$_docroot_htaccess,false);
			}

			/* /admin/.htaccess beállítása */
			$_admin_htaccess_file = DOCUMENT_ROOT.'/admin/.htaccess';
			$_admin_htaccess_open = ((is_file($_admin_htaccess_file))?(file_get_contents($_admin_htaccess_file)):(''));
			if(!strstr($_admin_htaccess_open,$_htaccess_ver)) {
				$_admin_htaccess = '#  Készítő: H.Tibor, '.($_htaccess_ver).'
'.((is_file(DOCUMENT_ROOT.'/admin/.htpasswd'))?('
AuthType Basic
AuthName "'.(iconv('UTF-8','ISO-8859-2','Jelszóval Védett!')).'"
AuthUserFile '.realpath(DOCUMENT_ROOT.'/admin/.htpasswd').'
require valid-user'):('')).'

DirectoryIndex index.html index.htm index.php
AddType application/json .json
AddType text/html .ajax

<Files ~ "\.(cgi|tpl|inc|ini|sql|pl|sh|tmp)$">
	order allow,deny
	deny from all
</Files>

<FilesMatch "\.(htm|html|css|js|php|phtml|json|ajax|ini|inc)$">
	AddDefaultCharset UTF-8
	DefaultLanguage hu-HU
</FilesMatch>

<ifModule mod_headers.c>
	# No Cache
	<FilesMatch "\.(php|json|ajax)$">
		Header set Cache-Control "no-cache, no-store"
		Header unset Last-Modified
	</FilesMatch>
	# 1 Week
	<FilesMatch "\.(html|htm|phtml|css|js|xml|txt)$">
		Header set Cache-Control "max-age=604800, cache"
	</FilesMatch>
	# 1 Month
	<FilesMatch "\.(jpg|jpeg|png|gif|swf)$">
		Header set Cache-Control "max-age=2419200, cache"
	</FilesMatch>
	# 1 Year
	<FilesMatch "\.(ico|pdf|flv|mp4|mp3)$">
		Header set Cache-Control "max-age=29030400, cache"
	</FilesMatch>
</iFModule>

<ifmodule mod_deflate.c>
	#Gzip
	AddOutputFilterByType DEFLATE image/png image/jpeg
	AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css text/javascript
	AddOutputFilterByType DEFLATE application/x-javascript application/javascript application/json
	AddOutputFilterByType DEFLATE application/x-httpd-php
</ifmodule>

<IfModule mod_rewrite.c>
	rewritebase /admin/
	RewriteEngine on

	RewriteCond %{HTTP_HOST} !^www\.
	RewriteCond %{HTTP_HOST} !^m\.
	RewriteRule ^(.*)$ http://www.%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

	RewriteRule ^(javas.js)$ javas.phtml [QSA]
	RewriteRule ^(styles.css)$ styles.phtml [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.json$ json.php [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.ajax$ ajax.php [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)\.html$ index.php [QSA]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php [QSA]
</IfModule>';
				fileWrite($_admin_htaccess_file,$_admin_htaccess,false);
			}

			/* /files/.htaccess beállítása */
			$_files_htaccess_file = DOCUMENT_ROOT.'/files/.htaccess';
			$_files_htaccess_open = ((is_file($_files_htaccess_file))?(file_get_contents($_files_htaccess_file)):(''));
			if(!strstr($_files_htaccess_open,$_htaccess_ver)) {
				$_files_htaccess = '#  Készítő: H.Tibor, '.($_htaccess_ver).'
AddType application/x-httpd-php-source .php .phtml .php3 .php5 .phpc .cgi .pl .sh
<Files ~ "\.(tpl|inc|sql|php|phtml|php3|php5|phpc|cgi|pl|sh)$">
	order allow,deny
	deny from all
</Files>';
				fileWrite($_files_htaccess_file,$_files_htaccess,false);
			}

			/* /images/.htaccess beállítása */
			$_files_htaccess_file = DOCUMENT_ROOT.'/files/.htaccess';
			$_files_htaccess_open = ((is_file($_files_htaccess_file))?(file_get_contents($_files_htaccess_file)):(''));
			if(!strstr($_files_htaccess_open,$_htaccess_ver)) {
				$_files_htaccess = '#  Készítő: H.Tibor, '.($_htaccess_ver).'
<iFModule mod_rewrite.c>
	rewritebase /
	RewriteEngine on

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ /themes/'.(in_text(($_POST['conf-theme'])?($_POST['conf-theme']):('default'))).'/images/$1 [QSA]
	
</iFModule>';
				fileWrite($_files_htaccess_file,$_files_htaccess,false);
			}

			/* /tmp/.htaccess beállítása */
			$_tmp_htaccess_file = DOCUMENT_ROOT.'/tmp/.htaccess';
			$_tmp_htaccess_open = ((is_file($_tmp_htaccess_file))?(file_get_contents($_tmp_htaccess_file)):(''));
			if(!strstr($_tmp_htaccess_open,$_htaccess_ver)) {
				$_tmp_htaccess = '#  Készítő: H.Tibor, '.($_htaccess_ver).'
AddType application/x-httpd-php-source .php .phtml .php3 .php5 .phpc .cgi .pl .sh
<Files ~ "\.*$">
	order allow,deny
	deny from all
</Files>';
				fileWrite($_tmp_htaccess_file,$_tmp_htaccess,false);
			}
			echo'<script> location.href="/installer.html" </script>';
		}
	}

	/* Adatok megadása */
	echo'
		<input type="hidden" name="rogzit" value="1" />
		<h3>Adatbázis kapcsolat</h3>
		<p><label for="conf-sql-host">MySQL host:</label> <input type="text" name="conf-sql-host" id="conf-sql-host" value="'.($_ENV['CONF']['SQL']['HOST']).'" /></p>
		<p><label for="conf-sql-user">MySQL user:</label> <input type="text" name="conf-sql-user" id="conf-sql-user" value="'.($_ENV['CONF']['SQL']['USER']).'" /></p>
		<p><label for="conf-sql-pass">MySQL pass:</label> <input type="text" name="conf-sql-pass" id="conf-sql-pass" value="'.($_ENV['CONF']['SQL']['PASS']).'" /></p>
		<p><label for="conf-sql-db">MySQL db:</label> <input type="text" name="conf-sql-db" id="conf-sql-db" value="'.($_ENV['CONF']['SQL']['DB']).'" /></p>
		<p>&nbsp;</p>

		<h3>Megjelenő theme</h3>
		<p><label for="conf-sitename">Weblap neve:</label> <input type="text" name="conf-sitename" id="conf-sitename" value="'.($_ENV['CONF']['SITENAME']).'" /></p>
		<p><label for="conf-theme">Weblap témája:</label> <input type="text" name="conf-theme" id="conf-theme" value="'.($_ENV['CONF']['THEME']).'" /></p>
		<p><label for="head-lang">Weblap nyelve:</label> <input type="text" name="head-lang" id="head-lang" value="'.($_ENV['HEAD']['LANG']).'" /></p>
		<p>&nbsp;</p>

		<h3>Fejlesztő</h3>
		<p><label for="author-name">Neve:</label> <input type="text" name="author-name" id="author-name" value="'.($_ENV['SITE']['AUTHOR-NAME']).'" /></p>
		<p><label for="author-tel">Tel.Száma:</label> <input type="text" name="author-tel" id="author-tel" value="'.($_ENV['SITE']['AUTHOR-TEL']).'" /></p>
		<p><label for="author-mail">Email címe:</label> <input type="text" name="author-mail" id="author-mail" value="'.($_ENV['SITE']['AUTHOR-MAIL']).'" /></p>
		<p><label for="author-site">Web címe:</label> <input type="text" name="author-site" id="author-site" value="'.($_ENV['SITE']['AUTHOR-SITE']).'" /></p>

										</div>
										<div style="display:table-cell;vertical-align:top;text-align:left;">

		<h3>JS-CSS kiegészítők</h3>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-highslide" value="highslide" '.((in_array('highslide',$_POST['css-js']) OR in_array('highslide',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-highslide">Highslide</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-jqueryui" value="jqueryui" '.((in_array('jqueryui',$_POST['css-js']) OR in_array('jqueryui',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-jqueryui">jQuery UI</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-jqcolum" value="jqcolum" '.((in_array('jqcolum',$_POST['css-js']) OR in_array('jqcolum',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-jqcolum">jQuery Columnizer</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-jqMobil" value="jqMobil" '.((in_array('jqMobil',$_POST['css-js']) OR in_array('jqMobil',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-jqMobil">jQuery Mobil</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-uniform" value="uniform" '.((in_array('uniform',$_POST['css-js']) OR in_array('uniform',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-uniform">Uniform</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-bgpos" value="bgpos" '.((in_array('bgpos',$_POST['css-js']) OR in_array('bgpos',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-bgpos">Background Pos (animate)</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-spnav" value="spnav" '.((in_array('spnav',$_POST['css-js']) OR in_array('spnav',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-spnav">Spastic Nav</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-nivoslider" value="nivoslider" '.((in_array('nivoslider',$_POST['css-js']) OR in_array('nivoslider',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-nivoslider">Nivo Slider</label>
		</p>
		<p>
			<input type="checkbox" name="css-js[]" id="css-jss-gmaps" value="gmaps" '.((in_array('gmaps',$_POST['css-js']) OR in_array('gmaps',$_ENV['CssJs']))?('checked'):('')).' />
			<label style="width:220px;" for="css-jss-gmaps">Google maps</label>
		</p>
		<p>&nbsp;</p>

		<h3>Telepíthető modulok</h3>';

	if(is_dir(MODULS_ROOT)) {
		if($_dh = opendir(MODULS_ROOT)) {
			while(($_file = readdir($_dh)) !== false) {
				if(filetype(MODULS_ROOT.'/'.$_file)=='dir'
					AND substr($_file,0,1)!='.'
					AND substr($_file,0,1)!='!'
					AND substr($_file,0,1)!='#'
					AND $_file != 'default') {
					echo'
						<p>
							<input type="checkbox" name="moduls[]" id="moduls-'.($_file).'" value="'.($_file).'" '.((in_array($_file,$_POST['moduls']) OR in_array($_file,$_ENV['moduls']))?('checked disabled'):('')).' />
							<label style="width:220px;" for="moduls-'.($_file).'">'.($_file).'</label>
						</p>';
				}
			}
		}
	}
	echo'
		<p>&nbsp;</p>

		<h3>Admin</h3>
		<p><label for="admin-pass">Root Jelszava:</label> <input type="text" name="admin-pass" id="admin-pass" placeholder="root" /></p>
										</div>
									</div>
								</div>
		<p>&nbsp;</p>
		<p style="text-align:center;"><input type="submit" value="Rögzít - Telepít" /></p>';
} else {
	echo'
		<p>Jelszó: <input type="password" name="pass" style="width:90px" /></p>
		<p>&nbsp;</p>
		<p style="text-align:center;"><input type="submit" value="Belép &#187;" /></p>';
}
echo'
						</fieldset>
					</form>
				</div>
			</div>
		</div>';
?>