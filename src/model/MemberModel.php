<?php
  namespace model;

  require_once("src/model/DAL/MemberRepository.php");
  require_once("src/helper/Misc.php");

  class MemberModel {
    private $memberRepository;
    private $misc;
    private static $username = "Admin";
    private static $password = "Password";

		public static $uniqueID        = "Login::UniqueID";
 		public static $sessionUserID   = "Login::UserID";
    public static $sessionUsername = "Login::Username";

    public function __construct() {
      $this->memberRepository = new \DAL\MemberRepository();
      $this->misc						  = new \helper\Misc();
    }

    /**
      * Checks if user is logged in.
      *
      * @return boolval - Either the user is logged in or not
      */
    public static function userIsLoggedIn() {
      if (isset($_SESSION[self::$sessionUserID])) {
	      // Check if the user is the real user
	      if ($_SESSION[self::$uniqueID] === \Helper\Misc::setUniqueID()) {
					return true;
				} else {
					\Model\MemberModel::logOut();
				}
      }

      return false;
    }
   
    /**
      * Log in the user
      *
      * @param string $postUsername
      * @param string $postPassword
      * @param string $postRemember - Whether to remember the user or not
      * @return boolval
      */
    public function logIn(\Model\Member $member) {
      // Get the database member
      $memberDB = $this->memberRepository->getMember($member->getName());

      // Can't find hen? Then false it!
      if (!$memberDB) {
        return false;
      }

      // Make the inputs safe to use in the code
      $username   = $this->misc->makeSafe($member->getName());
      $password   = $this->misc->makeSafe($member->getPassword());
      $usernameDB = $this->misc->makeSafe($memberDB->getName());
      $passwordDB = $this->misc->makeSafe($memberDB->getPasswordHash());
      $userID     = $this->misc->makeSafe($memberDB->getID());

      // Check if the correct password is provided
      if($passwordDB === $password) {
	      $_SESSION[self::$uniqueID] = $this->misc->setUniqueID();
        $_SESSION[self::$sessionUsername] = $usernameDB;
        $_SESSION[self::$sessionUserID] = $userID;

        return true;
      }
    }

    /**
      * Log out the user
      *
      * @return boolval
      */
    public static function logOut() {
      // Check if you really are logged in
      if (isset($_SESSION[self::$sessionUserID])) {
        session_unset();
        session_destroy();

        return true;
      }
    }
  }
