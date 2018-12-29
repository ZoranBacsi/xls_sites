		<header id="header">
			<div class="menuIcon mobile"></div>
			<div><h1>{head:h1}</h1></div>			
		</header>		
		<section id="main">
			<section class="header_pic">
				<p class="info">
					Tüzelő<br />
					házhozszállítás<br />
					Telefon:
				</p>
				<p class="phone">
					06 - 20 / 954 - 1228
				</p>
			</section>
			<section class="content">
					<nav id="nav">
						<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>} </ul>
						<br/><br/>
						<span class="clear"></span>							
					</nav>
					{site:page}
			</section>
			<footer id="footer">
					<div class="copy">&copy; <?php print date('Y').' Minden jog fenntartva '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'; ?> </div>
			</footer>
		</section>