<?php
  namespace DAL;

  require_once("src/model/DAL/Repository.php");
  require_once("src/model/Meme.php");

  class MemeRepository extends Repository {
    private static $idRow 				= "id";
    private static $userIDRow 		= "userID";
    private static $likesRow   		= "likes";
	  private static $imageRow 			= "image";
    private static $topTextRow	  = "topText";
    private static $bottomTextRow = "bottomText";
    private static $base64Row 		= "base64";

    public function __construct() {
      $this->dbTable = "memes";
    }

    /**
      * Add a meme to the db
      *
      * @param Meme $meme - The meme to save
      * @param int $userID
      * @return int - The ID of the meme saved
      */
    public function addMeme(\model\Meme $meme, $userID) {	    	    
      $db = $this->connection();

      $sql = "INSERT INTO $this->dbTable (" . self::$userIDRow . ", 
      	" . self::$imageRow . ", " . self::$topTextRow . ", 
				" . self::$bottomTextRow . ", " . self::$base64Row . ") 
      	VALUES (?, ?, ?, ?, ?)";
      	
		  $params = array($userID, $meme->getImage(), $meme->getTopText(), 
		  	$meme->getBottomText(), $meme->getBase64());

      $query = $db->prepare($sql);
		  $query->execute($params);
		  
		  return $db->lastInsertId();
    }
    
    /**
      * Get a specfic meme from the db
      *
      * @param int $id
      */
    public function getMeme($id) {
  		$db = $this->connection();

  		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$idRow . " = ?";
  		$params = array($id);

  		$query = $db->prepare($sql);
  		$query->execute($params);

  		$result = $query->fetch();

  		if ($result) {
	  		$meme = new \model\Meme($result[self::$idRow], $result[self::$userIDRow], 
	  			$result[self::$likesRow], $result[self::$imageRow], 
	  			$result[self::$topTextRow], $result[self::$bottomTextRow], 
	  			$result[self::$base64Row]);
	  		
  			return $meme;
  		} else {
	  		throw new \Exception("Could not find meme.");
  		}
  	}
  	
  	/**
      * Like a meme
      *
      * @param Meme $meme
      */
  	public function likeMeme(\model\Meme $meme) {
  		$db = $this -> connection();
			
  		$sql = "UPDATE $this->dbTable SET " . self::$likesRow . " =  
  			" . self::$likesRow . " + 1 WHERE " . self::$idRow . " = ?";
  		$params = array($meme->getID());

  		$query = $db->prepare($sql);
  		$query->execute($params);
  	}
  	
  	/**
      * Delete a meme
      *
      * @param Meme $meme
      */
  	public function deleteMeme(\model\Meme $meme) {
  		$db = $this -> connection();

  		$sql = "DELETE FROM $this->dbTable WHERE " . self::$idRow . " = ?";
  		$params = array($meme->getID());

  		$query = $db->prepare($sql);
  		$query->execute($params);
  	}
    
    /**
      * Retrives all the memes from the db
      *
      * @return array - of memes
      */
    public function getAllMemes() {
      $db = $this->connection();

      $sql = "SELECT * FROM $this->dbTable";

      $query = $db->prepare($sql);
      $query->execute();
     
      $memeList = array();
     
      foreach($query->fetchAll() as $result){
	      $meme = new \model\Meme($result[self::$idRow], $result[self::$userIDRow], 
	  			$result[self::$likesRow], $result[self::$imageRow], 
	  			$result[self::$topTextRow], $result[self::$bottomTextRow], 
	  			$result[self::$base64Row]);

        $memeList[] = $meme;
      }

      return $memeList;
    }
    
    /**
      * Get a specfic memebers memes
      *
      * @param int $id
      * @return array - of memes
      */
    public function getMembersMemes($id) {
      $db = $this->connection();

      $sql = "SELECT * FROM $this->dbTable WHERE " . self::$userIDRow . " = ?";
      $params = array($id);

      $query = $db->prepare($sql);
      $query->execute($params);

      $memeList = array();
     
      foreach($query->fetchAll() as $result){
	      $meme = new \model\Meme($result[self::$idRow], $result[self::$userIDRow], 
	  			$result[self::$likesRow], $result[self::$imageRow], 
	  			$result[self::$topTextRow], $result[self::$bottomTextRow], 
	  			$result[self::$base64Row]);

        $memeList[] = $meme;
      }
      
      return $memeList;
    }
  }
