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
	public function getNavigationText( $str ) {
		if( array_key_exists( $str, $this->_navigation ) )
			return $this->_navigation[$str];
		else
			return "<span style='font-size: 12px;'>[Translation not found]</span>";
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