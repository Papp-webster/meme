<?php
  namespace view;
  
  require_once("src/helper/Misc.php");

  class HTMLView {
	  private $misc;
	  
	  public function __construct() {
      $this->misc = new \helper\Misc();
    }
	  
    /**
      * Creates a HTML page. I blame the indentation
      * on webbrowsers and PHP.
      *
      * @param string $title - The page title
      * @param string $body - The middle part of the page
      * @return string - The whole page
      */
    public function echoHTML($title = "Member", $body) {
      if ($body === NULL) {
        throw new \Exception("HTMLView::echoHTML does not allow body to be null.");
      }

      echo "<!doctype html>
<html lang='sv'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>" . $title . "</title>
  
  <!-- Icons -->
	<link rel='apple-touch-icon' href='" . \Settings::$ROOT_PATH . "img/icon.png' />
	<link rel='shortcut icon' type='image/x-icon' href='" . \Settings::$ROOT_PATH . "img/favicon.png'>
		
	<!-- Facebook-stuff -->
	<meta property='og:image' content='" . \Settings::$ROOT_PATH . "img/icon.png'> 
	<meta property='og:type' content='website'>
	<meta property='og:site_name' content='" . $title . "'> 

	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <link rel='stylesheet' href='css/style.css'>
</head>
<body>
  <div class='container'>
    <header class='row'>
      <div class='col-md-12'>
        <a href='" . \Settings::$ROOT_PATH . "' id='logo'><h1>Meme Maker!</h1></a>
      </div>
    </header>
    
    <div class='row'>";
    
    if ($this->misc->anyAlerts()) {
	    echo "<div class='col-md-12'><div class='alert alert-info' role='alert'>" . $this->misc->getAlert() . "</div></div>";
    }
   
    echo $body . "
    </div>
    
    <footer class='row'>
			<div class='col-md-12'>
				<nav>
					<a href='" . \Settings::$ROOT_PATH . "'>Meme Maker!</a>
					<a href='mailto:marco@wheresmar.co'>Feedback</a>
				</nav>
			</div>
    </footer>
  </div>
</body>
</html>";
    }
  }
