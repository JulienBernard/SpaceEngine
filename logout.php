<?php

	/***
	 * 
	 * Point d'entrée de la page d'accueil.
	 * @author JulienBernard
	 * 
	 */
	
	/* Le namePage permet d'identifier votre page. Il doit être être écrit en minuscule et tenir en un seul mot.
	 */
	$namePage = "logout";
	
	/* Appel du moteur [ne pas modifier] */
	include_once("./config.php");
	
	$Engine = new Engine( $namePage );
	$Template = new Template();
	
	/* Informations sur la page [valeurs à modifier] */
	$Template->setTitle("Déconnexion");
	$Template->setDescription("Site propulsé par le SpaceEngine ! SpaceEngine Copyright (C) 2013 Julien Bernard - SpaceEngine is a free website engine under GPL license!");
	$Template->addCss("normalize.css");
	$Template->addCss("foundation.min.css");
	$Template->addSCript("jquery.min.js");
	$Template->addSCript("redirection.js");

	/* Lancement du moteur [ne pas modifier] */
	$Engine->startEngine( $Engine, $Template );
?>