<?php
  namespace controller;

  require_once("src/controller/Member.php");
  require_once("src/controller/Meme.php");
  require_once("src/controller/Page.php");
  require_once("src/view/Navigation.php");

  class Navigation {
    public function doControll() {
      $controller;

      switch (\view\Navigation::getAction()) {
        // Member
        case \view\Navigation::$actionAddUser:
          $controller = new \controller\Member();
          return $controller->addMember();
          break;

        case \view\Navigation::$actionLogin:
          $controller = new \controller\Member();
          return $controller->logIn();
          break;

        case \view\Navigation::$actionLogout:
          $controller = new \controller\Member();
          return $controller->logOut();
          break;

        // Memes
        case \view\Navigation::$actionCreateMeme:
          $controller = new \controller\Meme();
          return $controller->createMeme();
          break;
          
			 case \view\Navigation::$actionViewMeme:
          $controller = new \controller\Meme();
          return $controller->viewMeme();
          break;
          
        case \view\Navigation::$actionLikeMeme:
          $controller = new \controller\Meme();
          return $controller->likeMeme();
          break;
          
        case \view\Navigation::$actionDeleteMeme:
          $controller = new \controller\Meme();
          return $controller->deleteMeme();
          break;
          
			 case \view\Navigation::$actionViewGallery:
          $controller = new \controller\Meme();
          return $controller->viewGallery();
          break;
          
        case \view\Navigation::$actionUploadImgur:
          $controller = new \controller\Meme();
          return $controller->uploadImgur();
          break;

        // Pages
        default:
          $controller = new \controller\Page();
          return $controller->General();
          break;
      }
    }
  }
