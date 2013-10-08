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
				if( User::checkUsernameExist( $username ) )
				{
					/* Check des tailles (vérifications) */
					if( User::checkUsernameLength( $username, 2 ) && User::checkPasswordLength( $password, 2 ))
					{
						/* Check si le compte existe (correspondances du pseudo/mdp) */
						if( $userId = User::checkUserAccountMatch( $username, $password ) )																			// TODO: ajoute sécurité mdp (chiffrage/cryptage)
						{
							/* Destruction de la session au cas où ! */
							$Engine->destroySession("SpaceEngineConnected");
							$Engine->destroySession("SpaceEngineToken");
							/* Enregistrement de l'ID dans une session. */
							$token = User::generateUniqueToken(2);
							if( $token != false ) {
								if( User::updateToken( $token, $userId ) ) 
								{
									$Engine->createSession("SpaceEngineConnected", (int)$userId);
									$Engine->createSession("SpaceEngineToken", $token );
									$Engine->setSuccess("<span class='bold'>Connexion réussie.</span><br /><a style='color: black;' href='index.connect.php'>Si la redirection ne se fait pas, cliquez ici</a> !");
								}
								else 
									$Engine->setError("Une importante erreur est survenue : impossible de mettre à jour le token sécurisé !");
							}
							else 
								$Engine->setError("Une importante erreur est survenue : impossible de générer un token sécurisé !");
						}
						else
							$Engine->setError("Votre PSEUDONYME ou votre MOT DE PASSE ne correspondent pas.");
					}
					else
						$Engine->setError("Votre PSEUDONYME doit être supérieur à 3 caractères et être inférieur à 20 caractères.<br />Votre MOT DE PASSE doit être supérieur à 3 caractères.");
				}
				else
					$Engine->setError("Ce PSEUDONYME n'existe pas dans notre base de données.");
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
	