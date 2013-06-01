
	<header>
		<h1>PRESENTATION</h1>
	</header>
	
	<article>
		<p>
			<?php echo nl2br($presentation->getText()); ?>
		</p>
		<form action="index.php" method="POST">
			<input type="submit" name="retrieveText" value="Récuperer le texte" />
		</form>
		<br />
		<h2>Modifier ce texte via PDO :</h2>
		<p>
			Vous devez être connecté pour modifier ce texte.
		</p>
		<form action="index.php" method="POST">
			Pseudo <input type="text" name="login" value="test" /><br />
			Mot de passe <input type="password" name="password" value="test" />
			<input type="submit" name="Connexion" value="Connexion" />
		</form>
	</article>
	