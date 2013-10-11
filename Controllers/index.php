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
				$l = $Lang->getErrorText();
				if( $login == 1 )
					$Engine->setSuccess($l['loginSuccess']);
				else if( $login == 0 )
					$Engine->setError($l['loginError']);
				else if( $login == -1 )
					$Engine->setError($l['loginError1']);
				else if( $login == -2 )
					$Engine->setError($l['loginError2']);
				else if( $login == -3 )
					$Engine->setError($l['loginError3']);
				else if( $login == -4 )
					$Engine->setError($l['loginError4']);
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
	