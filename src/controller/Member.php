<?php
  namespace controller;

  require_once("src/model/DAL/MemberRepository.php");
  require_once("src/model/MemberModel.php");
  require_once("src/view/Member.php");
  require_once("src/helper/Misc.php");

  class Member { 
	  private $MemberRepository;
    private $model;
    private $view;
    private $misc;

    public function __construct() {
	    $this->MemberRepository = new \DAL\MemberRepository();
      $this->model 						= new \model\MemberModel();
      $this->view  						= new \view\Member();
      $this->misc 					  = new \helper\Misc();
    }

		/**
      * @return addMember
      */
    public function addMember() {
	    if($this->model->userIsLoggedIn()) {
		  	\view\Navigation::redirectHome();
		  }
		  
      if ($this->view->didMemberPressSubmit()) {
        try {
          $newMember = $this->view->getFormData();

					// The member to the db						
          $this->MemberRepository->addMember($newMember);

					// And as a welcome, log em in
          $this->model->logIn($newMember);
          
          // Send of an welcome alert
          $this->misc->setAlert("Welcome aboard my new best friend");

					// And send e'm home
          \view\Navigation::redirectHome();
        } catch (\Exception $e) {
          $this->misc->setAlert($e->getMessage());
          
          return $this->view->addMember();
        }
      } else {
        return $this->view->addMember();
      }
    }

		/**
      * @return loginMember
      */
    public function logIn() {
	    if($this->model->userIsLoggedIn()) {
		  	\view\Navigation::redirectHome();
		  }
	    
      if ($this->view->didMemberPressLogin()) {
	      try {
        // Get the form data and log the user in
        $member = $this->view->getFormData();
        $this->model->logIn($member);
        
        // TODO Fix this
        $this->misc->setAlert("Welcome home! Why not make a meme?");
        
        // Redirect home
        \view\Navigation::redirectHome();
        } catch (\Exception $e) {
	        $this->misc->setAlert($e->getMessage());
	        
	    		return $this->view->loginMember();    
	      }
      }

      // Else show the login page
      return $this->view->loginMember();
    }

		/**
      * @return redirectHome()
      */
    public function logOut() {
	    // Log the user out
      $this->model->logOut();
      
      // TODO Also fix this
      $this->misc->setAlert("And you're out!");

			// And send to index
      \view\Navigation::redirectHome();
    }
  }
