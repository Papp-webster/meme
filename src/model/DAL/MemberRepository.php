<?php
  namespace DAL;

  require_once("src/model/DAL/Repository.php");
  require_once("src/model/Member.php");

  class MemberRepository extends Repository {
	  private static $idRow 			= "id";
    private static $nameRow 		= "name";
    private static $passwordRow = "password";

    public function __construct() {
      $this->dbTable = "members";
    }

    /**
      * Add a member to the db
      *
      * @param Member $member - the member to save
      */
    public function addMember(\model\Member $member) {
      if ($this->getMember($member->getName())) {
        throw new \Exception('Username already taken.');
      }

      $db = $this->connection();

      $sql = "INSERT INTO $this->dbTable (" . self::$nameRow . ", " . self::$passwordRow . ") VALUES (?, ?)";
		  $params = array($member->getName(), $member->getPassword());

      $query = $db->prepare($sql);
		  $query->execute($params);
    }

    /**
      * Get a member from the db through username
      *
      * @param string $username - the username of the member to get
      * @return Member/Boolval - member if success or false if not
      */
    public function getMember($username) {
      $db = $this->connection();

      $sql = "SELECT * FROM $this->dbTable WHERE " . self::$nameRow . " LIKE '%" . $username . "%'";
      $query = $db->prepare($sql);
		  $query->execute();

      if ($query->rowCount() > 0) {
        foreach ($query->fetchAll() as $result) {
          $member = new \model\Member($result[self::$nameRow], $result[self::$passwordRow], $result[self::$idRow], $result[self::$passwordRow]);
          return $member;
        }
      }

      return false;
    }
  }
