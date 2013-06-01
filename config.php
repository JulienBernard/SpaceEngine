<?php

	/***
	 * 
	 * Configuration du moteur (base de donn�es, inclusions des fonctions, etc.)
	 * @author Julien Bernard
	 * 
	 */
	
	session_start();
	$timeStart = microtime(true);	// Temps d'ex�cution de la page, voir la fonction foot() (functions.php).
	
	/* Inclusion des fonctions du moteur */
	include_once("./functions.php");
	
	/* Configuration de la base de donn�es */
	define("SQL_DSN", "mysql:host=localhost;dbname=spaceengine");
	define("SQL_USER", "root");
	define("SQL_PASS", "");
	define("SQL_ENCODE", "utf8");
	
	/* Chemin d'acc�s du site */
	define("BASE_PATH", "http://localhost/Julien/ApocalySpace/SpaceEngine/");
	
	/* Informations par d�faut */
	define("DEFAULT_DESCRIPTION", "Moteur de site internet. D�velopper par Julien Bernard pour le projet ApocalySpace (www.apocalyspace.fr) !");
	define("DEFAULT_TITLE", "SpaceEngine - ");
	