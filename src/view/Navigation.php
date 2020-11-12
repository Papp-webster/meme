<?php
  namespace view;

  class Navigation {
    public  static $action            = "action";
    public  static $actionAddUser     = "register";
    public  static $actionLogin       = "login";
    public  static $actionLogout      = "logout";
    public  static $actionIndex       = "index";
    public  static $actionCreateMeme  = "generate";
    public  static $actionViewMeme    = "view";
    public  static $actionLikeMeme    = "like";
    public  static $actionDeleteMeme  = "delete";
    public  static $actionViewGallery = "view-member";
    public  static $actionUploadImgur = "upload-imgur";

    /**
      * Gets the action that the user wants
      */
    public static function getAction() {
      if (isset($_GET[self::$action]))
        return $_GET[self::$action];

      return self::$actionIndex;
    }

    /**
      * Redirects the user home (home set in settings file)
      */
    public static function redirectHome() {
      header('Location: ' . \Settings::$ROOT_PATH);
    }

		/**
      * Redirects the user to a meme
      * @param int @id - the meme's id
      */
    public static function redirectToMeme($id) {
      header('Location: ' . \Settings::$ROOT_PATH . "?" . Navigation::$action . "=" . Navigation::$actionViewMeme . "&" . \view\Meme::$getLocation . "=" . $id);
    }
  }
