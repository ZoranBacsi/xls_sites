<header id="header">
	<section class="head_h1">
		<section class="content">
			<h1>{head:h1}</h1>
			<p class="phone">Rendelésfelvétel: 20/ 478 54 24 </p>
		</section>
	</section>
	<section>		
		<img class="logo" src="/images/logo.png" alt="logo" />
		<section class="content">
			<p class="main_title">{conf:sitename}</p>
		</section>
	</section>
	<nav id="nav">
		<section class="content">
			<ul> {menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]<img class="divider" src="/images/nav_divider.png" alt="divider" /img></li>} </ul>
			<span class="clear"></span>
		</section>
	</nav>
	<img class="header_img" src="/images/header.jpg" alt="logo" />
	<section class="header_text">
		<section class="content">	
			<p class="h_text">
				Tegye esküvőjét páratlanná tortáinkkal! <br /> Rendelésfelvétel, minden nap 9:00-18:00-ig!
			</p>
			<img class="dove" src="/images/dove.png" alt="not a rabbit" />
		</section>
	</section>
</header>
<section id="main">
	<section class="content">
		<section class="group">
			<section class="row">
				<section class="cell leftCell">
					<section class="info_box">
						<h1>MEGKÖZELÍTÉS</h1>
						<hr>
						<iframe class="google_map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2687.5375340531273!2d19.49254621520877!3d47.654553092657984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741b57c920c73cd%3A0x3aee14b6e253451d!2zQXN6w7NkLCBGYWx1asOhcsOzayDDunRqYSA3LCAyMTcw!5e0!3m2!1shu!2shu!4v1467287823896" allowfullscreen></iframe>
						<hr>
						<h1>
							H - P: 9:00-18:00<br />
							SZ - V: 9:00-19:00
						</h1>
					</section>
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