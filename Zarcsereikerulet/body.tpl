
		<div id="header">
			<div class="menuIcon mobile"></div>
				<div class="logoText mobile">
					{conf:sitename}
			</div>
			<div class="shopIcon mobile"></div>
			<span class="clear"></span>
			<h1 class="nomobile"><span>{head:h1}</span></h1>
		</div>
		<div id="content">
			<div id="nav">
				<ul>
					{menu:<li class="[active]"><a href="[url]"><span>[link]</span></a>[SUB]</li>}
				</ul>
			</div>
			<div id="site_image" class="nomobile"><?php print($_ENV['SITE']['FejlecKep']); ?></div>
			<div class="contentBox">
				<div class="contentRow">
					<div id="sidebar" class="contentCell">
						<div id="nav2">
							<ul>
								{sitemenu:<li class="[active]"><a href="[url]"><span>[link]</span></a>[SUB]</li>}
							</ul>
						</div>
					</div>
					<div id="main" class="contentCell">
						<div class="SiteMain">
							{site:page}
						</div>
					</div>

				</div>
			</div>
		</div>
		<div id="footer">Baka Csoport Kft.<br/>1086 Budapest, Lujza u. 16<br/>asz: 24330522-2-42<br/><br/>&copy; {php:date('Y').' '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'} </div>