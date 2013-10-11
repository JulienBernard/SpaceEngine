<?php
	/* Destruction des session de connexion joueur */
	$Engine->createSession("SpaceEngineConnected", 0);
	$Engine->createSession("SpaceEngineToken", 0);
	$Engine->destroySession("SpaceEngineConnected");
	$Engine->destroySession("SpaceEngineToken");
	session_regenerate_id(true);
	session_destroy();

	/* Inclusion de la vue */
	include_once( $Engine->getViewPath() );
	
?><script type="text/javascript">redirection(3, 'index.php');</script><?php
