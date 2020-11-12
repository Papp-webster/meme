<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Member {
    private $misc;
    private static $name            = "name";
    private static $password        = "password";
    private static $password_repeat = "password_repeat";
    
		public  static $getLocation 		 = "id";

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    public static function getMemberID() {
  		if (isset($_GET[self::$getLocation])) {
  			return $_GET[self::$getLocation];
  		}

  		return NULL;
  	}


    /**
      * Gets the formdata that's posted
      *
      * @return User/null - depends if sucess or not
      */
    public function getFormData() {
  		if (isset($_POST[self::$name])) {
        // Check if the form post is from register form
        if (isset($_POST[self::$password_repeat])) {
          if ($_POST[self::$password] !== $_POST[self::$password_repeat]) {
              throw new \Exception("Lösenorden matchar inte.");
          }
        }
        
  			return new \model\Member($_POST[self::$name], $_POST[self::$password]);
  		}

  		return null;
  	}

    /**
      * Get the form for the registration
      *
      * @return string (HTML) - the form
      */
    public function addMember() {
      $name = isset($_POST[self::$name]) ? preg_replace('/[^a-z0-9\-_\.]/i', '', $_POST[self::$name]) : '';
      
      $ret  = "<div class='col-md-12 register'>";
		    $ret .= "<div class='col-sm-6 col-md-6'>";
		    	$ret .= "<div class='form'>";
						$ret .= "<form action='?action=" . Navigation::$actionAddUser . "' method='post' role='form'>";
						
						$ret .= "<div class='form-group'>";
							$ret .= "<label for='" . self::$name . "'>A sweet username:</label>";
							$ret .= "<input type='text' class='form-control' name='" . self::$name . "' id='" . self::$name . "' value='" . $name . "' placeholder='InterestingGuy93' />";
						$ret .= "</div>";
	
						$ret .= "<div class='form-group'>";
				      $ret .= "<label for='" . self::$password . "'>A secure password:</label>";
							$ret .= "<input type='password' class='form-control' name='" . self::$password . "' id='" . self::$password . "' placeholder='******' />";
						$ret .= "</div>";
						
						$ret .= "<div class='form-group'>";
				      $ret .= "<label for='" . self::$password_repeat . "'>And that password one more time:</label>";
				      $ret .= "<input type='password' class='form-control' name='" . self::$password_repeat . "' id='" . self::$password_repeat . "' placeholder='******' />";
						$ret .= "</div>";
			
			  		$ret .= "<input type='submit' value='Sign me up!' class='btn btn-default' />";
			  		$ret .= "</form>"; 		
		  		$ret .= "</div>";
	      $ret .= "</div>";
	      
	      $ret .= "<div class='col-sm-6 col-md-6'>";
		      $ret .= "<div class='textbox'>";
		      	$ret .= "<h2>Another member? Nice!</h2>";
						$ret .= "<p>You're going to love to make memes here. And every meme you make from now on, when you are logged in, get's saved into your own gallery for safe keeping.</p><p>So what are you waiting for?</p>";
					$ret .= "</div>";
	      $ret .= "</div>";
      $ret .= "</div>";
      

  		return $ret;
    }

    /**
      * A view for users not logged in
      *
      * @return string - The page log in page
      */
    public function loginMember() {
      $username = empty($_POST[self::$name]) ? '' : $_POST[self::$name];

      $ret  = "<div class='col-md-12 login'>";
		    $ret .= "<div class='col-sm-6 col-md-6'>";
					$ret .= "<form action='?action=" . Navigation::$actionLogin . "' method='post' class='textbox'>";
					
					$ret .= "<div class='form-group'>";
						$ret .= "<label for='" . self::$name . "'>Your username:</label>";
						$ret .= "<input type='text' class='form-control' name='" . self::$name . "' id='" . self::$name . "' value='" . $username . "' placeholder='InterestingGuy93' />";
					$ret .= "</div>";
					
					$ret .= "<div class='form-group'>";
						$ret .= "<label for='" . self::$password . "'>The super secret password:</label>";
						$ret .= "<input type='password' class='form-control' name='" . self::$password . "' id='" . self::$password . "' placeholder='******' />";
					$ret .= "</div>";
					
		  		$ret .= "<input type='submit' value='Log in!' class='btn btn-default' />";
		 		$ret .= "</form>"; 		
		 		
		 		$ret .= "<div class='textbox'>";
			 		$ret .= "<h2>Ain't got no account?</h2><p>No problem, you can <a href='?" . Navigation::$action . "=" . Navigation::$actionAddUser . "'>create one</a> for free.</p>";
		 		$ret .= "</div>";
		 		
		  $ret .= "</div>";
  
  		$ret .= "<div class='col-sm-6 col-md-6 meme'><img src='img/login.png'></div>";

      return $ret;
    }
    
    /**
      * Checks if user submitted the register form
      *
      * @return boolval
      */
    public function didMemberPressSubmit() {
      if (isset($_POST[self::$name]))
        return true;

      return false;
    }

    /**
      * Checks if user did login
      *
      * @return boolval
      */
    public function didMemberPressLogin() {
      if (isset($_POST[self::$name]))
        return true;

      return false;
    }

    /**
      * Checks if pressed log out
      *
      * @return boolval
      */
    public function didMemberPressLogout() {
      if (isset($_GET[self::$getLogout]))
        return true;

      return false;
    }
  }
