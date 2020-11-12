<?php
  namespace view;

  class Meme {
    private static $fieldTopText 		 = "memeTopText";
    private static $fieldBottomText  = "memeBottomText";
    private static $fieldImage 			 = "memeImage";
    private static $fieldImageUpload = "memeImageUpload";
    public  static $getLocation 		 = "id";
    
    /**
      * Gets the meme id from the get location
      *
      * @return int - the id
      */
    public function getMemeID() {
  		if (isset($_GET[self::$getLocation])) {
  			return $_GET[self::$getLocation];
  		}

  		return null;
  	}

		/**
      * Checks if user did submit the generate form
      *
      * @return boolval
      */
    public function didUserSubmit() {
      if (isset($_POST[self::$fieldTopText]))
        return true;

      return false;
    }

		/**
      * Gets the formdata that's posted
      *
      * @return Meme
      */
    public function getFormData() {
      if(file_exists($_FILES[self::$fieldImageUpload]['tmp_name']) || is_uploaded_file($_FILES[self::$fieldImageUpload]['tmp_name'])) {
		    $imagesizedata = getimagesize($_FILES[self::$fieldImageUpload]['tmp_name']);
		    
				if ($imagesizedata != FALSE) {
					if ((400 * 1024) < filesize($_FILES[self::$fieldImageUpload]['tmp_name'])) {
	    			throw new \Exception("That's a huge image. No way.");	
    			}
    		
					$_POST[self::$fieldImage] = $_FILES[self::$fieldImageUpload]['tmp_name'];
				}
    	}
    	
    	if (!isset($_POST[self::$fieldImage])) {
	    	throw new \Exception("You need to choose or upload an image that's not humungus.");
    	}

  		return new \model\Meme(null, null, null, $_POST[self::$fieldImage], $_POST[self::$fieldTopText], $_POST[self::$fieldBottomText]);
  	}

		/**
      * Create a meme view
      *
      * @return html
      */
    public function createMeme($imagesToChoose) {
	    $ret  = "<div class='col-md-12 generateMeme'>";
	    
	    if(!\Model\MemberModel::userIsLoggedIn()) {
		    $ret .= "<div class='alert alert-info' role='alert'>If you <a href='?" . Navigation::$action . "=" . Navigation::$actionLogin . "'>log in</a> you're meme get's saved to your own gallery. Just saying.</div>"; 
	    }

      $ret .= "<form action='?action=" . Navigation::$actionCreateMeme . "' method='post' enctype='multipart/form-data'>";
      
      $ret .= "<div class='col-sm-6 col-md-6'>";
	      $ret .= "<div class='textbox'>";    
	    		$ret .= "<label>Choose a sweet image to the right and fill in the text below:</label>"; 
	    		
					$ret .= "<div class='form-group'>";
			      $ret .= "<input type='text' class='form-control' name='" . self::$fieldTopText . "' id='" . self::$fieldTopText . "' placeholder='TOP ROW' />";
		      $ret .= "</div>";
		
					$ret .= "<div class='form-group'>";
			      $ret .= "<input type='text' class='form-control' name='" . self::$fieldBottomText . "' id='" . self::$fieldBottomText . "' placeholder='BOTTOM ROW' />";
		      $ret .= "</div>";
		      
					$ret .= "<div class='form-group'>";
		  	    $ret .= "<label for='" . self::$fieldImageUpload . "'>... OR upload Your own image file:</label>";
						$ret .= "<input type='file' class='form-control' name='" . self::$fieldImageUpload . "' id='" . self::$fieldImageUpload . "' />";
		      $ret .= "</div>";
		
		      $ret .= "<input type='submit' value='Work your magic!' class='btn btn-default' />";
	      $ret .= "</div>";	      
      $ret .= "</div>";
     
      $ret .= "<div class='col-sm-6 col-md-6'>";
	      $ret .= "<div id='imagesContainer'>";
		      // Loop through the image array provided
		      foreach($imagesToChoose as $image) {
			      $ret .= "<div class='col-xs-6 col-sm-6 col-md-4 image'><label><input type='radio' name='" . self::$fieldImage . "' id='" . $image . "' value='" . $image . "'><img src='" . $image . "'></label></div>";
		      }
	      $ret .= "</div>";
			$ret .= "</div>";

      $ret .= "</form>";
      $ret .= "</div>";

      return $ret;
    }
    
    /**
      * View a users gallery view
      *
      * @return html
      */
    public function viewGallery($memeList) {
	    $ret = "<div class='col-md-12 startPage'>";
	    
	    if (empty($memeList)) {
				$ret .= "<div class='alert alert-info' role='alert'>You don't have any memes. Why not <a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "'>make one</a>!</div>"; 
	    } else {
		 		// Loop out the memes
				foreach (array_reverse($memeList) as $meme) {
		      $ret .= "<div class='col-sm-4 col-md-4 meme'><a href='?" . Navigation::$action . "=" . Navigation::$actionViewMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "'>
		      <img src='data:image/png;base64," . $meme->getBase64() . "' /></div>";
				}   
	    }
	         
      $ret .= "</div>";

      return $ret; 
    }

		/**
      * View a meme view
      *
      * @return html
      */
    public function viewMeme(\model\Meme $meme) {
	    $linkToPage = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?" . Navigation::$action . "=" . Navigation::$actionViewMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID();
	    
	    $ret  = "<div class='col-md-12 viewMeme'>";
		    $ret .= "<div class='col-md-6'>";
		      $ret .= "<img src='data:image/png;base64," . $meme->getBase64() . "'>";
	      $ret .= "</div>";
	      
	      $ret .= "<div class='col-md-6'>";
	      	$ret .= "<div class='textbox'>";
	      	
	      		$ret .= "<h2>" . $meme->getTopText() . "<br>" . $meme->getBottomText() . "</h2>";
	      		
	      		$ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionLikeMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "' class='btn' id='lol'>" . $meme->getLikes() . " LOLS!</a>";
	      		
	      		$ret .= "<p id='link'><label><span class=''>Link</span><input class='' type='text' value='" . $linkToPage . "' readonly=''></label></p>";
	      			      		
	      		$ret .= "<div id='share'>";
	      			$ret .= "<a class='btn' href='https://www.facebook.com/sharer/sharer.php?u=" . $linkToPage . "' onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=570,height=280');return false;\">Facebook</a>";
	      			$ret .= "<a class='btn' href='https://twitter.com/home?status=" . $meme->getTopText() . $meme->getBottomText() . " - " . $linkToPage . "' onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=570,height=280');return false;\">Twitter</a>";
	      			$ret .= "<a class='btn' href='?" . Navigation::$action . "=" . Navigation::$actionUploadImgur . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "'>IMGUR</a>";
	      		$ret .= "</div>";
	      		
	      		$ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' id='create'>Make your own Meme</button>";	      	
	      		
	      		if (\Model\MemeModel::canEditMeme($meme->getUserID())) {
		      		$ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionDeleteMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "' id='delete'>Delete the meme</button>";	      	
		      	}
		      	
	      	$ret .= "</div>";
	      $ret .= "</div>";
      $ret .= "</div>";

      return $ret;
    }
  }
