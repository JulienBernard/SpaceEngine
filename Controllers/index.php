	<?php

	include_once(PATH_MODELS."myPDO.class.php");
	include_once(PATH_MODELS."user.class.php");
		
	
	/* Une action sur un formulaire (envoie par POST) a été effectuée.  */
	if( isset($_POST) ) {
		
		if( isset($_POST['connection']) ) {
			$fields = array('username' => $_POST['username'], 'password' => $_POST['password']);
			$return = $Engine->checkParams($fields);
			if( $return == 1 ) {
				$username = (String)$_POST['username'];
				$password = (String)$_POST['password'];
				
				include_once(PATH_MODELS."user.class.php");
				
				if( $id = User::checkConnection( $username, $password ) )
				{
					$Engine->createSession("SpaceEngineConnected", $id);
					$Engine->createSession("SpaceEngineToken", true);
					header("location: index.php");
				}
				else
					$ERROR = $Engine->setError("Le pseudo et le mot de passe ne correspondent pas.");
			}
			else
				$Engine->setInfo("Un des champs est vide.");
		}
	}

	/* Gestion des erreurs */
	$INFO = $Engine->getInfo();
	$ERROR = $Engine->getError();
	$SUCCESS = $Engine->getSuccess();
	/* Inclusion de la vue */
	include_once( $Engine->getViewPath() );
	