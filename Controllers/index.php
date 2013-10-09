	<?php

	include_once(PATH_MODELS."myPDO.class.php");		
	
	/* Une action sur un formulaire (envoie par POST) a été effectuée.  */
	if( isset($_POST) ) {
		if( isset($_POST['login']) ) {
			$fields = array('username' => $_POST['username'], 'password' => $_POST['password']);
			$return = $Engine->checkParams($fields);
			
			if( $return == 1 ) {
				include_once(PATH_MODELS."myPDO.class.php");
				include_once(PATH_MODELS."user.class.php");
			
				$username = (String)htmlspecialchars(strtolower($_POST['username']));
				$password = (String)htmlspecialchars($_POST['password']);
				$faction = (String)null;			
				
				/* Cet username n'est pas déjà attribué à un autre joueur. */
				$login = User::checkLogin( $username, $password );
				if( $login == 1 )
					$Engine->setSuccess("<span class='bold'>Connexion réussie.</span><br /><a style='color: black;' href='index.connect.php'>Si la redirection ne se fait pas, cliquez ici</a> !");
				else if( $login == 0 )
					$Engine->setInfo("Une erreur important est survenu, merci de contacter l'administrateur du site.");
				else if( $login == -1 )
					$Engine->setError("Ce PSEUDONYME n'existe pas dans notre base de données.");
				else if( $login == -2 )
					$Engine->setError("Votre PSEUDONYME doit être supérieur à 3 caractères et être inférieur à 20 caractères.<br />Votre MOT DE PASSE doit être supérieur à 3 caractères.");
				else if( $login == -3 )
					$Engine->setError("Votre PSEUDONYME ou votre MOT DE PASSE ne correspondent pas.");
				else if( $login == -4 )
					$Engine->setError("Une importante erreur est survenue : impossible de générer un token sécurisé !");
					
				$Engine->setInfo("Valeur:".$login);
			}
			else
				$Engine->setInfo("Un des champs est vide.");
		}
	}
	
	if( $Engine->getError() != null || $Engine->getSuccess() != null || $Engine->getInfo() != null )
	{
		?>
		<script>
			$(document).ready(function() {
				$('#Modal').foundation('reveal', 'open');
			});
		</script>
		<?php
	}

	/* Inclusion de la vue */
	include_once( $Engine->getViewPath() );
	