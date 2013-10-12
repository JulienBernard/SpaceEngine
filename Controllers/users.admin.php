<?php

	include_once(PATH_MODELS."myPDO.class.php");
	include_once(PATH_MODELS."user.class.php");
	
	/* Variables */
	$size = 10;
	$start = 0;
	
	if( isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0 )
		$start = (int)$_GET['p'] * $size;
	
	$User = new User( $_SESSION['SpaceEngineConnected'] );
	$usersList = $User->getUsersList( $start, $size);
	
	/* Inclusion de la vue */
	include_once( $Engine->getViewPath() );