
		<header id="header">			
			<section id="nav">
				<div class="logo">La-Cargo Kft.</div>
				<section class="nav content">
					<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
				</section>
			</section>
			<section class="topKep">
				<div>
					<h1>{head:h1}</h1>
				</div>
			</section>			
		</header>
		<section id="main">
			<section class="content">
				<section class="title">
				</section>
				<section class="divider">
				</section>
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							{site:page}
							<span class="clear"></span>
						</section>
						<section class="cell rightCell">
							<div class="leftContact">
								<h3>lacargo@gmail.com</h3>
								<h3>70/666-5652</h3>
								<?php print out_html('<p><iframe src="#{maps:1}" width="220" height="220"></iframe></p>'); ?>
							</div>
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