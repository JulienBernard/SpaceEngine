<?php

class User
{
	private $_id;
	private $_username;
	private $_rank;
	private $_rankText;
	
	/* Constructeur de la classe */
	public function __construct( $id )
	{
		if( !filter_var($id, FILTER_VALIDATE_INT) ) {
			throw new Exception('You must provide an integer value!');
		}
		$sqlData = $this->getUserData( $id );
		$this->_id = $sqlData['id'];
		$this->_username = $sqlData['username'];
		$this->_rank = $sqlData['rank'];
		if( $this->_rank == 3 )
			$this->_rankText = "super admin";
		else if( $this->_rank == 2 )
			$this->_rankText = "admin";
		else
			$this->_rankText = "member";
	}
	
	public function getId()
	{
		return $this->_id;
	}
	public function getUsername()
	{
		return $this->_username;
	}
	public function getRank()
	{
		return $this->_rank;
	}
	public function getRankText()
	{
		return $this->_rankText;
	}
	
	/**
	 * Recupère les données utilisateur depuis la base de données.
	 * @param int userId
	 * @return array or 0 (error)
	 */
	private function getUserData( $userId ) {
		
		/* Validation des paramètres */
		if( !is_numeric($userId) || $userId < 0 )
			return false;
		
		$sql = MyPDO::get();

		$rq = $sql->prepare('SELECT id, username, rank, token FROM users WHERE id=:idUser');
        $data = array(':idUser' => $userId );
		$rq->execute($data);
		
		if( $rq->rowCount() == 0 ) throw new Exception('Une importante erreur est survenue : Impossible de récupérer les données de cet utilisateur !');
		$row = $rq->fetch();
		return $row;
	}
	
	/** Récupère une liste de utilisateurs (selon $size [DEFAUT : 10])
	 * @param int $size				:	taille de la liste (plus elle est grande, plus la requête sera longue à effectuer !)
	 * @param int $startPosition	:	position de départ
	 */
	public function getUsersList( $startPosition = 0, $size = 10 ) {
		$sql = MyPDO::get();

		/* Si on arrive sur la page de classement "principale",
			on effectue une recherche sur la moitié supérieur aux nombre d'habitants
			moyen retournée par MySql [SELECT AVG(pl_population)] */
		if( $startPosition == 0 )
		{
			$rq = $sql->prepare('
				SELECT id, username, rank, token, activity
				FROM users
				WHERE users.id > (SELECT AVG(id) FROM users)
				ORDER BY users.id DESC
				LIMIT :startPosition, :size
			');
			$rq->bindValue('startPosition', (int)$startPosition, PDO::PARAM_INT);
			$rq->bindValue('size', (int)$size, PDO::PARAM_INT);
			$rq->execute() or die(print_r($rq->errorInfo()));
			
			$array = array();
			while( $row = $rq->fetch() )
				$array[] = $row;
			
			/* Au cas où :
				si le nombre de retour est inférieur à la taille souhaitée,
				on check sur toute la BDD. Dans tous les cas, on renvoit les mêmes données. */
			if( count($array) < $size )
			{
				unset($array);
				$rq = $sql->prepare('
					SELECT id, username, rank, token, activity
					FROM users
					ORDER BY users.id DESC
					LIMIT :startPosition, :size
				');
				$rq->bindValue('startPosition', (int)$startPosition, PDO::PARAM_INT);
				$rq->bindValue('size', (int)$size, PDO::PARAM_INT);
				$rq->execute() or die(print_r($rq->errorInfo()));
				
				while( $row = $rq->fetch() )
					$array[] = $row;
			}
		}
		else {
			$rq = $sql->prepare('
				SELECT id, username, rank, token, activity
				FROM users
				ORDER BY users.id DESC
				LIMIT :startPosition, :size
			');
			$rq->bindValue('startPosition', (int)$startPosition, PDO::PARAM_INT);
			$rq->bindValue('size', (int)$size, PDO::PARAM_INT);
			$rq->execute() or die(print_r($rq->errorInfo()));
			
			while( $row = $rq->fetch() )
				$array[] = $row;
		}
		
		if( isset($array) )
			return $array;
		else
			return 0;
	}
	
	/**
	 * Met à jour l'activité de l'utilisateur (timestamp)
	 * @param int userId
	 */
	public static function updateActivity( $userId )
	{
		$newTime = time();
		$sql = MyPDO::get();

		$rq = $sql->prepare('UPDATE users SET activity=:newTime WHERE id=:userId');
        $data = array(':userId' => (int)$userId, ':newTime' => (int)$newTime );
		$rq->execute($data);
	}
	
	/** Retourne le nombre d'utilisateur
	 * @param int $activity		:	durée après laquelle l'utilisateur est déclaré inactif (défaut 3 jours)
	 * @param int $do			:	prendre en compte le tps ou juste sortir la liste
	 */
	public static function countUsers( $activity = 259200, $rank = null ) {
		$currentActivityTime = time() - $activity;
		
		$sql = MyPDO::get();
		if( (int)$activity != 0 )
		{
			$req = $sql->prepare('SELECT id, activity FROM users WHERE activity >= :activityTime');
			$req->execute(array(':activityTime' => $currentActivityTime));
		}
		else
		{
			if( (int)$rank != null ) {
				$req = $sql->prepare('SELECT id FROM users WHERE rank = :rank');
				$req->execute(array(':rank' => $rank));
			}
			else {
				$req = $sql->prepare('SELECT id FROM users');
				$req->execute();
			}
		}
		return $req->rowCount();
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
		$Engine = new Engine( "mock" );
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
					$token = self::generateUniqueToken(2);
					if( $token != false ) {
						if( self::updateToken( $token, $userId ) ) 
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
	private static function checkUserAccountMatch( $username, $password ) {
		
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
	private static function checkUsernameExist( $username ) {
		
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
	 * Retourne le rang de l'utilisateur.
	 * @param int id
	 * @return id
	 */
	public static function getUserRank( $id ) {
		if( !filter_var($id, FILTER_VALIDATE_INT) ) {
			throw new Exception('You must provide an integer value!');
		}
		
		$sql = MyPDO::get();
		$rq = $sql->prepare('SELECT rank FROM users WHERE id=:id');
		$data = array(':id' => (int)$id);
		$rq->execute($data);
		
		if( $rq->rowCount() != 0)
		$row = $rq->fetch();
		return (int)$row['rank'];
	}
	
	/**
	 * Génère  un token unique crypté.
	 * @param int nbChar
	 * @return a string if it's ok, false it's not.
	 */
	private static function generateUniqueToken( $nbChar = 2 ) {
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
	private static function updateToken( $token, $id ) {
		$sql = MyPDO::get();
		$rq = $sql->prepare('UPDATE users SET token=:token WHERE id=:id');
        $data = array(':id' => $id, ':token' => $token);
	
		if( !$rq->execute($data) )
			return false;
		else
			return true;
	}
}