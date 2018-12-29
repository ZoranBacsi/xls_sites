
		<header id="header">
			<div class="content">
				<div class="menuIcon mobile"></div>
				<h1>{head:h1}</h1>
			</div>			
		</header>		
		<section id="main">
			<section class="content">
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							<nav id="nav">
								<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
							</nav>
							<p class="info">Elérhetőség</p>
							<p class="phone"><strong>nn / nnn nnnn</strong></p>
							<p class="info">info@filepdiesel.hu</p>							
							<div class="menu-pic"></div>
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
				<div class="copy">&copy; <?php print date('Y').' Minden jog fenntartva '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'; ?> </div>
			</section>
		</footer>