
		<nav id="nav">
			<section class="content">
				<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
				<span class="clear"></span>
			</section>
		</nav>

		<header id="header">
			<section class="content">
				<div class="menuIcon mobile"></div>
				<h1 class="nomobile">{head:h1}</h1>
				<div class="logoText mobile">
					{conf:sitename}
				</div>
				<span class="clear"></span>
			</section>
		</header>

		<section id="main">
			<section class="content">
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							...
						</section>
						<section class="cell contentCell">
							{site:page}
						</section>
						<section class="cell rightCell">
							...
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