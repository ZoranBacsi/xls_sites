	<header id="header">
		<section class="content">
			<section class="row">
				<div class="menuIcon mobile"></div>
				<div class="logoText mobile">
					{conf:sitename}
				</div>
				<span class="clear"></span>
				<img class="logo nomobile" src="/images/logo.png" />
				<img class="header-image nomobile"  src="/images/header.png" />
			</section>
			<section class="h1-line nomobile">					
				{head:h1}
			</section>
			<nav id="nav">
				<ul> {menu:<li class="[active]"><section class="triangle nomobile"></section><a href="[url]">[link]</a>[SUB]</li>} </ul>
				<span class="clear"></span>
			</nav>
		</section>
	</header>

	<section id="main">
		<section class="content">
			{site:page}
		</section>
		<section>
			<img class="main-image nomobile"  src="images/footer.png" />
		</section>
		<section class="main_info content">
			Veresegyház, Szent Korona u. 30. <br />
			Gárdony, Lóránt Péter u. 25. <br />
			06-20/343-6899 <br />
			06-20/333-1936
		</section>
	</section>

	<footer id="footer">
		<section class="content">
			<div class="copy">&copy; <?php print date('Y').' Minden jog fenntartva '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'; ?> </div>
		</section>
	</footer>