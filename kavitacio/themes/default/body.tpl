<div class="body_wrapper">
	<div id="header">
		<span class="logo"></span>
		<div><h1> Kavitáció <span class="speciel">háznál</span></h1></div>
		<div id="nav">
			<ul>
				{menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>}
			</ul>
		</div>
	</div>		
	<div id="content">
		<div class="image"><h1 class="kepszoveg">{head:h1}</h1></div>
		<div class="title"></div>
		<div class="contentBox">
			<div class="contentRow">
				<div id="main" class="contentCell">
					{site:page}
				</div>
				<div id="sidebar" class="contentCell">
					<div class="image_wrapper">
						<img src="/themes/default/images/sideimage.png" alt="" />
					</div>
				</div>
			</div>
		</div>
		<div class="phone-line">
			<div class="phone">
				<h2 class="phone">
					IDŐPONT KÉRÉS: <br> 70/ 548 54 45
				</h2>
			</div>
		</div>
	</div>
	<div id="footer">
		&copy; {php:date('Y').' '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'} 
	</div>
</div>