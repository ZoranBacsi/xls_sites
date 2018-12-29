
		<div id="header"<?php if($_ENV['REURL'][1]=='index' OR $_ENV['REURL'][1]=='szmenu' OR $_ENV['REURL']=='') { /* Főoldal */  } else {  print(' style="height:183px;background:none;"'); } ?>>
			<div class="menuIcon mobile"><p>Menü</p></div>
			<div class="content">
				<h1>{head:h1}</h1>
				<span class="logo">
					<span class="TextAuto">Autó</span>
					<span class="TextBerles">Bérlés</span>
				</span>
				<span class="logoBudaors"><a href="tel:+36309406454">06-30-940-6454</a><!--span class="TextBudaors"></span--></span>
				<div id="nav">
					<ul>
						{menu:<li class="[active]"><a href="[url]">[link]</a>[SUB]</li>}
					</ul>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="contentBox">
				<div class="contentRow">
					<div id="sidebar" class="contentCell">
						<div class="box">
							<h3 class="LeftTitle">ELÉRHETŐSÉG</h3>
							<p class="LeftTel"><a href="tel:+36309406454">06-30-940-6454</a></p>
							<p> </p>
						</div>
					</div>
					<div id="main" class="contentCell">
						<div class="box">{site:page}</div>
					</div>
				</div>
			</div>
		</div>