<?php

/**
 * Classe Engine. Gestion des fonctions principales du moteur.
 * @author Julien Bernard
 */
class Engine implements IEngine {
	
	private $_error;
	private $_success;
	private $_info;
	private $_controllerPath;
	private $_viewPath;
	private $_namePage;
	
	/**
	 * Constructeur du moteur. Initialise le moteur.
	 */
	public function __construct( $namePage ) {	
		$this->_error = (int)null;
		$this->_success = (int)null;
		$this->_info = (int)null;
		$this->_controllerPath = (String)"./Controllers/";
		$this->_viewPath = (String)"./Views/";
		$this->_namePage = (String)$namePage;
	}
	
	/**
	 * Charge le moteur selon l'activité de l'utilisateur : connecté, admin ou visiteur.
	 */
	public function startEngine( $Engine, $Template ) {
		if( isset($_GET['lang']) && !empty($_GET['lang']) && is_string($_GET['lang']) )
			$_SESSION['SpaceEngineLanguage'] = $_GET['lang'];
	
		$lang = 'fr';
		if( isset($_SESSION['SpaceEngineLanguage']) && $_SESSION['SpaceEngineLanguage'] == 'fr' )
			$lang = 'fr';
		else if( isset($_SESSION['SpaceEngineLanguage']) && $_SESSION['SpaceEngineLanguage'] == 'en' )
			$lang = 'en';
			
		include_once(PATH_MODELS."language.class.php");
		$Lang = new Language( $lang );
	
		$namePage = $this->_namePage;
		if( isset($_GET['visitor']) ) {
			$Template->addCss("style.css");
			$Engine->setControllerPath('./Controllers/'.strtolower($namePage).'.php');
			$Engine->setViewPath('./Views/'.strtolower($namePage).'.php');
			$Template->startTemplate('./template/header.php', $Template, $Engine, $Lang);
			include_once($this->_controllerPath);
			$Template->startTemplate('./template/footer.php', $Template, $Engine, $Lang);
		}
		else if( Engine::isAdmin() ) {
			$Template->addCss("admin.css");
			User::updateActivity( $_SESSION['SpaceEngineConnected'] );
			$Engine->setControllerPath('./Controllers/'.strtolower($namePage).'.admin.php');
			$Engine->setViewPath('./Views/'.strtolower($namePage).'.admin.php');
			$Template->startTemplate('./template/header.admin.php', $Template, $Engine, $Lang);
			include_once($this->_controllerPath);
			$Template->startTemplate('./template/footer.admin.php', $Template, $Engine, $Lang);
		}
		else if( Engine::isConnected() ) {
			$Template->addCss("style.css");
			User::updateActivity( $_SESSION['SpaceEngineConnected'] );
			$Engine->setControllerPath('./Controllers/'.strtolower($namePage).'.connect.php');
			$Engine->setViewPath('./Views/'.strtolower($namePage).'.connect.php');
			$Template->startTemplate('./template/header.connect.php', $Template, $Engine, $Lang);
			include_once($this->_controllerPath);
			$Template->startTemplate('./template/footer.connect.php', $Template, $Engine, $Lang);
		}
		else {
			$Template->addCss("style.css");
			$Engine->setControllerPath('./Controllers/'.strtolower($namePage).'.php');
			$Engine->setViewPath('./Views/'.strtolower($namePage).'.php');
			$Template->startTemplate('./template/header.php', $Template, $Engine, $Lang);
			include_once($this->_controllerPath);
			$Template->startTemplate('./template/footer.php', $Template, $Engine, $Lang);
		}
	}
	
	/**
	 * Vérifie si l'utilisateur est connecté (système de session).
	 * Vérifie ensuite si le token de l'utilisateur est bien celui de CET utilisateur dans la bdd.
	 */
	public static function isConnected() {
		if( !empty($_SESSION['SpaceEngineConnected']) && $_SESSION['SpaceEngineConnected'] != 0 )
		{
			if( !empty($_SESSION['SpaceEngineToken']) && count($_SESSION['SpaceEngineToken']) > 0)
			{
				include_once(PATH_MODELS."myPDO.class.php");
				include_once(PATH_MODELS."user.class.php");
				
				if( User::checkUserTokenMatch( $_SESSION['SpaceEngineToken'], $_SESSION['SpaceEngineConnected'] ) )
					return true;
				else
					return false;
			}
		}
		else
			return false;
	}
	
	/**
	 * Vérifie si l'utilisateur est connecté en tant qu'admin (système de session)
	 */
	public static function isAdmin() {
		if( Engine::isConnected() )
		{
			if( $rank = User::getUserRank( $_SESSION['SpaceEngineConnected'] ) )
			{
				if( $rank == ADMIN || $rank == SUPER_ADMIN )
					return true;
				else
					return false;
			}
			else
				return false;
		}
		else
			return false;
	}
	
	/**
	 * Vérifie que les champs du tableau ne sont pas vide (un champ peut être égale à 0, '0' ou ' ') !
	 * @param array $array				Champs à vérifier
	 * @param array $strictPositive		Si != NULL, alors les champs ne doivent être que positif
	 * @return boolean
	 */
	public function checkParams( $array, $strictPositive = NULL ) {
		if( is_array($array) )
		{
			$arrayError = array();
			foreach( $array as $key => $value )
			{
				if( $value === '0' OR $value === 0 )
					$arrayError[$key] = 1;
				elseif( empty($value) )
					$arrayError[$key] = 0;
				else
					$arrayError[$key] = 1;
					
				if( $strictPositive != NULL )
				{
					if( $value < 0 )
						$arrayError[$key] = 0;
				}
			}
			foreach( $arrayError as $key => $value )
			{				
				if( !$value )
					return $arrayError;	// Un des champs est vide, on retourne un tableau contenant le statut des champs (1= OK, 0 = vide)
			}	
			return 1;	// OK
		}
		return 0; 	// ERREUR
	}
	
	/**
	 * Créer une session et l'initialise avec un contenu.
	 */
	public function createSession( $name, $content ) {
		if( isset($_SESSION[$name]) )
			return 0;
		else
			$_SESSION[$name] = $content;
		return 1;
	}
	
	/**
	 * Détruis une session selon son nom, si elle existe.
	 */
	public function destroySession( $name ) {
		if( isset($_SESSION[$name]) )
			unset($_SESSION[$name]);
		else
			return 0;
		return 1;
	}
	
	/* Setters et Getters */
	private function setControllerPath( $path ) {
		$this->_controllerPath = $path;
	}
	public function getControllerPath() {
		return $this->_controllerPath;
	}
	private function setViewPath( $path ) {
		$this->_viewPath = $path;
	}
	public function getViewPath() {
		return $this->_viewPath;
	}
	public function getError() {
		return $this->_error;
	}
	public function setError( $string ) {
		$this->_error = $string;
	}
	public function getSuccess() {
		return $this->_success;
	}
	public function setSuccess( $string ) {
		$this->_success = $string;
	}
	public function getInfo() {
		return $this->_info;
	}
	public function setInfo( $string ) {
		$this->_info = $string;
	}
}