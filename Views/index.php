
	<main id="main">
		<section class="primary what">
			<article class="article">
				<span class="fast-link">
					<a href="#" class="toTop"><img src="./img/up.png" alt="Previous" /></a>
					<a href="#" class="toWhy"><img src="./img/down.png" alt="Next" /></a>
				</span>
				<h1><img src="./img/home.png" /> What</h1>
				<p>
					The name "SpaceEngine" represent a free engine for your website.</p>
				<p>
					It's coded in PHP5 object, using Foundation 4 (HTML Framework) and it's very simple to use for anyone!
				</p>
			</article>
		</section>
		<section class="secondary why">
			<article class="article">
				<span class="fast-link">
					<a href="#" class="toWhat"><img src="./img/up.png" alt="Previous" /></a>
					<a href="#" class="toWho"><img src="./img/down.png" alt="Next" /></a>
				</span>
				<h1><img src="./img/use.png" /> Why</h1>
				<p>
					You can find a lot of another web engine on the web. But you can also use the SpaceEngine for a lot of good reason!
					<ul>
						<li>Simply <a href="#">awesome for novice</a></li>
						<li><a href="#">Explicites</a> comments</li>
						<li>Fast <a href="#">commissioning</a></li>
						<li>Secure & <a href="#">WYSIWYG back-end</a></li>
						<li>HTML framework <a href="#">Foundation 4</a> implemented</li>
					</ul>
				</p>
			</article>
		</section>
		<section class="primary who">
			<article class="article">
				<span class="fast-link">
					<a href="#" class="toWhy"><img src="./img/up.png" alt="Previous" /></a>
					<a href="#" class="toTutorial"><img src="./img/down.png" alt="Next" /></a>
				</span>
				<h1><img src="./img/follow.png" /> Who?</h1>
				<p>
					My name is Julien Bernard. I am a young web & software developer.<br />
					You can follow me on <a href="#">Twitter</a> or play to <a href="#">ApocalySpace</a>, one of my another fun project!
				</p>
			</article>
		</section>
		<section class="secondary tutorial">
			<article class="article">
				<span class="fast-link">
					<a href="#" class="toTop"><img src="./img/up.png" alt="Previous" /></a>
					<a href="#" class="toFollow"><img src="./img/down.png" alt="Next" /></a>
				</span>
				<h1><img src="./img/coffee.png" /> Getting Started</h1>
				<p>
					Download the latest stable version of the engine on his GitHub homepage. Please, be care to be in the master branch!
				</p>
			</article>
		</section>
		<section class="primary tutorial">
			<nav class="navigation follow">
				<a href="#" class="toTop"><img src="./img/up.png" alt="Previous" /></a><br />
				<a href="https://github.com/JulienBernard">I'm on GitHub</a><a href="https://twitter.com/ProJibi">I'm on Twitter</a><br />
				<a href="#" data-dropdown="drop1">Play online with me on ApocalySpace</a><a href="#" data-dropdown="drop1">Meet me at Paris with the LAN PARTY</a>
			</nav>
		</section>
	</main>
	
	<ul id="drop1" class="f-dropdown content" data-dropdown-content>
		<h6>Not available yet!</h6>
	</ul>

	<div id="loginModal" class="reveal-modal">
		<h2>Awesome login page!</h2>
		<p class="lead">Hey! Thanks you to try the SpaceEngine, you'll see: it's very simple to use it!</p>
		<p>
			Please enter your login and your password. For the demo, please use: "demo" & "demo".
		</p>
		
		<form action="index.php" method="POST">
			<div class="row">
				<div class="large-4 columns">
					<label for="usr">Your username</label>
					<input id="usr" type="text" name="username" placeholder="Username" />
				</div>
				<div class="large-4 columns">
					<label for="pwd">Your password</label>
					<input id="pwd" type="password" name="password" placeholder="Password" />
				</div>
				<div class="large-4 columns">
					<br />
					<input class="small button" type="submit" name="login" value="Log me" />
				</div>
			</div>
		</form>
		
		<div class="panel">
			<p class="lead">1. Secured Connection</p>
			<p>
				For every connection, a secret token is created and sent on the database.<br />
				Thereby, the session (which on only keeps the user ID) cannot get hacked by simple values updates. You can even add a captcha if you would like to!
			</p>
		</div>

		<a class="close-reveal-modal">&#215;</a>
	</div>
	
	<div id="Modal" class="reveal-modal">
		<?php
			if( $Engine->getError() != null )
			{
				echo '<p class="lead">An error has been detected!</p>';
				echo '<p>'.$Engine->getError().'</p>';
			}
			else if( $Engine->getSuccess() != null )
			{
				echo '<p class="lead">Success!</p>';
				echo $Engine->getSuccess();
			}
			else if( $Engine->getInfo() != null )
			{
				echo '<p class="lead">Informations:</p>';
				echo $Engine->getInfo();
			}
		?>
	</div>
	