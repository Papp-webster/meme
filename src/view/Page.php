<?php
  namespace view;

  class Page {
    public function startPage($memeList) {
	    $ret = "<div class='col-md-12 startPage'>";
	    
	    // Show menu depending on if your logged in or not
			if(\Model\MemberModel::userIsLoggedIn()) {
        $username = $_SESSION[\model\MemberModel::$sessionUsername];
        $userID   = $_SESSION[\model\MemberModel::$sessionUserID];
        
        $ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionViewGallery . "&" . \view\Meme::$getLocation . "=" . $userID . "' class='callout'>My gallery</a></div>";
        $ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' class='callout prime'>Make a meme!</a></div>";
        $ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionLogout . "' class='callout'>Log out</a></div>";
			} else {
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionAddUser . "' class='callout'>Register</a></div>";
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' class='callout prime'>Make a meme!</a></div>";
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionLogin . "' class='callout'>Log in</a></div>";				
			}
			
			if (empty($memeList)) {
				$ret .= "<br style='clear: both;'><div class='alert alert-info' role='alert'>Not a single meme exists. Let's be the first and <a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "'>make one</a>!</div>"; 
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
  }
