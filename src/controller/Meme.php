<?php
  namespace controller;

  require_once("src/model/DAL/MemeRepository.php");
  require_once("src/model/MemeModel.php");
  require_once("src/model/Meme.php");
  require_once("src/view/Meme.php");
  require_once("src/helper/Misc.php");
  
  class Meme {
	  private $memeRepository;
    private $model;
    private $view;
    private $misc;

    public function __construct() {
	    $this->memeRepository = new \DAL\MemeRepository();
      $this->model 					= new \model\MemeModel();
      $this->view  					= new \view\Meme();
      $this->misc 					= new \helper\Misc();
    }

		/**
      * @return createMeme
      */
    public function createMeme() {
      if ($this->view->didUserSubmit()) {
	      try {
		      $meme = $this->view->getFormData();
	        $this->model->makeMeme($meme);
	
					// Check if the memeber is logged in and
					// assign the meme to that user if so
	        if(\Model\MemberModel::userIsLoggedIn()) {
		      	$userID = $_SESSION[\model\MemberModel::$sessionUserID];
		      } else {
			      $userID = null;
		      }
	        
	        // And save the meme
	        $id = $this->memeRepository->addMeme($meme, $userID);
	
					$meme = $this->memeRepository->getMeme($id);
					\view\Navigation::redirectToMeme($meme->getID());
	      } catch (\Exception $e) {
          $this->misc->setAlert($e->getMessage());
          
          $imagesToChoose = $this->model->getImagesToChoose();
          return $this->view->createMeme($imagesToChoose);
        }
      }

      $imagesToChoose = $this->model->getImagesToChoose();

      return $this->view->createMeme($imagesToChoose);
    }
    
    /**
      * @return viewMeme
      */
    public function viewMeme() {
	    try {
	    	$id   = $this->view->getMemeID();
	  	  $meme = $this->memeRepository->getMeme($id);
		    
		    return $this->view->viewMeme($meme);
	    } catch (\Exception $e) {
		    $this->misc->setAlert($e->getMessage());
		    
		    \view\Navigation::redirectHome();
		  }
    }
    
    /**
      * @return redirectToMeme()
      */
    public function likeMeme() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    $this->memeRepository->likeMeme($meme);
	    
	    \view\Navigation::redirectToMeme($meme->getID());
    }
    
    /**
      * @return redirectToMeme()
      */
    public function deleteMeme() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    if (\Model\MemeModel::canEditMeme($meme->getUserID())) {    
		    $this->memeRepository->deleteMeme($meme);
	    }
	    
	    // To index!
	    \view\Navigation::redirectHome();
    }
    
    /**
      * @return viewGallery
      */
    public function viewGallery() {
	    $id       = \View\Member::getMemberID();
	    $memeList = $this->memeRepository->getMembersMemes($id);
	    
	    return $this->view->viewGallery($memeList);
    }
    
    /**
      * @return redirectToMeme()
      */
    public function uploadImgur() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    $imgurURL = $this->model->uploadImgur($meme);
	    
	    $this->misc->setAlert("The upload is now at: <a href='" . $imgurURL . "' target='_blank'>" . $imgurURL . "</a>");
	    
	    \view\Navigation::redirectToMeme($meme->getID());
    }
  }
