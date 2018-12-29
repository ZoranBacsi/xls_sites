		<header id="header">
			<div class="content">
				<div class="menuIcon mobile"></div>
				<h1>{head:h1}</h1>
			</div>			
		</header>
		<section id="navigation">
			<nav id="nav">
				<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>											
			</nav>
		</section>
		<section id="placeholder">
		
		</section>
		<section id="main">
			<section class="content">
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							<p class="info_title">Ügyfélfogadási idő:</p>
							<p class="info_data">H-P: 9:00-18:00</p>
							<p class="info_title">Információs szám:</p>
							<p class="info_data">06-70-545-5456</p>
							<p class="info_title">Internetes ügyintézés:</p>
							<p class="info_data">forgalombahelyezes@gmail.com</p>
							<section id="triangle"></section>
						</section>
						<section class="cell rightCell">
							{site:page}
							<span class="clear"></span>
						</section>
					</section>
				</section>
			</section>
		</section>

		<footer id="footer">
			<section class="content">
				<div class="copy">&copy; <?php print date('Y').' Minden jog fenntartva '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'; ?> </div>
			</section>
		</footer>