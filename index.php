<?php
  session_start();

  require_once("src/view/HTMLView.php");
  require_once("src/controller/Navigation.php");

  $controller = new \controller\Navigation();
  $body = $controller->doControll();

  $view = new \view\HTMLView();
  $view->echoHTML("Meme Maker!", $body);
