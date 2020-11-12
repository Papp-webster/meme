<?php
  namespace model;

  class Meme {
	  private $id;
	  private $userID;
	  private $likes;
    private $topText;
    private $bottomText;
    private $image;
    private $base64;

    public function __construct($id = null, $userID = null, $likes = null, 
    	$image, $topText, $bottomText, $base64 = null) {
	    	
      $this->image 			= $image;
      $this->topText 		= $topText;
      $this->bottomText = $bottomText;
      
			if ($id != null) {
		    $this->id = $id;
	    }
	   
			if ($userID != null) {
		    $this->userID = $userID;
	    }
	    
	    if ($likes != null) {
		    $this->likes = $likes;
	    }
	    
	    if ($base64 != null) {
		    $this->base64 = $base64;
	    } 
    }

		public function getID() {
			return $this->id;
		}
				
		public function getUserID() {
			return $this->userID;
		}
				
		public function getLikes() {
			return $this->likes;
		}

    public function getTopText() {
      return $this->topText;
    }

    public function getBottomText() {
      return $this->bottomText;
    }

    public function getImage() {
      return $this->image;
    }

		public function getBase64() {
      return $this->base64;
    }

		/**
      * Setter for the base64 image
      *
      * @param string $password - The password to save
      */
		public function setBase64($base64) {
      $this->base64 = $base64;
    }
  }
