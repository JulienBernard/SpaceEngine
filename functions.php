<?php
	/***
	 * 
	 * Fonctions principales du moteur. Ne pas y toucher sauf si vous �tes s�r de vous !
	 * @author JulienBernard
	 *
	 */

	/**
	 * Inclusion du template (header) avec diverses informations. Diff�rent header peuvent �tre appel�s si $path != null.
	 * @param String $title
	 * @param String $description
	 * @param array[String] $t_css		Tableau des chemins d'acc�s aux styles
	 * @param array[String] $t_scripts	Tableau des chemins d'acc�s aux scripts
	 * @param String $path
	 */
	function head( $title, $description, $t_css, $t_scripts, $path = NULL ) {
		if( !empty( $path ) )
			$path = '.'.(String)$path;
	
		include_once('./template/header'.$path.'.php');
	}
	
	/**
	 * Inclusion du template (footer). Diff�rent footer peuvent �tre appel�s si $path != null.
	 * @param String $path
	 * @param timestamp $timeStart		Timer pour le temps d'�x�cution de la page (si renseign�)
	 */
	function foot( $path = NULL, $timeStart = NULL) {
		if( !empty( $path ) )
			$path = '.'.(String)$path;
		
		$timeEnd = 0;
		$mTime = 0;
		$execution = null;
		if( !empty($timeStart) )
		{
			$timeEnd = microtime(true);
			$mTime = $timeEnd - $timeStart;
			$execution = number_format($mTime, 3);
		}
	
		include_once('./template/footer'.$path.'.php');		
	}
	
	/**
	 * Retourne "true" si la session "SpaceEngine_Connected" existe et retourne "true" => le visiteur est "connect�".
	 * @return boolean
	 */
	function isConnected()
	{
		if( !empty($_SESSION['SpaceEngine_Connected']) && $_SESSION['SpaceEngine_Connected'] == true )
			return true;
		else
			return false;
	}
	
	/**
	 * V�rifie que les champs du tableau ne sont pas vide (un champ peut �tre �gale � 0, '0' ou ' ') !
	 * @param array $array				Champs � v�rifier
	 * @param array $strictPositive		Si != NULL, alors les champs ne doivent �tre que positif
	 * @return boolean
	 */
	function verifyParams( $array, $strictPositive = NULL )
	{
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
					return $arrayError[$key];	// Un des champs est vide, on retourne un tableau contenant le statut des champs (1= OK, 0 = vide)
			}
			return true;	// OK
		}
		return false; 	// ERREUR
	}
