<?php

class Language
{
	private $_lang;
	private $_navigation;
	private $_error;
	
	public function __construct( $lang = 'fr' )
	{
		$this->_lang = $lang;
		$this->setNavigationText();
		$this->setErrorText();
	}
	
	private function setNavigationText() {
		include('./lang/'.$this->_lang.'.php');
		$this->_navigation = $navigation;
	}
	public function getNavigationText() {
		return $this->_navigation;
	}
	
	private function setErrorText() {
		include('./lang/'.$this->_lang.'.php');
		$this->_error = $error;
	}
	public function getErrorText() {
		return $this->_error;
	}
}
?>