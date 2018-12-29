<div class="body_wrapper">
		<div id="header">
			<h1>{head:h1}</h1>
			<div class="phone">30/ 245 45 86</div>
			<span class="logo"></span>
		</div>		
		<div class="image"></div>
		<div id="nav">
			<ul>
				{menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>}
			</ul>
		</div>
		<div id="content">
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
		</div>
		<div id="footer">&copy; {php:date('Y').' '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'} </div>
		</div>