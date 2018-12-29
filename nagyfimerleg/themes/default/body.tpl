
		<header id="header">
			<h1><span class="content">{head:h1}</span></h1>
			<div class="kapcs">
				<div class="content">
					<a class="tel" href="tel:+36705455457" >+36 70 545 5457</a>
					<a class="mail" href="mailto:nagyfimerleg@gmail.com">nagyfimerleg@gmail.com</a>
				</div>
			</div>
			<section class="content">
				<div class="mobile menuIcon"></div>
				<a href="/" target="_top"><span class="logo"></span></a>
				<div class="logoText"> </div>
				<span class="clear"></span>
			</section>
		</header>
		
		<section id="main">
			<section class="content">
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							<nav id="nav">
								<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
							</nav>
							<span class="clear"></span>
						</section>
						<section class="cell">
							{site:page}
							<span class="clear"></span>
						</section>
					</section>
				</section>
			</section>
		</section>

		<footer id="footer">
			<section class="content">
				<div class="kapcs">
					<a class="tel" href="tel:+36705455457">+36 70 545 5457</a>
					<a class="mail" href="mailto:nagyfimerleg@gmail.com">nagyfimerleg@gmail.com</a>
					<!-- a class="cim" href="https://www.google.hu/maps/place/1142 Budapest, Dorozsmai u. 11/a" target="_blank">1142 Budapest, Dorozsmai u. 11/a fsz. 4.</a-->
				</div>
				<div class="copy">&copy; <?php print date('Y').' Minden jog fenntartva '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'; ?> </div>
			</section>
		</footer>