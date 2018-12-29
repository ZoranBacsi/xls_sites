		<header id="header">
			<section class="content">
				<section class="title">
					<h2>Energetikai tanusítvány</h2>
					<p>Tanusítvány több mint 15 év energetikai tapasztalattal - kamarai regisztrációval Budapesten és környékén</p>
				</section>
				<section class="phone">
					<p>Információs szám</p>
					<h2>20/ 544 6585</h2>
				</section>
			</section>
		</header>
		<section id="nav">
			<section class="content">
				<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
			</section>
		</section>
		<section id="main">
			<section class="content">				
				<img class="header_image" src="/images/header.png" alt="header" />
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							<div class="nav2">
								<ul> {secMenu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
							</div>
						</section>
						<section class="cell contentCell">
							{site:page}
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