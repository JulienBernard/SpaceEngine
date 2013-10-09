<?php

/**
 * Classe Template. Gestion des templates du site.
 * @author Julien Bernard
 */
class Template implements ITemplate {
	private $_title;
	private $_description;
	private $_tcss = array();
	private $_tscript = array();
	
	/**
	 * Inclusion du fichier selon son chemin d'accès ($path)
	 */
	public function startTemplate( $path, $Template ) {
		$lang = 'fr';
		if( isset($_SESSION['SpaceEngineLanguage']) && $_SESSION['SpaceEngineLanguage'] == 'fr' )
			$lang = 'fr';
		else if( isset($_SESSION['SpaceEngineLanguage']) && $_SESSION['SpaceEngineLanguage'] == 'en' )
			$lang = 'en';
			
		include_once("./lang/".$lang.".php");
		include_once( $path );
	}
	
	/* Setters et Getters */
	public function setTitle( $title ) {
		$this->_title = $title;
	}
	public function getTitle() {
		return (String)$this->_title;
	}
	public function setDescription( $desc ) {
		$this->_description = $desc;
	}
	public function getDescription() {
		return (String)$this->_description;
	}
	
	public function addCss( $path ) {
		$currentSize = count($this->_tcss);
		$this->_tcss[++$currentSize] = (String)$path;
	}
	public function getCss() {
		return $this->_tcss;
	}
	public function addScript( $path ) {
		$currentSize = count($this->_tscript);
		$this->_tscript[++$currentSize] = (String)$path;
	}
	public function getScript() {
		return $this->_tscript;
	}	
}