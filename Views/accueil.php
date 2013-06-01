
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
			Pseudo <input type="text" name="login" value="test" /><?php if( isset($returnError) && $returnError['login'] == 0) echo "Ce champ ne doit pas être vide."; ?><br />
			Mot de passe <input type="password" name="password" value="test" /><?php if( isset($returnError) && $returnError['password'] == 0 ) echo "Ce champ ne doit pas être vide."; ?><br />
			<input type="submit" name="Connection" value="Connexion" />
		</form>
		<?php
			if( !empty($errorLogin) )
				echo "<p>".$errorLogin."</p>";
		?>
	</article>
	