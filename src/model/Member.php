<?php
  namespace model;

  class Member {
	  private $id;
    private $name;
    private $password;
    private $passwordHash;

    public function __construct($name, $password, $id = null, $passwordHash = null) {	    
      $this->setName($name);
      $this->setPassword($password);
      
			if ($id != null) {
		    $this->id = $id;
	    }
	    
	    if ($passwordHash != null) {
		  	$this->passwordHash = $passwordHash;
	    }
    }
        
    public function getID() {
	    return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    /**
      * Setter for username
      *
      * @param string $name - the name to save
      */
    public function setName($name) {
      $length = mb_strlen($name);

      if ($length < 3) {
        throw new \Exception("Username is too short. At least 3 characters.");
      } else if ($length > 20) {
        throw new \Exception("Username is way too long.");
      }

      $username = preg_replace('/[^a-z0-9\-_\.]/i', '', $name, -1, $hasInvalid);

      if ($hasInvalid)
        throw new \Exception("Don't even try to hack me with those crazy characters.");

      $this->name = $name;
    }

    public function getPassword() {
      return $this->password;
    }

    /**
      * Setter for the password
      *
      * @param string $password - The password to save
      */
    public function setPassword($password) {
      $length = mb_strlen($password);

      if ($length < 4)
        throw new \Exception("We want safe passwords. So more then 4 characters please.");
        
      // Encrypt the password
      $password = sha1($password);

      $this->password = $password;
    }
    
    public function getPasswordHash() {
	    return $this->passwordHash;
    }
  }
