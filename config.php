<?php

	/***
	 * 
	 * Configuration du moteur (base de données, inclusions des fonctions, etc.)
	 * @author Julien Bernard
	 * 
	 */
	
	session_start();
	$timeStart = microtime(true);	// Temps d'exécution de la page, voir la fonction foot() (functions.php).
		
	/* Configuration de la base de données */
	define("SQL_DSN", "mysql:host=localhost;dbname=spaceengine");
	define("SQL_USER", "root");
	define("SQL_PASS", "root");
	define("SQL_ENCODE", "utf8");
	
	/* Chemin d'accès du site */
	define("BASE_SITE", "http://localhost/Pro/SpaceEngine/SpaceEngine/");
	define('BASE_PATH', '/Pro/SpaceEngine/SpaceEngine/');
	
	/* Informations par défaut */
	define("DEFAULT_DESCRIPTION", "Site propulsé par le SpaceEngine ! SpaceEngine Copyright (C) 2013 Julien Bernard - SpaceEngine is a free website engine under GPL license!");
	define("DEFAULT_TITLE", "SpaceEngine - ");
	
	/* Chemin d'accès MVC */
	define("PATH_MODELS", "./Models/");
	define("PATH_CONTROLLERS", "./Controllers/");
	define("PATH_VIEWS", "./Views/");

	/* Administration */
	define("MEMBERS", 0);
	define("ADMIN", 1);
	define("SUPER_ADMIN", 2);
	
	include_once("./SpaceEngine/ISpaceEngine.php");
	include_once("./SpaceEngine/engine.class.php");
	include_once("./SpaceEngine/template.class.php");
	