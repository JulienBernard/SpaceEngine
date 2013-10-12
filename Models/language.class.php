<?php

class Language
{
	private $_lang;
	private $_navigation;
	private $_error;
	private $_admin;
	
	public function __construct( $lang = 'fr' )
	{
		$this->_lang = $lang;
		$this->setNavigationText();
		$this->setErrorText();
		$this->setAdminText();
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
	public function getErrorText( $str ) {
		if( array_key_exists( $str, $this->_error ) )
			return $this->_error[$str];
		else
			return "<span style='font-size: 12px;'>[Translation not found]</span>";
	}
	
	private function setAdminText() {
		include('./lang/'.$this->_lang.'.php');
		$this->_admin = $admin;
	}
	public function getAdminText( $str ) {
		if( array_key_exists( $str, $this->_admin ) )
			return $this->_admin[$str];
		else
			return "<span style='font-size: 12px;'>[Translation not found]</span>";	}
}
?>