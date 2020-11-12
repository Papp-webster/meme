<?php
  namespace controller;
	
	require_once("src/model/DAL/MemeRepository.php");
  require_once("src/view/Page.php");

  class Page {
	  private $memeRepository;
    private $view;

    public function __construct() {
			$this->memeRepository = new \DAL\MemeRepository();
      $this->view 					= new \view\Page();
    }

		/**
      * @return startPage
      */
    public function general() {
	    $memeList = $this->memeRepository->getAllMemes();
      return $this->view->startPage($memeList);
    }
  }
