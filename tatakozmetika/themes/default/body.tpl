
		<header id="header">
			<section class="content">
				<div class="mobile menuIcon"></div>
				<h1>{head:h1}</h1>
				<div class="logo">Tata Kozmetika</div>
				<div class="contact">
					Bejelentkezés: +36 30 2887698
					<a href="http://fb.com/" target="_blank"><img src="/images/icon-fb.png" alt="f" border="0" /></a>
				</div>
				<span class="clear"></span>
				<div class="topKep">
					<span class="text">
						Kozmetika, lávaköves masszázs,<br/>
						sminktetoválás, 3D műszempilla,<br/>
						facelift arcmasszázs.<br/>
						<br/>
						Csak természetes összetételű<br/>
						anyagokkal!
					</span>
				</div>
			</section>
		</header>
		
		<nav id="nav">
			<section class="content">
				<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
			</section>
		</nav>
		
		<section id="main">
			<section class="content">
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							<div class="leftContact">
								<p>Telefonon történő bejelentkezés<br/>alapján 0036 30 2887698.</p>
								<p><a href="https://www.google.hu/maps/place/%C3%9Ajhegyi+%C3%BAt+40,+Tata,+2890/@47.6603039,18.336355,17z/data=!3m1!4b1!4m2!3m1!1s0x476a45bf89f1ce15:0x14cee2c6f77d6987" target="_blank">2899 Tata Újhegyi út.40.</a></p>
								<?php print out_html('<p><iframe src="#{maps:1}" width="280" height="300"></iframe></p>'); ?>
							</div>
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