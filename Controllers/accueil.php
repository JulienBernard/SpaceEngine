	<?php

	include_once(PATH_MODELS."myPDO.class.php");
	include_once(PATH_MODELS."presentation.class.php");
		
	$presentation = new Presentation();
	
	/* Une action sur un formulaire (envoie par POST) a été effectuée.  */
	if( isset($_POST) ) {
		if( isset($_POST['retrieveText']) ) {
			$presentation->retrieveText();
		}
		
		if( isset($_POST['Connection']) ) {
			$fields = array('login' => $_POST['login'], 'password' => $_POST['password']);
			$return = verifyParams($fields);
			if( $return == 1 ) {
				$login = (String)$_POST['login'];
				$password = (String)$_POST['password'];
				
				include_once(PATH_MODELS."user.class.php");
				
				if( User::checkConnection( $login, $password ) )
				{
					createSession("SpaceEngine_Connected", true);
					createSession("SpaceEngine_ConnectedLogin", $login);
					header("location: index.php");
				}
				else {
					$errorLogin = "Erreur de connexion. Le pseudo et le mot de passe ne correspondent pas.";
				}
			}
			else {
				$errorLogin = "Un des champs est vide.";
				$returnError = $return;
			}
		}
	}

	/* Inclusion de la vue */
	include_once( $viewPath );