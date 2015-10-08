<?php
require_once 'config.php';

$controller = new \controller\MasterController();

$controller->handleInput();

$page = new \view\ContentView();
echo $page->Render($controller->generateOutput(), $controller->IsLoggedIn());
