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
	 * Vérifie si la connexion d'un utilisateur peut se faire. Renvoie différente erreur si une erreur en ressort.
	 * @param String username
	 * @param String password
	 * @return
	 *	1	: Connexion correcte, l'utilisateur est connecté.
	 *	0	: Une erreur importante est apparue
	 *	-1	: L'utilisateur n'existe pas
	 *	-2	: La taille de l'utilisateur ou du mot de passe est inférieur/supérieur à x caractères (défaut 2)
	 *	-3	: Le mot de passe ne correspond pas à cet utilisateur
	 *	-4	: Impossible de générer un token sécurisé !
	 */
	public static function checkLogin( $username, $password ) {
		/* Validation des paramètres */
		if( !is_string($username) || !is_string($password) || empty($username) || empty($password) )
			return 0;
			
		if( self::checkUsernameExist($username) ) {
			if( self::checkUsernameLength($username, 2, 20) && self::checkPasswordLength($password, 2) ) {
				if( $userId = self::checkUserAccountMatch($username,$password) ) {
					/* Destruction de la session au cas où ! */
					$Engine->destroySession("SpaceEngineConnected");
					$Engine->destroySession("SpaceEngineToken");
					/* Création du token unique pour la session de l'utilisateur */
					$token = User::generateUniqueToken(2);
					if( $token != false ) {
						if( User::updateToken( $token, $userId ) ) 
						{
							$Engine->createSession("SpaceEngineConnected", (int)$userId);
							$Engine->createSession("SpaceEngineToken", $token );
							return 1; // Succès !
						}
						else 
							return 0; // Impossible de mettre à jour le token ! (plus de token de libre, problème de création du token ?)
					} else 
						return -4;
				} else
					return -3;
			} else
				return -2;
		} else
			return -1;
	}	
	
	/**
	 * Vérifie si l'username et le password sont exactes. 
	 * @param String username
	 * @param String password
	 * @return id de l'utilisateur ou 0 (erreur)
	 */
	private function checkUserAccountMatch( $username, $password ) {
		
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
	private function checkUsernameExist( $username ) {
		
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
	private function generateUniqueToken( $nbChar = 2 ) {
		if( !filter_var($nbChar, FILTER_VALIDATE_INT) ) {
			throw new Exception('You must provide an integer value!');
		}
		
		$str = substr(crypt(uniqid(mt_rand(), true), 0), $nbChar);
		return ckeckTokenExisted($str);
	}
	
	/**
	 * Vérifie si ce token n'existe pas déjà dans la base de données.
	 * @param String token
	 * @return String
	 */
	private function ckeckTokenExisted( $token ) {
		$sql = MyPDO::get();
		$rq = $sql->prepare('SELECT id FROM users WHERE token=:token');
		$data = array(':token' => (String)$token);
		$rq->execute($data);
		
		if( $rq->rowCount() != 0)
			return generateUniqueToken(2);
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
	private function updateToken( $token, $id ) {
		$sql = MyPDO::get();
		$rq = $sql->prepare('UPDATE users SET token=:token WHERE id=:id');
        $data = array(':id' => $id, ':token' => $token);
	
		if( !$rq->execute($data) )
			return false;
		else
			return true;
	}
}