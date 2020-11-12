<?php
  namespace model;

  class MemeModel {
    /**
      * The function that fires everyting off
      *
      * @param Meme $meme - A meme to make
      * @return boolval - If successful
      */
    public function makeMeme(Meme $meme) {
      try {
        $generatedImage = $this->generate($meme->getImage(), $meme->getTopText(), $meme->getBottomText());

        // Save to meme
        $meme->setBase64($generatedImage);

        return true;
      } catch (\Exception $e) {
        return false;
      }
    }

    /**
      * A giant function that generates the meme
      *
      * @param string $imagePath - Path to image to put the meme on
      * @param string $topText - The text to put on the top
      * @param string $bottomText - Vice vers
      * @return base64 - The image base64 decoded
      */
  	private function generate($imagePath, $topText, $bottomText) {
      $tmpSizes    = getimagesize($imagePath);
  		$imageWidth  = $tmpSizes[0];
  		$imageHeight = $tmpSizes[1];

      // Remove mean characters and uppercase
  		$topText    = strtoupper(preg_replace('/\s\s+/', ' ',  $topText));
  		$bottomText = strtoupper(preg_replace('/\s\s+/', ' ', $bottomText));

      // Get the font and calculate the font size and margin
  		$font     = 'font/Impact.ttf';
  		$fontSize = round(0.07 * $imageWidth);
  		$margin   = round(0.03 * $imageWidth);

  		$topText_params    = $this->getTextParams($topText, $imageWidth, $margin, $font, $fontSize);
  		$bottomText_params = $this->getTextParams($bottomText, $imageWidth, $margin, $font, $fontSize);

      // Get the image to put text upon
  		$image = @imagecreatefromstring(file_get_contents($imagePath));
  		$white = imagecolorallocate($image, 255, 255, 255);
  		$black = imagecolorallocate($image, 0, 0, 0);

  		// Top text. First the shaddow
  		imagettftext($image, $fontSize + 0.5, 0,
	  		$topText_params['centered_start'],
	  		$fontSize + $margin,
	  		$black, $font, $topText_params['text']
  		);

      // Then the text
  		imagettftext($image, $fontSize, 0,
	  		$topText_params['centered_start'] - 2,
	  		$fontSize + $margin - 2,
	  		$white, $font, $topText_params['text']
  		);

  		// Bottom text, same here
  		imagettftext($image, $fontSize, 0,
	  		$bottomText_params['centered_start'],
	  		$imageHeight - $bottomText_params['height'] + $fontSize + $margin,
	  		$black, $font, $bottomText_params['text']
  		);

      // The actual text
  		imagettftext($image, $fontSize, 0,
	  		$bottomText_params['centered_start'] - 2,
	  		$imageHeight - $bottomText_params['height'] + $fontSize + $margin - 2,
	  		$white, $font, $bottomText_params['text']
  		);

      // Fake output to make a base64 string
      ob_start();
      imagejpeg($image, NULL, 100);
      $generatedImg = base64_encode(ob_get_clean());

  		return $generatedImg;
  	}

    /**
      * Get some usefull info about a string
      *
      * @param string $text - The text
      * @param string $width - Width of the image to put text on
      * @param string $margin - Margin for the text
      * @param string $font - Wich font
      * @param string $fontSize - And the font size
      * @return array - Text info, like height and center
      */
  	private function getTextParams($text, $width, $margin, $font, $fontSize) {
  		$text = explode(' ', $text);
  		$textRebuilt = '';

      // Row it up
  		foreach($text as $word) {
  			$box = imagettfbbox($fontSize, 0, $font, $textRebuilt.' '.$word);

        if($box[2] > $width - $margin * 2) {
  				$textRebuilt .= "\n".$word;
  			} else {
  				$textRebuilt .= " ".$word;
  			}
  		}

      // Find center
  		$textRebuilt = $this->alignCenterImgTxt($textRebuilt);
  		$box = imagettfbbox($fontSize, 0, $font, $textRebuilt);

      // Make a sweet array with stuff
  		$ret['text']           = $textRebuilt;
  		$ret['height']         = $box[1] + $fontSize + $margin * 2;
  		$ret['centered_start'] = ceil(($width-$box[2]) / 2);

  		return $ret;
  	}

    /**
      * Align the text to the center
      *
      * @param string $text - The text
      * @return string - The text, but this time centered
      */
  	private function alignCenterImgTxt($text) {
  		$text             = trim($text);
  		$text_a_tmp       = explode("\n", $text);
  		$maxLineLength = 0;

	  	foreach($text_a_tmp as $line) {
	  	  if (mb_strlen($line) > $maxLineLength) $maxLineLength = mb_strlen($line);
	  	}

	  	$text = '';

	  	foreach($text_a_tmp as $line) {
	  		$text .= $this->mbStrPad($line, $maxLineLength, ' ', STR_PAD_BOTH) . "\n";
	  	}

	  	return $text;
  	}

    /**
      * Pad a string to a certain length with another string
      *
      * @param string $input
      * @param string $padLength
      * @param string $padString
      * @param string $padStyle
      * @param string $encoding - Witch encoding
      * @return string - The text, but this time centered
      */
  	private function mbStrPad($input, $padLength, $padString, $padStyle, $encoding = "UTF-8") {
  		return str_pad($input, strlen($input) - mb_strlen($input, $encoding) + $padLength, $padString, $padStyle);
  	}

    /**
      * Scans the meme image folder for memes
      *
      * @return array - Image paths found
      */
    public function getImagesToChoose() {
      $imagesDir = 'img/memes/';
      $images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

      return $images;
    }
    
    /**
      * Uploads an image to IMGUR with their API
      *
      * @param Meme $meme - The meme to upload
      * @return string - The adress of the uploaded image
      */
    public function uploadImgur(\model\Meme $meme) {				    
			$url = 'https://api.imgur.com/3/image.json';
			$headers = array("Authorization: Client-ID " . \Settings::$IMGUR_CLIENTID);
			$pvars  = array('image' => $meme->getBase64());
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			   CURLOPT_URL=> $url,
			   CURLOPT_TIMEOUT => 30,
			   CURLOPT_POST => 1,
			   CURLOPT_RETURNTRANSFER => 1,
			   CURLOPT_HTTPHEADER => $headers,
			   CURLOPT_POSTFIELDS => $pvars
			));
			
			$json_returned = curl_exec($curl);
			$json_returned = json_decode($json_returned, true);
			curl_close ($curl); 
			
			return "http://imgur.com/" . $json_returned["data"]["id"];
    }
    
    /**
      * Checks if the user can edit the meme
      *
      * @param int $userID - The id of the user
      * @return boolval
      */
    public static function canEditMeme($userID) {
	    if(\Model\MemberModel::userIsLoggedIn()) {
		    if ($userID === $_SESSION[\model\MemberModel::$sessionUserID]) {
			  	return true;  
			  }
		  }
		  
	    return false;
    }
  }
