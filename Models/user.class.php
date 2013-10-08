<?php

class User
{
	private $_login;
	private $_token;
	
	/* Constructeur de la classe */
	public function __construct( $id )
	{
		/* Récupération des informations depuis la bdd */
		// TODO stock dans les variables d'instance
	}
	
	public function getLogin()
	{
		return $this->_login;
	}
	
	public function getToken()
	{
		return $this->_token;
	}
	
	/**
	 * Vérifie si le login et le password sont exactes. Attention, dans cet exemple le mdp est en clair (bouhhhh ^^) 
	 * @param String login
	 * @param String password
	 * @return Id de l'utilisateur
	 */
	public static function checkConnection( $login, $password ) {
		if( (String)$login == "demo" && (String)$password == "demo" )
			return 1;
		else
			return 0;
	}
	
	/**
	 * Vérifie si l'username et le password sont exactes. 
	 * @param String username
	 * @param String password
	 * @return id de l'utilisateur ou 0 (erreur)
	 */
	public static function checkUserAccountMatch( $username, $password ) {
		
		/* Validation des paramètres */
		if( !is_string($username) || !is_string($password) || empty($username) || empty($password) )
			return false;
		
		$sql = MyPDO::get();
		
		$rq = $sql->prepare('SELECT id FROM users WHERE username=:username AND password=:password');
		$data = array(':username' => (String)$username, ':password' => (String)$password);
		$rq->execute($data);

		if( $rq->rowCount() != 0)
		{
			$row = $rq->fetch();
			return (int)$row['id'];
		}
		else
			return 0;
	}
	
	/**
	 * Vérifie si l'username existe dans la bdd.
	 * @param String username
	 */
	public static function checkUsernameExist( $username ) {
		
		/* Validation des paramètres */
		if( !is_string($username) || empty($username) )
			return false;
			
		$sql = MyPDO::get();
		$rq = $sql->prepare('SELECT id FROM users WHERE username=:username');
		$data = array(':username' => (String)$username);
		$rq->execute($data);
		
		if( $rq->rowCount() != 0)
		{
			$row = $rq->fetch();
			return (int)$row['id'];
		}
		return false;
	}
	
	/**
	 * Vérifie si l'username est supérieur à 4 caractères et inférieur à 20.
	 * @param String username
	 */
	public static function checkUsernameLength( $username, $min = 4, $max = 20 ) {
		if( strlen($username) < $min || strlen($username) > $max )
			return false;
		return true;
	}
	
	/**
	 * Vérifie si le password est supérieur à 6 caractères.
	 * @param String password
	 */
	public static function checkPasswordLength( $password, $min = 6 ) {
		if( strlen($password) < $min )
			return false;
		return true;
	}
	
	/**
	 * Génère  un token unique crypté.
	 * @param int nbChar
	 * @return a string if it's ok, false it's not.
	 */
	public static function generateUniqueToken( $nbChar = 2 ) {
		if( !filter_var($nbChar, FILTER_VALIDATE_INT) ) {
			throw new Exception('You must provide an integer value!');
		}
		
		$str = substr(crypt(uniqid(mt_rand(), true), 0), $nbChar);
		return self::ckeckTokenExisted($str);
	}
	
	/**
	 * Vérifie si ce token n'existe pas déjà dans la base de données.
	 * @param String token
	 * @return String
	 */
	private static function ckeckTokenExisted( $token ) {
		$sql = MyPDO::get();
		$rq = $sql->prepare('SELECT id FROM users WHERE token=:token');
		$data = array(':token' => (String)$token);
		$rq->execute($data);
		
		if( $rq->rowCount() != 0)
			return self::generateUniqueToken(2);
		else
			return $token;
	}
	
	/**
	 * Vérifie si ce token est bien celui présent pour cet utilisateur.
	 * @param String token
	 * @param int id
	 * @return true or false
	 */
	public static function checkUserTokenMatch( $token, $id ) {
		if( !filter_var($id, FILTER_VALIDATE_INT) ) {
			throw new Exception('You must provide an integer value!');
		}
		
		$sql = MyPDO::get();
		$rq = $sql->prepare('SELECT token FROM users WHERE id=:id');
		$data = array(':id' => (int)$id);
		$rq->execute($data);
		
		if( $rq->rowCount() != 0)
		{
			$row = $rq->fetch();
			$str = (string)$row['token'];
			
			if( $token == $str )
				return true;
		}
		return false;
	}
	
	/**
	 * Met à jour le token nouvellement généré dans la bdd de la connexion actuelle.
	 * @param String token
	 * @param int id
	 * @return true or false
	 */
	public static function updateToken( $token, $id ) {
		$sql = MyPDO::get();
		$rq = $sql->prepare('UPDATE users SET token=:token WHERE id=:id');
        $data = array(':id' => $id, ':token' => $token);
	
		if( !$rq->execute($data) )
			return false;
		else
			return true;
	}
}