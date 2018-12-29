		<div class="up_line">
			<section class="content">
				<p class="welcome">Welcome to Kontír Digital Office website!</p>
				<p class="call_us">00-36-30-246-4295, 00-44-7788236595</p>	
				<img class="phone" src="/images/phone.png" alt="Call Us" />		
			</section>
		</div>
		<div class="h1_line">
			<section class="content">
				<h1 class="nomobile">{head:h1}</h1>
			</section>
		</div>
		<header id="header">
			<section class="content">
				<div class="menuIcon mobile"></div>
				<div class="logoText mobile">
					{conf:sitename}
				</div>
				<div class="header_text"> Accounting and financial regulations </div>
				<span class="clear"></span>
			</section>
		</header>
		<section id="main">
			<section class="content">
				<section class="group">
					<section class="row">
						<section class="cell leftCell">
							<nav id="nav">
								<section class="content">
									<ul> {menu:<li class="[active]"><a href="[url]">[link]</a><section class="link_circle"></section>[SUB]</li>} </ul>
									<span class="clear"></span>
								</section>
							</nav>
						</section>
						<section class="cell contentCell">
							{site:page}
						</section>
					</section>
				</section>
			</section>
		</section>
		<section class="info_line">
			<section class="content">
				<div class="info">
					<img class="footer_icon" src="/images/loc.png" alt="Location" />
					ADRESS<br /><br />
					1116 Budapest, Fehérvári út 168-178. C Iph. 7. em. 47.<br /> Post adress: 1116 Budapest Kondorosi út 12.a fszt. 1.
				</div>
				<div class="info">
					<img class="footer_icon" src="/images/tel.png" alt="Call Us" />
					PHONE<br /><br />
					00-36-30-246-4295<br />00-44-7788236595
				</div>
				<div class="info">
					<img class="footer_icon" src="/images/mail.png" alt="E-mail Us" />
					E-MAIL<br /><br />
					info@kontir2000.hu
				</div>
				<div class="info">
					FOLLOW US!<br /><br />
					<img class="footer_icon" src="/images/face.png" alt="facebook" /> facebook <img class="footer_icon" src="/images/twitter.png" alt="twitter" /> twitter 
				</div>
				<div class="copy">&copy; <?php print date('Y').' All rights reserved '.$_ENV['CONF']['SITENAME'].' &bull; <a href="http://'.$_ENV['SITE']['AUTHOR-SITE'].'/" target="_blank">'.$_ENV['SITE']['AUTHOR-NAME'].'</a>'; ?> </div>
			<section class="content">
		</section>